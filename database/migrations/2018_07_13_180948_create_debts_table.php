<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->unsignedInteger('creditor_id');

            $table->unsignedInteger('debtor_id');

            $table->double('amount', 10, 4)
                  ->unsigned();

            $table->timestamps();

            $table->foreign('creditor_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('debtor_id')
                ->references('id')->on('users')
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
        Schema::table('debts', function (Blueprint $table) {
            $table->dropForeign(['debtor_id']);
            $table->dropForeign(['creditor_id']);
        });

        Schema::dropIfExists('debts');
    }
}
