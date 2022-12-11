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
        Schema::create('completed_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId("work_id")->nullable()->constrained("works")->onDelete("cascade");
            $table->foreignId("student_id")->nullable()->constrained("students")->onDelete("cascade");
            $table->date("date_of_completion")->nullable();
            $table->text("comment")->nullable();
            $table->integer("points")->default(0);
            $table->integer("completed")->default(0);
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
        Schema::dropIfExists('completed_works');
    }
};
