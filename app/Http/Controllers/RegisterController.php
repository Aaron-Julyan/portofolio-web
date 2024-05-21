<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;

class RegisterController extends Controller
{

    public function index()
    {
        return view('createuser');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:255|unique:users',
            // 'email' => 'required|email:dns|unique:users',
            'email' => [
                'required',
                'email:dns',
                'unique:users',
                function ($attribute, $value, $fail) {
                    $allowedDomains = ['john.petra.ac.id', 'petra.ac.id'];
                    $emailDomain = substr(strrchr($value, "@"), 1);
        
                    if (!in_array($emailDomain, $allowedDomains)) {
                        $fail('The :attribute must be an email address from an allowed domain.');
                    }
                },
            ],
            'password' => 'required|min:4|max:255',
            'category' => 'required|max:255',
            'description' => 'max:255',
            'file' => 'required|image|file|max:3072'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $validatedData['file'] = $request->file('file')->store('profile-images');

        $validatedData['status'] = 'group';

        User::create($validatedData);

        session()->flash('success', 'New User Created! Please Login');

        return redirect('/login');
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
