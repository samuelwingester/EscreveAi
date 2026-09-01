<?php

namespace App\Repositories;

use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Repositories\Repository;
use App\Models\Classroom;

use Illuminate\Support\Facades\DB;

class ClassroomRepository extends Repository implements ClassroomRepositoryInterface
{
    protected string $modelClass = Classroom::class;

    public function getByTeacher(
        int|string $id,
        array $filters = [],
        array $columns = ["*"],
        string $orderBy = "id",
        int $limit = 0,
        int $offset = 0
    ) {
        $query = DB::table( "classes" )->where( "teacher_id", "=", $id )->where( $filters )->orderBy( $orderBy );

        if ( $limit > 0 )
            $query = $query->limit( $limit );
        if ( $offset > 0 )
            $query = $query->offset( $offset );

        return $query->get( $columns );
    }

    public function getByTeacherWithStudents( int|string $id )
    {
        return DB::table( "classes" )
            ->leftJoin( "students", "classes.id", "=", "students.class_id" )
            ->where( "classes.teacher_id", $id )
            ->groupBy( "classes.id", "classes.name", "classes.shift" )
            ->get([ "classes.id", "classes.name", "classes.shift", DB::raw( "COUNT(students.id) as students" ) ]);
    }

    public function getStats( int|string $id )
    {
        // Melhorar isso depois funciona mas e feio;
        return DB::selectOne("
            SELECT
                COUNT( DISTINCT stu.id ) as students,
                COUNT( DISTINCT act.id ) as activities,
                COUNT( DISTINCT rep.id ) as reports,
                COUNT( DISTINCT CASE WHEN stu.writing_level = 'pre-silabico' THEN stu.id END) as pre_silabico,
                COUNT( DISTINCT CASE WHEN stu.writing_level = 'silabico' THEN stu.id END) as silabico,
                COUNT( DISTINCT CASE WHEN stu.writing_level = 'silabico-alfabetico' THEN stu.id END) as silabico_alfabetico,
                COUNT( DISTINCT CASE WHEN stu.writing_level = 'alfabetico' THEN stu.id END) as alfabetico
            FROM classes cla
                LEFT JOIN students stu ON cla.id = stu.class_id
                LEFT JOIN activities act ON cla.id = act.class_id
                LEFT JOIN reports rep ON stu.id = rep.student_id
            WHERE cla.id = ?;
        ", [ $id ]);
    }
}
