<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Barang extends Model
{
   use HasFactory;
   protected $table = 'barang';
   protected $fillable = [
   'nama',
   'barcode',
   'image', 
   'harga_siswa',
   'harga_alumni',
   'harga_guru',
   'harga_umum',
   'id_katagori',
   'merk',
   'jumlah',
   'id_lokasi',
   'id_kelengkapan',
   'keterangan',
   'status_tampil'];

   protected static function boot(){
      parent::boot();
      static::creating(function($model){
          if(empty($model->barcode)){
            
            do {
               $code = random_int(100000, 999999);
            } while (Barang::where("barcode", "=", $code)->first());
            $model->barcode = $code;
          }
      });
  }   
}