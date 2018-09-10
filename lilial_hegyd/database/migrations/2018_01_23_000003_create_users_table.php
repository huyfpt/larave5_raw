<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
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
            $table->integer('civility')->nullable()->default(null);
            $table->string('firstname')->nullable()->default(null);
            $table->string('lastname')->nullable()->default(null);
            $table->string('username', 50);
            $table->string('email')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('mobile')->nullable()->default(null);
            $table->unsignedInteger('creator_id')->nullable()->default(null);
            $table->unsignedInteger('updator_id')->nullable()->default(null);
            $table->rememberToken();

            $table->index(["updator_id"], 'users_updator_id_foreign');

            $table->index(["creator_id"], 'users_creator_id_foreign');

            $table->unique(["username"], 'users_username_unique');
            $table->nullableTimestamps();


            $table->foreign('creator_id', 'users_creator_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('updator_id', 'users_updator_id_foreign')
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
