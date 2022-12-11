<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function disciplines(){
        return $this->belongsToMany(Discipline::class,"discipline_group","group_id","discipline_id");
    }
    public function students(){
        return $this->hasMany(Student::class,"group_id");
    }
}
