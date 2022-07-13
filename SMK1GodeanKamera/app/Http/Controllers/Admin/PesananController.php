<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sewa;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index() {
		$pesanans = Pesanan::selectRaw('pesanan.id_user, users.name, min(pesanan.updated_at) as date_create')
        ->Join('users', 'pesanan.id_user','=','users.id')
        ->groupBy('pesanan.id_user')
        ->groupBy('users.name')
        ->orderBy('pesanan.updated_at', 'asc')->get();
		
		return view('admin.pesanan.index', compact('pesanans'));
	}

    public function show($id_user) {
        
        $user = User::where('id',$id_user)->get()->first();
        
		$pesanans = Pesanan::where('id_user',$id_user)
        ->Join('barang', 'pesanan.id_barang','=','barang.id')
        ->get(['pesanan.id_user','barang.nama','pesanan.jumlah','pesanan.updated_at']);
		return view('admin.pesanan.show', compact('pesanans','user'));
	}
    public function confirm($id_user) {
		$pesanans = Pesanan::selectRaw("id_user, id_barang, jumlah, now() as 'tgl_sewa', date_add(now(),interval 1 day) as 'tgl_harus_kembali'")
        ->where('id_user',$id_user)
        ->get()->toArray();
        foreach ($pesanans as $pesanan){
            $pesan = new Sewa;
            $pesan->id_user = $pesanan['id_user'];
            $pesan->id_barang = $pesanan['id_barang'];
            $pesan->jumlah = $pesanan['jumlah'];
            $pesan->tgl_sewa = $pesanan['tgl_sewa'];
            $pesan->tgl_harus_kembali = $pesanan['tgl_harus_kembali'];
            $pesan->save();
        }
        Pesanan::where('id_user', $id_user)->delete();
		
	}

}