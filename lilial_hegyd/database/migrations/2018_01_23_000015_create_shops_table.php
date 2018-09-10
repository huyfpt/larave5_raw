<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'shops';

    /**
     * Run the migrations.
     * @table shops
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('department')->nullable()->default(null);
            $table->string('client_code')->nullable()->default(null);
            $table->string('sector_code')->nullable()->default(null);
            $table->string('sector')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('director_email')->nullable()->default(null);
            $table->string('ape')->nullable()->default(null);
            $table->string('siren')->nullable()->default(null);
            $table->string('siret')->nullable()->default(null);
            $table->integer('code_type')->nullable()->default(null);
            $table->integer('code_status')->nullable()->default(null);
            $table->tinyInteger('sleeping')->default('0');
            $table->string('billing_email')->nullable()->default(null);
            $table->timestamp('created_at_crm')->nullable()->default(null);
            $table->timestamp('updated_at_crm')->nullable()->default(null);
            $table->tinyInteger('active')->default('0');
            $table->tinyInteger('head_office');
            $table->nullableTimestamps();

            $table->unsignedInteger('company_id');
            $table->foreign('company_id')
                ->references('id')->on('companies')
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
