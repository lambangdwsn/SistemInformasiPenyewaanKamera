<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('barang', function (Blueprint $table) {

             $table->foreign('id_kelengkapan')->references('id')->on('barang')->onUpdate('cascade')->onDelete('set null');
             $table->foreign('id_katagori')->references('id')->on('katagori')->onUpdate('cascade')->onDelete('set null');
             $table->foreign('id_lokasi')->references('id')->on('lokasi')->onUpdate('cascade')->onDelete('restrict');
         });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
