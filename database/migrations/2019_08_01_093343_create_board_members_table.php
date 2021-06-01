<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('job')->nullable();
            $table->text('photo')->nullable();
            $table->text('content')->nullable();
            $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('board_members');
    }
}
