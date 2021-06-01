<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixAccreditationRequestsFormsNodesTableForForeign extends Migration
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
            $table->dropColumn('parent_id');
            //$table->integer('parent_id')->unsigned()->nullable();
           // $table->foreign('parent_id')->references('id')->on('accreditation_requests_forms')->onDelete('cascade');
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
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('accreditation_requests')->onDelete('cascade');
        });
    }
}
