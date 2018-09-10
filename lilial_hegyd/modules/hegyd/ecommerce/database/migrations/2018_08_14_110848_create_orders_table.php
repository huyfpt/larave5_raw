<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('reference');

            $table->integer('status');

            $table->string('delivery_firstname')->nullable();
            $table->string('delivery_lastname')->nullable();
            $table->string('delivery_company')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_additional_1')->nullable();
            $table->string('delivery_additional_2')->nullable();
            $table->string('delivery_zip')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_country')->nullable();
            $table->string('delivery_phone')->nullable();
            $table->string('delivery_email')->nullable();

            $table->string('invoice_firstname')->nullable();
            $table->string('invoice_lastname')->nullable();
            $table->string('invoice_company')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('invoice_additional_1')->nullable();
            $table->string('invoice_additional_2')->nullable();
            $table->string('invoice_zip')->nullable();
            $table->string('invoice_city')->nullable();
            $table->string('invoice_country')->nullable();
            $table->string('invoice_phone')->nullable();
            $table->string('invoice_email')->nullable();

            $table->decimal('weight_total', 15, 4)->nullable();

            $table->decimal('product_total_ht', 15, 4)->nullable();
            $table->decimal('product_total_ttc', 15, 4)->nullable();

            $table->decimal('total_ht', 15, 4)->nullable();
            $table->decimal('total_vat', 15, 4)->nullable();
            $table->decimal('total_ttc', 15, 4)->nullable();

            $table->decimal('delivery_price', 15, 4)->nullable();

            $table->text('comment')->nullable()->nullable();

            $table->integer('payment_means')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamp('paid_at')->nullable()->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
        Schema::enableForeignKeyConstraints();
    }
}
