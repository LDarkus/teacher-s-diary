<?php

use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\GroupController;
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
Route::delete("disciplines/{discipline}/{group}",[DisciplineController::class,"destroyGroup"])->name("disciplines.destroyGroup");
Route::resource('groups', GroupController::class);
Route::resource("students", StudentController::class);
Route::resource('works', WorkController::class);
