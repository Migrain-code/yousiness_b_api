<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonelResource;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group PersonalAuth
 */
class PersonalAuthController extends Controller
{
    /**
     * POST api/personal/auth/login
     *
     * Status Codes
     * <ul>
     * <li>phone</li>
     * <li>password</li>
     * <li> 401 Unauthorized Hatası </li>
     * </ul>
     * Login apisi
     *
     *
     */

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = Personel::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'message' => 'Telefon Numarası veya şifre yanlış'
            ], 401);
        }

        $token = $user->createToken('Access Token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => PersonelResource::make($user),
            'type' => "personel",
        ]);
    }

    /**
     * POST api/personal/auth/logout
     *
     *
     * <ul>
     * <li>Token Göndermeniz Yeterli</li>
     * </ul>
     * Logout apisi
     *
     * @header Bearer {token}
     *
     */
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Sistemden Çıkış Yapıldı']);
    }
    /**
     * GET api/personal/auth/user
     *
     *
     * <ul>
     * <li>Token Göndermeniz Yeterli</li>
     * </ul>
     * Use Info apisi
     *
     * @header Bearer {token}
     *
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => PersonelResource::make($request->user()),
        ]);
    }
}
