<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Mail\TempPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Illuminate\Http\JsonResponse;

class ManageUser extends Controller
{
    //

    #[Group(name: 'Gerenciar Usuários')]
    #[Response(content: ['data' => ['user'], 'message' => 'Sucesso!', 'current_page' => 1, 'per_page' => 15, 'total' => 1], status: 200)]
    #[Authenticated]
    public function index(Request $request): JsonResponse {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
            'search' => 'nullable|string|min:3|max:50',
        ]);

        $users = User::when($request->search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            // desmonstrar array de objetos para não aparecer 0
            'data' => $users->items(),
            'message' => 'Sucesso!',
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
        ]);
    }

    #[Group(name: 'Gerenciar Usuários')]
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


    #[Group(name: 'Gerenciar Usuários')]
    #[Response(content: ['data' => ['user'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function show(User $user): JsonResponse {
        return response()->json([
            'data' => [
                $user,
            ],
            'message' => 'Sucesso!'
        ]);
    }

    #[Group(name: 'Gerenciar Usuários')]
    #[Response(content: ['message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function update(Request $request, User $user): JsonResponse {
        $request->validate([
            'name' => 'required|min:3|max:50|unique:users,name,' . $user->id,
            'is_active' => 'required|boolean',
        ]);

        $user->name = $request->name;
        $user->is_active = $user->role === 'admin' ? true : $request->is_active;
        $user->save();

        return response()->json(['message' => 'Sucesso!']);
    }

    // NEW TEMP PASSWORD
    #[Group(name: 'Gerenciar Usuários')]
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
