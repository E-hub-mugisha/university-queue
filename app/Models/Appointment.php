<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'service_request_id',
        'appointment_date',
        'appointment_time',
        'location',
        'status',
    ];
}
