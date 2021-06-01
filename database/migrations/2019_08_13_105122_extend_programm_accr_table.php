<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendProgrammAccrTable extends Migration
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
            $table->renameColumn('status_id','univer_type_id');
            $table->string('registration_number')->nullable();
            $table->dateTime('visit_date_start')->nullable();
            $table->dateTime('visit_date_end')->nullable();
            $table->string('bin')->nullable();
            $table->text('license')->nullable();
            $table->text('report_doc')->nullable();
            $table->text('decision_doc')->nullable();
            $table->text('committee_consist_doc')->nullable();
            $table->text('org_form')->nullable();
            $table->boolean('reaccr')->default(false);
            $table->boolean('ex_ante')->default(false);
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
            $table->renameColumn('univer_type_id','status_id');
            $table->dropColumn('registration_number');
            $table->dropColumn('visit_date_start');
            $table->dropColumn('visit_date_end');
            $table->dropColumn('bin');
            $table->dropColumn('license');
            $table->dropColumn('report_doc');
            $table->dropColumn('decision_doc');
            $table->dropColumn('committee_consist_doc');
            $table->dropColumn('org_form');
            $table->dropColumn('reaccr');
            $table->dropColumn('ex_ante');
        });
    }
}
