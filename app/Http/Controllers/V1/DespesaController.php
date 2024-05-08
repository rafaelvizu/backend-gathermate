<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Despesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;

class DespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'categoria_despesa_id' => 'nullable|exists:categoria_despesas,id',
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
        ]);

        $despesas = Despesa::when($request->categoria_despesa_id, function ($query, $categoria_despesa_id) {
            return $query->where('categoria_id', $categoria_despesa_id);
        })
            ->where('evento_id', $request->evento_id)
            ->paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            'data' => $despesas->items(),
            'message' => 'Sucesso!',
            'current_page' => $despesas->currentPage(),
            'per_page' => $despesas->perPage(),
            'total' => $despesas->total(),
        ]);
    }


    #[Group(name: 'Despesas')]
    #[Response(content: ['data' => ['despesa'], 'message' => 'Sucesso!'], status: 201)]
    #[Authenticated]
    public function store(Request $request): JsonResponse
    {
        //
        $request->validate([
            'descricao' => 'required|string|min:1|max:1000',
            'valor_unidade' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
            'evento_id' => 'required|exists:eventos,id'
        ]);


        $valor_total = $request->valor_unidade * $request->quantidade;


        $despesa = Despesa::create([
            'descricao' => $request->descricao,
            'valor_unidade' => $request->valor_unidade,
            'quantidade' => $request->quantidade,
            'valor_total' => $valor_total,
            'categoria_id' => $request->categoria_id,
            'evento_id' => $request->evento_id,
        ]);

        return response()->json([
            'data' => $despesa,
            'message' => 'Sucesso!',
        ]);

    }

    #[Group(name: 'Despesas')]
    #[Response(content: ['data' => ['despesa'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function show(Despesa $despesa): JsonResponse
    {
        //
        return response()->json([
            'data' => $despesa,
            'message' => 'Sucesso!',
        ]);
    }


    #[Group(name: 'Despesas')]
    #[Response(content: ['data' => ['despesa'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function update(Request $request, Despesa $despesa): JsonResponse
    {
        //
        $request->validate([
            'descricao' => 'required|string|min:1|max:1000',
            'valor_unidade' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
            'evento_id' => 'required|exists:eventos,id'
        ]);

        $despesa->update([
            'descricao' => $request->descricao,
            'valor_unidade' => $request->valor_unidade,
            'quantidade' => $request->quantidade,
            'valor_total' => $request->valor_unidade * $request->quantidade,
            'valor_pago' => $request->valor_pago,
            'pago' => $request->valor_pago === $request->valor_total,
            'categoria_id' => $request->categoria_id,
            'evento_id' => $request->evento_id,
        ]);

        return response()->json([
            'data' => $despesa,
            'message' => 'Sucesso!',
        ]);
    }

    #[Group(name: 'Despesas')]
    #[Response(content: ['message' => 'Sucesso!'], status: 200)]
    public function destroy(Despesa $despesa): JsonResponse
    {
        //
        $despesa->delete();

        return response()->json([
            'mwssage' => 'Sucesso!',
        ]);
    }
}
