<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'description', 'soil_requirements',
        'cultivation_method', 'harvest_time', 'nutritional_value',
        'uses', 'image_url'
    ];
}
