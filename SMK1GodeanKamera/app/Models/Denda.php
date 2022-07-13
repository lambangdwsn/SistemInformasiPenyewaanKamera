<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Denda extends Model
{
   use HasFactory;
   protected $table = 'denda';
   protected $fillable = [
       'denda_siswa',
       'denda_alumni',
       'denda_guru',
       'denda_umum'
    ];
}