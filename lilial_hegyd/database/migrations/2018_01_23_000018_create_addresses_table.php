<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'addresses';

    /**
     * Run the migrations.
     * @table addresses
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('type')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('additional_1')->nullable()->default(null);
            $table->string('additional_2')->nullable()->default(null);
            $table->string('zip')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('firstname')->nullable()->default(null);
            $table->string('lastname')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('company')->nullable()->default(null);
            $table->unsignedInteger('addressable_id');
            $table->string('addressable_type');
            $table->unsignedInteger('country_id')->nullable()->default(null);
            $table->double('latitude')->nullable()->default(null);
            $table->double('longitude')->nullable()->default(null);

            $table->index(["country_id"], 'addresses_country_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('country_id', 'addresses_country_id_foreign')
                ->references('id')->on('countries')
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
