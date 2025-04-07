<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'attempts',
        'attempts',
        'old_passes',
        'capitals',
        'special_chars',
        'numbers',
        'length',
    ];
}
