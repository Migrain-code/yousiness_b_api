<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();
        $user->passwrod = Hash::make($request->input('password'));
        if ($user->save()){
            return response()->json([
                'status' => "success",
                'message' => "Ihre Benutzerinformationen wurden aktualisiert.",
            ]);
        }
        return response()->json([
            'status' => "success",
            'message' => "Ihre Benutzerinformationen wurden aktualisiert.",
        ]);
    }
}
