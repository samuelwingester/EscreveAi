<?php

namespace App\Services\Aluno;

use App\Models\Aluno;

class StoreAlunoService
 {
	public static function execute( array $data )
	{
		$aluno = new Aluno;

		$aluno->nome = $data['nome'];
		$aluno->data_nascimento = $data['data_nascimento'];
		$aluno->responsavel_id = $data['responsavel_id'];

		$aluno->saveOrFail();

		return response()->json($aluno, 201);	
	}
}