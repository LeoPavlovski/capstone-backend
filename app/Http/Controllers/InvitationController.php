<?php

namespace App\Http\Controllers;

use App\Models\InternshipStudent;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function invite(Request $request)
    {
        $validated = $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'student_id' => 'required|exists:users,id',
        ]);

        // Check if the student is already invited
        $exists = InternshipStudent::where('internship_id', $validated['internship_id'])
            ->where('student_id', $validated['student_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Student already invited'], 400);
        }

        // Create the invitation
        $invitation = InternshipStudent::create([
            'internship_id' => $validated['internship_id'],
            'student_id' => $validated['student_id'],
        ]);

        return response()->json(['message' => 'Invitation sent successfully', 'invitation' => $invitation], 201);
    }
    public function getStudentInvitations($student_id)
    {
        // Validate the student ID
        $student_id = intval($student_id);

        // Check if the student exists
        $studentExists = \DB::table('users')->where('id', $student_id)->exists();

        if (!$studentExists) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Fetch the invitations for the student
        $invitations = InternshipStudent::where('student_id', $student_id)
            ->with('internship') // Assuming you have a relationship with the Internship model
            ->get();

        return response()->json(['invitations' => $invitations], 200);
    }
}
