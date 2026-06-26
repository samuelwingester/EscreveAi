<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Turma;

use App\Services\Turma\StoreTurmaService;
use App\Services\Turma\UpdateTurmaService;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Turma::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([ 
            'nome' => ['required', 'max:100'],
            'criador_id' => ['required', 'exists:professores,id']
        ]);

        return StoreTurmaService::execute( $data );      
    }

    /**
     * Display the specified resource.
     */
    public function show(Turma $turma)
    {
        return $turma;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma)
    {
        $data = $request->validate([
            'nome' => ['sometimes', 'max:100'],
            'ativo' => ['sometimes', 'boolean:strict']
        ]);

        return UpdateTurmaService::execute( $turma, $data );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        $turma->deleteOrFail();

        //Retorna 204 se não houver erros
        return response()->noContent();
    }
}
