<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'attribute_values';

    /**
     * Run the migrations.
     * @table attribute_values
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('value');
            $table->string('key');
            $table->string('color')->nullable()->default(null);
            $table->integer('position');
            $table->tinyInteger('removable')->default('1');
            $table->unsignedInteger('attribute_id');

            $table->index(["attribute_id"], 'attribute_values_attribute_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('attribute_id', 'attribute_values_attribute_id_foreign')
                ->references('id')->on('attributes')
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
