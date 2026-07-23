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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->text('complaint');
            $table->enum('status', ['menunggu_konfirmasi', 'disetujui', 'ditolak', 'dikonversi'])->default('menunggu_konfirmasi');
            $table->foreignId('service_transaction_id')->nullable()->constrained('service_transactions')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
