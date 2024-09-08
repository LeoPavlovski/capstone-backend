<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'time', 'location', 'course_code', 'max_students', 'user_id',
    ];
    public function students()
    {
        return $this->belongsToMany(User::class, 'students_courses', 'course_id', 'user_id');
    }

}
