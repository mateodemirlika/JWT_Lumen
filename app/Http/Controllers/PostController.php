<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {

            $post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();
            $category = Category::find(1);
            $post->categories()->attach($category);


            return response()->json(['status' => 'success', 'message' => 'Post created successfully'],201);

//            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

    }
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return response([
                'data' => $post,
                'message' => 'Product Found'
            ],200);
        }
        catch(ModelNotFoundException $exception) {
            return response(['message' => 'Product Not Found!'],404);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->body = $request->body;

            if ($post->save()) {
                return response()->json(['status' => 'success', 'message' => 'Post updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Post deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
