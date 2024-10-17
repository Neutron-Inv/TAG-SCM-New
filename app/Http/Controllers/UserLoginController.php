<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\{User, Log};
use Illuminate\Support\Facades\Gate;
class UserLoginController extends Controller
{

    public function userlogin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $data = [
            "email" => $validatedData["email"],
            "password" => $validatedData["password"],
        ];
    
        if (Auth::attempt($data)) {
            // Authentication successful, check if user is active
            $user = Auth::user();
            if ($user->status == '-1' || $user->user_activation_code == 0) {
                $log = new Log([
                    "user_id" => $user->user_id,
                    "activities" => 'Attempted to Log in',
                ]);
                $log->save();
                return redirect()->back()->with([
                    "error" => "Oops!!! Your account has been suspended. Please contact your administrator.",
                ]);
            } else {
                // User is active, log the login activity
                $log = new Log([
                    "user_id" => $user->user_id,
                    "activities" => 'Logged In',
                ]);
                $log->save();
    
                // Redirect user to their intended URL or dashboard
                return redirect()->intended('/dashboard')->with([
                    "success" => $user->first_name . ' ' . $user->last_name . " Welcome To $user->role Dashboard",
                ]);
            }
        } else {
            // Authentication failed, redirect back to login with error message
            return redirect()->back()->with([
                "error" => "Invalid email or password.",
            ]);
        }
    }

    public function logout()
    {
        // $log = new Log([
        //     "user_id" => Auth::user()->user_id,
        //     "activities" => 'Logged Out',
        // ]);
        // $log->save();
        // dd($log);
        Auth::logout();
        return view("auth.login");
    }

}
