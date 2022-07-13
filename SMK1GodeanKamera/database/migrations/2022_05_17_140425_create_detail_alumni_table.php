<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAlumniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_alumni', function (Blueprint $table) {
            $table->foreignUuid('id_alumni')->unique()->nullable(false);
            $table->foreign('id_alumni')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('NIK',16)->unique()->nullable();
            $table->smallInteger('id_program_keahlian')->unsigned();
            $table->foreign('id_program_keahlian')->references('id')->on('program_keahlian')->onUpdate('cascade')->onDelete('no action');
            $table->year('tahun_lulus');
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
        Schema::dropIfExists('detail_alumni');
    }
}
