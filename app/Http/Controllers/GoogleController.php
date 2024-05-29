<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect('google.callback');
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->getId())->first();

            if ($finduser) {
                Auth::login($finduser);

                request()->session()->regenerate();
                return redirect()->intended('/dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                    'file' => $user->getAvatar(),
                    'status' => 'user'
                ]);
                Auth::login($newUser);
                request()->session()->regenerate();
                return redirect()->intended('/dashboard');
            }
        } catch (\Throwable $th) {
            // dd("error");
        }
    }
}
