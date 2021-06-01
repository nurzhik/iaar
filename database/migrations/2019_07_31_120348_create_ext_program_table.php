<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ext_program', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('program_id')->unsigned()->nullable();
            $table->foreign('program_id')->references('id')->on('program_accreditations')->onDelete('cascade');
            $table->bigInteger('ext_report_id')->unsigned()->nullable();
            $table->foreign('ext_report_id')->references('id')->on('external_review_reports')->onDelete('cascade');
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
        Schema::dropIfExists('ext_program');
    }
}
