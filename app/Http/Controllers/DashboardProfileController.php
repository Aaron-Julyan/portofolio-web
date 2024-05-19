<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\Post;
use App\Models\Contributor;
use App\Models\Keyword;
use Illuminate\Support\Facades\Auth;

class DashboardProfileController extends Controller
{
    public function index()
    {
        $sendvalue = "No Value";

        //ambil semua postingan
        $datapost = Post::orderBy('created_at', 'desc')->get();
        //ambil semua user selain dirinya sendiri
        $currentUser = Auth::user();
        $datauser = User::all();

        //untuk button tag
        $tagcategories = User::orderBy('category')
            ->whereNotNull('category')
            ->distinct('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('category');

        // dd($datauser);
        return view('dashboardprofile', compact('datauser', 'tagcategories', 'sendvalue'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($value)
    {
        // dd($value);

        //ini sama kayak dashboard
        //ambil semua postingan berdasarkan tag yang di select
        $sendvalue = $value;

        // $datapost = Post::orderBy('created_at', 'desc')
        //     ->where('category', $value)
        //     ->get();

        //ambil semua user selain dirinya sendiri
        $currentUser = Auth::user();
        $datauser = User::where('category', $value)->get();

        // $postfile = [];
        // $postcontributor = [];
        // $postkeyword = [];
        // foreach ($datapost as $post) {
        //     $postcontributor[$post->id] = Contributor::where('post_id', $post->id)->get();
        //     $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        // }

        //untuk button tag
        $tagcategories = User::orderBy('category')
            ->whereNotNull('category')
            ->distinct('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('category');

        // dd($tagcategories);
        // return view('dashboardprofile', compact('datauser', 'datapost', 'postcontributor', 'postkeyword', 'tagcategories', 'sendvalue'));
        return view('dashboardprofile', compact('datauser', 'tagcategories', 'sendvalue'));
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
