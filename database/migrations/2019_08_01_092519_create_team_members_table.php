<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('job')->nullable();
            $table->text('photo')->nullable();
            $table->integer('sort_order')->nullable();
            $table->text('experience')->nullable();
            $table->text('education')->nullable();
            $table->string('languages')->nullable();
            $table->text('qualities')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('skype')->nullable();
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('static_pages')->onDelete('cascade');
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
        Schema::dropIfExists('team_members');
    }
}
