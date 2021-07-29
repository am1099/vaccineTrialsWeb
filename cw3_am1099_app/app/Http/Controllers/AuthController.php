<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Crypt;
use App\Models\Volunteer;



class AuthController extends Controller
{


    public function index()
    {
        return view('login_mine');
    }

    public function signin(Request $req)
    {
        $req->validate([
            'email' => ['required', 'string', 'email', 'exists:volunteers,email'],
            'passwordHash' => ['required', 'string', 'min:5'],
        ],

        ['email.exists' => 'Incorrect Email address, please try again.']    );

        if (Auth::attempt([

            'email' => $req->email,
            'password' => $req->passwordHash
        ])) {

            $email = Crypt::encrypt($req->email);

            if ($req->email == 'admin@admin') {
                return redirect()->route('display_normal_stats')->with('success', 'You have logged in successfully');

            }else{
            return redirect()->route('displayvolunteers', $email)->with('success', 'You have logged in successfully');
            }
        }else{
        return redirect()->back()->withInput($req->only('email'))->with('danger', 'Login failed: incorrect Email address or password');}
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
