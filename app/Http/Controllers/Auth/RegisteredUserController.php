<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Laravel\Paddle\Subscription;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_coach' => ['sometimes', 'boolean'],
            'subscription' => ['sometimes', 'boolean'],
        ]);

        if ($request->has('subscription') && $request->subscription) {
            $request->validate([
                'card_number' => ['required', 'regex:/^[\d ]{12,19}$/'],
                'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
                'cvv' => ['required', 'digits_between:3,4'],
            ]);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_coach' => $request->has('is_coach') ? 1 : 0,
            'subscription' => $request->has('subscription') ? 1 : 0,
        ]);

        if ($user->is_coach) {
            \App\Models\Coach::create([
                'user_id' => $user->id,
                'bio' => $request->bio ?? 'This coach has not added a bio yet.',
            ]);
        }


        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');

    }


}
