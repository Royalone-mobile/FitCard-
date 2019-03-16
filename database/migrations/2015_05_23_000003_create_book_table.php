<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('visitor_id')->unsigned();
			$table->integer('class_id')->unsigned();
			$table->integer('review')->unsigned();
			$table->date('date');

			$table->foreign('visitor_id')->references('id')->on('consumer');
			$table->foreign('class_id')->references('id')->on('class');

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
		Schema::drop('book');
	}

}
