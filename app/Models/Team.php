<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'position',
        'facebook',
        'instagram',
        'image',
        'updated_by'
    ];

      public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}