<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'cities';

    /**
     * Run the migrations.
     * @table cities
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('department', 5)->nullable()->default(null);
            $table->string('slug')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('zip', 5)->nullable()->default(null);
            $table->string('zip_list')->nullable()->default(null);
            $table->string('city_code', 5)->nullable()->default(null);
            $table->string('insee_code', 10)->nullable()->default(null);
            $table->string('longitude')->nullable()->default(null);
            $table->string('latitude')->nullable()->default(null);
            $table->unsignedInteger('country_id')->nullable()->default(null);

            $table->index(["zip"], 'cities_zip_index');

            $table->index(["slug"], 'cities_slug_index');

            $table->index(["department"], 'cities_department_index');

            $table->index(["country_id"], 'cities_country_id_foreign');

            $table->index(["name"], 'cities_name_index');


            $table->foreign('country_id', 'cities_country_id_foreign')
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
