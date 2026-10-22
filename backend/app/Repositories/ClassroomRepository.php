<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ClassroomRepository
{
    public function getByTeacherWithStudents( int|string $id )
    {
        return DB::table( "classes" )
            ->leftJoin( "students", "classes.id", "=", "students.classroom_id" )
            ->where( "classes.teacher_id", $id )
            ->groupBy( "classes.id", "classes.name", "classes.shift" )
            ->get([ "classes.id", "classes.name", "classes.shift", DB::raw( "COUNT(students.id) as students" ) ]);
    }

    public function getStats( int|string $id )
    {
        return (array) DB::selectOne("
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
