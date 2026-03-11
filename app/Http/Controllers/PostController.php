<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Assuming you have a Post model to handle database interactions
        $post = Post::create($validatedData);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
        ], 201);
    }
}
