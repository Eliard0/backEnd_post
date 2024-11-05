<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index(){
        return Post::all();
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'content' => 'required|string',
                'tags' => 'nullable|array',
            ]);
    
            $post = Post::create([
                'title' => $request->title,
                'author' => $request->author,
                'content' => $request->content,
                'tags' => json_encode($request->tags),
            ]);
    
            return response()->json($post, 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar post',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function searchPost($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }    
}
