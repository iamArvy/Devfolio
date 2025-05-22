<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CreateCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use App\Models\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class CertificationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        try {
            $certifications = $request->user()
                ->certifications()
                ->orderBy('date_acquired', 'desc')
                ->paginate(10);

            return inertia()->render('Certifications', ['certifications' => $certifications]);
        } catch (Exception $e) {
            Log::error('Failed to fetch certifications', ['error' => $e->getMessage()]);
            return back()->with('error', 'Unable to load certifications at the moment.');
        }
    }

    public function store(CreateCertificationRequest $request)
    {
        try {
            $validated = $request->validated();
            $request->user()->certifications()->create($validated);

            return to_route('certifications.index')->with('success', 'Certification successfully created');
        } catch (Exception $e) {
            Log::error('Failed to create certification', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create certification.');
        }
    }

    public function update(UpdateCertificationRequest $request, Certification $certification): RedirectResponse
    {
        try {
            $this->authorize('update', $certification);

            $validated = $request->validated();
            $certification->update($validated);

            return to_route('certifications.index')->with('success', 'Certification successfully updated');
        } catch (Exception $e) {
            Log::error('Failed to update certification', [
                'error' => $e->getMessage(),
                'certification_id' => $certification->id,
            ]);
            return back()->with('error', 'Failed to update certification.');
        }
    }

    public function destroy(Certification $certification, Request $request): RedirectResponse
    {
        try {
            $this->authorize('delete', $certification);
            $certification->delete();

            return to_route('certifications.index')->with('success', 'Certification successfully deleted');
        } catch (Exception $e) {
            Log::error('Failed to delete certification', [
                'error' => $e->getMessage(),
                'certification_id' => $certification->id,
            ]);
            return back()->with('error', 'Failed to delete certification.');
        }
    }
}
