<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'content',
        'image_url',
        'image',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
