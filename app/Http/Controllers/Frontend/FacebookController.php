<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Crypt;
use App\User;

class FacebookController extends Controller
{
    /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(Request $request)
    {
         // Set the facebook fields to retrieve
        $user = Socialite::driver('facebook')->fields([
                                                    'name', 
                                                    'email', 
                                                ]);
        $socialiteUser = $user->user(); // Get facebook data
        $user          = User::where('facebook_id', $socialiteUser->getId())->first();
        if (!count($user)) {
            $user = User::socialAuth($socialiteUser, 'facebook');
            Auth::loginUsingId($user->id);
            return redirect("/");
        }
        Auth::loginUsingId($user->id);
        return redirect("/");
    }
}
