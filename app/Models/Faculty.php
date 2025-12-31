<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id', 'description'];

    // Relationship with Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship with Requests (if needed)
    public function requests()
    {
        return $this->hasMany(\App\Models\Request::class, 'faculty_id');
    }
}
