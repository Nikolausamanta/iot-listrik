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
        Session::flash('email', $request->email);
        Session::flash('password', $request->password);

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'email diisi woy',
            'password.required' => 'password diisi woy',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            //kalau authentication sukses
            return redirect()->to('/')->with('success', Auth::user()->name . ' berhasil melakukan Login');
        } else {
            // kalau authentication gagal
            return redirect('sesi')->withErrors('Username dan Password Salah');
        }
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
        Session::flash('name', $request->name);
        Session::flash('email', $request->email);
        Session::flash('password', $request->password);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'name diisi woy',
            'email.required' => 'email diisi woy',
            'email.email' => 'Silahkan masukkan email yang valid',
            'email.unique' => 'Email sudah pernah digunakan, silakan pilih email yang lain',
            'password.required' => 'password diisi woy',
            'password.min' => 'Minimum password yang dizikan adalh 6 karakter',
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
