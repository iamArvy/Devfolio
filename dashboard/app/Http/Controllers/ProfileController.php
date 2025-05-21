<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profile = $request->user()->profile()->first();
        return inertia()->render('Profile', ['profile' => $profile]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $profile = $request->user()->profile()->create($validated);
        return to_route('profile.index')->with('success', 'Profile successfully created');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile): RedirectResponse
    {
        $validated = $request->validated();
        $profile->update($validated);
        return to_route('profile.index')->with('success', 'Profile successfully updated');
    }
}
