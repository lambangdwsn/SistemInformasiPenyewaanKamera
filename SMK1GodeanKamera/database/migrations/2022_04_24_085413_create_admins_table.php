<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->string('email')->unique();
            $table->string('password',255);
            $table->string('NIP',18)->unique();
            $table->text('alamat')->nullable();
            $table->string('no_tlp',15);
            $table->enum('role',['Admin','Petugas'])->nullable(false)->default('Petugas');
            $table->rememberToken();
            $table->timestamps();
        });

        Admin::create([
            'name' => 'admin super',
            'email' => 'admin@multi-auth.test',
            'NIP' => '1234567890123456',
            'no_tlp' => '085803956811',
            'alamat' => 'Jalan yang sangat jauh banget',
            'password' => bcrypt(12345678),
            'role' => 'Admin',
        ]);

        Admin::create([
            'name' => 'petugas 1',
            'email' => 'petugas@multi-auth.test',
            'NIP' => '1234567890654321',
            'no_tlp' => '0858039568222',
            'alamat' => 'Jalan yang sangat jauh',
            'password' => bcrypt(12345678),
            'role' => 'Petugas',
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
