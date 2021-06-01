<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendNainAccrTableForIsReakkr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_accreditations', function (Blueprint $table) {
            //
            $table->boolean('reakkr')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_accreditations', function (Blueprint $table) {
            //
            $table->dropColumn('reakkr');
        });
    }
}
