<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopUserTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'shop_user';

    /**
     * Run the migrations.
     * @table shop_user
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('entry_at')->nullable()->default(null);
            $table->timestamp('ended_at')->nullable()->default(null);
            $table->unsignedInteger('role_id');

            $table->primary(["user_id", "shop_id", "role_id"]);

            $table->nullableTimestamps();


            $table->foreign('shop_id', 'shop_user_shop_id_foreign')
                ->references('id')->on('shops')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_id', 'shop_user_user_id_foreign')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('role_id', 'fk_shop_user_roles1_idx')
                ->references('id')->on('roles')
                ->onDelete('no action')
                ->onUpdate('no action');
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
