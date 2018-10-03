<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueToDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('debts', function (Blueprint $table) {
            $table->unique(['creditor_id', 'debtor_id']);
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
            $table->index(['creditor_id']);
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->dropUnique(['creditor_id', 'debtor_id']);
        });
    }
}
