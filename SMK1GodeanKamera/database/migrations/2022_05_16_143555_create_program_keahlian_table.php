<?php

use App\Models\ProgramKeahlian;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramKeahlianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_keahlian', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('nama_program',50)->unique();
            $table->timestamps();
        });

        $data =  array(
            [
                'nama_program' => 'Akuntansi dan Keuangan Lembaga',
            ],
            [
                'nama_program' => 'Manajemen Perkantoran dan Layanan Bisnis',
            ],
            [
                'nama_program' => 'Pemasaran',
            ],
            [
                'nama_program' => 'Desain dan Komunikasi Visual',
            ],
        );
        foreach ($data as $datum){
            $program = new ProgramKeahlian();
            $program->nama_program = $datum['nama_program'];
            $program->save();
        }
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_keahlian');
    }
}
