<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymAmenityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gym_amenity', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('amenity_id')->unsigned();
			$table->integer('gym_id')->unsigned();

			$table->timestamps();

			$table->foreign('amenity_id')->references('id')->on('amenity');
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
		Schema::drop('gym_amenity');
	}

}
