<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['name','description','fields'];

    protected $casts = ['fields' => 'array'];

    public function sections()
    {
        return $this->hasMany(PageSection::class, 'form_id');
    }
}
