<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAmountAndCreditToPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->enum('status', ['pending', 'done', 'failed'])->after('plan_id')->default('pending');
            $table->integer('amount', false, true)->after('plan_id');
            $table->integer('credit', false, true)->after('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('amount');
            $table->dropColumn('credit');
        });
    }
}
