<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('guest:user')->except('logout');
    //     $this->middleware('guest:groups')->except('logout');
    // }

    public function index()
    {
        return view('login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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

    // public function showGroupLogin(){
    //     return view('login', ['url' => 'group']);
    // }

    public function authenticate(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Log In Failed!');
    }

    //login with google
    // public function showUserLogin(){
    //     return view('login', ['url' => 'user']);
    // }

    // public function redirectToGoogle(){
    //     return Socialite::driver('google')->redirect();
    // }

    // public function handleGoogleCallback(){
    //     try {
    //         $user = Socialite::driver('google')->user();
    //         $finduser = User::where('google_id', $user->getId())->first();
            
    //         if($finduser){
    //             Auth::guard('user')->login($finduser, true);

    //             request()->session()->regenerate();

    //             return redirect()->intended('/dashboard');
    //         } else{
    //             $newUser = User::create([
    //                 'name' => $user->getName(),
    //                 'email' => $user->getEmail(),
    //                 'google_id' => $user->getId(),
    //             ]);
    //             Auth::login($newUser);

    //             request()->session()->regenerate();

    //             return redirect()->intended('/dashboard');
    //         }
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function logout()
    {
        Auth::logout();
        
        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/dashboard')->with('success', 'Log Out Success!');
    }
}
