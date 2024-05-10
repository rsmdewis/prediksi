<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('show.index', compact('posts'));
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments()->latest()->get();
        return view('show.detail', compact('post', 'comments'));
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'content' => 'required',
        ]);

        Comment::create([
            'post_id' => $postId,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
