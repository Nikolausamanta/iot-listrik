<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function index()
    {
        return view("sesi/index", [
            'title' => 'Sesi'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email must be filled in.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password must be filled in.',
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (!$user || !Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('sesi')->withErrors(['invalid_credentials' => 'Invalid email or password.'])->withInput($request->except('password'));
        }

        return redirect()->to('/')->with('success', Auth::user()->name . ' successfully logged in');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('sesi')->with('success', 'Berhasil Logout');
    }

    public function register()
    {
        return view('sesi/register', [
            'title' => 'Register'
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address has already been used, please choose a different email.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least 6 characters.',
            'password_confirmation.required' => 'Please confirm your password.',
            'password_confirmation.same' => 'The password confirmation does not match the password entered.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        User::create($data);


        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            //kalau authentication sukses
            return redirect()->to('sesi')->with('success', 'Berhasil membuat akun');
        }
    }
}
