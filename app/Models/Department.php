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
        return $this->hasMany(ServiceRequest::class, 'department_id');
    }
    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class);
    }
}
