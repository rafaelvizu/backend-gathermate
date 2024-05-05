<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{

    #[Response(content: ['data' => ['user'], 'message' => 'Sucesso!'], status: 200)]

    public function login(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('authToken', expiresAt: now()->addDays(2))
                ->plainTextToken;


            if (!auth()->user()->is_active) {
                return response()->json(['message' => 'Não autorizado!'], 401);
            }

            $response_json = [
                'data' => [
                    'user' => auth()->user(),
                    'token' => $token,
                ],
                'message' => 'Sucesso!'
            ];

            return response()->json([$response_json], 200);
        }

        return response()->json(['message' => 'Não autorizado!'], 401);
    }

    #[Response(content: ['message' => 'Logged out'], status: 200)]
    #[Authenticated]
    public function logout(Request $request): JsonResponse {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    #[Response(content: ['data' => ['user' => 'User'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function me(Request $request): JsonResponse {
        return response()->json([$request->user()], 200);
    }

    #[Response(content: ['message' => 'Senha alterada!'], status: 200)]
    #[Authenticated]
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|min:6|max:255',
            'old_password' => 'required|min:6|max:255'
        ]);

        $user = auth()->user();

        if (!auth()->attempt(['email' => $user->email, 'password' => $request->old_password])) {
            return response()->json(['message' => 'Não autorizado!'], 401);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Senha alterada!'], 200);
    }

    #[Response(content: ['message' => 'Perfil atualizado!'], status: 200)]
    #[Authenticated]
    public function updateProfile(Request $request): JsonResponse {
        $request->validate([
            'name' => 'required|min:3|max:50|unique:users,name,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        return response()->json(['message' => 'Perfil atualizado!'], 200);
    }

}
