<?php

use App\Models\Katagori;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKatagoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('katagori', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('katagori',50)->unique();
            $table->timestamps();
        });

        $data =  array(
            [
                'katagori' => 'Kelengkapan',
            ],
            [
                'katagori' => 'Kamera',
            ],
            [
                'katagori' => 'Audio',
            ],
            [
                'katagori' => 'Drone',
            ],
        );
        foreach ($data as $datum){
            $katagori = new Katagori();
            $katagori->katagori = $datum['katagori'];
            $katagori->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('katagori');
    }
}
