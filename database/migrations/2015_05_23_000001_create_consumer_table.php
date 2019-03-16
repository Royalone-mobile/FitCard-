<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consumer', function(Blueprint $table)
		{

			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->integer('plan')->unsigned();
			$table->integer('credit');
			$table->date('registerdate');
			$table->date('memberdate');
			$table->string('image');
			$table->string('city');
			$table->string('phone');
			$table->string('address');
			$table->string('zip');
			$table->double('fund');
			$table->string('card');
			$table->integer('month');
			$table->integer('year');
			$table->string('card_token');
			$table->date('invoice_start');
			$table->date('invoice_end');
			$table->integer('business_id');

			$table->timestamps();

			
		});
		Schema::table('consumer', function ($table) {
            $table->foreign('plan')->references('id')->on('plan');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('consumer');
	}

}
