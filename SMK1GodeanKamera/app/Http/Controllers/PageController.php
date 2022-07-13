<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sewa;
use App\Models\Barang;
use App\Models\Artikel;
use App\Models\Katagori;
use App\Models\Kontak;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
class PageController extends Controller
{
    public function home(){
        $barang = Barang::where('status_tampil','ya')
            ->take(3)
            ->orderBy('created_at', 'desc')
            ->get(['barang.id','barang.nama','barang.image','barang.harga_siswa','barang.harga_alumni','barang.harga_guru','barang.harga_umum','barang.jumlah']);
        $artikel = Artikel::where('status_tampil','ya')
            ->take(3)
            ->orderBy('updated_at', 'desc')
            ->get(['artikel.image','artikel.judul','artikel.isi']);
        
        return view('Dashboard', compact('barang','artikel'));
    }

    public function kontak(){
        $kontak = Kontak::all()->first();
        return view('kontak',compact('kontak'));
    }

    public function sewa(){
        $sewa = Sewa::selectRaw("barang.nama,barang.image, sewa.jumlah, IF(sewa.keperluan ='Pribadi',datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa)*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
           IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'harga', IF(sewa.keperluan ='Pribadi',datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa)*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
           IF(users.role='Alumni',barang.harga_alumni,
              IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)*sewa.jumlah as 'total_harga',sewa.tgl_harus_kembali,
              IF(datediff(now(),sewa.tgl_harus_kembali)>0,datediff(now(),sewa.tgl_harus_kembali),0) as 'terlambat'")
        ->Join('barang','sewa.id_barang','=','barang.id')
        ->Join('users','sewa.id_user','=','users.id')
        ->where('id_user',Auth::guard('web')->user()->id)
        ->where('status_acc','disewa')
        ->get();
        $isKosong = false;
        $sum = DB::select("SELECT SUM(sewa.jumlah * barang.harga_".strtolower(Auth::guard('web')->user()->role).") as 'total' FROM `sewa` INNER JOIN barang ON sewa.id_barang = barang.id WHERE sewa.id_user = '".Auth::guard('web')->user()->id."'
        AND sewa.status_acc = 'disewa';")[0]->total;
        $denda = DB::select("SELECT sum(IF(datediff(now(),sewa.tgl_harus_kembali)>0,datediff(now(),sewa.tgl_harus_kembali),0)*denda.denda_".strtolower(Auth::guard('web')->user()->role).") as 'denda' FROM `sewa` INNER JOIN denda WHERE sewa.id_user = '".Auth::guard('web')->user()->id."'
        AND sewa.status_acc = 'disewa'")[0]->denda;
    if(Sewa::where('id_user',Auth::guard('web')->user()->id)->where('status_acc','disewa')->exists()){
        return view('sewa',compact('sewa','isKosong','sum','denda'));
    }else{
        $sum = 0;
        $isKosong = true;
        return view('sewa',compact('sewa','isKosong','sum','denda'));
    }
    }

    public function berita(){
        $berita = Artikel::where('status_tampil','ya')
        ->orderBy('updated_at', 'desc')
        ->get();
        return view('berita.index',compact('berita'));
    }

    public function beritaShow($id){
        $berita = Artikel::where('id',$id)->where('status_tampil','ya')->first();
        if(Artikel::where('id',$id)->where('status_tampil','ya')->exists()){
            return view('berita.show',compact('berita'));
        }else{
            abort(404);
        }
    }

    public function barang($katagori){
        if($katagori === 'semua'){
            $barang = Barang::where('status_tampil','ya')
            ->get(['barang.id','barang.nama','barang.image','barang.harga_siswa','barang.harga_alumni','barang.harga_guru','barang.harga_umum','barang.jumlah']);
        }elseif(Katagori::where('katagori','=',ucfirst($katagori))->exists()){
            $barang = Barang::leftJoin('katagori', 'barang.id_katagori','=','katagori.id')->where('status_tampil','ya')
            ->where('katagori.katagori',ucfirst($katagori))
            ->get(['barang.id','barang.nama','barang.image','barang.harga_siswa','barang.harga_alumni','barang.harga_guru','barang.harga_umum','barang.jumlah']);
        }
        return view('barang',compact('barang','katagori'));
    }

    public function indexPesanan(){
        $pesanan = Pesanan::Join('barang','pesanan.id_barang','=','barang.id')
        ->where('id_user',Auth::guard('web')->user()->id)
        ->get(['pesanan.id','pesanan.jumlah','pesanan.updated_at','barang.nama','barang.image','barang.harga_siswa','barang.harga_alumni','barang.harga_guru','barang.harga_umum']);
        $isKosong = false;
        $sum = DB::select("SELECT SUM(pesanan.jumlah*barang.harga_".  strtolower(Auth::guard('web')->user()->role) .") as 'total' FROM pesanan INNER JOIN barang ON pesanan.id_barang = barang.id WHERE pesanan.id_user = '".Auth::guard('web')->user()->id."';")[0]->total;
    if(Pesanan::where('id_user',Auth::guard('web')->user()->id)->exists()){
        return view('pesanan.index',compact('pesanan','isKosong','sum'));
    }else{
        $sum = 0;
        $isKosong = true;
        return view('pesanan.index',compact('pesanan','isKosong','sum'));
    }
    }

    public function addPesanan(Request $request){
        if(Pesanan::whereDate('updated_at',date('Y-m-d'))
        ->where('id_user',Auth::guard('web')->user()->id)
        ->where('id_barang',$request->barang_id)->exists()){
        
        }else {
            $pesanan = new Pesanan;
            $pesanan->id_user = Auth::guard('web')->user()->id;
            $pesanan->id_barang = $request->barang_id;
            $pesanan->jumlah = 1;
            $pesanan->save();
        }
        return redirect(route('pesanan.index'));
        
    }

    public function showPesanan($id){
        $pesanan = Pesanan::Join('barang','pesanan.id_barang','=','barang.id')
        ->where('pesanan.id',$id)
        ->get(['pesanan.id','barang.nama','barang.image','barang.harga_siswa','barang.harga_alumni','barang.harga_guru','barang.harga_umum','pesanan.jumlah'])->first();

        return view('pesanan.show',compact('pesanan'));
    }

    public function updatePesanan(Request $request){
        $id = request()->route('id');
        $request->validate([
            'jumlah' => ['required','regex:/^([1-9]|[1-9][0-9])*$/'],
        ]);
        
        Pesanan::where('id', $id)
                    ->update([
                        'jumlah'=> $request->jumlah
                    ]);

        return redirect(route('pesanan.show',['id' => $id]))->with('status','Pesanan berhasil diubah');
    }

    public function deleteConfirmPesanan($id){
        $pesanan = Pesanan::Join('barang','pesanan.id_barang','=','barang.id')
        ->where('pesanan.id',$id)
        ->get(['pesanan.id','barang.nama','barang.image','barang.harga_siswa','barang.harga_alumni','barang.harga_guru','barang.harga_umum','pesanan.jumlah'])->first();

        return view('pesanan.delete', compact('pesanan'));
    }

    public function deletePesanan($id){
        Pesanan::destroy($id);
        return redirect(route('pesanan.index',['id' => $id]))->with('status','Pesanan berhasil dihapus');
    }

}
