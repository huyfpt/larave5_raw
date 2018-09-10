<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMetaRobotsSeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('seos', 'meta_robots')) return;

        Schema::table('seos', function(Blueprint $table)
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
        if (!Schema::hasColumn('seos', 'meta_robots')) return;

        Schema::table('seos', function(Blueprint $table)
        {
            $table->dropColumn('meta_robots');
        });
    }
}