<?php

namespace App\Http\Controllers;

use App\Models\CompletedWork;
use App\Models\Discipline;
use App\Models\Discipline_Group;
use App\Models\Group;
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


        return view("discipline.index", compact("disciplines", "title"));
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


    public function showWorks(Discipline $discipline, Group $group)
    {

        /*  foreach ($group->students as $student) {
            foreach ($student->completedWorks as $work) {
                dd($work->work);
            }
        } */
        $title = "Оцененивание работ студентов";
        return view("discipline.showWorks", compact("title", "discipline", "group"));
    }
    public function updateWork(Request $request, CompletedWork $completedWork)
    {

        $tasks_id = $request->tasks;

        $completedWork->comment = $request->input("comment");
        foreach ($completedWork->tasksProgress as $task) {

            if (isset($tasks_id) && (in_array($task->id, $tasks_id))) {
                $task->completed = 1;
            } else {
                $task->completed = 0;
            }

            $task->save();
        }

        if (isset($tasks_id) && (count($completedWork->tasksProgress) == count($tasks_id))) {
            $completedWork->points = $request->input("points");
            $completedWork->date_of_completion = $request->input("date_of_completion");
            $completedWork->completed=1;
        } else {
            $completedWork->points = 0;
            $completedWork->date_of_completion = null;
            $completedWork->completed=0;
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
        $d = $discipline->groups()->sync($request->groups);
        //Нужно подумать как добавлять в промежуточные таблице при добавлении удалиении группы

        $discipline->save();

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

        return redirect()->back();
    }
}
