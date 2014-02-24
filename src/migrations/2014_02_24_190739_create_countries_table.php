<?php

use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Config::get('richarddavey/countries::table'), function($table)
        {
            $table->string('name', 80);
            $table->string('printable_name', 80);
            $table->string('ISO3166_1_alpha2', 2)->nullable();
            $table->string('ISO3166_1_alpha3', 3)->nullable();
            $table->integer('ISO3166_1_num')->nullable();
            $table->string('IDD', 4)->nullable();
            $table->string('NDD', 4)->nullable();
            $table->string('IDC', 4)->nullable();
            $table->string('ISO639_1', 2)->nullable();
            $table->string('ISO4217_name', 80)->nullable();
            $table->string('ISO4217', 3)->nullable();
            $table->string('ISO4217_symbol', 20)->nullable();
            $table->primary('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Config::get('richarddavey/countries::table'));
    }
}