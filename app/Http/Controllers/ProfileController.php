<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display the profile.
     */
    public function index(Request $request)
    {
        try {
            $profile = $request->user()->profile()->first();
            return inertia()->render('Profile', ['profile' => $profile]);
        } catch (Exception $e) {
            Log::error('Failed to fetch profile', ['error' => $e->getMessage()]);
            return back()->with('error', 'Unable to load profile at the moment.');
        }
    }

    /**
     * Store a newly created profile.
     */
    public function store(CreateProfileRequest $request): RedirectResponse
    {
        try {
            if ($request->user()->profile()->exists())
                return back()->with('error', 'Profile already exists.');

            $validated = $request->validated();
            $request->user()->profile()->create($validated);

            return to_route('profile.index')->with('success', 'Profile successfully created');
        } catch (Exception $e) {
            Log::error('Failed to create profile', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create profile.');
        }
    }

    /**
     * Update the specified profile.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        try {
            if (!$request->user()->profile()->exists())
                return back()->with('error', "Profile doesn't exist");

            $validated = $request->validated();
            $request->user()->profile()->update($validated);
            return to_route('profile.index')->with('success', 'Profile successfully updated');
        } catch (Exception $e) {
            Log::error('Failed to update profile', [
                'error' => $e->getMessage(),
                'profile_id' => $profile->id,
            ]);
            return back()->with('error', 'Failed to update profile.');
        }
    }
}
