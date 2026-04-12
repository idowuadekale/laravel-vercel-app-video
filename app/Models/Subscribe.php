<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'subscribed_at'
    ];

    protected $casts = [
        'subscribed_at' => 'datetime'
    ];

    // Automatically set subscribed_at when creating a new subscription
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->subscribed_at = $model->subscribed_at ?: now();
        });
    }
}