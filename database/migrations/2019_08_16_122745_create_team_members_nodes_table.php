<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members_nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('team_members')->onDelete('cascade');
            $table->string('lang')->nullable();
            $table->string('name')->nullable();
            $table->string('job')->nullable();
            $table->integer('sort_order')->nullable();
            $table->text('experience')->nullable();
            $table->text('education')->nullable();
            $table->string('languages')->nullable();
            $table->text('qualities')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_members_nodes');
    }
}
