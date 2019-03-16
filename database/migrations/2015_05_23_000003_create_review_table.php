<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('review', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('visitor_id')->unsigned();
			$table->integer('gym_id')->unsigned();
			$table->string('description');
			$table->date('date');
			$table->integer('star');
			$table->integer('class_id');
			$table->string('title');

			$table->timestamps();

			$table->foreign('visitor_id')->references('id')->on('consumer');
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
		Schema::drop('review');
	}

}
