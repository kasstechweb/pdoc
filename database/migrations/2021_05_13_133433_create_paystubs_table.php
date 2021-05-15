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
            $table->decimal('hourly_qty', 13, 5);
            $table->decimal('hourly_rate', 13, 5);
            $table->decimal('stat_qty', 13, 5);
            $table->decimal('stat_rate', 13, 5);
            $table->decimal('vac_pay', 13, 5);
            $table->decimal('overtime_qty', 13, 5);
            $table->decimal('overtime_rate', 13, 5);
            $table->decimal('cpp', 13, 5); // from website
            $table->decimal('ei', 13, 5); // from website
            $table->decimal('federal_tax', 13, 5);
            $table->decimal('net_pay', 13, 5);
            $table->string('pay_frequency');
            $table->decimal('employer_cpp', 13, 5); // from website
            $table->decimal('employer_ei', 13, 5); // from website
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
