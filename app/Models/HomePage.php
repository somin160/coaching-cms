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
        'courses',
        'rankers',
        'image_content',
        'videos',
        'img_grid',
        'achievers',
        'testimonials',
        'faqs',
    ];

    protected $casts = [
        'hero_slider' => 'array',
        'courses' => 'array',
        'rankers' => 'array',
        'image_content' => 'array',
        'videos' => 'array',
        'img_grid' => 'array',
        'achievers' => 'array',
        'testimonials' => 'array',
        'faqs' => 'array',
    ];
}
