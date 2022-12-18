<?php

use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\studentAttendancesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WorkController;
use App\Models\Discipline;
use App\Models\Student;
use App\Models\Work;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DisciplineController::class, "index"]);
Route::resource("disciplines", DisciplineController::class);
Route::get("disciplines/{discipline}/{group}",[DisciplineController::class,"showWorks"])->name("disciplines.showWorks");
Route::put("disciplines/store/{completedWork}",[DisciplineController::class,"updateWork"])->name("disciplines.updateWork");
Route::get("disciplines/studentAttendances/{discipline}/{group}",[DisciplineController::class,"showStudentAttendances"])->name("disciplines.showStudentAttendances");
Route::put("disciplines/studentAttendances/{discipline}/{group}",[DisciplineController::class,"updateStudentAttendances"])->name("disciplines.updateStudentAttendances");
Route::post("studentAttendances/{discipline}/{group}",[StudentAttendancesController::class,"addDateInTable"])->name("studentAttendances.addDateInTable");
Route::delete("disciplines/{discipline}/{group}",[DisciplineController::class,"destroyGroup"])->name("disciplines.destroyGroup");
Route::resource('groups', GroupController::class);
Route::resource("students", StudentController::class);
Route::resource('works', WorkController::class);
