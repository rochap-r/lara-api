<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts= Post::paginate(10);
        return response()->json(['posts' =>$posts], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data=$request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $data['user_id']=1; // Assuming user_id is 1 for demonstration
        $post= Post::create($data);
        return response()->json([
            'message' => 'Post created',
            'data' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return response()->json([
                'data' => $post
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $post = Post::findOrFail($id);
            
            $data = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'body' => 'sometimes|required|string',
            ]);

            $post->update($data);

            return response()->json([
                'data' => $post,
                'message' => 'Post updated ' . $post->id
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return response()->noContent(204);
    }
}
