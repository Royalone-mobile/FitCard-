<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('owner');
			$table->string('account');
			$table->string('password');
			$table->string('location');
			$table->string('city');
			$table->string('zipcode');
			$table->double('lat');
			$table->double('lng');
			$table->string('email');
			$table->string('phone');
			$table->string('bank');
			$table->string('vat');
			$table->string('image');
			$table->string('description');
			$table->string('country');

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
		Schema::drop('company');
	}

}
