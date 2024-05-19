<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\Post;
use App\Models\Contributor;
use App\Models\Keyword;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $sendvalue = "No Value";

        //ambil semua postingan
        $datapost = Post::orderBy('created_at', 'desc')->get();

        $postfile = [];
        $postcontributor = [];
        $postkeyword = [];
        foreach ($datapost as $post) {
            $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
                ->join('users', 'users.id', '=', 'contributors.user_id')
                ->where('contributors.post_id', $post->id)
                ->get();
            $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        }

        //untuk button tag
        $tagdepartment = Post::orderBy('department')
            ->distinct('department')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('department');

        $tagcategories = Post::orderBy('categories')
            ->distinct('categories')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('categories');

        $tagsubcategories = Post::orderBy('subcategories')
            ->distinct('subcategories')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('subcategories');

        // recent keyword
        // $tagkeywords = Keyword::orderBy('keyword')
        //     ->distinct('keyword')
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->pluck('keyword');

        // ambil 5 random keywords
        $tagkeywords = Keyword::select('keyword')
            ->distinct()
            ->get()
            ->pluck('keyword')
            ->shuffle()
            ->take(5);

        // dd($tagkeywords);
        return view('dashboard', compact('datapost', 'postcontributor', 'postkeyword', 'tagdepartment', 'tagcategories', 'tagsubcategories', 'tagkeywords', 'sendvalue'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    // ini untuk filter by: department, categories, subcategories
    public function show($value)
    {
        // dd($value);

        //ini sama kayak dashboard
        //ambil semua postingan berdasarkan tag yang di select
        $sendvalue = $value;

        $datapost = Post::orderBy('created_at', 'desc')
            ->where('department', $value)
            ->orWhere('categories', $value)
            ->orWhere('subcategories', $value)
            ->get();

        $postfile = [];
        $postcontributor = [];
        $postkeyword = [];
        foreach ($datapost as $post) {
            $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
                ->join('users', 'users.id', '=', 'contributors.user_id')
                ->where('contributors.post_id', $post->id)
                ->get();
            $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        }

        //untuk button tag
        $tagdepartment = Post::orderBy('department')
            ->distinct('department')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('department');

        $tagcategories = Post::orderBy('categories')
            ->distinct('categories')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('categories');

        $tagsubcategories = Post::orderBy('subcategories')
            ->distinct('subcategories')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('subcategories');

        // recent keyword
        // $tagkeywords = Keyword::orderBy('keyword')
        //     ->distinct('keyword')
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->pluck('keyword');

        // ambil 5 random keywords
        $tagkeywords = Keyword::select('keyword')
            ->distinct()
            ->get()
            ->pluck('keyword')
            ->shuffle()
            ->take(5);

        // dd($tagkeywords);

        return view('dashboard', compact('datapost', 'postcontributor', 'postkeyword', 'tagdepartment', 'tagcategories', 'tagsubcategories', 'tagkeywords', 'sendvalue'));
    }

    // ini untuk filter by: keyword
    public function showkeywordresult($value)
    {
        //ini sama kayak dashboard
        //ambil semua postingan berdasarkan tag yang di select
        $sendvalue = $value;

        $datakeyword = Keyword::where('keyword', $value)->get();
        $postid = $datakeyword->pluck('post_id');
        $datapost = Post::whereIn('id', $postid)->get();
        // dd($datakeyword, $postid, $datapost);

        $postfile = [];
        $postcontributor = [];
        $postkeyword = [];
        foreach ($datapost as $post) {
            $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
                ->join('users', 'users.id', '=', 'contributors.user_id')
                ->where('contributors.post_id', $post->id)
                ->get();
            $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        }

        //untuk button tag
        $tagdepartment = Post::orderBy('department')
            ->distinct('department')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('department');

        $tagcategories = Post::orderBy('categories')
            ->distinct('categories')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('categories');

        $tagsubcategories = Post::orderBy('subcategories')
            ->distinct('subcategories')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('subcategories');

        // recent keyword
        // $tagkeywords = Keyword::orderBy('keyword')
        //     ->distinct('keyword')
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->pluck('keyword');

        // ambil 5 random keywords
        $allKeywords = Keyword::select('keyword')
            ->where('keyword', '!=', $value)
            ->distinct()
            ->get()
            ->pluck('keyword');

        $randomKeywords = $allKeywords->shuffle()->take(4);
        $tagkeywords = $randomKeywords->prepend($value);
        // dd($tagkeywords);

        return view('dashboard', compact('datapost', 'postcontributor', 'postkeyword', 'tagdepartment', 'tagcategories', 'tagsubcategories', 'tagkeywords', 'sendvalue'));
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
