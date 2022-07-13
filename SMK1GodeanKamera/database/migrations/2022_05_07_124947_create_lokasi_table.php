<?php

use App\Models\Lokasi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lokasi', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('lokasi',100);
            $table->timestamps();
        });

        $data =  array(
            [
                'lokasi' => 'Rak 01',
            ],
            [
                'lokasi' => 'Rak 02',
            ],
            [
                'lokasi' => 'Rak 03',
            ],
            [
                'lokasi' => 'Rak 04',
            ],
        );
        foreach ($data as $datum){
            $lokasi = new Lokasi();
            $lokasi->lokasi = $datum['lokasi'];
            $lokasi->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lokasi');
    }
}
