<?php

namespace App\Http\Controllers;

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
        $title="Список дисциплин";

        $disciplines = Discipline::with("groups")->get();

        return view("discipline.index", compact("disciplines","title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups=Group::all();
        $title="Формирование новой дисциплины";
        return view("discipline.create",compact("title","groups"));
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


        $discipline->name=$request->input("name");
        $discipline->save();


        if($request->groups!=null){
            foreach($request->groups as $group_id)
        {
            $discipline_group= new Discipline_Group();
            $discipline_group->discipline_id=$discipline->id;
            $discipline_group->group_id=$group_id;
            $discipline_group->save();

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
        $title="Подробная информация о дисциплине";
        return view("discipline.show",compact("title","discipline"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Discipline $discipline)
    {
        $title="Редактирование дисциплины";
        $groups=Group::all();
        return view("discipline.edit",compact("discipline","title","groups"));
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


        $discipline->name=$request->input("name");
        $discipline->save();

        DB::delete('delete from discipline_group where discipline_id = ?', [$discipline->id]);
        foreach($request->groups as $group_id)
        {
            $discipline_group= new Discipline_Group();
            $discipline_group->discipline_id=$discipline->id;
            $discipline_group->group_id=$group_id;
            $discipline_group->save();

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
        dd($group);
        $group=Group::find($group->id);
        DB::delete('delete from discipline_group where group_id =? and discipline_id=?', [$group->id,$discipline->id]);

        return redirect()->back();
    }
}
