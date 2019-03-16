<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeConsumerPlanIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumer', function (Blueprint $table) {
            $table->dropForeign('consumer_plan_foreign');
            $table->dropColumn('plan');
            $table->integer('plan_id', false, true)->nullable();
            $table->foreign('plan_id')->references('id')->on('plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumer', function (Blueprint $table) {
            $table->dropForeign('consumer_plan_id_foreign');
            $table->dropColumn('plan_id');
            $table->integer('plan')->unsigned();
            $table->foreign('plan')->references('id')->on('plan');
        });
    }
}
