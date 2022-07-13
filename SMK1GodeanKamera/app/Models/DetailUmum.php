<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUmum extends Model
{
    use HasFactory;
    protected $table = 'detail_umum';
    protected $fillable = [
    'id_umum',
    'NIK'
    ];
}
