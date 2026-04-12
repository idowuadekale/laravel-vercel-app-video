<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;
    protected $fillable = [
        'welcome_heading',
        'welcome_bio',
        'about_heading',
        'about_info',
        'phone',
        'email',
        'address',
        'map',
        'about_img',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
