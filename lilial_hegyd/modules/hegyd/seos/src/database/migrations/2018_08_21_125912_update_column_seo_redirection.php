<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnSeoRedirection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seo_url_redirects', function(Blueprint $table)
        {
            $table->index('new_url');
            $table->index('old_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seo_url_redirects', function(Blueprint $table)
        {
            $table->dropIndex(['new_url']);
            $table->dropIndex(['old_url']);
        });
    }
}