<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $with = ["tasks"];
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
