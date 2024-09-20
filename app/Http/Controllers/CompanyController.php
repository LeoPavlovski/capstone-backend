<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(Company::all());
    }

    // Show a single company
    public function show($id)
    {
        $company = Company::find($id);
        if ($company) {
            return response()->json($company);
        }
        return response()->json(['message' => 'Company not found'], 404);
    }

    // Create a new company
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'companyWebsite' => 'required|string|max:255',
            'companySize' => 'required|integer',
            'industry' => 'required|string',
            'contactPersonName' => 'required|string|max:255',
            'contactPersonEmail' => 'required|email|max:255',
            'contactPersonPhone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',  // Make sure user_id is validated
        ]);

        $company = Company::create($validatedData);
        return response()->json($company, 201);
    }

    // Update a company
    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        if ($company) {
            $validatedData = $request->validate([
                'companyWebsite' => 'sometimes|string|max:255',
                'companySize' => 'sometimes|string',
                'industry' => 'sometimes|string',
                'contactPersonName' => 'sometimes|string|max:255',
                'contactPersonEmail' => 'sometimes|email|max:255',
                'contactPersonPhone' => 'sometimes|string|max:20',
                'address' => 'sometimes|string|max:255',
                'linkedin' => 'nullable|string|max:255',
                'twitter' => 'nullable|string|max:255',
                'name'=>'string'
            ]);

            $company->update($validatedData);
            return response()->json($company);
        }

        return response()->json(['message' => 'Company not found'], 404);
    }

    // Delete a company
    public function destroy($id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->delete();
            return response()->json(['message' => 'Company deleted']);
        }
        return response()->json(['message' => 'Company not found'], 404);
    }
}
