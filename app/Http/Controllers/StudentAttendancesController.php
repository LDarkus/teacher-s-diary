<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StudentAttendancesController extends Controller
{

    public function addDateInTable(Discipline $discipline, Group $group, Request $request)
    {   date_default_timezone_set("Asia/Irkutsk");
        $student=$group->students()->first();


        $array = DB::table('student_attendances')
            ->where('typeWork', '=', $request->typeWork)
            ->where('date_visit', '=', date("Y-m-d"))
            ->where("student_id","=",$student->id)
            ->get();


        if ($array->isEmpty()) {
            foreach ($group->students as $student) {
                DB::insert('insert into student_attendances (discipline_id,student_id,typeWork,date_visit) values (?, ?,?,?)', [$discipline->id, $student->id, $request->typeWork, date("Y-m-d")]);
            }

        }
        else{
            dd($array);
        }

        return redirect()->back();
    }
}
