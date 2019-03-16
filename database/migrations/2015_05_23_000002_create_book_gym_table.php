<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookGymTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_gym', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('visitor_id')->unsigned();
			$table->integer('gym_id')->unsigned();
			$table->integer('review')->unsigned();
			$table->dateTime('date');

			$table->foreign('visitor_id')->references('id')->on('consumer');
			$table->foreign('gym_id')->references('id')->on('gym');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_gym');
	}

}
