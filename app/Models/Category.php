<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','type','parent_id','status'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getFullPathAttribute()
    {
    $path = $this->name;
    $parent = $this->parent;
    while ($parent) {
        $path = $parent->name . ' → ' . $path;
        $parent = $parent->parent;
    }
    return $path;
    }
}
