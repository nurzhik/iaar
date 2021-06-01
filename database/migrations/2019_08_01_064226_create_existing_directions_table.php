<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistingDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('existing_directions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('expert_id')->unsigned()->nullable();
            $table->foreign('expert_id')->references('id')->on('experts')->onDelete('cascade');
            $table->string('direction')->nullable();
            $table->string('specialization')->nullable();
            $table->tinyInteger('accr_type')->nullable();
            $table->string('organization_title')->nullable();
            $table->string('organization_type_id')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
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
        Schema::dropIfExists('existing_directions');
    }
}
