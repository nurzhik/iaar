<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RewriteDirectionAndSpecFieldsInDirectionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('existing_directions', function (Blueprint $table) {
            //
            $table->dropColumn('direction');
            $table->dropColumn('specialization');
            $table->integer('direction_id')->unsigned()->nullable();
            $table->foreign('direction_id')->references('id')->on('expert_directions');
            $table->integer('spec_id')->unsigned()->nullable();
            $table->foreign('spec_id')->references('id')->on('expert_specializations');
        });
        Schema::table('possible_directions', function (Blueprint $table) {
            //
            $table->dropColumn('direction');
            $table->dropColumn('specialization');
            $table->integer('direction_id')->unsigned()->nullable();
            $table->foreign('direction_id')->references('id')->on('expert_directions');
            $table->integer('spec_id')->unsigned()->nullable();
            $table->foreign('spec_id')->references('id')->on('expert_specializations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('existing_directions', function (Blueprint $table) {
            //
            $table->dropForeign('existing_directions_direction_id_foreign');
            $table->dropForeign('existing_directions_spec_id_foreign');
            $table->string('direction')->nullable();
            $table->string('specialization')->nullable();
        });
        Schema::table('possible_directions', function (Blueprint $table) {
            //
            $table->dropForeign('possible_directions_direction_id_foreign');
            $table->dropForeign('possible_directions_spec_id_foreign');
            $table->string('direction')->nullable();
            $table->string('specialization')->nullable();
        });
    }
}
