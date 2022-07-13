<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangRusak extends Model
{
    use HasFactory;
    protected $table = 'barang_rusak';
    protected $fillable = [
    'id_barang',
    'jumlah',
    'keterangan',
    'status'];

    protected $primaryKey = 'id_barang_rusak';
}
