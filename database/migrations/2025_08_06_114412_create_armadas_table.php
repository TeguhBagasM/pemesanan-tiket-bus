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
        Schema::create('armada', function (Blueprint $table) {
            $table->id();
            $table->string('no_unik')->unique();
            $table->unsignedBigInteger('id_admin');
            $table->string('supir');
            $table->integer('jumlah_kursi');
            $table->string('no_kendaraan');
            $table->string('rute_asal');
            $table->string('rute_tujuan');
            $table->decimal('harga_tiket', 10, 2);
            $table->time('jam_berangkat');
            $table->timestamps();
            
            $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade');
            $table->index(['rute_asal', 'rute_tujuan']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('armada');
    }
};
