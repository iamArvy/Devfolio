<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use App\Models\Certification;
use Illuminate\Http\RedirectResponse;

class CertificationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $certifications = $request->user()->certifications()->orderBy('date_acquired', 'desc')->paginate(10);
        return inertia()->render('Certifications', ['certifications' => $certifications]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCertificationRequest $request)
    {
        $validated = $request->validated();
        $certification = $request->user()->certifications()->create($validated);
        return to_route('certifications.index')->with('success', 'Certification successfully created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCertificationRequest $request, Certification $certification): RedirectResponse
    {
        $this->authorize('update', $certification);
        $validated = $request->validated();
        $certification->update($validated);
        return to_route('certifications.index')->with('success', 'Certification successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certification $certification, Request $request): RedirectResponse
    {
        $this->authorize('delete', $certification);
        $certification->delete();
        return to_route('certifications.index')->with('success', 'Certification successfully deleted');
    }
}
