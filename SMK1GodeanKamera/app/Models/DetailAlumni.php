<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAlumni extends Model
{
    use HasFactory;
    protected $table = 'detail_alumni';
    protected $fillable = [
    'id_alumni',
    'NIK',
    'id_program_keahlian',
    'tahun_lulus',
    ];
}
