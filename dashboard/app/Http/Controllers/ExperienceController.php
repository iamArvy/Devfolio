<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;

class ExperienceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $request->user()->experiences()->orderBy('start_date', 'desc')->paginate(10);
        return inertia()->render('Experiences', ['items' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateExperienceRequest $request)
    {
        $validated = $request->validated();
        $item = $request->user()->experiences()->create($validated);
        return to_route('experiences.index')->with('success', 'Experience successfully created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $this->authorize('update', $experience);
        $validated = $request->validated();
        $experience->update($validated);
        return to_route('experiences.index')->with('success', 'Experience successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience, Request $request): RedirectResponse
    {
        $this->authorize('delete', $experience);
        $experience->delete();
        return to_route('experiences.index')->with('success', 'Experience successfully deleted');
    }
}
