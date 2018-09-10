<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'news';

    /**
     * Run the migrations.
     * @table news
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('active')->default('0');
            $table->string('name')->nullable()->default(null);
            $table->longText('content')->nullable()->default(null);
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('end_at')->nullable()->default(null);
            $table->tinyInteger('display_on_slider')->default('0');
            $table->unsignedInteger('category_id')->nullable()->default(null);
            $table->unsignedInteger('author_id')->nullable()->default(null);

            $table->index(["author_id"], 'news_author_id_foreign');

            $table->index(["category_id"], 'news_category_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('author_id', 'news_author_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('category_id', 'news_category_id_foreign')
                ->references('id')->on('news_categories')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
