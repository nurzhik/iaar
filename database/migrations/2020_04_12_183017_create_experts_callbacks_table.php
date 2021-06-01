<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertsCallbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experts_callbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('surname')->nullable();
            $table->string('name')->nullable();
            $table->string('third_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('languages')->nullable();
            $table->text('level_of_knowing')->nullable();
            $table->string('science_degree')->nullable();
            $table->string('science_rank')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->text('work_place')->nullable();
            $table->string('job')->nullable();
            $table->string('teaching_experience')->nullable();
            $table->text('rewards')->nullable();
            $table->string('science_sphere')->nullable();
            $table->text('expert_spheres')->nullable();
            $table->text('documents')->nullable();
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
        Schema::dropIfExists('experts_callbacks');
    }
}
