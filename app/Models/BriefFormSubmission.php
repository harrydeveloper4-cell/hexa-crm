<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BriefFormSubmission extends Model
{
    protected $fillable = [
        'brief_form_request_id',
        'answers',
        'pdf_path',
        'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function formRequest()
    {
        return $this->belongsTo(BriefFormRequest::class, 'brief_form_request_id');
    }
}
