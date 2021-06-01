<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('static_pages')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->dateTime('show_date')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('year')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('image')->nullable();
            $table->text('file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
