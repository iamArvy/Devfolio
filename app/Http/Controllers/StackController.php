<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateStackRequest;
use App\Http\Requests\UpdateStackRequest;
use App\Models\Stack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class StackController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $stacks = $request->user()->stacks()->orderBy('created_at', 'desc')->paginate(10);
            return inertia()->render('Stacks', ['items' => $stacks]);
        } catch (Exception $e) {
            Log::error('Failed to load stacks', ['error' => $e->getMessage()]);
            return back()->with('error', 'Unable to load stacks.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStackRequest $request)
    {
        try {
            $validated = $request->validated();
            $request->user()->stacks()->create($validated);
            return to_route('stacks.index')->with('success', 'Stack successfully created');
        } catch (Exception $e) {
            Log::error('Failed to create stack', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create stack.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStackRequest $request, Stack $stack): RedirectResponse
    {
        try {
            $this->authorize('update', $stack);
            $validated = $request->validated();
            $stack->update($validated); // <-- Fix here
            return to_route('stacks.index')->with('success', 'Stack successfully updated');
        } catch (Exception $e) {
            Log::error('Failed to update stack', [
                'error' => $e->getMessage(),
                'stack_id' => $stack->id,
            ]);
            return back()->with('error', 'Failed to update stack.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stack $stack, Request $request): RedirectResponse
    {
        try {
            $this->authorize('delete', $stack);
            $stack->delete();
            return to_route('stacks.index')->with('success', 'Stack successfully deleted');
        } catch (Exception $e) {
            Log::error('Failed to delete stack', [
                'error' => $e->getMessage(),
                'stack_id' => $stack->id,
            ]);
            return back()->with('error', 'Failed to delete stack.');
        }
    }
}
