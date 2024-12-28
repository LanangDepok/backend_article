<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();

        $user = $users->map(function ($value) {
            return [
                'id' => $value->id,
                'name' => $value->name,
                'email' => $value->email
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data user',
            'data' => $user
        ], 200);
    }
}
