<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;
    protected $table = 'sewa';
    protected $fillable = [
        'id_user',
        'id_barang',
        'jumlah',
        'tgl_sewa',
        'tgl_harus_kembali',
        'tgl_kembali',
        'keperluan',
        'denda_terlambat',
        'denda_lain',
        'keterangan_sewa',
        'keterangan_kembali',
        'status_acc'
    ];
}
