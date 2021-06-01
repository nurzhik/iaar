<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendReportsTableForContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_review_reports', function (Blueprint $table) {
            //
            $table->text('text')->nullable();
            $table->tinyInteger('univer_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_review_reports', function (Blueprint $table) {
            //
            $table->dropColumn('text');
            $table->dropColumn('univer_type_id');
        });
    }
}
