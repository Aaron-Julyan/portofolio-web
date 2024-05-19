<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContributorController extends Controller
{
    public function index()
    {
        if (session()->has('edited')) {
            session()->put('edited', 'Post Updated!');
        }

        //untuk remember permission
        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            session()->put('isAdmin', $permissionId);
        }

        $postid = session('postid');

        //ambil contributor post tersebut saja
        $postcontributor = Contributor::where('post_id', $postid)->get();

        //mengambil user_id dari postcontributor
        if (session()->has('isAdmin')) {
            $userid = session('isAdmin');
        } else {
            $userid = auth()->id();
        }
        $postContributorIds = $postcontributor->pluck('user_id')->toArray();
        $userArray = array_merge([$userid], $postContributorIds);

        //ambil semua pengguna kecuali pengguna yang sedang login 
        //dan pengguna yang sudah ada di $postContributorIds
        $alluser = User::whereNotIn('id', $userArray)->get();
        
        session(['postid' => $postid]); //supaya kalo tidak melakukan apa-apa tetap mengirimkan id
        return view('createpostcontributor',  compact('postcontributor', 'alluser', 'postid'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validateData['post_id'] = $request->postid;
        $validateData['user_id'] = $request->selectedId;

        if ($request->selectedId == '0') {
            session(['postid' => $request->postid]);
            return redirect('/createpostcontributor')->with('error', 'No User Selected!');
        }

        Contributor::create($validateData);

        if (session()->has('edited')) {
            session()->put('edited', 'Post Updated!');
            session(['postid' => $request->postid]);

            //untuk remember permission
            if (session()->has('isAdmin')) {
                $permissionId = session('isAdmin');
                session()->put('isAdmin', $permissionId);
        }

            return redirect('/createpostcontributor')->with('success', 'New Contributor Added!');
        } else {
            //untuk remember permission
            if (session()->has('isAdmin')) {
                $permissionId = session('isAdmin');
                session()->put('isAdmin', $permissionId);
            }

            session(['postid' => $request->postid]);
            return redirect('/createpostcontributor')->with('success', 'New Contributor Added!');
        }
    }

    public function show($postid)
    {
        $postcontributor = Contributor::where('post_id', $postid)->get();

        session(['postid' => $postid]);
        return view('createpostcontributor',  compact('postcontributor', 'postid'));
    }

    public function edit(Request $request)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        $postid = session('postid');
        Contributor::destroy($id);

        session(['postid' => $postid]);
        return redirect('/createpostcontributor')->with('success', 'Contributor Deleted!');
    }
}
