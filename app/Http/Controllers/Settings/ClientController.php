<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display the client credentials.
     */
    public function index(Request $request): Response
    {
        $client = $request->user()->client()->first();
        return Inertia::render('settings/Client', ['client' => $client]);
    }

    /**
     * Generate Client Credentials.
     */
    public function create(Request $request): RedirectResponse
    {
        if ($request->user()->client()->exists()) {
            return to_route('settings.client.index')->with('error', 'Client already exists.');
        }

        $request->user()->client()->create();

        return to_route('settings.client.index')->with('success', 'Client credentials created.');
    }

    /**
     * Refresh Client Secret.
     */
    public function refresh(Request $request): RedirectResponse
    {
        $client = $request->user()->client()->first();

        if (!$client) {
            return to_route('settings.client.index')->with('error', 'No client credentials found.');
        }

        $client->secret = Str::random(40);
        $client->save();


        return to_route('settings.client.index')->with('success', 'Client secret refreshed.');
    }

    /**
     * Delete Client Credentials.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $client = $request->user()->client()->first();

        if (!$client) {
            return to_route('settings.client.index')->with('error', 'No client credentials to delete.');
        }

        $client->delete();

        return to_route('settings.client.index')->with('success', 'Client credentials deleted.');
    }
}
