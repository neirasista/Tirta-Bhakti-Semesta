<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        return response()->json(Grade::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gradeName' => 'required|string|max:255',
            'minBudget' => 'required|numeric',
            'maxBudget' => 'required|numeric',
        ]);

        $grade = Grade::create($validated);
        return response()->json(['message' => 'Grade created successfully', 'data' => $grade], 201);
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $validated = $request->validate([
            'gradeName' => 'required|string|max:255',
            'minBudget' => 'required|numeric',
            'maxBudget' => 'required|numeric',
        ]);

        $grade->update($validated);
        return response()->json(['message' => 'Grade updated successfully', 'data' => $grade]);
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();
        return response()->json(['message' => 'Grade deleted successfully']);
    }
}
