<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'permissions';

    /**
     * Run the migrations.
     * @table permissions
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50);
            $table->string('display_name')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->unsignedInteger('category_id');

            $table->index(["category_id"], 'permissions_category_id_foreign');

            $table->unique(["name"], 'permissions_name_unique');
            $table->nullableTimestamps();


            $table->foreign('category_id', 'permissions_category_id_foreign')
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
