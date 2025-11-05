<?php
use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');


test('user can\'t access dashboard without being logged in', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

use App\Models\User;

it('logs in a mocked user', function () {
    $user = User::factory()->make([
        'id' => 1,
        'name' => 'Mock User',
        'email' => 'mock@example.com'
    ]);
    $this->actingAs($user);
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

