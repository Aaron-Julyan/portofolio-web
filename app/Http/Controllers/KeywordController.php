<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\Post;
use Illuminate\Http\Request;

class KeywordController extends Controller
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

        //ambil keyword post
        $postkeyword = Keyword::where('post_id', $postid)->get();

        return view('createpostkeyword',  compact('postkeyword', 'postid'));;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validateData['post_id'] = $request->postid;
        $validateData['keyword'] = $request->keyword;

        // if ($request->selectedId == '0') {
        //     session(['postid' => $request->postid]);
        //     return redirect('/createpostcontributor')->with('error', 'No User Selected!');
        // }

        Keyword::create($validateData);

        if (session()->has('edited')) {
            session()->put('edited', 'Post Updated!');
            session(['postid' => $request->postid]);

            //untuk remember permission
            if (session()->has('isAdmin')) {
                $permissionId = session('isAdmin');
                session()->put('isAdmin', $permissionId);
            }

            return redirect('/createpostkeyword')->with('success', 'New Keyword Added!');
        } else {
            //untuk remember permission
            if (session()->has('isAdmin')) {
                $permissionId = session('isAdmin');
                session()->put('isAdmin', $permissionId);
            }
            
            session(['postid' => $request->postid]);
            return redirect('/createpostkeyword')->with('success', 'New Keyword Added!');
        }
    }

    public function show($postid)
    {
        $postcontributor = Keyword::where('post_id', $postid)->get();

        session(['postid' => $postid]);
        return view('createpostkeyword',  compact('postcontributor', 'postid'));
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
        Keyword::destroy($id);

        session(['postid' => $postid]);
        return redirect('/createpostkeyword')->with('success', 'Keyword Deleted!');
    }
}
