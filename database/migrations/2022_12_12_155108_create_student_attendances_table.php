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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId("discipline_id")->nullable()->constrained("disciplines")->onDelete("cascade");
            $table->foreignId("student_id")->nullable()->constrained("students")->onDelete("cascade");
            $table->string("typeWork")->nullable();
            $table->date("date_visit")->nullable();
            $table->boolean("visit")->default(0);
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
        Schema::dropIfExists('student_attendances');
    }
};
