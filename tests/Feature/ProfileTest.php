<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/profile')->assertRedirect('/login');
});

test('authenticated users can visit their profile', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/profile')->assertOk();
});
