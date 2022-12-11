<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;
    protected $with = ['groups','works'];


    public function groups(){
        return $this->belongsToMany(Group::class,"discipline_group","discipline_id","group_id");
    }
    public function works()
    {
        return $this->hasMany(Work::class,"discipline_id");
    }
}
