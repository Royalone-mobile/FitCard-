<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('class', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('gym')->unsigned();
			$table->longText('description');
			$table->date('date');
			$table->time('starthour');
			$table->time('endhour');
			$table->integer('category');
			$table->integer('value');
			$table->integer('recurring');
			$table->date('enddate');

			$table->timestamps();

			$table->foreign('gym')->references('id')->on('gym');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('class');
	}

}
