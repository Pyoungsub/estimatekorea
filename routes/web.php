<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Team;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/auth/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [App\Http\Controllers\SocialiteLogin::class, 'handleProviderCallback']);
Route::get('/generate-sitemap', function () {
    Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/about'))
        ->add(Url::create('/contact'))
        ->writeToFile(public_path('sitemap.xml'));

    return 'sitemap.xml generated!';
});