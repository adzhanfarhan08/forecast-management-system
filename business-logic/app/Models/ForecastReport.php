<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'period_days',
        'generated_at',
    ];
    
    protected $casts = [
        'generated_at' => 'datetime',
    ];
}
