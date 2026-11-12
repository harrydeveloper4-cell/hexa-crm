<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BriefFormField extends Model
{
    protected $fillable = [
        'brief_form_id',
        'label',
        'field_type',
        'help_text',
        'options',
        'is_required',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function form()
    {
        return $this->belongsTo(BriefForm::class, 'brief_form_id');
    }
}
