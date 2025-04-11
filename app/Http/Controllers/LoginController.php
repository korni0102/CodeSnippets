<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('login.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:8|max:20'
        ]);

        // try to log in user, if its successful then redirect to home
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended(route('home'));
        }

        // if the login is not possible then redirect "back" (to origin url) with error msg
        return back()->withErrors(['error' => __('trans.The provided credentials do not match our records.')]);
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * @return View
     */
    public function showRegisterForm(): View
    {
        return view('login.registration');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        //This will be redirecting automatically when the data is not correct, based on the rules
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed',
            'password_confirmation' => 'required|string|min:8|max:20'
        ]);

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('home')->with('success', __('trans.You have successfully registered!'));
    }
}
