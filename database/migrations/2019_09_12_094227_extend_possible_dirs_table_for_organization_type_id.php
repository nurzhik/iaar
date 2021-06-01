<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendPossibleDirsTableForOrganizationTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('possible_directions', function (Blueprint $table) {
            //
            $table->integer('organization_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('possible_directions', function (Blueprint $table) {
            //
            $table->dropColumn('organization_type_id');
        });
    }
}
