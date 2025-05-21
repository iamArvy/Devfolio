<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ClientController extends Controller
{
    /**
     * Generate Client Credentials.
     */
    public function index(Request $request): Response
    {
        $client = $request->user()->client();
        return inertia()->render('settings/Client', ['client' => $client]);
    }

    /**
     * Generate Client Credentials.
     */
    public function create(Request $request): RedirectResponse
    {
        $request->user()->client()->create();
        return to_route('settings.client.index');
    }

    /**
     * Generate Client Credentials.
     */
    public function refreshSecret(Request $request): RedirectResponse
    {
        $clientSecret = Str::random(40);
        $request->user()->client()->update(['secret' => $clientSecret]);
        return to_route('settings.client.index');
    }
}
