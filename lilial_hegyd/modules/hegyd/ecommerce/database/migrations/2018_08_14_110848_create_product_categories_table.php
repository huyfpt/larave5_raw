<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_categories');

        Schema::create('product_categories', function (Blueprint $table)
        {
            $table->increments('id');

            $table->boolean('active');
            $table->string('name');
            $table->string('slug');

            $table->integer('parent_id');
            $table->text('description');
            $table->string('select_site')->nullable();
            $table->string('trade')->nullable();
            $table->string('accroche')->nullable();

            $table->string('meta_robots')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->integer('ranking')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('created_at');
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
        Schema::dropIfExists('product_categories');
        Schema::enableForeignKeyConstraints();
    }
}
