<?php

namespace App\Services;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log($action, $model, $changes = null)
    {
        AuditTrail::create([
            'user_name' => auth()->check() ? auth()->user()->name : 'Guest',
            'action'    => $action,
            'model'     => class_basename($model),
            'model_id'  => $model->id,
            'changes'   => $changes,
            'ip_address'=> Request::ip(),
            'device'    => Request::header('User-Agent'),
        ]);
    }
}