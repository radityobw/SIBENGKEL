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
        Schema::create('service_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('mechanic_id')->nullable()->constrained('mechanics')->onDelete('set null');
            $table->enum('type', ['servis', 'penjualan'])->default('servis');
            $table->text('complaint');
            $table->decimal('cost', 12, 2)->default(0.00);
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_transactions');
    }
};
