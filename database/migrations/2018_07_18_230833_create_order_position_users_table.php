<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPositionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_position_users', function (Blueprint $table) {
            $table->unsignedInteger('order_position_id');

            $table->unsignedInteger('user_id')
                  ->nullable();

            $table->timestamps();

            $table->foreign('order_position_id')
                  ->references('id')->on('order_positions')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('order_position_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['order_position_id']);
        });

        Schema::dropIfExists('order_position_users');
    }
}
