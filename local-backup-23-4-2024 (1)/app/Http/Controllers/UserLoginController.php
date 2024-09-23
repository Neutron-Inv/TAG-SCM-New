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
        $data = [
            "email" => $request->input("email"),
            "password" => $request->input("password"),
        ];
        // $user = User::where('user_id', 1)->first();
        // $user->assignRole('SuperAdmin');
        if (Auth::attempt($data)) {
            $usertype = Auth::user()->role;
            if ((Auth::user()->status == '-1') OR (Auth::user()->user_activation_code == 0)) {
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Attempted to Log in',
                ]);
                $log->save();
                return redirect()->back()->with([
                    "error" => "Ooops!!! You Account has been suspended. Please contact your administrator",
                ]);
            } else {
                if (!empty($usertype)) {
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Logged In',
                    ]);
                    $log->save();
                    return redirect()->route("dashboard.index")->with([
                        "success" => Auth::user()->first_name . ' '.  Auth::user()->last_name . " " . "Welcome To $usertype  Dashboard"
                    ]);
                } else {
                    return redirect()->back()->with([
                        "error" => "Please login with a valid details",
                    ]);
                }
            }

        } else {
            return redirect()->back()->with([
                "error" => "Invalid Username or Password",
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
