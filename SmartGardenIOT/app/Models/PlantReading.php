<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantReading extends Model
{
    use HasFactory;

    // Add this part:
    protected $fillable = [
        'temp',
        'humidity',
        'soil_raw',
        'soil_percent'
    ];
}