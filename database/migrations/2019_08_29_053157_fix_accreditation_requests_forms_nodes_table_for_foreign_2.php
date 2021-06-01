<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixAccreditationRequestsFormsNodesTableForForeign2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accreditation_requests_forms_nodes', function (Blueprint $table) {
            //


        });
        Schema::table('accreditation_requests_forms_nodes', function (Blueprint $table) {

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accreditation_requests_forms_nodes', function (Blueprint $table) {
            //

        });
    }
}
