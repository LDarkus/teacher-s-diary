<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Unset_;

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
    public function student_attendances(){
        return $this->hasMany(StudentAttendance::class);
    }
    //Связь с дисциплиной через посещаемость
    public function disciplineAttendances(){
        return $this->belongsToMany(Discipline::class,"student_attendances","student_id","discipline_id");
    }





    public function addInCompletedWork($id){
        $group = Group::with("disciplines")->find($id);


        foreach($group->disciplines as $discipline){

            UnSet($works_id);
            foreach ($discipline->works as $w) {
                $works_id[] = $w->id;
            }
            if(!isset($works_id)){
                continue;
            }
            $this->works()->attach($discipline->works);
            $this->refresh();

            foreach ($this->completedWorks as $cWork) {

                if (in_array($cWork->work->id, $works_id)) {
                    foreach ($cWork->work->tasks as $tId) {

                        DB::insert('insert into task_progress (task_id, completed_work_id) values (?, ?)', [$tId->id, $cWork->id]);
                    }
                }
            }

        }



    }

}
