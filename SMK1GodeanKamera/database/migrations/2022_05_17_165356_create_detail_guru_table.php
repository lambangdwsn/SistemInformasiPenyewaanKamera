<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_guru', function (Blueprint $table) {
            $table->foreignUuid('id_guru')->unique()->nullable(false);
            $table->foreign('id_guru')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('NIP',18)->unique();
            $table->string('bidang_keahlian',20);
            $table->string('jabatan',20);
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
        Schema::dropIfExists('detail_guru');
    }
}
