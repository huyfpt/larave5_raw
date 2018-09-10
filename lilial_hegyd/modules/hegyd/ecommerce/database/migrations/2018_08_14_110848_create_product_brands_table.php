<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBrandsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_brands');
        
        Schema::create('product_brands', function (Blueprint $table)
        {
            $table->increments('id');

            $table->boolean('active');
            $table->string('name');
            $table->string('slug');

            $table->index('slug');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_brands');
        Schema::enableForeignKeyConstraints();
    }
}
