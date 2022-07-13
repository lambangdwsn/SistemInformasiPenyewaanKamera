<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_siswa', function (Blueprint $table) {
            $table->foreignUuid('id_siswa')->unique()->nullable(false);
            $table->foreign('id_siswa')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('id_program_keahlian')->unsigned();
            $table->foreign('id_program_keahlian')->references('id')->on('program_keahlian')->onUpdate('cascade')->onDelete('restrict');
            $table->string('NIS',5)->unique();
            $table->enum('Kelas',['X','XI','XII'])->nullable(false);;
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
        Schema::dropIfExists('_detail_siswa');
    }
}
