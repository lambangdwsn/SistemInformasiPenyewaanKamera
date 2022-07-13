<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSewaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sewa', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('id_user');
            $table->bigInteger('id_barang')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_barang')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('jumlah');
            $table->date('tgl_pinjam');
            $table->date('tgl_harus_kembali');
            $table->date('tgl_kembali')->nullable();
            $table->enum('keperluan',['Lomba','KBM','Pribadi'])->default('Pribadi');
            $table->double('denda_lain', 20, 2)->nullable();
            $table->text('keterangan_sewa')->nullable();
            $table->text('keterangan_kembali')->nullable();
            $table->enum('status_acc',['proses-sewa','disewa','proses-kembali','selesai'])->default('proses-sewa');
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
        Schema::dropIfExists('sewa');
    }
}
