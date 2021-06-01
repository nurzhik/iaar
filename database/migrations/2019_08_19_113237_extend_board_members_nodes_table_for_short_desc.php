<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendBoardMembersNodesTableForShortDesc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_members_nodes', function (Blueprint $table) {
            $table->text('short_desc')->nullable();
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
        Schema::table('board_members_nodes', function (Blueprint $table) {
            $table->text('short_desc')->nullable();
            //
        });
    }
}
