<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['page_section_id','question','answer','sort_order','status'];

    public function section()
    {
        return $this->belongsTo(PageSection::class, 'page_section_id');
    }
}

