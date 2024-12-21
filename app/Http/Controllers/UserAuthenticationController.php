<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\States;
use App\Models\Districts;
use App\Models\Cities;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserAuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone' => $request->phone,
                'city'=> $request->city,
                'address' => $request->address,
                'password' => bcrypt($request->password),
                'role' => 'Application User'
            ]);
            $roles = ['Application User'];
            $user->syncRoles($roles);
            if ($user) {
                // Dispatch the Registered event
                try {
                    event(new Registered($user));
                } catch (\Exception $e) {
                    Log::error('Error sending email' . $e->getMessage());
                    return redirect('/signup')->with('error', 'Error in sending email.Exception:' . $e->getMessage());
                }
                return redirect('/signup')->with('success', 'A verification email has been sent to your email address. Please verify your email address to activate your account.');
            }
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect('/signup')->with('error', 'Error creating user.Exception:' . $e->getMessage());
        }
    }

    public function verifyEmail($id, $hash)
    {
        // Find the user by ID
        try {
            $user = User::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error finding user: ' . $e->getMessage());
            return redirect('/register')->with('error', 'System could not idefied you as Registered User. Please register again.');
        }

        // Verify the email hash
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect('/register')->with('error', 'Invalid verification link. Please resend verification link.');
        }

        // Check if the user has already been verified
        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('error', 'Email already verified. Please procced to Login.');
        }

        // Mark the email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect('/login')->with('success', 'Hurry!! Email verified Successfully. Please proceed to login.');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect('/login')->with('error', 'System could not verify you as a registered User. Please Sign up before login.');
        }
        if (Auth::attempt($credentials)) {
            // Check if the user's email is verified
            if (Auth::user()->email_verified_at) {
                // Authentication successful
                if(Auth::user()->role == 'Blood Bank User') {
                    return redirect('/donors')->with('success', 'Welcome!');
                }else {
                    return redirect('/blood_banks')->with('success', 'Welcome!');
                }
            } else {
                // Email not verified, logout the user and redirect to login page
                Auth::logout();
                return redirect('/login')->with('error', 'Error! Please verify your email address before login.');
            }
        } else {
            // Authentication failed
            return redirect('/login')->with('error', 'Error! Invalid credentials.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('error', 'You have been logout!');
    }

    public function getDistricts($stateId)
    {
        $districts = Districts::where('states_id', $stateId)->get();
        return response()->json($districts);
    }

    public function getCities($districtId)
    {
        $cities = Cities::where('districts_id', $districtId)->get();
        return response()->json($cities);
    }

    public function stateTocities($stateId)
    {
        $cities = Cities::where('states_id', $stateId)->get();
        return response()->json($cities);
    }

    public function login()
    {
        return view('userauthentication.login');
    }

    public function home()
    {
        return redirect('/blood_banks');
    }

}
