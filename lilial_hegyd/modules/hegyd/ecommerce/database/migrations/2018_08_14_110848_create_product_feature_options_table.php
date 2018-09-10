<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFeatureOptionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('product_feature_options');
        Schema::create('product_feature_options', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('feature_id');
            $table->string('name');
            $table->string('value');

            $table->index('feature_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_feature_options');
    }
}
