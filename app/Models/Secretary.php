<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "image",
        "position",
        "instagram",
        "updated_by"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}