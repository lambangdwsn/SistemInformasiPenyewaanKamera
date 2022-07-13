<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('barcode', 8);
            $table->string('image',50)->nullable();
            $table->double('harga_siswa', 8, 2);
            $table->double('harga_alumni', 8, 2);
            $table->double('harga_guru', 8, 2);
            $table->double('harga_umum', 8, 2);
            $table->smallInteger('id_katagori')->unsigned()->nullable();
            $table->string('merk',50)->nullable();
            $table->integer('jumlah');
            $table->bigInteger('id_kelengkapan')->unsigned()->nullable();
            $table->smallInteger('id_lokasi')->unsigned();
            $table->text('keterangan')->nullable();
            $table->enum('status_tampil', ['ya', 'tidak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
