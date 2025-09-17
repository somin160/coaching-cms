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
  public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Yeh function child categories ke saath relationship banata hai (optional but good practice)
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
   protected $casts = [
    'sections' => 'array',
    'main_category_type' => 'string',
];
public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

}
