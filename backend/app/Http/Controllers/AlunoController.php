<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Aluno;

use App\Services\Aluno\StoreAlunoService;
use App\Services\Aluno\UpdateAlunoService;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Aluno::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => ['required', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'responsavel_id' => ['required', 'exists:responsaveis,id'],
            'data_nascimento' => ['required', 'date_format:Y-m-d', 'before:today']
        ]);

        return StoreAlunoService::execute( $data );
    }

    /**
     * Display the specified resource.
     */
    public function show(Aluno $aluno)
    {
        return $aluno;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
    {
        $data = $request->validate([
            'nome' => ['sometimes', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'data_nascimento' => ['sometimes', 'date_format:Y-m-d', 'before:today']
        ]);

        return UpdateAlunoService::execute( $aluno, $data );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        $aluno->deleteOrFail();
        
        return response()->noContent();
    }
}
