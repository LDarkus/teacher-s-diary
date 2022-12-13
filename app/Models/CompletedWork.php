<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedWork extends Model
{
    use HasFactory;
    protected $fillable = ['work_id'];
    public function tasks()
    {
        return $this->belongsToMany(Task::class, "task_progress", "completed_work_id", "task_id");
    }
    public function work()
    {
        return $this->belongsTo(Work::class);
    }
    public function tasksProgress()
    {
        return $this->hasMany(TaskProgress::class,"completed_work_id");
    }
}
