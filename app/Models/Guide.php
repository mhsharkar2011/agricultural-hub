<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'category', 'description', 'season', 'method', 'steps', 'tips'
    ];

    protected $casts = [
        'steps' => 'array',
        'tips' => 'array',
    ];
}
