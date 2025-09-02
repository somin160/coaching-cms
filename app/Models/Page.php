<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'page_type',
        'title',
        'slug',
        'category_id',
        'meta_title',
        'meta_description',
        'sections',
        'status',
    ];

    protected $casts = [
        'sections' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
