<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_name', 'action', 'model', 'model_id', 'changes',
        'ip_address', 'device'
    ];

    protected $casts = [
        'changes' => 'array'
    ];
}