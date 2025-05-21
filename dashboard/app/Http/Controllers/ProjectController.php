<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $request->user()->projects()->orderBy('created_at', 'desc')->paginate(10);
        return inertia()->render('Projects', ['items' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request)
    {
        $validated = $request->validated();
        $certification = $request->user()->projects()->create($validated);
        return to_route('projects.index')->with('success', 'Project successfully created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);
        $validated = $request->validated();
        $project->update($validated);
        return to_route('projects.index')->with('success', 'Project successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);
        $project->delete();
        return to_route('projects.index')->with('success', 'Project successfully deleted');
    }
}
