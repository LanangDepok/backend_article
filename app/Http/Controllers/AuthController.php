<?php

namespace App\Http\Controllers;

use App\Models\AuthorKeyAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $messages = [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong'
        ];
        $validated = Validator::make($data, $rules, $messages)->validate();

        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        if ($user->roles->pluck('role_name')->contains('Author')) {
            $token = $user->createToken('isLogin', ['Author'])->plainTextToken;
        } elseif ($user->roles->pluck('role_name')->contains('Reader')) {
            $token = $user->createToken('isLogin', ['Reader'])->plainTextToken;
        } else {
            $token = $user->createToken('isLogin', ['Admin'])->plainTextToken;
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil melakukan login',
            'data' => [
                'token' => $token,
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name
            ]
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required'
        ];
        $messages = [
            'email.unique' => 'Email sudah terdaftar',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
            'name.required' => 'Nama tidak boleh kosong'
        ];
        $validated = Validator::make($data, $rules, $messages)->validate();

        if ($request->author_key_input) {
            $author_key = AuthorKeyAccess::pluck('author_key');

            if ($author_key->contains($request->author_key_input)) {
                $used_key = AuthorKeyAccess::where('author_key', $request->author_key_input)->first();
                $used_key->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Key tidak valid'
                ]);
            }
        }

        $user = User::create([
            'email' => $validated['email'],
            'name' => $validated['name'],
            'password' => $validated['password']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil melakukan register',
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil melakukan logout'
        ]);
    }
}
