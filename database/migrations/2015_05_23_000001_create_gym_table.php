<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gym', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->integer('category');
            $table->integer('company')->unsigned();
            $table->integer('location');
            $table->string('joindate');
            $table->double('totalcredit');
            $table->double('currentcredit');
            $table->string('bankaccount');
            $table->string('image');
            $table->string('logo');
            $table->double('rating');
            $table->integer('reviews');
            $table->time('starthour_mon');
            $table->time('endhour_mon');
            $table->time('starthour_tue');
            $table->time('endhour_tue');
            $table->time('starthour_wed');
            $table->time('endhour_wed');
            $table->time('starthour_thu');
            $table->time('endhour_thu');
            $table->time('starthour_fri');
            $table->time('endhour_fri');
            $table->time('starthour_sat');
            $table->time('endhour_sat');
            $table->time('starthour_sun');
            $table->time('endhour_sun');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('lat');
            $table->string('lon');
            $table->string('usability');
            $table->integer('close_mon');
            $table->integer('close_tue');
            $table->integer('close_wed');
            $table->integer('close_thu');
            $table->integer('close_fri');
            $table->integer('close_sat');
            $table->integer('close_sun');
            $table->integer('visitcode');

            $table->timestamps();

            $table->foreign('company')->references('id')->on('company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gym');
    }
}
