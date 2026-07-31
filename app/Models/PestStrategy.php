<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestStrategy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'description', 'methods', 'tips'
    ];

    protected $casts = [
        'methods' => 'array',
        'tips' => 'array',
    ];
}
