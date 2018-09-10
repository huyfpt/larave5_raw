<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class HegydFaqsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return    void
     */
    public function up()
    {
        Schema::create('faqs_categories', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('label', 255);
            $table->text('introduction');
            $table->string('image', 255);
            $table->boolean('status')->default('0');
            $table->integer('parent_id');

            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('image', 255);
            $table->string('document', 255);
            $table->boolean('status')->default('0');
            
            $table->string('title', 255);
            $table->string('slug');
            $table->text('content');
            $table->string('meta_title', 255);
            $table->string('meta_description', 255);
            $table->string('meta_keyword', 255);

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('faqs_categories');

            $table->integer('author_id')->unsigned()->nullable();
            $table->foreign('author_id')->references('id')->on('users');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('faqs_categories');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}