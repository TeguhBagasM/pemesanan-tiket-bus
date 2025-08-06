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
         Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pemesanan')->unique();
            $table->unsignedBigInteger('id_admin');
            $table->unsignedBigInteger('id_pengguna');
            $table->string('tgl_pemesanan');
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->string('jadwal_pemesanan');
            $table->integer('jumlah_tiket');
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();
            
            $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');
            $table->index('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
