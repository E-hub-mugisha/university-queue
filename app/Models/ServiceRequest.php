<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'request_number',
        'student_id',
        'department_id',
        'service_type_id',
        'description',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($req) {
            if (empty($req->request_number)) {
                $req->request_number = self::generateRequestNumber();
            }
        });
    }

    private static function generateRequestNumber()
    {
        do {
            $number = 'REQ-' . date('Y') . '-' . strtoupper(uniqid());
        } while (self::where('request_number', $number)->exists());

        return $number;
    }

    public function attachments()
    {
        return $this->hasMany(RequestAttachment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function replies()
    {
        return $this->hasMany(ServiceRequestReply::class)->latest();
    }
}
