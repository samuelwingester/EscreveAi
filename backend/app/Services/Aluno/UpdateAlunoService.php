<?php

namespace App\Services\Aluno;

use App\Models\Aluno;

class UpdateAlunoService
 {
	public static function execute( Aluno $aluno, array $data )
	{
		$aluno->fill($data);
		
		$aluno->saveOrFail();

		return response()->json($aluno, 202);
	}
}