<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'hero_slider',
        'img_with_content',
        'videos',
        'achievers',
    ];

    protected $casts = [
        'hero_slider' => 'array',
        'img_with_content' => 'array',
        'videos' => 'array',
        'achievers' => 'array',
    ];
}
