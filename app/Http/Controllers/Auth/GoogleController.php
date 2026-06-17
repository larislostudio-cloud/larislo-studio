<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // ============================================
            // STEP 1: Cari user berdasarkan google_id ATAU email
            // ============================================
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            // ============================================
            // STEP 2: UpdateOrCreate (buat baru atau update)
            // ============================================
            if ($user) {
                // User sudah ada → update google_id & avatar saja
                $user->update([
                    'name'     => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar'   => $googleUser->getAvatar(),
                ]);
            } else {
                // User belum ada → buat baru
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    'password'  => Hash::make(Str::random(24)),
                    'role'      => 'free',
                ]);
            }

            // ============================================
            // STEP 3: Login & Redirect
            // ============================================
            Auth::login($user);

            if (!$user->store) {
                return redirect()->route('biodata.create');
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }
}
