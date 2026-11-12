<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BriefForm extends Model
{
    protected $fillable = ['title', 'description', 'is_active'];

    public function fields()
    {
        return $this->hasMany(BriefFormField::class)->orderBy('sort_order')->orderBy('id');
    }

    public function activeFields()
    {
        return $this->fields()->where('is_active', true);
    }

    public function requests()
    {
        return $this->hasMany(BriefFormRequest::class);
    }
}
