<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $data = [
            'title' => 'App Name | Login'
        ];

        return view('auth.login', $data);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {

            $userExists = User::where('email', $request->email)->exists();
            if (!$userExists) {
                return redirect()->back()->with(['error' => 'No account found with this email.']);
            }

            $user = User::where('email', $request->email)->first();
            if (!\Hash::check($request->password, $user->password)) {
                return redirect()->back()->with(['error' => 'The provided credentials do not match our records!']);
            }

            $request->authenticate();
            $request->session()->regenerate();

            if (Auth::user() && Auth::user()->role == 'user') {
                return redirect()->route('user.dashboard.index');
            } else if (Auth::user() && Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard.index');
            } else {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('error', 'You are not authorized to access this page.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Internal Server Error');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
