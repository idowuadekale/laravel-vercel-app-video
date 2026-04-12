<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
     protected $fillable = [
        'image',
        'short_bio',
        'updated_by'
    ];

       public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}