<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('shopping_positions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('shopping_id');

            $table->string('name');

            $table->float('price', 8, 4);

            $table->unsignedInteger('quantity')
                  ->default(1);

            $table->timestamps();

            $table->foreign('shopping_id')
                  ->references('id')->on('shoppings')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('shopping_positions', function (Blueprint $table) {
            $table->dropForeign(['shopping_id']);
        });

        Schema::dropIfExists('shopping_positions');
    }
}
