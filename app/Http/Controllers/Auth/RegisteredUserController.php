<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $data = ['title' => 'App Name | Register'];
        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'string',],
                'passwordConfirm' => ['required', 'string', 'same:password'],
            ]);

            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            return redirect()->route('login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Internal Server Error');
        }
    }
}
