<?php

namespace App\Services\Turma;

use App\Models\Turma;

class UpdateTurmaService
 {
	public static function execute( Turma $turma, array $data )
	{
		$turma->fill($data);
		
		$turma->saveOrFail();

		return response()->json($turma, 202);
	}
}