<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStaticPagesAdditionalDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_pages', function (Blueprint $table) {
            //
            $table->longText('additional_documents')->nullable()->change();
        });
        Schema::table('static_pages_nodes', function (Blueprint $table) {
            //
            $table->longText('additional_documents')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_pages', function (Blueprint $table) {
            //
            $table->text('additional_documents')->nullable()->change();
        });
        Schema::table('static_pages_nodes', function (Blueprint $table) {
            //
            $table->text('additional_documents')->nullable()->change();
        });
    }
}
