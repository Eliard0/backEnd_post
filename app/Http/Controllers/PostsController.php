<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        try {
            return Post::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar os dados',
                'error' => $e->getMessage(),
            ], 404);
        }
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
        try {
            $post = Post::findOrFail($id);
            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar post',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function updatePost(Request $request, $id)
    {
        try {

            $post = Post::findOrFail($id);

            $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'author' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'tags' => 'nullable|array',
            ]);

            $post->update($request->only(['title', 'author', 'content', 'tags']));

            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar post',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao Deletar post',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
