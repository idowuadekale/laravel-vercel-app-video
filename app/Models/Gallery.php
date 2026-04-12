<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        "date",
        "name",
        "live",
        "link",
        "updated_by"
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}