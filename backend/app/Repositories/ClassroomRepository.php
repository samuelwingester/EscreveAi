<?php

namespace App\Repositories;

use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Repositories\Repository;
use App\Models\Classroom;

use Illuminate\Support\Facades\DB;

class ClassroomRepository extends Repository implements ClassroomRepositoryInterface
{
    protected string $modelClass = Classroom::class;

    public function getWithTeacherId( int|string $id )
    {
        return DB::table( 'classes' )->where( 'teacher_id', $id )->get( ['name', 'id'] );
    }
}
