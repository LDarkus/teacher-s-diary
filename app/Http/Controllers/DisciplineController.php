<?php

namespace App\Http\Controllers;

use App\Models\CompletedWork;
use App\Models\Discipline;
use App\Models\Discipline_Group;
use App\Models\Group;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Список дисциплин";
        $disciplines = Discipline::all();
        $groups = Group::all();

        return view("discipline.index", compact("disciplines", "title", "groups"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        $title = "Формирование новой дисциплины";
        return view("discipline.create", compact("title", "groups"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $discipline = new Discipline();


        $discipline->name = $request->input("name");
        $discipline->save();


        if ($request->groups != null) {
            foreach ($request->groups as $group_id) {
                $discipline->groups()->save(Group::find($group_id));
            }
        }

        return redirect()->route("disciplines.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Discipline $discipline)
    {

        $title = "Подробная информация о дисциплине";
        //Сортировка по типам работ
        $discipline = Discipline::with(['works' => function ($query) {
            $query->orderBy('typeWork', 'asc');
        }])->find($discipline->id);




        return view("discipline.show", compact("title", "discipline"));
    }


    public function showWorks(Discipline $discipline, Group $group, Request $request)
    {

        /*  foreach ($group->students as $student) {
            foreach ($student->completedWorks as $work) {
                dd($work->work);
            }
        } */
        $labWorks = $discipline->works->filter(function ($work) {
            if ($work->typeWork == "Лабораторная")
                return $work;
        });
        $practWorks = $discipline->works->filter(function ($work) {
            if ($work->typeWork == "Практическая")
                return $work;
        });
        $method = 1;
        $title = "Оцененивание работ студентов";
        $method = $request->input("method");




        return view("discipline.showWorks", compact("title", "discipline", "group", "method", "labWorks", "practWorks"));
    }
    public function showStudentAttendances(Discipline $discipline, Group $group, Request $request)
    {

        /*  foreach ($group->students as $student) {
            foreach ($student->completedWorks as $work) {
                dd($work->work);
            }
        } */

        $title = "Отметка посещаемости студентов";

        $tab=2;
        if(empty($request->tab))
        {

        }
        else{
            dd($request->tab);
        }

        return view("discipline.showAttendanceMark", compact("title", "discipline", "group", "tab"));
    }

    public function updateStudentAttendances(Discipline $discipline, Group $group, Request $request)
    {

        /*  foreach ($group->students as $student) {
            foreach ($student->completedWorks as $work) {
                dd($work->work);
            }
        } */

        $student_attendances=$discipline->student_attendances;
        $type=$request->type;
        $marks=StudentAttendance::find($request->input("mark"));
        foreach($student_attendances as $attendance)
        {
            if($group->students->contains($attendance->student_id) && $attendance->typeWork==$type)
            {

                if($marks->contains($attendance->id))
                {
                    $attendance->visit=1;
                }
                else{
                    $attendance->visit=0;
                }
                $attendance->save();
            }
        }



        return redirect()->back();
    }
    public function updateWork(Request $request, CompletedWork $completedWork)
    {

        $tasks_id = $request->tasks;

        $completedWork->comment = $request->input("comment");
        foreach ($completedWork->tasksProgress as $task) {
            //dd($tasks_id,$completedWork->tasksProgress);
            if (isset($tasks_id) && (in_array($task->task_id, $tasks_id))) {

                $task->completed = 1;
            } else {
                $task->completed = 0;
            }

            $task->save();
        }

        if (isset($tasks_id)) {

            if ((count($completedWork->tasksProgress) == count($tasks_id))) {
                $completedWork->points = $request->input("points");
                $completedWork->date_of_completion = $request->input("date_of_completion");
                $completedWork->completed = 1;
            } elseif ((count($tasks_id) == 0)) {
                $completedWork->points = 0;
                $completedWork->date_of_completion = null;
                $completedWork->completed = 0;
            } else {
                $completedWork->completed = 2;
            }
        }


        $completedWork->save();

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Discipline $discipline)
    {
        $title = "Редактирование дисциплины";
        $groups = Group::all();
        return view("discipline.edit", compact("discipline", "title", "groups"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discipline $discipline)
    {


        $discipline->name = $request->input("name");
        $g = $discipline->groups()->sync($request->groups);

        $groupsUpdata = $g["attached"];
        $groupsDelete = $g["detached"];


        $discipline->save();

        if (!empty($groupsUpdata)) {
            $discipline->refresh();
            $works = $discipline->works;
            foreach ($works as $w) {
                $works_id[] = $w->id;
            }

            foreach ($discipline->groups as $group) {
                //dd($discipline->groups,$groups,$group);
                if (in_array($group->id, $groupsUpdata)) {

                    foreach ($group->students as $student) {
                        $student->works()->attach($works);
                        foreach ($student->completedWorks as $cWork) {
                            if (in_array($cWork->work->id, $works_id)) {
                                foreach ($cWork->work->tasks as $tId) {

                                    DB::insert('insert into task_progress (task_id, completed_work_id) values (?, ?)', [$tId->id, $cWork->id]);
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($groupsDelete)) {

            foreach ($discipline->groups as $group) {
                //dd($discipline->groups,$groups,$group);

                if (in_array($group->id, $groupsDelete)) {

                    foreach ($group->students as $student) {
                        $student->works()->detach($discipline->works);
                        $student->disciplineAttendances()->detach($discipline);
                    }
                }
            }
        }

        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discipline $discipline)
    {

        $discipline->delete();
        return redirect('/');
    }

    public function destroyGroup(Discipline $discipline, Group $group)
    {

        $group = Group::find($group->id);
        DB::delete('delete from discipline_group where group_id =? and discipline_id=?', [$group->id, $discipline->id]);
        foreach ($group->students as $student) {
            $student->works()->sync(null);
            $student->disciplineAttendances()->sync(null);
        }

        return redirect()->back();
    }
}
