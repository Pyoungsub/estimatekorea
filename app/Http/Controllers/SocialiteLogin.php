<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SocialiteLogin extends Controller
{
    //
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        // Social account must have email
        if (!$socialUser->getEmail()) {
            return redirect('/login')->withErrors([
                'email' => 'This social account does not provide an email address.',
            ]);
        }

        // 1) Check if user exists
        $existingUser = User::where('email', $socialUser->getEmail())->first();

        if ($existingUser) {
            Auth::login($existingUser);
            return redirect('/dashboard');
        }

        // 2) Create new user
        $user = User::create([
            'name'        => $socialUser->getName(),
            'email'       => $socialUser->getEmail(),
            'password'    => Hash::make(str()->random(10)),
            'provider'    => $provider,
            'provider_id' => $socialUser->getId(),
        ]);

        // 3) Create Personal Team (Jetstream)
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        Auth::login($user);

        return redirect('/dashboard');
    }
}
