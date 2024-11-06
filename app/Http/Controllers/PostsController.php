<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

use App\Models\Post;
use Illuminate\Http\Request;


#[OA\Info(
    version: '1.0.0',
    title: 'My API',
)]
#[OA\License(name: 'MIT')]
class PostsController extends Controller
{

    #[OA\Get(
        path: '/api/posts',
        summary: 'List all posts',
        responses: [
            new OA\Response(
                response: '200',
                description: 'A list of posts'
            )
        ]
    )]
    public function getAllPosts()
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

    #[OA\Post(
        path: '/api/posts',
        summary: 'Create a new post',
        requestBody: new OA\RequestBody(
            required: true,
            content: [
                new OA\JsonContent(ref: '#/components/schemas/Post')
            ]
        ),
        responses: [
            new OA\Response(
                response: '201',
                description: 'Post created successfully',
                content: [
                    new OA\JsonContent(ref: '#/components/schemas/Post')
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error'
            ),
            new OA\Response(
                response: '500',
                description: 'Server error'
            )
        ]
    )]
    public function createdPost(Request $request)
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

    #[OA\Get(
        path: '/api/posts/{id}',
        summary: 'Get a post by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID of the post',
                schema: new OA\Schema(type: 'integer') 
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Post found',
                content: [
                    new OA\JsonContent(ref: '#/components/schemas/Post')
                ]
            ),
            new OA\Response(
                response: '404',
                description: 'Post not found'
            )
        ]
    )]
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

    #[OA\Put(
        path: '/api/posts/{id}',
        summary: 'Update a post by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID of the post',
                schema: new OA\Schema(type: 'integer') 
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: [
                new OA\JsonContent(ref: '#/components/schemas/Post')
            ]
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Post updated successfully',
                content: [
                    new OA\JsonContent(ref: '#/components/schemas/Post')
                ]
            ),
            new OA\Response(
                response: '404',
                description: 'Post not found'
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error'
            )
        ]
    )]
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

    #[OA\Delete(
        path: '/api/posts/{id}',
        summary: 'Delete a post by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID of the post',
                schema: new OA\Schema(type: 'integer') 
            )
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Post deleted successfully'
            ),
            new OA\Response(
                response: '404',
                description: 'Post not found'
            )
        ]
    )]
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

#[OA\Schema(
    schema: 'Post',
    type: 'object',
    required: ['title', 'author', 'content', 'tags'],
)]
class PostSchema
{
    #[OA\Property(type: 'string', example: 'Post Title')]
    public string $title;

    #[OA\Property(type: 'string', example: 'Author Name')]
    public string $author;

    #[OA\Property(type: 'string', example: 'Post content')]
    public string $content;

    #[OA\Property(type: 'array', items: new OA\Items(type: 'string'), example: '["tag1", "tag2", "tag3"]')]
    public array $tags;
}

#[OA\Schema(
    schema: 'IntegerSchema',
    type: 'integer',
    description: 'Um número inteiro representando o ID do post.',
    example: 1
)]
class IntegerSchema
{
}