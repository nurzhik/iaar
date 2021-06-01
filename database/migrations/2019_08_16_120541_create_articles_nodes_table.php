<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('articles')->onDelete('cascade');
            $table->string('lang')->nullable();
            $table->string('title')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('text')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->text('og_title')->nullable()->default(null);
            $table->text('og_img')->nullable()->default(null);
            $table->text('og_description')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_nodes');
    }
}
