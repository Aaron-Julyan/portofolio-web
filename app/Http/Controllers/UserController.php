<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserStore;
use App\Models\User;
use App\Models\Post;
use App\Models\Contributor;
use App\Models\Keyword;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // forget semua session
        if (session()->has('edited')) {
            session()->forget('edited');
        }
        if (session()->has('isAdmin')) {
            session()->forget('isAdmin');
        }

        // dd(session('edited'), session('isAdmin'));

        $datauser = Auth::user();
        $members = User::paginate(5); //data member dari group
        $datapost = Post::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $postcontributor = [];
        $postkeyword = [];
        foreach ($datapost as $post) {
            // $postfile[$post->id] = File::where('post_id', $post->id)->get(); 
            $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
                ->join('users', 'users.id', '=', 'contributors.user_id')
                ->where('contributors.post_id', $post->id)
                ->get();
            $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        }

        session()->put('groupId', $datauser->id); //untuk check member list
        return view('profile', compact('datauser', 'members', 'datapost', 'postcontributor', 'postkeyword'));
    }

    public function finishpost()
    {
        // dd(session('edited'), session('isAdmin'));
        $datauser = Auth::user();
        $members = User::paginate(5);
        $datapost = Post::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $postcontributor = [];
        $postkeyword = [];
        foreach ($datapost as $post) {
            $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
                ->join('users', 'users.id', '=', 'contributors.user_id')
                ->where('contributors.post_id', $post->id)
                ->get();
            $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        }
        // dd(session('isAdmin'), session('edited'));

        //untuk permission
        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            $permissionUser = User::find($permissionId);

            if (session()->has('edited')) {
                return redirect('/viewprofile/' . $permissionId)
                    ->with(compact('datauser', 'members', 'datapost', 'postcontributor', 'postkeyword'))
                    ->with('edited', 'Post Edited!');
            } else {
                return redirect('/viewprofile/' . $permissionId)
                    ->with(compact('datauser', 'members', 'datapost', 'postcontributor', 'postkeyword'))
                    ->with('success', 'New Post Created!');
            }
        } else {
            if (session()->has('edited')) {
                return view('/profile')->with(compact('datauser', 'members', 'datapost', 'postcontributor', 'postkeyword'))->with('edited', 'Post Updated!');
            } else {
                return view('/profile')->with(compact('datauser', 'members', 'datapost', 'postcontributor', 'postkeyword'))->with('edited', 'New Post Created!');
            }
        }

        // if (session()->has('edited')) {
        //     return view('/profile')->with(compact('datauser', 'members', 'datapost', 'postcontributor', 'postkeyword'))->with('edited', 'Post Updated!');
        // } else {
        //     return view('/profile')->with(compact('datauser', 'members', 'datapost', 'postcontributor', 'postkeyword'))->with('edited', 'New Post Created!');
        // }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserStore $request)
    {
        //create user di RegisterController
    }

    public function show($viewprofileid)
    {
        //sebelum memasukkan value session baru pada isAdmin,  forget semua session
        if (session()->has('edited')) {
            session()->forget('edited');
        }
        if (session()->has('isAdmin')) {
            session()->forget('isAdmin');
        }

        // dd(session('edited'), session('isAdmin'));

        $datauser = User::find($viewprofileid);
        // $members = User::paginate(5);

        //session groupId untuk view member list (meskipun login atau tidak)
        if (Auth::check()) {
            $isAdmin = Group::where('user_id', Auth::user()->id)
                ->where('group_id', $viewprofileid)
                ->where('status', 'Admin')
                ->exists(); 

            if ($isAdmin) {
                session()->put('isAdmin', $viewprofileid);
            }

            session()->put('groupId', $viewprofileid);
        } else {
            session()->put('groupId', $viewprofileid);
            $isAdmin = false;
        }

        $datapost = Post::where('user_id', $viewprofileid)
            ->orderBy('created_at', 'desc')
            ->get();

        $postcontributor = [];
        $postkeyword = [];
        foreach ($datapost as $post) {
            $postcontributor[$post->id] = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
                ->join('users', 'users.id', '=', 'contributors.user_id')
                ->where('contributors.post_id', $post->id)
                ->get();
            $postkeyword[$post->id] = Keyword::where('post_id', $post->id)->get();
        }

        session()->put('groupId', $datauser->id); //untuk check member list
        
        // kalo view profile sendiri akan direct ke /profile
        if (Auth::check()) {
            if (Auth::user()->id == $viewprofileid) {
                return view('profile', compact('datauser', 'isAdmin', 'datapost', 'postcontributor', 'postkeyword'));
            } else {
                return view('viewprofile', compact('datauser', 'isAdmin', 'datapost', 'postcontributor', 'postkeyword'));
            }
        } else {
            return view('viewprofile', compact('datauser', 'isAdmin', 'datapost', 'postcontributor', 'postkeyword'));
        }
    }

    public function edit()
    {
        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            $datauser = User::find($permissionId);
            return view('editprofile', compact("datauser"));
        } else {
            $datauser = Auth::user();
            return view('editprofile', compact("datauser"));
        }
    }

    public function update(UserStore $request, $id)
    {
        // $user = Auth::user();
        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            $user = User::find($permissionId);
        } else {
            $user = Auth::user();
        }
        // dd($request->all());

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'email:dns',
            'category' => 'max:255',
            'description' => 'max:255',
            'file' => 'image|file|max:3072'
        ]);

        if ($request->email != $user->email) {
            $validatedData['email'] .= '|unique:users';
        }

        if ($request->file('file')) {
            if ($user->file) {
                Storage::delete($user->file);
            }
            $validatedData['file'] = $request->file('file')->store('profile-images');
        }

        User::where('id', $user->id)
            ->update($validatedData);

        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            return redirect('/viewprofile/' . $permissionId)->with('success', 'Profile Updated!');
        } else {
            return redirect('/profile')->with('success', 'Profile Updated!');
        }
    }

    public function destroy($id)
    {
        //
    }


    //ga dipake ya ini?
    public function getcontributors($postid)
    {
        dd("Accessing getContributors function with postid: $postid");
        // Validasi postId
        $post = Post::find($postid);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Ambil kontributor untuk post tersebut
        $contributors = Contributor::where('post_id', $postid)->get();

        // Format data yang akan dikirimkan ke client
        // Menggunakan relasi user untuk mengambil data
        $contributorsData = $contributors->map(function ($contributor) {
            return [
                'name' => $contributor->user->name,
                'email' => $contributor->user->email,
                'image_url' => $contributor->user->file,
            ];
        });

        dd($contributorsData);

        return response()->json($contributorsData);
    }
}
