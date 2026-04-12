<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    // Page view
    public function index()
    {
        $users = AuditTrail::select('user_name')->distinct()->pluck('user_name');
        return view('audit.index', compact('users'));
    }

    // AJAX endpoint for DataTables
    public function ajaxLogs(Request $request)
    {
        // Get logs ordered by created_at DESC (latest first)
        $logs = AuditTrail::orderBy('created_at', 'desc')->get();

        // Format JSON and send
        $logs->transform(function($log) {
            return [
                'id' => $log->id,
                'user_name' => $log->user_name,
                'action' => $log->action,
                'model' => $log->model,
                'model_id' => $log->model_id,
                'changes' => $log->changes,
                'ip_address' => $log->ip_address,
                'device' => $log->device,
                'created_at' => $log->created_at->format('Y-m-d H:i:s') // ISO format for correct sorting
            ];
        });

        return response()->json(['data' => $logs]);
    }
}