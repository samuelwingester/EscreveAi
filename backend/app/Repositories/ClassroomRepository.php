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

    public function getStats( int|string $id )
    {
        return DB::selectOne("
            SELECT COUNT( stu.id ) as students,
                COUNT( act.id ) as activities, COUNT( rep.id ) as reports,
                COUNT( CASE WHEN stu.writing_level = 'pre-silabico' THEN 1 END) as pre_silabico,
                COUNT( CASE WHEN stu.writing_level = 'silabico' THEN 1 END) as silabico,
                COUNT( CASE WHEN stu.writing_level = 'silabico-alfabetico' THEN 1 END) as silabico_alfabetico,
                COUNT( CASE WHEN stu.writing_level = 'alfabetico' THEN 1 END) as alfabetico
            FROM classes cla
                LEFT JOIN students stu ON cla.id = stu.class_id
                LEFT JOIN activities act ON cla.id = act.class_id
                LEFT JOIN reports rep ON stu.id = rep.student_id
            WHERE cla.id = ?;
        ", [ $id ]);
    }
}
