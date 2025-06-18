<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('discount', 10, 2)->default(0)->comment('Diskon dalam persentase atau nominal');
            $table->decimal('total_payment', 15, 2)->default(0)->comment('Total pembayaran setelah diskon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('discount');
            $table->dropColumn('total_payment');
        });
    }
};
