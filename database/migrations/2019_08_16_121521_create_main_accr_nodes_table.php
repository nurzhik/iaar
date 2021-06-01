<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainAccrNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_accrs_nodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('main_accreditations')->onDelete('cascade');
            $table->string('lang')->nullable();
            $table->string('license')->nullable();
            $table->text('report_doc')->nullable();
            $table->text('decision_doc')->nullable();
            $table->text('committee_consist_doc')->nullable();
            $table->string('org_form')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_accrs_nodes');
    }
}
