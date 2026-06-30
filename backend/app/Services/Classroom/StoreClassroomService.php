<?php

namespace App\Services\Classroom;

use Illuminate\Http\Request;

use App\Models\Classroom;

class StoreClassroomService
 {
	public static function execute( array $data )
	{
		$classroom = new Classroom;

		$classroom->nome = $data['nome'];
		$classroom->criador_id = $data['criador_id'];
		
		$classroom->saveOrFail();

		return response()->json($classroom, 201);
	}
}