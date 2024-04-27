<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return response()->json(['data' => $branches]);
    }

    public function show($slug)
    {
        $branch = Branch::where('slug', $slug)->firstOrFail();
        return response()->json(['data' => $branch]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:branches',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:open,temporarily-closed,closed'
        ]);

        $branch = Branch::create($request->all());
        return response()->json(['message' => 'Branch created successfully', 'data' => $branch], 201);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:branches,slug,' . $id,
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:open,temporarily-closed,closed'
        ]);

        $branch->update($request->all());
        return response()->json(['message' => 'Branch updated successfully', 'data' => $branch]);
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
