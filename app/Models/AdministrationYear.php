<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrationYear extends Model
{
    use HasFactory;

    protected $table = 'administration_year';

    protected $fillable = ['year1', 'year2', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}