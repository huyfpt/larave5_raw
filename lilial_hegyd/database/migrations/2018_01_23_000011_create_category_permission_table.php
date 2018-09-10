<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryPermissionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'category_permission';

    /**
     * Run the migrations.
     * @table category_permission
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('key');
            $table->string('name');
            $table->unsignedInteger('parent_id')->nullable()->default(null);

            $table->index(["parent_id"], 'category_permission_parent_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('parent_id', 'category_permission_parent_id_foreign')
                ->references('id')->on('category_permission')
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
