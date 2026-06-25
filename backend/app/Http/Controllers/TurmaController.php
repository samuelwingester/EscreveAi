<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Turma;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Turma::find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recurso não encontrado.'
            ], 404);
        }

        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Turma::destroy($id);
    }
}
