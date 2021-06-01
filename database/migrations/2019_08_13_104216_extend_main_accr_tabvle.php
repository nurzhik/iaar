<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendMainAccrTabvle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_accreditations', function (Blueprint $table) {
            $table->tinyInteger('univer_type_id')->nullable();
            $table->string('registration_number')->nullable();
            $table->dateTime('visit_date_start')->nullable();
            $table->dateTime('visit_date_end')->nullable();
            $table->string('bin')->nullable();
            $table->text('license')->nullable();
            $table->text('report_doc')->nullable();
            $table->text('decision_doc')->nullable();
            $table->text('committee_consist_doc')->nullable();
            $table->text('org_form')->nullable();

            //
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
            $table->dropColumn('univer_type_id');
            $table->dropColumn('registration_number');
            $table->dropColumn('visit_date_start');
            $table->dropColumn('visit_date_end');
            $table->dropColumn('bin');
            $table->dropColumn('license');
            $table->dropColumn('report_doc');
            $table->dropColumn('decision_doc');
            $table->dropColumn('committee_consist_doc');
            $table->dropColumn('org_form');
        });
    }
}
