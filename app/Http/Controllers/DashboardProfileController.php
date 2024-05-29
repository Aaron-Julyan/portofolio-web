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

        //ambil semua user
        $datauser = User::all();

        //untuk button tag
        $tagcategories = User::orderBy('category')
            ->whereNotNull('category')
            ->distinct('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('category');

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
        //sama kayak dashboard
        //ambil semua postingan berdasarkan tag yang di select
        $sendvalue = $value;

        $currentUser = Auth::user();
        $datauser = User::where('category', $value)->get();

        //untuk button tag
        $tagcategories = User::orderBy('category')
            ->whereNotNull('category')
            ->distinct('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('category');

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
