<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Response;

class EventoController extends Controller
{

    #[Response(content: ['data' => ['evento'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function index(Request $request)
    {
        //
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:300',
        ]);

        $eventos = Evento::paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            'data' => [
                'evento' => $eventos,
            ],
            'message' => 'Sucesso!'
        ]);
    }



    #[Response(content: ['data' => ['evento'], 'message' => 'Sucesso!'], status: 201)]
    #[Authenticated]
    public function store(Request $request)
    {
        //
        $request->validate([
            'nome' => 'required|min:3|max:50|unique:eventos',
            'descricao' => 'required|min:3|max:50',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after:data_inicio',

            'online' => 'required|boolean',

            'endereco' => 'nullable|min:3|max:50',
            'cidade' => 'nullable|min:3|max:50',
            'cep' => 'nullable|regex:/\d{5}-\d{3}/',
            'estado' => 'nullable|regex:/[A-Z]{2}/',

        ]);

        $evento = Evento::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,

            'online' => $request->online,

            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'cep' => $request->cep,
            'estado' => $request->estado,

        ]);

        $response_json = [
            'data' => [
                'evento' => $evento,
            ],
            'message' => 'Sucesso!'
        ];

        return response()->json([$response_json], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        //
        return response()->json([
            'data' => [
                'evento' => $evento,
            ],
            'message' => 'Sucesso!'
        ]);

    }


    #[Response(content: ['data' => ['evento' => 'Evento'], 'message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function update(Request $request, Evento $evento)
    {
        //
        $request->validate([
            'nome' => 'required|min:3|max:50|unique:eventos,nome,' . $evento->id,
            'descricao' => 'required|min:3|max:50',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after:data_inicio',

            'online' => 'required|boolean',

            'endereco' => 'nullable|min:3|max:50',
            'cidade' => 'nullable|min:3|max:50',
            'cep' => 'nullable|regex:/\d{5}-\d{3}/',
            'estado' => 'nullable|regex:/[A-Z]{2}/',


        ]);

        $evento->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,

            'online' => $request->online,

            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'cep' => $request->cep,
            'estado' => $request->estado,
        ]);

        $response_json = [
            'data' => [
                'evento' => $evento,
            ],
            'message' => 'Sucesso!'
        ];

        return response()->json([$response_json]);
    }


    #[Response(content: ['message' => 'Sucesso!'], status: 200)]
    #[Authenticated]
    public function destroy(Evento $evento)
    {
        $evento->delete();
        return response()->json([
            'message' => 'Sucesso!'
        ]);
    }


}
