<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributablesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'attributables';

    /**
     * Run the migrations.
     * @table attributables
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('attributable_id')->nullable()->default(null);
            $table->string('attributable_type')->nullable()->default(null);
            $table->unsignedInteger('attribute_value_id');
            $table->string('field', 32);

            $table->index(["attribute_value_id"], 'attributables_attribute_value_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('attribute_value_id', 'attributables_attribute_value_id_foreign')
                ->references('id')->on('attribute_values')
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
