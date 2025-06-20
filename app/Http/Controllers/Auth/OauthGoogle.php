<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OauthGoogle extends Controller
{
    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): \Illuminate\Http\RedirectResponse
    {
        $user = Socialite::driver('google')->stateless()->user();

        $this->registerOrLoginUser($user);

        return redirect()->route('dashboard');
    }

    protected function registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        $random_password = Str::random(8);

        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = Hash::make($random_password);
            $user->save();

            event(new Registered($user));

        }

        Auth::login($user);
    }
}
