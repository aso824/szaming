<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('shoppings', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')
                  ->nullable();

            $table->unsignedInteger('shop_id')
                  ->nullable();

            $table->date('purchased_at');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onCascade('set null');

            $table->foreign('shop_id')
                  ->references('id')->on('shops')
                  ->onCascade('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('shoppings', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('shoppings');
    }
}
