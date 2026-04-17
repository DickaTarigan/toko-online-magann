<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AuthController extends Controller
{
    //--Tampilkan form registrasi--
    public function showRegister(): Response
    {
        return Inertia::render('Auth/Register');
    }

    //--proses data registrasi dari form--
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100|min:3',
            'email'    => ['required','email', 'unique:users,email',
                            //Fungsi custom untuk tidak mengizinkan domain tertentu
                            function($attribute, $value, $fail){
                                if (str_ends_with($value, '@test.com')){
                                    $fail('Domain email tidak diizinkan');
                                }
                            }],
            'password' => ['required', 
                            'confirmed', 
                            Password::min(8)
                            ->letters()
                            ->mixedCase()
                            ->numbers()],
            'role'     => 'required|in:buyer,seller',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        Auth::login($user);

        //Redirect berdasarkan role
        if ($user->isSeller()) {
            return redirect()->route('seller.dashboard');
        }

        return redirect()->route('home');
    }

    //--Tampilkan form login--
    public function showLogin(): Response
    {
        return Inertia::render('Auth/Login');
    }

    //--Proses Login--
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'  => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isSeller()) {
                return redirect()->intended (route('seller.dashboard'));
            }
            return redirect ()->intended(route('home'))->with('success', 'Selamat Datang, ' .$user->name);
        }

        // Jika gagal: kembalikan ke form dengan error
        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    //--Logout--
    public function logout(Request $request)
    {
        Auth::Logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Berhasil Logout');
    }
}
