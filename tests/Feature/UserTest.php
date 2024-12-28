<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('get all users after login', function () {
    $response = $this->actingAs(User::find(1))->withHeaders([
        'Accept' => 'application/json'
    ])->get('/api/users');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Berhasil mengambil data user',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Bagas',
                    'email' => 'bagas@gmail.com'
                ],
                [
                    'id' => 2,
                    'name' => 'Rizki',
                    'email' => 'rizki@gmail.com'
                ],
                [
                    'id' => 3,
                    'name' => 'Yanto',
                    'email' => 'yanto@gmail.com'
                ]
            ]
        ]);
});

test('get all users before login', function () {
    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])->get('/api/users');

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.'
        ]);
});
