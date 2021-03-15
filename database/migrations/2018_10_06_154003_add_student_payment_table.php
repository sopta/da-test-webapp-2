<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use CzechitasApp\Models\Enums\StudentPaymentType;

class AddStudentPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('student_id');
            $table->mediumInteger('price');
            $table->enum('payment', StudentPaymentType::getAvailableValues(true))->comment("Type of payment");
            $table->unsignedInteger('user_id')->nullable()->comment("Logged in user");

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_payments');
    }
}
