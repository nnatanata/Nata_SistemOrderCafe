<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders', 'order_batch')) {
                $table->string('order_batch')->after('order_date');
            }

            if (!Schema::hasColumn('orders', 'status')) {
                $table->enum('status', ['Baru', 'Diproses', 'Selesai'])
                      ->default('Baru')
                      ->after('order_batch');
            }

            $table->dateTime('order_date')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('orders', 'order_batch')) {
                $table->dropColumn('order_batch');
            }

            $table->date('order_date')->change();
        });
    }
};
