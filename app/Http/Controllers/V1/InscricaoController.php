<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Inscricao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Unauthenticated;

class InscricaoController extends Controller
{

    #[Group(name: 'Inscrições')]
    #[Response(content: ['data' => ['inscricao'], 'message' => 'Sucesso!', 'current_page' => 1, 'per_page' => 15, 'total' => 1], status: 200)]
    #[Unauthenticated]
    public function index(Request $request): JsonResponse
    {
        //
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
            'search' => 'nullable|string|min:3|max:50',
        ]);

        $inscricoes = Inscricao::when($request->search, function ($query, $search) {
            return $query->where('nome', 'like', "%$search%");
        })
        ->with('evento')
        ->paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            'data' => $inscricoes->items(),
            'message' => 'Sucesso!',
            'current_page' => $inscricoes->currentPage(),
            'per_page' => $inscricoes->perPage(),
            'total' => $inscricoes->total(),
        ]);
    }



    #[Group(name: 'Inscrições')]
    #[Response(content: ['data' => ['inscricao'], 'message' => 'Sucesso!'], status: 201)]
    #[Unauthenticated]
    public function store(Request $request): JsonResponse
    {

        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'nome' => 'required|min:3|max:50',
            'email' => 'required|email|unique:inscricaos,email,NULL,id,evento_id,' . $request->evento_id,
            'cpf' => 'required|min:11|max:14',
        ]);

        $inscricao = Inscricao::create([
            'evento_id' => $request->evento_id,
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
        ]);

        return response()->json([
            'data' => $inscricao,
            'message' => 'Sucesso!',
        ], 201);
    }


    #[Group(name: 'Inscrições')]
    #[Response(content: ['data' => ['inscricao'], 'message' => 'Sucesso!'], status: 200)]
    #[Unauthenticated]
    public function show(Inscricao $inscricao): JsonResponse
    {
        //
        return response()->json([
            'data' => $inscricao,
            'message' => 'Sucesso!',
        ]);
    }



}
