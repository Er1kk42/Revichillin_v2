<?php
//ciatocne upravene pomocou AI
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('welcome');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->route('welcome')->with('status', 'Prihlásenie bolo úspešné.');
        }

        return back()
            ->withErrors(['email' => 'Nesprávny e-mail alebo heslo.'])
            ->onlyInput('email');

    }

    public function showProfile(Request $request)
    {
        $orders = $request->user()->orders()->with('items.product')->latest()->get();
        $reviews = $request->user()->reviews()->with('product')->latest()->get();

        return view('user', ['orders' => $orders, 'reviews' => $reviews]);
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();
        $changes = ['name' => $validated['name']];
        if ($request->filled('password')) {
            $changes['password'] = $validated['password'];
        }

        $request->user()->update($changes);

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
