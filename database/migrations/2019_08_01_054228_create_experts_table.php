<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->string('type_id')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->integer('category_id')->nullable();
            $table->string('certificate_number')->nullable();
            $table->dateTime('certificate_date')->nullable();
            $table->text('place_of_work')->nullable();
            $table->string('position')->nullable();
            $table->text('academic_degrees')->nullable();
            $table->text('languages')->nullable();
            $table->text('contacts')->nullable();
            $table->tinyInteger('category_number')->nullable();
            //$table->text('possible_directions')->nullable();
            //$table->text('existing_directions')->nullable();
            $table->boolean('is_chairman')->default(false);

            $table->boolean('is_participated')->default(false);
            $table->tinyInteger('foreign_expert_type')->nullable();
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
        Schema::dropIfExists('experts');
    }
}
