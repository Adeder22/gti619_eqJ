<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityLogs extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'action'];
}
