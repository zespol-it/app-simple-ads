<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'images',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'float',
    ];
}
