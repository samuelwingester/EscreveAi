<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Contracts\ClassroomRepositoryInterface;
use App\Repositories\Query\Contracts\QueryOptionsInterface;

use App\Repositories\Repository;
use App\Models\Classroom;
use App\Repositories\Query\QueryOptions;

class ClassroomRepository extends Repository implements ClassroomRepositoryInterface
{
    protected string $modelClass = Classroom::class;

    public function getByTeacher( int|string $id, array $filters = [], array $columns = ["*"], ?QueryOptionsInterface $options = null )
    {
        $filters[] = ["teacher_id", "=", $id];

        if ( !$options ) $options = new QueryOptions();

        $builder = DB::table( "classes" )->where( $filters );

        $builder = $builder->orderBy( $options->orderBy, $options->direction );

        if ( $options->limit > 0 ) $builder = $builder->limit( $options->limit );
        if ( $options->offset > 0 ) $builder = $builder->offset( $options->offset );

        return $builder->get( $columns );
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
                LEFT JOIN students stu ON cla.id = stu.classroom_id
                LEFT JOIN activities act ON cla.id = act.classroom_id
                LEFT JOIN reports rep ON stu.id = rep.student_id
            WHERE cla.id = ?;
        ", [ $id ]);
    }
}
