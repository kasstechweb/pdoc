<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('sin')->unique();
            $table->string('name');
//            $table->string('email')->unique();
//            $table->string('phone')->unique();
            $table->string('address');
            $table->date('hire_date');
            $table->date('termination_date');
            $table->decimal('pay_rate')->unsigned();
            $table->boolean('ei_exempt');
            $table->boolean('cpp_exempt');
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
        Schema::dropIfExists('employees');
    }
}
