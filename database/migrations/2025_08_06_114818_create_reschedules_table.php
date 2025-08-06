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
         Schema::create('reschedule', function (Blueprint $table) {
            $table->id();
            $table->string('id_reschedule')->unique();
            $table->unsignedBigInteger('id_tiket');
            $table->timestamp('jadwal_lama');
            $table->timestamp('jadwal_baru')->nullable();
            $table->enum('status_reschedule', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->foreign('id_tiket')->references('id')->on('tiket')->onDelete('cascade');
        });

        // Pembatalan Table
        Schema::create('pembatalan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembatalan')->unique();
            $table->unsignedBigInteger('id_tiket');
            $table->string('alasan');
            $table->timestamp('tgl_pembatalan');
            $table->decimal('refund', 10, 2)->default(0);
            $table->enum('status_pembatalan', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->foreign('id_tiket')->references('id')->on('tiket')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembatalan');
        Schema::dropIfExists('reschedule');
    }
};
