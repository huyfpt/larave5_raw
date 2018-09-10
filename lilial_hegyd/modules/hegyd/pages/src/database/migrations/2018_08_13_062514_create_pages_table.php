<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pages');
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 500);
            $table->text('content');
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('status');
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_robots');
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
        Schema::dropIfExists('pages');
    }
}
