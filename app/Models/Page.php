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
        'main_category_type',
        'sections',
        'status',
    ];

   protected $casts = [
    'sections' => 'array',
    'main_category_type' => 'string',
];
public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

}
