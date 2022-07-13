<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailUmumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_umum', function (Blueprint $table) {
            $table->foreignUuid('id_umum')->unique()->nullable(false);
            $table->foreign('id_umum')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('NIK',16)->unique()->nullable();
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
        Schema::dropIfExists('detail_umum');
    }
}
