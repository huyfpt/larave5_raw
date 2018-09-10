<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMetaRobotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('pages', 'meta_robots')) return;

        Schema::table('pages', function(Blueprint $table)
        {
            $table->string('meta_robots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('pages', 'meta_robots')) return;

        Schema::table('pages', function(Blueprint $table)
        {
            $table->dropColumn('meta_robots');
        });
    }
}
