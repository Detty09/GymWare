<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Coach;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $coach = null;

        if ($user->is_coach) {
            $coach = Coach::where('user_id', $user->id)->first();
        }

        return view('profile.edit', [
            'user' => $user,
            'coach' => $coach,
        ]);
    }

    public function updateBio(Request $request): RedirectResponse
    {
        $request->validate([
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = $request->user();

        if ($user->is_coach) {
            \App\Models\Coach::updateOrCreate(
                ['user_id' => $user->id],
                ['bio' => $request->bio]
            );
        }

        return Redirect::route('profile.edit')->with('status', 'bio-updated');
    }

    public function updateSubscription(Request $request)
    {
        $user = $request->user();

        // Only premium members
        if (!$user->subscription) {
            abort(403);
        }

        $request->validate([
            'card_number' => 'required|string|min:12|max:19',
            'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cvv' => 'required|string|min:3|max:4',
        ]);

        return back()->with('status_subscription', 'Payment method updated successfully.');
    }


    public function cancelSubscription(Request $request)
    {
        $user = $request->user();

        if (!$user->subscription) {
            abort(403);
        }

        $user->update([
            'subscription' => false,
        ]);

        return back()->with('status_subscription', 'Your subscription has been canceled.');
    }

    public function subscribe(Request $request){
        $user = $request->user();
        $request->validate([
            'card_number' => 'required|string|min:12|max:19',
            'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cvv' => 'required|string|min:3|max:4',
        ]);
        $user->subscription = true;
        $user->save();

        return back()->with('profile.subscribe', 'You successfully subscribed to the premium plan.');
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 🧠 If this user is a coach, update or create the coach bio
        if ($user->is_coach) {
            Coach::updateOrCreate(
                ['user_id' => $user->id],
                ['bio' => $request->input('bio', '')]
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
