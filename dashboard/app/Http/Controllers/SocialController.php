<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateSocialRequest;
use App\Http\Requests\UpdateSocialRequest;
use App\Models\Social;
use Illuminate\Http\RedirectResponse;

class SocialController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $request->user()->socials()->orderBy('created_at', 'desc')->paginate(10);
        return inertia()->render('Socials', ['items' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSocialRequest $request)
    {
        $validated = $request->validated();
        $request->user()->socials()->create($validated);
        return to_route('socials.index')->with('success', 'Social successfully created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialRequest $request, Social $social): RedirectResponse
    {
        $this->authorize('update', $social);
        $validated = $request->validated();
        $request->user()->socials()->update($validated);
        return to_route('socials.index')->with('success', 'Social successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Social $social, Request $request): RedirectResponse
    {
        $this->authorize('delete', $social);
        $social->delete();
        return to_route('socials.index')->with('success', 'Social successfully deleted');
    }
}
