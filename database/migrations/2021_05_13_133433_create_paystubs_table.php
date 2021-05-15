<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaystubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystubs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('employer_id');
            $table->date('paid_date');
            $table->decimal('hourly_qty');
            $table->decimal('hourly_rate');
            $table->decimal('stat_qty');
            $table->decimal('stat_rate');
            $table->decimal('vac_pay');
            $table->decimal('overtime_qty');
            $table->decimal('overtime_rate');
            $table->decimal('cpp'); // from website
            $table->decimal('ei'); // from website
            $table->decimal('federal_tax');
            $table->decimal('net_pay');
            $table->string('pay_frequency');
            $table->decimal('employer_cpp'); // from website
            $table->decimal('employer_ei'); // from website
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('employer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paystubs');
    }
}
