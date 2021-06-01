<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendProgramAccrNodesTableForOrgForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_accr_nodes', function (Blueprint $table) {
            //

            $table->text('org_form')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_accr_nodes', function (Blueprint $table) {
            //
            $table->dropColumn('org_form');
        });
    }
}
