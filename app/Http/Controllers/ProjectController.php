<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $items = $request->user()->projects()->orderBy('created_at', 'desc')->paginate(10);
            return inertia()->render('Projects', ['items' => $items]);
        } catch (Exception $e) {
            Log::error('Failed to fetch projects', ['error' => $e->getMessage()]);
            return back()->with('error', 'Unable to load projects.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $request->user()->projects()->create($validated);
            return to_route('projects.index')->with('success', 'Project successfully created');
        } catch (Exception $e) {
            Log::error('Failed to create project', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create project.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        try {
            $this->authorize('update', $project);
            $validated = $request->validated();
            $project->update($validated);
            return to_route('projects.index')->with('success', 'Project successfully updated');
        } catch (Exception $e) {
            Log::error('Failed to update project', [
                'error' => $e->getMessage(),
                'project_id' => $project->id,
            ]);
            return back()->with('error', 'Failed to update project.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        try {
            $this->authorize('delete', $project);
            $project->delete();
            return to_route('projects.index')->with('success', 'Project successfully deleted');
        } catch (Exception $e) {
            Log::error('Failed to delete project', [
                'error' => $e->getMessage(),
                'project_id' => $project->id,
            ]);
            return back()->with('error', 'Failed to delete project.');
        }
    }
}
