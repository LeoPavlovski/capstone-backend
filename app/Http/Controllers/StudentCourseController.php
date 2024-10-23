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

        // Check if the course is full
        if ($course->max_students <= 0) {
            return response()->json(['message' => 'The course is full'], 400);
        }

        // Check if the user has already joined the course
        if ($user->courses()->where('course_id', $validated['course_id'])->exists()) {
            return response()->json(['message' => 'You have already joined this course'], 400);
        }

        // Attach the student to the course
        $user->courses()->attach($validated['course_id']);

        // Decrement the max_students count
        $course->decrement('max_students'); // This automatically updates the max_students field

        return response()->json(['message' => 'Successfully joined the course', 'remaining_spots' => $course->max_students]);
    }
    public function leaveCourse(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = User::find($validated['user_id']);
        $course = Course::find($validated['course_id']);

        // Check if the user is actually enrolled in the course
        if (!$user->courses()->where('course_id', $validated['course_id'])->exists()) {
            return response()->json(['message' => 'You are not enrolled in this course'], 400);
        }

        // Detach the student from the course
        $user->courses()->detach($validated['course_id']);

        // Increment the max_students count
        $course->increment('max_students'); // This automatically updates the max_students field

        return response()->json(['message' => 'Successfully left the course', 'remaining_spots' => $course->max_students]);
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
        $courses = Course::where('user_id', $professorId)->get(['id', 'name', 'description']);

        // Fetch students who have joined these courses, including course details
        $students = User::whereHas('courses', function($query) use ($courses) {
            $query->whereIn('courses.id', $courses->pluck('id')); // Specify 'courses.id' to avoid ambiguity
        })->where('roleId', 1) // Ensure this matches the roleId for students
        ->with(['courses' => function($query) use ($courses) {
            $query->whereIn('courses.id', $courses->pluck('id')) // Specify 'courses.id' here too
            ->withPivot('created_at', 'updated_at');
        }])
            ->get(['users.id', 'name', 'surname', 'roleId']); // Specify 'users.id' explicitly

        return response()->json($students);
    }

}
