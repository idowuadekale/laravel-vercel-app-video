<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function createFaq()
    {
        $faqs = Faq::latest()->paginate(10);
        $faqsAuth = Faq::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('faqs.create', ['faqs' => $faqs, 'faqsAuth' => $faqsAuth]);
    }

    public function addEntry(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'body' => 'required|string',
        ]);
        $data['updated_by'] = Auth::id();

        $faq = Faq::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $faq, [
            'created_fields' => $faq->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function editFaq(Faq $faq)
    {
        return view('faqs.edit', compact('faq'));
    }

    public function saveEntry(Faq $faq, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'body' => 'required|string',
        ]);
        $data['updated_by'] = Auth::id();

        // Save original values before changes
        $old = $faq->getOriginal();

        // ---- Update the team record ----
        $faq->update($data);

        // Detect changed fields only
        $changes = $faq->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $faq, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('faqs.create')->with('success', 'Record updated successfully!');
    }

    public function destroy(Faq $faq)
    {
        // Save original values before deletion
        $old = $faq->toArray();

        // Delete the record
        $faq->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $faq, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('faqs.create')->with('success', 'Record deleted successfully!');
    }
}
