<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description'];

    // Relationships
    public function requests()
    {
        return $this->hasMany(\App\Models\Request::class, 'department_id');
    }
}
