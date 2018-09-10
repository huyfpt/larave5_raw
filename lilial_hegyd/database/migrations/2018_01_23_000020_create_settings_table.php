<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'settings';

    /**
     * Run the migrations.
     * @table settings
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('key');
            $table->integer('type');
            $table->integer('position');
            $table->text('description')->nullable()->default(null);
            $table->string('value')->nullable()->default(null);
            $table->string('default')->nullable()->default(null);
            $table->string('icon')->nullable()->default(null);
            $table->string('class')->nullable()->default(null);
            $table->string('class_icon')->nullable()->default(null);
            $table->unsignedInteger('category_id');

            $table->index(["category_id"], 'settings_category_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('category_id', 'settings_category_id_foreign')
                ->references('id')->on('setting_categories')
                ->onDelete('cascade')
                ->onUpdate('restrict');


            $table->boolean('is_reference')->default(false);
            $table->nullableMorphs("settingable");
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
