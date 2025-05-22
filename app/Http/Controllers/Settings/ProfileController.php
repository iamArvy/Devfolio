<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\WorkOS\Http\Requests\AuthKitAccountDeletionRequest;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'status' => $request->session()->get('status'),
            'client' => $request->user()->client(),
        ]);
    }

    /**
     * Update the user's profile settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        try {
            $request->user()->update(['name' => $request->name]);
            return to_route('settings.profile.edit')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update user profile', ['error' => $e->getMessage(), 'user_id' => $request->user()->id]);
            return back()->withErrors('Failed to update profile. Please try again.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(AuthKitAccountDeletionRequest $request): RedirectResponse
    {
        return $request->delete(
            using: fn (User $user) => $user->delete()
        );
    }
}
