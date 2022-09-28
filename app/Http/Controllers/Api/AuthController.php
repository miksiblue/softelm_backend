<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{

    public function login(StoreAuthRequest $request)
    {
        $request->authenticate();
        $userRole = Auth::user()->role->role_name;
        $accessToken = auth()->user()->createToken('authToken', [$userRole])->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken], 200);
    }

    public function logout()
    {
        Auth::user()->token()->delete();
        return response()->json(['message' => "Logout successful"], 200);
    }
}
