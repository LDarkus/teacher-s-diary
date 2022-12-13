<?php

namespace App\Http\Controllers;

use App\Models\CompletedWork;
use App\Models\Discipline;
use App\Models\Group;
use App\Models\Task;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Writer\Word2007\Part\Rels;


class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = "Формирование работы";
        $discipline_id=$request->input("discipline");

        return view("work.create", compact('title','discipline_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discipline=Discipline::find($request->input("discipline_id"));


        $tasks = explode("\n", str_replace("\r", "", $request->input("tasks")));
        $tasks = array_filter($tasks);
        $work = new Work();
        $work->discipline_id=$request->input("discipline_id");

        $work->name=$request->input("nameWork");
        $work->typeWork=$request->input("typeWork");
        $work->max_points=$request->input("scoreWork");
        $work->deadline=$request->input("deadline");
        $work->save();
        $discipline->refresh();

        foreach($tasks as $t){

            $task= new Task();
            $task->name=$t;
            $tasks_id[]=$work->tasks()->save($task);


        }

        foreach($discipline->groups as $group){
            foreach($group->students as $student){

                $student->works()->attach($work);
                foreach($student->completedWorks as $cWork){


                    if($cWork->work_id==$work->id)
                    {

                        foreach($tasks_id as $tId)
                        {

                            DB::insert('insert into task_progress (task_id, completed_work_id) values (?, ?)', [$tId->id, $cWork->id]);
                        }
                    }

                }

            }
        }




        return redirect()->route("disciplines.show", ["discipline"=>$work->discipline_id]);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        $title = "Редактирование работы";


        return view("work.edit", compact('title',"work"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        $tasks = explode("\n", str_replace("\r", "", $request->input("tasks")));
        $tasks = array_filter($tasks);
        $work->name=$request->input("nameWork");
        $work->typeWork=$request->input("typeWork");
        $work->max_points=$request->input("scoreWork");
        $work->deadline=$request->input("deadline");
        $work->save();
        Task::where("work_id","=",$work->id)->delete();
        foreach($tasks as $t){

            $task= new Task();
            $task->name=$t;
            $work->tasks()->save($task);
        }

        return redirect()->route("disciplines.show", ["discipline"=>$work->discipline_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        $work->delete();
        return redirect()->back();
    }
}
