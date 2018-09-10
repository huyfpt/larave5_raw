<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'uploads';

    /**
     * Run the migrations.
     * @table uploads
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('visibility')->nullable()->default(null);
            $table->integer('type')->nullable()->default(null);
            $table->string('size')->nullable()->default(null);
            $table->string('mime_type')->nullable()->default(null);
            $table->string('extension')->nullable()->default(null);
            $table->string('filename')->nullable()->default(null);
            $table->string('path')->nullable()->default(null);
            $table->string('media')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->integer('uploadable_id')->nullable()->default(null);
            $table->string('uploadable_type')->nullable()->default(null);
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('updator_id');
            $table->integer('position')->nullable()->default(null);

            $table->index(["creator_id"], 'uploads_creator_id_foreign');

            $table->index(["updator_id"], 'uploads_updator_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('creator_id', 'uploads_creator_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('updator_id', 'uploads_updator_id_foreign')
                ->references('id')->on('users')
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
