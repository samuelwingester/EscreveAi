<?php

namespace App\Services\Turma;

use Illuminate\Http\Request;

use App\Models\Turma;

class StoreTurmaService
 {
	public static function execute( array $data )
	{
		$turma = new Turma;

		$turma->nome = $data['nome'];
		$turma->criador_id = $data['criador_id'];
		
		$turma->saveOrFail();

		return response()->json($turma, 201);
	}
}