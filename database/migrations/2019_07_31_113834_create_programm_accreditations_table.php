<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammAccreditationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_accreditations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status_id')->nullable();
            $table->string('program_title')->nullable();
            $table->string('program_index')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->integer('years')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->timestamps();
            $table->bigInteger('university_id')->unsigned()->nullable();
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_accreditations');
    }
}
