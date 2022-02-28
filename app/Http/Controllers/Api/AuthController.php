<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponder;

    public function login(): JsonResponse
    {
        request()->validate([
           "email" => "required|email",
           "password" => "required|min:8|max:30",
           "device_name" => "required",
        ]);

        $user = User::select(["id", "name", "password", "email"])
            ->where('email', request("email"))
            ->first();

        if(! $user || Hash::check(request("password"), $user->password)) {
            throw ValidationException::withMessages([
                "email" => [__("Credenciais inválidas")]
            ]);
        }

        $token = $user->createToken(request("device_name"))->plainTextToken;

        return $this->success(
            __("Bem-vindo(a)"),
            [
                "user" => $user->toArray(),
                "token" => $token,
            ]
        );
    }

    public function signup(): JsonResponse
    {
        request()->validate([
            "name" => "required|min:2|max:60",
            "email" => "required|email|unique:users",
            "password" => "required|min:8|max:30",
            "passwordConfirmation" => "required|same:password|min:8|max:30",
        ]);

        User::create([
            "name" => request("name"),
            "email" => request("email"),
            "password" => bcrypt(request("password")),
            "created_at" => now()
        ]);

        return $this->success(
           __("Conta criada")
        );
    }
}
