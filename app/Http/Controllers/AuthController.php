<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function showRegister()
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        //dd($data);
        $user = User::create([
           'name' => $data['name'],
           'email' => $data['email'],
           'birth_date' => $data['birth_date'],
           'password' => $data['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home');
    }

    public function showLogin()
    {
        return view('login');  // ← toto posiela výsledok do View
    }

    public function login(LoginRequest $request)
    {
        $loginData = $request->validated();

        if (Auth::attempt($loginData)) {
            $request->session()->regenerate();
            return redirect()->route('welcome');
        }

        return back()
            ->withErrors(['Nespravne heslo alebo e-mail'])
            ->onlyInput('email');

    }

    public function showProfile()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->get();

        return view('user', ['orders' => $orders]);
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        $user->name = $data['name'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return redirect()->route('user')->with('status', 'Profil bol úspešne uložený.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}


