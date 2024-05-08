<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Cidade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Unauthenticated;

class EventoController extends Controller
{

    #[Group(name: 'Eventos')]
    #[Response(content: ['data' => ['evento'], 'message' => 'Sucesso!', 'current_page' => 1, 'per_page' => 15, 'total' => 1], status: 200)]
    #[Unauthenticated]
    public function index(Request $request): JsonResponse
    {
        //
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
            'search' => 'nullable|string|min:3|max:50',
            'categoria_evento_id' => 'nullable|in:categorias_eventos,id',
        ]);

        $eventos = Evento::when($request->search, function ($query, $search) {
            return $query->where('nome', 'like', "%$search%");
        })
            ->when($request->categoria_evento_id, function ($query, $categoria_evento_id) {
                return $query->where('categoria_evento_id', $categoria_evento_id);
            })
            ->withCount('inscricoes')
            ->paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            'data' => $eventos->items(),
            'message' => 'Sucesso!',
            'current_page' => $eventos->currentPage(),
            'per_page' => $eventos->perPage(),
            'total' => $eventos->total(),
        ]);
    }



    #[Group(name: 'Eventos')]
    #[Response(content: ['data' => ['evento'], 'message' => 'Sucesso!'], status: 201)]
    #[Authenticated]
    public function store(Request $request): JsonResponse
    {
        //
        $request->validate([
            'nome' => 'required|min:3|max:50|unique:eventos',
            'descricao' => 'required|min:3|max:50',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after:data_inicio',

            'modalidade' => 'required|in:presencial,online,hibrido',
            'endereco' => 'nullable|min:3|max:50',
            'cidade_id' => 'nullable|in:' . Cidade::pluck('id')->implode(','),
            'cep' => 'nullable|regex:/\d{5}-\d{3}/',
            'link' => 'nullable|url',
            'categoria_evento_id' => 'required|in:categorias_eventos,id',
        ]);

        $cidade = Cidade::find($request->cidade);

        $cidade_nome = $cidade->cidade;
        $estado = $cidade->estado;


        $evento = Evento::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,

            'modalidade' => Str::title($request->modalidade),

            'endereco' => $request->endereco,
            'cidade' => $cidade_nome,
            'cep' => $request->cep,
            'estado' => $estado,
            'link' => $request->link,
            'categoria_evento_id' => $request->categoria_evento_id,
        ]);

        $response_json = [
            'data' => [
                'evento' => $evento,
            ],
            'message' => 'Sucesso!'
        ];

        return response()->json([$response_json], 201);
    }

    #[Group(name: 'Eventos')]
    #[Response(content: ['data' => ['evento'], 'message' => 'Sucesso!'], status: 200)]
    #[Unauthenticated]
    public function show(Evento $evento): JsonResponse
    {
        //
        return response()->json([
            'data' => [
                $evento,
            ],
            'message' => 'Sucesso!'
        ]);

    }


    #[Group(name: 'Eventos')]
    #[Response(content: ['data' => ['evento'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function update(Request $request, Evento $evento): JsonResponse
    {
        //
        $request->validate([
            'nome' => 'required|min:3|max:50|unique:eventos,nome,' . $evento->id,
            'descricao' => 'required|min:3|max:50',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after:data_inicio',

            'online' => 'required|boolean',

            'endereco' => 'nullable|min:3|max:50',
            'cidade_id' => 'nullable|in:' . Cidade::pluck('id')->implode(','),
            'cep' => 'nullable|regex:/\d{5}-\d{3}/',
            'link' => 'nullable|url',
            'categoria_evento_id' => 'required|in:categorias_eventos,id',
        ]);

        $cidade = Cidade::find($request->cidade);

        $cidade_nome = $cidade->cidade;
        $estado = $cidade->estado;

        $evento->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,

            'online' => $request->online,

            'endereco' => $request->endereco,
            'cidade' => $cidade_nome,
            'cep' => $request->cep,
            'estado' => $estado,
            'link' => $request->link,
            'categoria_evento_id' => $request->categoria_evento_id,
        ]);

        $response_json = [
            'data' => [
                $evento,
            ],
            'message' => 'Sucesso!'
        ];

        return response()->json([$response_json]);
    }

    #[Group(name: 'Eventos')]
    #[Response(content: ['message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function destroy(Evento $evento): JsonResponse
    {
        $evento->delete();
        return response()->json([
            'message' => 'Sucesso!'
        ]);
    }


}
