<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BriefFormRequest extends Model
{
    protected $fillable = [
        'brief_form_id',
        'order_id',
        'client_id',
        'support_person_id',
        'form_title',
        'fields_snapshot',
        'access_token_hash',
        'status',
        'email_status',
        'expires_at',
        'sent_at',
        'submitted_at',
    ];

    protected $casts = [
        'fields_snapshot' => 'array',
        'expires_at' => 'datetime',
        'sent_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(BriefForm::class, 'brief_form_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function supportPerson()
    {
        return $this->belongsTo(User::class, 'support_person_id');
    }

    public function submission()
    {
        return $this->hasOne(BriefFormSubmission::class);
    }
}
