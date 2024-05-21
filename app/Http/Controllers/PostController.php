<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\User;
use App\Models\Post;
use App\Models\File;
use App\Models\Comment;
use App\Models\Contributor;
use App\Models\Keyword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $permissionName = "-";
        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            $permissionUser = User::find($permissionId);
            $permissionName = $permissionUser->name;
            // dd($permissionId, $permissionName);
        }

        return view('createpost', compact('permissionName'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'description' => 'required',
            'department' => 'required|not_in:empty',
            'categories' => 'required|not_in:empty',
            'subcategories' => 'required|not_in:empty',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|dimensions:ratio=16/9,4/3,3/4',
            'slug' => 'required|unique:posts',
        ]);

        $validateData['slug'] = Str::slug($request->slug);
        $validateData['excerpt'] = Str::limit(strip_tags($request->description), 30);

        $thumbnailPath = $request->file('thumbnail')->store('public-thumbnails');
        $validateData['thumbnail'] = $thumbnailPath;

        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            $validateData['user_id'] = $permissionId;
        } else {
            $validateData['user_id'] = auth()->user()->id;
        }

        $newPost = Post::create($validateData);
        $postid = $newPost->id;

        session(['postid' => $postid]);
        // remove edited session value kalo create new post
        if (session()->has('edited')) {
            session()->forget('edited');
        }
        return redirect('/createpostfile')->with('success', 'New Post Created!');
    }

    public function show(Post $post)
    {
        $currentuser = Auth::id();
        // $userpost = $post->user_id;
        // dd($currentUser, $userpost);

        $postfile = File::where('post_id', $post->id)->get();
        $albums = $postfile->where('filetype', 'Album');
        $postcontributor = Contributor::select('contributors.*', 'users.file', 'users.name', 'users.email', 'users.status')
            ->join('users', 'users.id', '=', 'contributors.user_id')
            ->where('contributors.post_id', $post->id)
            ->get();
        $postkeyword = Keyword::where('post_id', $post->id)->get();
        $postcomment = Comment::where('post_id', $post->id)->get();

        return view('viewpost', compact('currentuser', 'post', 'postfile', 'postcontributor', 'postkeyword', 'postcomment', 'albums'));
    }

    public function edit($id)
    {
        $post = Post::find($id);

        return view('editpost', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $validateData = $request->validate([
            'description' => 'required',
            'department' => 'required|not_in:empty',
            'categories' => 'required|not_in:empty',
            'subcategories' => 'required|not_in:empty',
            'thumbnail' => 'image|mimes:jpeg,png,jpg|dimensions:ratio=16/9,4/3,3/4',
        ]);

        if ($request->slug != $post->slug) {
            $validatedData['slug'] = 'required|unique:posts';
        }
        // $validateData['slug'] = Str::slug($request->slug);
        if ($request->description != $post->description) {
            $validateData['excerpt'] = Str::limit(strip_tags($request->description), 30);
        }

        // dd($request->description);

        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            $validateData['user_id'] = $permissionId;
        } else {
            $validateData['user_id'] = auth()->user()->id;
        }

        if ($request->file('thumbnail')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validateData['thumbnail'] = $request->file('thumbnail')->store('public-files');
        }

        //untuk remember permission
        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            session()->put('isAdmin', $permissionId);
        }

        Post::where('id', $id)->update($validateData);

        // send edit status
        session()->put('edited', 'Post Updated!');
        session(['postid' => $post->id]);
        return redirect('/createpostfile')->with('success', 'Post Edited!');

        // session(['postid' => $id]);
        // return view('/createpostfile')->with('success', 'Post Updated!');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $files = File::where('post_id', $post->id)->get();
        // dd($files);

        foreach ($files as $file) {
            if ($file->filetype == 'Image') {
                Storage::delete('public-images/' . $file->file);
            } else if ($file->filetype == 'Video') {
                Storage::delete('public-videos/' . $file->file);
            } else if ($file->filetype == 'Audio') {
                Storage::delete('public-audios/' . $file->file);
            } else if ($file->filetype == 'Object') {
                Storage::delete('public-objects/' . $file->file);
            } else if ($file->filetype == 'Document') {
                Storage::delete('public-documents/' . $file->file);
            }
        }

        Storage::delete($post->thumbnail);
        Post::destroy($id);
        return redirect('/profile')->with('success', 'Post Deleted!');
    }

    // public function checkSlug(Request $request){
    //     $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
    //     return response()->json(['z`slug' => $slug]);
    // }
}
