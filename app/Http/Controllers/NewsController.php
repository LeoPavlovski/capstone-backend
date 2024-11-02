<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // Get all news
        $news = News::all();
        return response()->json($news);
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'department' => 'required|integer',
        ]);

        // Create new news entry
        $news = News::create($validated);
        return response()->json($news, 201);
    }

    public function show($id)
    {
        // Get news by ID
        $news = News::findOrFail($id);
        return response()->json($news);
    }

    public function update(Request $request, $id)
    {
        // Validate request
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author' => 'sometimes|required|string|max:255',
            'publication_date' => 'sometimes|required|date',
            'department' => 'required|integer',
        ]);

        // Update news
        $news = News::findOrFail($id);
        $news->update($validated);
        return response()->json($news);
    }

    public function destroy($id)
    {
        // Delete news
        $news = News::findOrFail($id);
        $news->delete();
        return response()->json(['message' => 'News deleted successfully']);
    }
}
