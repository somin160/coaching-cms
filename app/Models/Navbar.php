<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Navbar extends Model
{
    protected $fillable = [
        'title', 'slug', 'parent_id', 'order', 'status',
    ];

    // Automatically generate slug on create/update
    protected static function booted()
    {
        static::saving(function ($navbar) {
            if (empty($navbar->slug)) {
                $navbar->slug = Str::slug($navbar->title);
            }
        });
    }

    // Parent menu
    public function parent()
    {
        return $this->belongsTo(Navbar::class, 'parent_id');
    }

    // Child menus
    public function children()
    {
        return $this->hasMany(Navbar::class, 'parent_id')->orderBy('order');
    }
}
