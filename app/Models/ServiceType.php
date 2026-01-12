<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['office_id', 'name'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
