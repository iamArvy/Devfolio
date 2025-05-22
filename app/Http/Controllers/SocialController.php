<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateSocialRequest;
use App\Http\Requests\UpdateSocialRequest;
use App\Models\Social;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $items = $request->user()->socials()->orderBy('created_at', 'desc')->paginate(10);
            return inertia()->render('Socials', ['items' => $items]);
        } catch (Exception $e) {
            Log::error('Failed to fetch socials', ['error' => $e->getMessage()]);
            return back()->with('error', 'Unable to load social links.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSocialRequest $request)
    {
        try {
            $validated = $request->validated();
            $request->user()->socials()->create($validated);
            return to_route('socials.index')->with('success', 'Social successfully created');
        } catch (Exception $e) {
            Log::error('Failed to create social', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create social link.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialRequest $request, Social $social): RedirectResponse
    {
        try {
            $this->authorize('update', $social);
            $validated = $request->validated();
            $social->update($validated); // ✅ fix
            return to_route('socials.index')->with('success', 'Social successfully updated');
        } catch (Exception $e) {
            Log::error('Failed to update social', [
                'error' => $e->getMessage(),
                'social_id' => $social->id,
            ]);
            return back()->with('error', 'Failed to update social link.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Social $social, Request $request): RedirectResponse
    {
        try {
            $this->authorize('delete', $social);
            $social->delete();
            return to_route('socials.index')->with('success', 'Social successfully deleted');
        } catch (Exception $e) {
            Log::error('Failed to delete social', [
                'error' => $e->getMessage(),
                'social_id' => $social->id,
            ]);
            return back()->with('error', 'Failed to delete social link.');
        }
    }
}
