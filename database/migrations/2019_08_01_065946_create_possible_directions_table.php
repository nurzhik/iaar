<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePossibleDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possible_directions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('expert_id')->unsigned()->nullable();
            $table->foreign('expert_id')->references('id')->on('experts')->onDelete('cascade');
            $table->string('direction')->nullable();
            $table->string('specialization')->nullable();
            $table->tinyInteger('accr_type')->nullable();
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
        Schema::dropIfExists('possible_directions');
    }
}
