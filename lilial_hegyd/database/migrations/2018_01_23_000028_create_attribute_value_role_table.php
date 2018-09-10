<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValueRoleTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'attribute_value_role';

    /**
     * Run the migrations.
     * @table attribute_value_role
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('attribute_value_id');
            $table->unsignedInteger('role_id');

            $table->index(["role_id"], 'attribute_value_role_role_id_foreign');

            $table->index(["attribute_value_id"], 'attribute_value_role_attribute_value_id_foreign');


            $table->foreign('attribute_value_id', 'attribute_value_role_attribute_value_id_foreign')
                ->references('id')->on('attribute_values')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('role_id', 'attribute_value_role_role_id_foreign')
                ->references('id')->on('roles')
                ->onDelete('cascade')
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
