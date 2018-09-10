<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlugPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('pages', 'slug')) return;

        Schema::table('pages', function(Blueprint $table)
        {
            $table->string('slug');
            $table->string('title');

            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('pages', 'slug')) return;

        Schema::table('pages', function(Blueprint $table)
        {
            $table->dropColumn('slug');
            $table->dropColumn('title');
        });
    }
}