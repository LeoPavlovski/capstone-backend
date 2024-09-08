<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function joinCourse(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = User::find($validated['user_id']);
        $course = Course::find($validated['course_id']);

        // Check if the user has already joined the course
        if ($user->courses()->where('course_id', $validated['course_id'])->exists()) {
            return response()->json(['message' => 'You have already joined this course'], 400);
        }

        // Attach the student to the course
        $user->courses()->attach($validated['course_id']);

        return response()->json(['message' => 'Successfully joined the course']);
    }

    public function getStudentCourses($studentId)
    {
        // Find the student by ID
        $student = User::find($studentId);

        // If the student doesn't exist, return an error response
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Retrieve the courses associated with the student, including pivot data
        $courses = $student->courses()->withPivot('created_at', 'updated_at')->get();

        // Optionally, you can load additional user information if needed
        // $courses->load('user');

        return response()->json($courses);
    }
    public function getStudentsForProfessor($professorId)
    {
        // Find the courses taught by the professor
        $courses = Course::where('user_id', $professorId)->pluck('id');

        // Fetch students who have joined these courses
        $students = User::whereHas('courses', function($query) use ($courses) {
            $query->whereIn('course_id', $courses);
        })->where('roleId', 1) // Ensure this matches the roleId for students
        ->get(['id', 'name', 'surname']);

        return response()->json($students);
    }
}
