<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'page_id','section_type','section_data',
        'form_id','sort_order','status',
    ];

    protected $casts = [
        'section_data' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'page_section_id')->orderBy('sort_order');
    }
}
