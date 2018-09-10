<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValueUserTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'attribute_value_user';

    /**
     * Run the migrations.
     * @table attribute_value_user
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('attribute_value_id');
            $table->unsignedInteger('user_id');

            $table->index(["attribute_value_id"], 'attribute_value_user_attribute_value_id_foreign');

            $table->index(["user_id"], 'attribute_value_user_user_id_foreign');


            $table->foreign('attribute_value_id', 'attribute_value_user_attribute_value_id_foreign')
                ->references('id')->on('attribute_values')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('user_id', 'attribute_value_user_user_id_foreign')
                ->references('id')->on('users')
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
