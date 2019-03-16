<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gym_location', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('location_id')->unsigned();
			$table->integer('gym_id')->unsigned();

			$table->timestamps();

			$table->foreign('location_id')->references('id')->on('location');
			$table->foreign('gym_id')->references('id')->on('gym');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gym_location');
	}

}
