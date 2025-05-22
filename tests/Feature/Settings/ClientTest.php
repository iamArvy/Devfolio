<?php

use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can display client credentials page with client data', function () {
    $client = Client::factory()->for($this->user)->create();

    $response = $this->get(route('settings.client.index'));

    $response->assertOk();
    // $response->assertInertia(fn ($page) =>
    //     $page->component('settings/Client')
    //          ->where('client.id', $client->id)
    // );
});

it('can create new client credentials if none exist', function () {
    $response = $this->post(route('settings.client.create'));

    $response->assertRedirect(route('settings.client.index'));
    $response->assertSessionHas('success', 'Client credentials created.');

    $this->assertDatabaseHas('clients', [
        'user_id' => $this->user->id,
    ]);
});

it('cannot create duplicate client credentials', function () {
    Client::factory()->for($this->user)->create();

    $response = $this->post(route('settings.client.create'));

    $response->assertRedirect(route('settings.client.index'));
    $response->assertSessionHas('error', 'Client already exists.');
});

it('can refresh client secret if client exists', function () {
    $client = Client::factory()->for($this->user)->create(['secret' => 'oldsecret']);

    $response = $this->post(route('settings.client.refresh'));

    $response->assertRedirect(route('settings.client.index'));
    $response->assertSessionHas('success', 'Client secret refreshed.');

    $client->refresh();

    expect($client->secret)->not->toEqual('oldsecret');
});

it('cannot refresh client secret if client does not exist', function () {
    $response = $this->post(route('settings.client.refresh'));

    $response->assertRedirect(route('settings.client.index'));
    $response->assertSessionHas('error', 'No client credentials found.');
});

it('can delete client credentials if client exists', function () {
    $client = Client::factory()->for($this->user)->create();

    $response = $this->delete(route('settings.client.destroy'));

    $response->assertRedirect(route('settings.client.index'));
    $response->assertSessionHas('success', 'Client credentials deleted.');

    $this->assertDatabaseMissing('clients', ['id' => $client->id]);
});

it('cannot delete client credentials if none exist', function () {
    $response = $this->delete(route('settings.client.destroy'));

    $response->assertRedirect(route('settings.client.index'));
    $response->assertSessionHas('error', 'No client credentials to delete.');
});
