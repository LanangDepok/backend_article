<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login', function () {
    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])->post('/api/login', [
        'email' => 'bagas@gmail.com',
        'password' => '123'
    ]);

    $response->assertStatus(200);
});
