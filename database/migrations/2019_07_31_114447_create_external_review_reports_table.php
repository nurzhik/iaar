<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalReviewReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_review_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->text('report_file')->nullable();
            $table->text('decision_file')->nullable();
            $table->timestamps();
            $table->bigInteger('university_id')->unsigned()->nullable();
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade');
            $table->bigInteger('program_id')->unsigned()->nullable();
            $table->foreign('program_id')->references('id')->on('program_accreditations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_review_reports');
    }
}
