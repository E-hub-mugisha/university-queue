<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'user_id',
        'department_id',
        'faculty_id',
        'program',
        'level',
        'phone'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if (empty($student->student_number)) {
                $student->student_number = self::generateStudentNumber();
            }
        });
    }

    private static function generateStudentNumber()
    {
        do {
            $number = 'STD-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('student_number', $number)->exists());

        return $number;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
