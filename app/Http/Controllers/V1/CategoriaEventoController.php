<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\CategoriaEvento;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Unauthenticated;

class CategoriaEventoController extends Controller
{

    #[Group(name: 'Categorias de eventos')]
    #[Response(content: ['data' => ['categoria_eventos'], 'message' => 'Sucesso!', 'current_page' => 1, 'per_page' => 15, 'total' => 1], status: 200)]
    #[Unauthenticated]
    public function index(Request $request)
    {
        //
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
            'search' => 'nullable|string|min:3|max:50',
        ]);

        $categorias = CategoriaEvento::when($request->search,  function ($query, $search) {
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


    #[Group(name: 'Categorias de eventos')]
    #[Response(content: ['data' => ['categoria_eventos'], 'message' => 'Sucesso!'], status: 201)]
    #[Authenticated]
    public function store(Request $request)
    {
        //
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'descricao' => 'required|string|min:3|max:1000'
        ]);

        $categoriaEvento = CategoriaEvento::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return response()->json([
            'data' => $categoriaEvento,
            'message' => 'Sucesso!',
        ], 201);
    }


    #[Group(name: 'Categorias de eventos')]
    #[Response(content: ['data' => ['categoria_eventos'], 'message' => 'Sucesso!'], status: 200)]
    #[Unauthenticated]
    public function show(CategoriaEvento $categoriaEvento)
    {
        //
        return response()->json([
            'data' => $categoriaEvento,
            'message' => 'Sucesso!',
        ]);
    }




    #[Group(name: 'Categorias de eventos')]
    #[Response(content: ['data' => ['categoria_eventos'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function update(Request $request, CategoriaEvento $categoriaEvento)
    {
        //
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'descricao' => 'required|string|min:3|max:1000'
        ]);

        $categoriaEvento->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return response()->json([
            'data' => $categoriaEvento,
            'message' => 'Sucesso!',
        ]);
    }

}
