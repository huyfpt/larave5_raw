<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('carts');
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');

            $table->text('comment')->nullable();

            $table->string('remember_token')->nullable();

            $table->integer('payment_means')->nullable();
            $table->string('payment_id')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('invoice_address_id')->unsigned()->nullable();
            $table->foreign('invoice_address_id')->references('id')->on('addresses');

            $table->integer('delivery_address_id')->unsigned()->nullable();
            $table->foreign('delivery_address_id')->references('id')->on('addresses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
