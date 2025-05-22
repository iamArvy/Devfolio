<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class ExperienceController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        try {
            $items = $request->user()
                ->experiences()
                ->orderBy('start_date', 'desc')
                ->paginate(10);

            return inertia()->render('Experiences', ['items' => $items]);
        } catch (Exception $e) {
            Log::error('Failed to fetch experiences', ['error' => $e->getMessage()]);
            return back()->with('error', 'Unable to load experiences at the moment.');
        }
    }

    public function store(CreateExperienceRequest $request)
    {
        try {
            $validated = $request->validated();
            $request->user()->experiences()->create($validated);

            return to_route('experiences.index')->with('success', 'Experience successfully created');
        } catch (Exception $e) {
            Log::error('Failed to create experience', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create experience.');
        }
    }

    public function update(UpdateExperienceRequest $request, Experience $experience): RedirectResponse
    {
        try {
            $this->authorize('update', $experience);

            $validated = $request->validated();
            $experience->update($validated);

            return to_route('experiences.index')->with('success', 'Experience successfully updated');
        } catch (Exception $e) {
            Log::error('Failed to update experience', [
                'error' => $e->getMessage(),
                'experience_id' => $experience->id,
            ]);
            return back()->with('error', 'Failed to update experience.');
        }
    }

    public function destroy(Experience $experience, Request $request): RedirectResponse
    {
        try {
            $this->authorize('delete', $experience);
            $experience->delete();

            return to_route('experiences.index')->with('success', 'Experience successfully deleted');
        } catch (Exception $e) {
            Log::error('Failed to delete experience', [
                'error' => $e->getMessage(),
                'experience_id' => $experience->id,
            ]);
            return back()->with('error', 'Failed to delete experience.');
        }
    }
}
