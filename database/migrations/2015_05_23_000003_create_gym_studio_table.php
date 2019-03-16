<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymStudioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gym_studio', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('studio_id')->unsigned();
			$table->integer('gym_id')->unsigned();

			$table->timestamps();

			$table->foreign('studio_id')->references('id')->on('studio');
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
		Schema::drop('gym_studio');
	}

}
