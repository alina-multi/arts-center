<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle(Request $request)
    {
        // Store the intended URL (where user came from) in session
        if ($request->has('intended')) {
            session(['url.intended' => $request->get('intended')]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            // Check if user already exists with this email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update existing user with Google data if not already set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }
            } else {
                // Generate a unique username from Google name or email
                $baseUsername = $this->generateUsernameFromGoogleUser($googleUser);
                
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'username' => $baseUsername,
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(24)),
                ]);
            }

            // Log the user in
            Auth::login($user);

            // Redirect to intended URL or fallback to frontend
            $intendedUrl = session('url.intended', env('FRONTEND_URL'));
            session()->forget('url.intended'); // Clear the intended URL from session
            
            return redirect()->to($intendedUrl);

        } catch (\Exception $e) {
            // Report error to Sentry
            report($e);
            
            // Redirect to frontend with error
            return redirect()->to(env('FRONTEND_URL') . '?auth_error=google_failed');
        }
    }

    /**
     * Generate a unique username from Google user data
     */
    private function generateUsernameFromGoogleUser($googleUser)
    {
        // Simply use the first part of the email address
        $emailParts = explode('@', $googleUser->getEmail());
        $baseUsername = Str::slug($emailParts[0], '');
        
        // Make it unique by checking database
        $username = $baseUsername;
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        return $username;
    }
}
