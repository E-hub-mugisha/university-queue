<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'office_id',
        'is_active',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
