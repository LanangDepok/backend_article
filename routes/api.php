<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tes', function () {
    return response()->json([
        'message' => 'Hello World',
    ]);
});
