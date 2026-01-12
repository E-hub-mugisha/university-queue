<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Relationships
    public function requests()
    {
        return $this->hasMany(ServiceRequest::class, 'office_id');
    }
    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class);
    }
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
