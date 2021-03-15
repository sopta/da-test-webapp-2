<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use CzechitasApp\Models\Enums\OrderType;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->date('signature_date')->nullable();
            $table->string('type');

            $table->string('client');
            $table->string('address');
            $table->string('ico');
            $table->string('substitute');
            $table->string('contact_name');
            $table->string('contact_tel');
            $table->string('contact_mail');
            $table->date('start_date_1');
            $table->date('start_date_2')->nullable();
            $table->date('start_date_3')->nullable();
            $table->date('final_date_from')->nullable();
            $table->date('final_date_to')->nullable();

            $table->text('xdata');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
