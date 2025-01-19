<?php
namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // List contents with search and pagination
    public function index(Request $request)
    {
        $query = Content::query();

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Paginate results (default 10 items per page)
        $contents = $query->paginate(10);

        return response()->json($contents);
    }
    public function indexall()
    {
        $query = Content::query();

        // Search by title

        // Paginate results (default 10 items per page)
        $contents = $query->paginate(6);

        return response()->json($contents);
    }

    // Create new content
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $content = Content::create($validated);

        return response()->json($content, 201);
    }

    // Get content by ID
    public function show($id)
    {
        $content = Content::findOrFail($id);

        return response()->json($content);
    }

    // Update content
    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);

        $content->update($validated);

        return response()->json($content);
    }

    // Delete content
    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return response()->json(['message' => 'Content deleted successfully']);
    }
}
