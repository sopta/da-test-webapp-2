<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use CzechitasApp\Models\Enums\StudentLogOutType;
use CzechitasApp\Models\Enums\StudentPaymentType;

class AddStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('term_id');
            $table->string('parent_name');
            $table->string('forename');
            $table->string('surname');
            $table->date('birthday');
            $table->string('email');

            $table->enum('payment', StudentPaymentType::getAvailableValues())->nullable()->comment("If pays school - keep null");
            $table->enum('logged_out', StudentLogOutType::getAvailableValues())->nullable()->comment("Log out status - NULL not logged out");
            $table->string('alternate')->nullable()->comment("Name of alternate student - if is logged out");
            $table->string('canceled')->nullable()->comment("If not null - student is canceled with reason");

            $table->string('restrictions')->nullable()->comment("Medical restrictions of kid");
            $table->string('note')->nullable();
            $table->text('private_note')->nullable();

            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('users');
            $table->foreign('term_id')->references('id')->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
