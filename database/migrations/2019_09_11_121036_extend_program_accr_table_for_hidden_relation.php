<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendProgramAccrTableForHiddenRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_accreditations', function (Blueprint $table) {
            //
            $table->integer('hidden_relation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_accreditations', function (Blueprint $table) {
            //
            $table->dropColumn('hidden_relation_id');
        });
    }
}
