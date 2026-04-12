<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuditService;
use App\Models\AdministrationYear;
use Illuminate\Support\Facades\Auth;

class AdministrationYearController extends Controller
{
    public function index()
    {
        // Since only one record exists, fetch the first or null
        $adminYear = AdministrationYear::first();
        return view('admin_year.form', compact('adminYear'));
    }

   public function storeOrUpdate(Request $request)
{
    $request->validate([
        'year1' => 'required|digits:4',
        'year2' => 'required|digits:4|gt:year1',
    ]);

    $data = [
        'year1' => $request->year1,
        'year2' => $request->year2,
        'updated_by' => Auth::id(),
    ];

    // Get existing record for comparison
    $existing = AdministrationYear::first();

    // Update or create record
    $adminYear = AdministrationYear::updateOrCreate([], $data);

    // ==========================
    //      AUDIT TRAIL LOG
    // ==========================
    $changes = [];

    if ($existing) {
        foreach (['year1', 'year2'] as $field) {
            if ($existing->$field != $request->$field) {
                $changes[$field] = [
                    'old' => $existing->$field,
                    'new' => $request->$field,
                ];
            }
        }
        if (!empty($changes)) {
            AuditService::log('updated', $adminYear, $changes);
        }
    } else {
        // First-time creation
        AuditService::log('created', $adminYear, [
            'created_fields' => $adminYear->toArray()
        ]);
    }

    return redirect()->back()->with('success', 'Record saved successfully.');
}

}