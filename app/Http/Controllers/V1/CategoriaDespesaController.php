<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\CategoriaDespesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Unauthenticated;

class CategoriaDespesaController extends Controller
{

    #[Group(name: 'Categorias de despesas')]
    #[Response(content: ['data' => ['categoria'], 'message' => 'Sucesso!', 'current_page' => 1, 'per_page' => 15, 'total' => 1], status: 200)]
    #[Authenticated]
    public function index(Request $request): JsonResponse
    {
        //
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
            'search' => 'nullable|string|min:3|max:50',
        ]);

        $categorias = CategoriaDespesa::when($request->search,  function ($query, $search) {
            return $query->where('nome', 'like', "%$search%");
        })->paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            'data' => $categorias->items(),
            'message' => 'Sucesso!',
            'current_page' => $categorias->currentPage(),
            'per_page' => $categorias->perPage(),
            'total' => $categorias->total(),
        ]);
    }


    #[Group(name: 'Categorias de despesas')]
    #[Response(content: ['data' => ['despesa'], 'message' => 'Sucesso!'], status: 201)]
    #[Authenticated]
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'descricao' => 'required|string|min:3|max:1000'
        ]);

        $categoriaDespesa = CategoriaDespesa::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return response()->json([
            'data' => $categoriaDespesa,
            'message' => 'Sucesso!',
        ]);
    }

    #[Group(name: 'Categorias de despesas')]
    #[Response(content: ['data' => ['despesa'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function show(CategoriaDespesa $categoriaDespesa): JsonResponse
    {
        //
        return response()->json([
            'data' => $categoriaDespesa,
            'message' => 'Sucesso!',
        ]);
    }


    #[Group(name: 'Categorias de despesas')]
    #[Response(content: ['data' => ['despesa'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function update(Request $request, CategoriaDespesa $categoriaDespesa)
    {
        //
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'descricao' => 'required|string|min:3|max:1000'
        ]);

        $categoriaDespesa->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return response()->json([
            'data' => $categoriaDespesa,
            'message' => 'Sucesso!',
        ]);
    }


}
