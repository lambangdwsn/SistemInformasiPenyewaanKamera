<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSiswa extends Model
{
    use HasFactory;
    protected $table = 'detail_siswa';
    protected $fillable = [
    'id_siswa',
    'id_program_keahlian',
    'NIS',
    'Kelas',
    ];
}
