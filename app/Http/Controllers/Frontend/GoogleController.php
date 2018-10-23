<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Crypt;
use App\User;

class GoogleController extends Controller
{
    function callback(Request $request)
    {
        $socialiteUser = Socialite::driver('google')->user(); // Get google data
        $user          = User::where('google_id', $socialiteUser->getId())->first();
        if (!count($user)) {
            $user = User::socialAuth($socialiteUser, 'google');
            Auth::loginUsingId($user->id);
            return redirect("/");
        }
        Auth::loginUsingId($user->id);
        return redirect("/");
    }

    function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
}
