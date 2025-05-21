<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateStackRequest;
use App\Http\Requests\UpdateStackRequest;
use App\Models\Stack;
use Illuminate\Http\RedirectResponse;

class StackController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stacks = $request->user()->stacks()->orderBy('created_at', 'desc')->paginate(10);
        return inertia()->render('Stacks', ['items' => $stacks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStackRequest $request)
    {
        $validated = $request->validated();
        $request->user()->stacks()->create($validated);
        return to_route('stacks.index')->with('success', 'Stack successfully created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStackRequest $request, Stack $stack): RedirectResponse
    {
        $this->authorize('update', $stack);
        $validated = $request->validated();
        $request->user()->stacks()->update($validated);
        return to_route('stacks.index')->with('success', 'Stack successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stack $stack, Request $request): RedirectResponse
    {
        $this->authorize('delete', $stack);
        $stack->delete();
        return to_route('stacks.index')->with('success', 'Stack successfully deleted');
    }
}
