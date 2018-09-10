<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('order_lines');
        
        Schema::create('order_lines', function (Blueprint $table) {
            $table->increments('id');

            $table->string('product_reference')->nullable();
            $table->string('product_name')->nullable();

            $table->float('unit_price_ht')->nullable();
            $table->float('unit_weight')->nullable();

            $table->float('vat_rate')->nullable();
            $table->float('vat_amount')->nullable();

            $table->integer('quantity')->nullable();

            $table->float('total_ht')->nullable();
            $table->float('total_ttc')->nullable();

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->timestamps();
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
        Schema::dropIfExists('order_lines');
        Schema::enableForeignKeyConstraints();
    }
}
