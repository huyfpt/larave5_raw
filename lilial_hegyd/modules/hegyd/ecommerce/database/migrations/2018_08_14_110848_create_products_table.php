<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products');

        Schema::create('products', function (Blueprint $table)
        {
            $table->increments('id');

            $table->boolean('active');
            $table->string('name');
            $table->string('slug');
            $table->string('reference');
            $table->string('grip')->nullable();
            $table->text('description')->nullable();

            $table->integer('stock')->nullable();
            $table->integer('stock_alert')->nullable();

            $table->float('width')->nullable();
            $table->float('length')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();

            $table->float('price', 15, 4)->nullable();
            $table->float('delivery_price', 15, 4)->nullable();

            $table->integer('vat_id')->unsigned()->nullable();
            $table->foreign('vat_id')->references('id')->on('vat');

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('product_categories');

            $table->integer('brand_id')->unsigned()->nullable();
            //$table->foreign('brand_id')->references('id')->on('product_brands');

            $table->string('meta_robots');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');

            $table->timestamps();
            $table->softDeletes();


            $table->index('reference');
            $table->index('name');
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
        Schema::dropIfExists('products');
        Schema::enableForeignKeyConstraints();
    }
}
