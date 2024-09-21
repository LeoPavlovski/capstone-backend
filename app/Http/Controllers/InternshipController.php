<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json(Internship::all());
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request including the company_id
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location' => 'required|string',
            'duration' => 'required|string',
            'stipend' => 'required|boolean',
            'deadline' => 'required|date',
            'user_id' => 'required|exists:users,id', // Ensure user_id exists
            'company'=>'required'
        ]);

        // Create the internship with the validated data
        $internship = Internship::create($validatedData);

        return response()->json($internship, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Internship::findOrFail($id));
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
    public function update(Request $request, string $id)
    {
        $internship = Internship::findOrFail($id);
        $internship->update($request->all());
        return response()->json($internship, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Internship::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
