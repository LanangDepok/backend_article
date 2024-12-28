<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BiodataController extends Controller
{
    public function updateBiodata(Request $request)
    {

        $data = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
        ];
        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
        ];
        $validated = Validator::make($data, $rules, $messages)->validate();

        $user = Auth::user();

        if ($validated['email'] === $user->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terdaftar'
            ]);
        }

        if ($request->password !== null) {
            $validated['password'] = $request->password;
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah biodata'
        ]);
    }
}
