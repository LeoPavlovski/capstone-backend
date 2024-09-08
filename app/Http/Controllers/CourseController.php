<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'time' => 'required',
                'location' => 'required|string|max:255',
                'course_code' => 'required|string|unique:courses,course_code|max:10',
                'max_students' => 'required|integer',
                'user_id' => 'required|exists:users,id', // Validate that user_id exists in users table
            ]);

            $course = Course::create($validatedData);
            return response()->json($course, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
    }
    public function getCreator($id)
    {
        $course = Course::findOrFail($id);
        return response()->json(['user_id' => $course->user_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
            'time' => 'sometimes|required',
            'location' => 'sometimes|required|string|max:255',
            'course_code' => 'sometimes|required|string|unique:courses,course_code,'.$id.'|max:10',
            'max_students' => 'sometimes|required|integer',
        ]);

        $course = Course::findOrFail($id);
        $course->update($validatedData);
        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(null, 204);
    }
}
