<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::with('user:id,name')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return $comment->load('user:id,name');
    }
}
