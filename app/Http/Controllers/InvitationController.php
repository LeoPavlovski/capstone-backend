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
    public function updateInvitationStatus(Request $request, $invitationId)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // Find the invitation by ID
        $invitation = InternshipStudent::findOrFail($invitationId);

        // Update the status of the invitation
        $invitation->status = $validated['status'];
        $invitation->save();

        return response()->json(['message' => 'Invitation status updated successfully', 'invitation' => $invitation], 200);
    }
    public function getProfessorInternships($professor_id)
    {
        // Validate the professor ID
        $professor_id = intval($professor_id);

        // Check if the professor exists
        $professorExists = \DB::table('users')->where('id', $professor_id)->where('roleId', 2)->exists();

        if (!$professorExists) {
            return response()->json(['message' => 'Professor not found'], 404);
        }

        // Fetch internships that the professor is supervising
        $internships = \DB::table('internships')
            ->where('user_id', $professor_id) // Assuming user_id is the professor's ID
            ->get();

        if ($internships->isEmpty()) {
            return response()->json(['message' => 'No internships found for this professor'], 404);
        }

        // Fetch students that have joined these internships
        $internshipIds = $internships->pluck('id')->toArray();

        $students = InternshipStudent::whereIn('internship_id', $internshipIds)
            ->with(['student', 'internship']) // Assuming relationships with student and internship models
            ->get();

        return response()->json(['internships' => $internships, 'students' => $students], 200);
    }
}
