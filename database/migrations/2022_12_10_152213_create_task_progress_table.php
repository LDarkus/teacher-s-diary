<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId("task_id")->nullable()->constrained("tasks")->onDelete("cascade");
            $table->foreignId("work_id")->nullable()->constrained("completed_works")->onDelete("cascade");
            $table->integer('completed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_progress');
    }
};
