<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTermAndOrderFlagColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terms', function (Blueprint $table) {
            $table->string('flag', 10)->nullable()->after('category_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('flag', 10)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terms', function (Blueprint $table) {
            $table->dropColumn(['flag']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['flag']);
        });
    }
}
