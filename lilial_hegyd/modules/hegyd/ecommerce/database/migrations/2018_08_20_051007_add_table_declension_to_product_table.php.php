<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableDeclensionToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('products', function(Blueprint $table)
        {
            if (!Schema::hasColumn('products', 'table_declension')) {
                $table->text('table_declension')->nullable();
            }

            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug');
                $table->index('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function(Blueprint $table)
        {
            $table->dropColumn('table_declension');
            $table->dropColumn('slug');
        });
    }
}
