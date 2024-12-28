<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getAllPosts()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(2);

        $post = $posts->getCollection()->map(function ($value) {
            return [
                'id' => $value->id,
                'title' => $value->title,
                'description' => $value->description,
                'author' => $value->user->name
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data post',
            'data' => $post,
            'pagination' => [
                'retrieved_items' => $posts->count(),
                'total_items' => $posts->total(),
                'item_per_page' => $posts->perPage(),
                'total_pages' => $posts->lastPage(),
                'current_page' => $posts->currentPage(),
                'current_page_url' => $posts->url($posts->currentPage()),
                'previous_page_url' => $posts->previousPageUrl(),
                'next_page_url' => $posts->nextPageUrl()
            ]
        ]);
    }

    public function getPostByUser()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(2);

        $post = $posts->getCollection()->map(function ($value) {
            return [
                'id' => $value->id,
                'title' => $value->title,
                'description' => $value->description,
                'author' => $value->user->name
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data post berdasarkan user',
            'data' => $post,
            'pagination' => [
                'retrieved_items' => $posts->count(),
                'total_items' => $posts->total(),
                'item_per_page' => $posts->perPage(),
                'total_pages' => $posts->lastPage(),
                'current_page' => $posts->currentPage(),
                'current_page_url' => $posts->url($posts->currentPage()),
                'previous_page_url' => $posts->previousPageUrl(),
                'next_page_url' => $posts->nextPageUrl()
            ]
        ]);
    }

    public function getDetailPost(Post $post)
    {
        $post = Post::where('id', $post->id)->first();

        return response([
            'success' => true,
            'message' => 'Berhasil mengambil detail post',
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                ''
            ]
        ]);
    }

    public function createPost(Request $request)
    {
        $user = Auth::user();

        if ($user->tokenCan('Author')) {
            $data = $request->all();
            $rules = [
                'title' => 'required',
                'description' => 'required'
            ];
            $messages = [
                'title.required' => 'Judul tidak boleh kosong',
                'description.required' => 'Deskripsi tidak boleh kosong'
            ];
            $validated = Validator::make($data, $rules, $messages)->validate();
            $validated['user_id'] = $user->id;

            $post = Post::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil membuat post',
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'description' => $post->description,
                    'author' => $user->name
                ]
            ]);
        }
        abort(403);
    }

    public function updatePost(Request $request, Post $post)
    {
        $user = Auth::user();

        if ($user->tokenCan('Author') && $user->id == $post->user_id) {
            $data = $request->all();
            $rules = [
                'title' => 'required',
                'description' => 'required'
            ];
            $messages = [
                'title.required' => 'Judul tidak boleh kosong',
                'description.required' => 'Deskripsi tidak boleh kosong'
            ];
            $validated = Validator::make($data, $rules, $messages)->validate();

            $post->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengupdate post',
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'description' => $post->description,
                    'author' => $user->name
                ]
            ]);
        }
        abort(403);
    }

    public function deletePost(Post $post)
    {
        $user = Auth::user();

        if ($user->tokenCan('Author') && $user->id == $post->user_id) {
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus post'
            ]);
        }
        abort(403);
    }
}
