<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $postid = session('postid');
        // dd($postid);
        $post = Post::find($postid);
        $postfile = File::where('post_id', $postid)->get();

        if (session()->has('edited')) {
            session()->put('edited', 'Post Updated!');
        }

        //untuk remember permission
        if (session()->has('isAdmin')) {
            $permissionId = session('isAdmin');
            session()->put('isAdmin', $permissionId);
        }

        session(['postid' => $postid]); //supaya kalo tidak melakukan apa-apa tetap mengirimkan id
        return view('createpostfile',  compact('postfile', 'postid'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'filename' => 'required',
        ]);

        $validateData['post_id'] = $request->postid; //taruh diatas soalnya mau dipakai album

        // dd($request->all());
        if ($request->selectFile == "0") {
            if (session()->has('edited')) {
                session()->put('edited', 'Post Updated!');
            }

            //untuk remember permission
            if (session()->has('isAdmin')) {
                $permissionId = session('isAdmin');
                session()->put('isAdmin', $permissionId);
            }

            session(['postid' => $request->postid]);
            return redirect('/createpostfile')->with('error', 'Please Select File Type!');
        }

        if ($request->input('link')) {
            $validateData['filetype'] = "Link";
        } else if ($request->file('image')) {
            $validateData['filetype'] = "Image";
        } else if ($request->file('album')) {
            $validateData['filetype'] = "Album";
        } else if ($request->file('video')) {
            $validateData['filetype'] = "Video";
        } else if ($request->file('audio')) {
            $validateData['filetype'] = "Audio";
        } else if ($request->file('object')) {
            $validateData['filetype'] = "Object";
        } else if ($request->file('document')) {
            $validateData['filetype'] = "Document";
        }

        //validations
        if ($request->input('link')) {
            $validateSingleImage = Validator::make($request->all(), [
                'link' => 'url',
            ]);
            if ($validateSingleImage->fails()) {
                return redirect('/createpostfile')->with(['postid' => $request->postid, 'error' => 'Please Insert Link!']);
            }
        } else if ($request->has('image')) {
            $validateSingleImage = Validator::make($request->all(), [
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);
            if ($validateSingleImage->fails()) {
                return redirect('/createpostfile')->with(['postid' => $request->postid, 'error' => 'File Must be an Image (jpg, jpeg, png)!']);
            }
        } else if ($request->has('album')) {
            foreach ($request->file('album') as $singleImage) { // Validasi setiap file dalam album
                $validateSingleImage = Validator::make(['album' => $singleImage], [
                    'album' => 'image|mimes:jpeg,png,jpg',
                ]);
                if ($validateSingleImage->fails()) {
                    return redirect('/createpostfile')->with(['postid' => $request->postid, 'error' => 'File Must be Multiple Image (jpg, jpeg, png)!']);
                }
            }
        } else if ($request->has('video')) {
            $validateSingleImage = Validator::make($request->all(), [
                'video' => 'mimes:mp4',
            ]);
            if ($validateSingleImage->fails()) {
                return redirect('/createpostfile')->with(['postid' => $request->postid, 'error' => 'File Must be a Video (mp4)!']);
            }
        } else if ($request->has('audio')) {
            $validateSingleImage = Validator::make($request->all(), [
                'audio' => 'mimes:mp3,wav',
            ]);
            if ($validateSingleImage->fails()) {
                return redirect('/createpostfile')->with(['postid' => $request->postid, 'error' => 'File Must be an Audio (mp3)!']);
            }
        } else if ($request->has('object')) {
            $validateSingleImage = Validator::make($request->all(), [
                'object' => 'file',
            ]);
            if ($validateSingleImage->fails()) {
                return redirect('/createpostfile')->with(['postid' => $request->postid, 'error' => 'File Must be a 3D Object (glb/gltf)!']);
            }
        } else if ($request->has('document')) {
            $validateSingleImage = Validator::make($request->all(), [
                'document' => 'mimes:pdf',
            ]);
            if ($validateSingleImage->fails()) {
                return redirect('/createpostfile')->with(['postid' => $request->postid, 'error' => 'File Must be a Document (pdf)!']);
            }
        }

        // input to file db
        if ($request->input('link')) {
            $validateData['file'] = $request->input('link');
        } else if ($request->has('image')) {
            $request->file('image')->store('public-images');
            $validateData['file'] = $request->file('image')->hashName();
        } else if ($request->has('album')) {
            foreach ($request->file('album') as $singleImage) {
                $singleImage->store('album-images');
                $validateData['file'] = $singleImage->hashName();

                File::create([
                    'post_id' => $request->postid,
                    'filetype' => "Album",
                    'filename' => $request->filename,
                    'file' => $singleImage->hashName()
                ]);
            }
        } else if ($request->has('video')) {
            $request->file('video')->store('public-videos');
            $validateData['file'] = $request->file('video')->hashName();
        } else if ($request->has('audio')) {
            $request->file('audio')->store('public-audios');
            $validateData['file'] = $request->file('audio')->hashName();
        } else if ($request->has('object')) {
            $request->file('object')->store('public-objects');
            $validateData['file'] = $request->file('object')->hashName();
        } else if ($request->has('document')) {
            $request->file('document')->store('public-documents');
            $validateData['file'] = $request->file('document')->hashName();
        }

        //kalo album harus masukin gambar satu-satu
        if (!$request->has('album')) {
            File::create($validateData);
        }

        if (session()->has('edited')) {
            session()->put('edited', 'Post Updated!');
            session(['postid' => $request->postid]);

            //untuk remember permission
            if (session()->has('isAdmin')) {
                $permissionId = session('isAdmin');
                session()->put('isAdmin', $permissionId);
            }

            return redirect('/createpostfile')->with('success', 'New File Added!');
        } else {
            //untuk remember permission
            if (session()->has('isAdmin')) {
                $permissionId = session('isAdmin');
                session()->put('isAdmin', $permissionId);
            }

            session(['postid' => $request->postid]);
            return redirect('/createpostfile')->with('success', 'New Post Added!');
        }
    }

    public function show($postid)
    {
        $post = Post::find($postid);
        $postfile = File::where('post_id', $postid)->get();

        session(['postid' => $postid]);
        return view('createpostfile',  compact('postfile', 'postid'));
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
        $file = File::find($id);
        // dd($postid);

        if ($file->filetype == 'Link') {
            File::destroy($id);
        } else if ($file->filetype == 'Image') {
            Storage::delete('public-images/' . $file->file);
            File::destroy($id);
        } else if ($file->filetype == 'Album') {
            Storage::delete('album-images/' . $file->file);
            File::destroy($id);
        } else if ($file->filetype == 'Video') {
            Storage::delete('public-videos/' . $file->file);
            File::destroy($id);
        } else if ($file->filetype == 'Audio') {
            Storage::delete('public-audios/' . $file->file);
            File::destroy($id);
        } else if ($file->filetype == 'Object') {
            Storage::delete('public-objects/' . $file->file);
            File::destroy($id);
        } else if ($file->filetype == 'Document') {
            Storage::delete('public-documents/' . $file->file);
            File::destroy($id);
        }

        session(['postid' => $postid]);
        return redirect('/createpostfile')->with('success', 'File Deleted!');
    }

    public function viewpostfile($fileid)
    {
        $files = File::find($fileid);
        // dd($files);

        return view('/viewpostfile',  compact('files'));
    }
}
