<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class Authentication extends Controller
{
    /**
     * Show login page
     *
     * @return View
     */
    public function login()
    {
        return view('consumer.auth.login');
    }

    /**
     * Redirect to Facebook login page (external page)
     *
     * @see ::facebookLoginCallback
     *
     * @return Redirect
     */
    public function redirectToFacebookLogin()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Callback from Facebook
     *
     * If user exists, log it in. If not, create new one and log in.
     *
     * @return Redirect
     */
    public function facebookLoginCallback()
    {
        $userFace = Socialite::driver('facebook')->user();
        $user     = User::where('email', $userFace->email)->get()->first();

        if (!$user) {
            $user = User::create([
                'name'     => $userFace->name,
                'email'    => $userFace->email,
                'password' => $userFace->token
            ]);
        }

        Auth::login($user);

        $authController = new AuthController;

        return redirect($authController->getRedirectTo());
    }

    /**
     * Show register page
     *
     * @return View
     */
    public function register()
    {
        return view('consumer.auth.register');
    }

    /**
     * Show forgot password page with e-mail input field
     *
     * @return View
     */
    public function forgotPassword()
    {
        return view('consumer.auth.forgot');
    }
}
