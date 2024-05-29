<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        $name = Auth::check() ? Auth::user()->name : $request->name;
        $userid = Auth::check() ? Auth::user()->id : null;

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => $userid,
            'name' => $name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'New Comment Succesfully Added!.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
