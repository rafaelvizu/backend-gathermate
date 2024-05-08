<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Despesa;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'descricao' => 'required|string|min:1|max:1000',
            'valor_unidade' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1',
            'valor_total' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'evento_id' => 'required|exists:eventos,id'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Despesa $despesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Despesa $despesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Despesa $despesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Despesa $despesa)
    {
        //
    }
}
