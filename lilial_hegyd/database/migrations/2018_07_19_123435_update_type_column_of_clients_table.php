<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTypeColumnOfClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->enum('type', ['user', 'professional'])->default('user')->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1);
        });
    }
}
