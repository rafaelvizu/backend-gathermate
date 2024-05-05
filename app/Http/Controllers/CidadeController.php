<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Response;

class CidadeController extends Controller
{

    #[Response(content: ['data' => ['evento'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function index(Request $request): JsonResponse
    {
        //
        $request->validate([
            'search' => 'string',
            'per_page' => 'integer',
            'page' => 'integer',
        ]);

        $search = $request->input('search');
        $per_page = $request->input('per_page', 1000);
        $page = $request->input('page', 1);

        $query = Cidade::query();

        if ($search) {
            $query->where('nome', 'like', "%$search%");
        }

        $cidades = $query->paginate($per_page, ['*'], 'page', $page);

        $response_json = [
            'data' => [
                'evento' => $cidades,
            ],
            'page' => $cidades->currentPage(),
            'per_page' => $cidades->perPage(),
            'message' => 'Sucesso!'
        ];

        return response()->json($response_json);
    }
}
