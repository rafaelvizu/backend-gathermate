<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Mail\TempPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ManageUser extends Controller
{
    //

    #[Response(content: ['data' => ['user'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function index(Request $request): JsonResponse {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
        ]);

        $users = User::paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            'data' => [
                'user' => $users,
            ],
            'message' => 'Sucesso!'
        ]);
    }

    #[Response(content: ['data' => ['user' => 'User'], 'message' => 'Sucesso!'], status: 201)]
    #[Authenticated]
    public function store(Request $request): JsonResponse {
        $request->validate([
            'name' => 'required|min:3|max:50|unique:users',
            'email' => 'required|email|unique:users',
        ]);


        $temp_password = substr(md5(rand()), 0, 7);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($temp_password)
        ]);

        Mail::to($user->email)
            ->send(new TempPasswordMail($temp_password, $user->name));

        $response_json = [
            'data' => [
                'user' => $user,
            ],
            'message' => 'Sucesso!'
        ];

        return response()->json([$response_json], 201);
    }


    #[Response(content: ['data' => ['user' => 'User'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function show(User $user): JsonResponse {
        return response()->json([
            'data' => [
                'user' => $user,
            ],
            'message' => 'Sucesso!'
        ]);
    }

    #[Response(content: ['message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function update(Request $request, User $user): JsonResponse {
        $request->validate([
            'name' => 'required|min:3|max:50|unique:users,name,' . $user->id,
            'is_active' => 'required|boolean',
        ]);

        $user->name = $request->name;
        $user->is_active = $request->is_active;
        $user->save();

        return response()->json(['message' => 'Sucesso!']);
    }

    // NEW TEMP PASSWORD
    #[Response(content: ['message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function newTempPassword(User $user): JsonResponse {
        $temp_password = substr(md5(rand()), 0, 7);

        $user->password = bcrypt($temp_password);
        $user->save();

        Mail::to($user->email)
            ->send(new TempPasswordMail($temp_password, $user->name));

        return response()->json(['message' => 'Sucesso!']);
    }



}
