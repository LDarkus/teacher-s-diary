<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{


    use HasFactory;

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function works(){
        return $this->belongsToMany(Work::class,"completed_works","student_id","work_id");
    }

    public function completedWorks(){
        return $this->hasMany(CompletedWork::class);
    }

    public function addInCompletedWork($id){
        $group = Group::with("disciplines")->find($id);


        foreach($group->disciplines as $discipline){

            foreach($discipline->works as $work){
                    $completedWork=new CompletedWork();
                    $completedWork->student_id=$this->id;
                    $completedWork->work_id=$work->id;
                    $completedWork->save();
                }

            }
    }

}
