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

    private static function generateStudentNumber(): string
    {
        $year = date('Y');

        $last = self::whereYear('created_at', $year)
            ->where('student_number', 'like', "%/$year")
            ->orderByDesc('id')
            ->first();

        $nextNumber = $last
            ? ((int) explode('/', $last->student_number)[0] + 1)
            : 1;

        return str_pad($nextNumber, 5, '0', STR_PAD_LEFT) . "/$year";
    }

    protected static function booted()
    {
        static::creating(function ($student) {
            if (empty($student->student_number)) {
                $student->student_number = self::generateStudentNumber();
            }
        });
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
