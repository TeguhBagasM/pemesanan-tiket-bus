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
        Schema::create('tiket', function (Blueprint $table) {
            $table->id();
            $table->string('id_tiket')->unique();
            $table->unsignedBigInteger('id_pembayaran');
            $table->decimal('harga_tiket', 10, 2);
            $table->string('no_kursi');
            $table->enum('status_tiket', ['active', 'used', 'cancelled', 'rescheduled'])->default('active');
            $table->timestamps();
            
            $table->foreign('id_pembayaran')->references('id')->on('pembayaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
