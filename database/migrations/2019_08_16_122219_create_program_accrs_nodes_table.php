<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramAccrsNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_accr_nodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('program_accreditations')->onDelete('cascade');
            $table->string('lang')->nullable();
            $table->string('license')->nullable();
            $table->text('report_doc')->nullable();
            $table->text('decision_doc')->nullable();
            $table->text('committee_consist_doc')->nullable();
            $table->string('program_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_accr_nodes');
    }
}
