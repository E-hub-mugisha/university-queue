<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['staff_number','user_id', 'department_id', 'faculty_id', 'position', 'phone'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($staff) {
            if (empty($staff->staff_number)) {
                $staff->staff_number = self::generateStaffNumber();
            }
        });
    }

    public static function generateStaffNumber()
    {
        do {
            $number = 'STF-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('staff_number', $number)->exists());

        return $number;
    }

    // Link to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Link to department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Link to faculty
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
