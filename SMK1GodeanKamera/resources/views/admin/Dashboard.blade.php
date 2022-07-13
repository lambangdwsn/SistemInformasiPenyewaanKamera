@extends('layouts.AdminMain')
@section('title','Dashboard')

@section('container')
<?php
use App\Models\User;
use App\Models\Sewa;
use App\Models\Barang;
use App\Models\BarangRusak;

$transaksiBulanLalu = [Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m',strtotime('-1 MONTH')) .'-01')
->where('tgl_kembali','<=','2022-'. date('m',strtotime('-1 MONTH')) .'-5')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m',strtotime('-1 MONTH')) .'-06')
->where('tgl_kembali','<=','2022-'. date('m',strtotime('-1 MONTH')) .'-10')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m',strtotime('-1 MONTH')) .'-11')
->where('tgl_kembali','<=','2022-'. date('m',strtotime('-1 MONTH')) .'-15')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m',strtotime('-1 MONTH')) .'-16')
->where('tgl_kembali','<=','2022-'. date('m',strtotime('-1 MONTH')) .'-20')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m',strtotime('-1 MONTH')) .'-21')
->where('tgl_kembali','<=','2022-'. date('m',strtotime('-1 MONTH')) .'-25')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m',strtotime('-1 MONTH')) .'-26')
->where('tgl_kembali','<=','2022-'. date('m',strtotime('-1 MONTH')) .'-30')
->pluck('total')->first()
];

$transaksiBulanIni = [Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m') .'-01')
->where('tgl_kembali','<=','2022-'. date('m') .'-5')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m') .'-06')
->where('tgl_kembali','<=','2022-'. date('m') .'-10')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m') .'-11')
->where('tgl_kembali','<=','2022-'. date('m') .'-15')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m') .'-16')
->where('tgl_kembali','<=','2022-'. date('m') .'-20')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m') .'-21')
->where('tgl_kembali','<=','2022-'. date('m') .'-25')
->pluck('total')->first(),
Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa)*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali','>=','2022-'. date('m') .'-26')
->where('tgl_kembali','<=','2022-'. date('m') .'-30')
->pluck('total')->first()
];

$masukHari = Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->where('tgl_kembali',date("Y-m-d"))
->pluck('total')->first();

$masukBulan = Sewa::selectRaw("sum(
    IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa, IF(users.role='Alumni',barang.harga_alumni,IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
    IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
    IFNULL(sewa.denda_lain,0)
) as 'total'")
->Join('users','sewa.id_user','=','users.id')
->Join('denda','denda.id','=','denda.id')
->Join('barang','sewa.id_barang','=','barang.id')
->where('status_acc','selesai')
->whereYear('tgl_kembali',date("Y"))
->whereMonth('tgl_kembali',date("m"))
->pluck('total')->first();


$userAll = User::count();
$barangAll = Barang::sum('jumlah');
$barangRusakAll = BarangRusak::sum('jumlah');
$userMounth = User::whereMonth('created_at', '=', date('m'))->whereYear('created_at',date("Y"))->count();
$jumlahTJ = Sewa::where('status_acc','disewa')->count();
$jumlahTB = Sewa::where('status_acc','selesai')->whereYear('tgl_kembali',date("Y"))->whereMonth('tgl_kembali',date("m"))->count();
$userSiswa = User::where('role', '=','Siswa')->count();
$userAlumni = User::where('role', '=','Alumni')->count();
$userGuru = User::where('role', '=','Guru')->count();
$userUmum = User::where('role', '=','Umum')->count();

?>
<div class='container'>
        <div class="row">
            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                    <h5 class="card-title">Pelanggan Baru (Bulan Ini)</h5>
                    <p class="card-text">{{$userMounth}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                    <h5 class="card-title">Total Pelanggan (User)</h5>
                    <p class="card-text">{{$userAll}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                    <h5 class="card-title">Transaksi Berjalan</h5>
                    <p class="card-text">{{$jumlahTJ}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi (Bulan Ini)</h5>
                        <p class="card-text">{{$jumlahTB}}</p>
                    </div>
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pemasukan (Hari Ini)</h5>
                        <p class="card-text">{{is_null($masukHari) ? 0 : $masukHari}}</p>
                    </div>
                </div>    
            </div>
            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pemasukan (Bulan Ini)</h5>
                        <p class="card-text">{{is_null($masukBulan) ? 0 : $masukBulan}}</p>
                    </div>
                </div>    
            </div>
            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Barang</h5>
                        <p class="card-text">{{$barangAll}}</p>
                    </div>
                </div>    
            </div>
            <div class="col-md-6 col-lg-3 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Barang (Bermasalah)</h5>
                        <p class="card-text">{{$barangRusakAll}}</p>
                    </div>
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="d-none d-xl-block d-lg-block d-md-block col-lg-6">
            <h1>Penghasilan Bulanan Per 5 Hari (Ribu)</h1>
                <div class="card">
                        <div class="card-body">
                            <canvas id="chLine"></canvas>
                        </div>
                </div>
            </div>
            <div class="d-none d-xl-block d-lg-block d-md-block col-lg-6">
            <h1>Total Pengguna</h1>
                <div class="card">
                        <div class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                </div>
            </div>
        </div>
            <script>
                var ctxL = document.getElementById("chLine").getContext('2d');
                var myLineChart = new Chart(ctxL, {
                    type: 'line',
                    data: {
                    labels: ["10","15", "20","25", "30"],
                    datasets: [{
                        label: "Bulan Lalu",
                        data: [
                            {{ is_null($transaksiBulanLalu[0]) ? 0 : ($transaksiBulanLalu[0]/1000) }},
                            {{ is_null($transaksiBulanLalu[1]) ? 0 : ($transaksiBulanLalu[1]/1000) }},
                            {{ is_null($transaksiBulanLalu[2]) ? 0 : ($transaksiBulanLalu[2]/1000) }},
                            {{ is_null($transaksiBulanLalu[3]) ? 0 : ($transaksiBulanLalu[3]/1000) }},
                            {{ is_null($transaksiBulanLalu[4]) ? 0 : ($transaksiBulanLalu[4]/1000) }},
                            {{ is_null($transaksiBulanLalu[5]) ? 0 : ($transaksiBulanLalu[5]/1000) }}
                            ],
                        backgroundColor: [
                            'rgba(105, 0, 132, .2)',
                        ],
                        borderColor: [
                            'rgba(200, 99, 132, .7)',
                        ],
                        borderWidth: 2
                        },
                        {
                        label: "Bulan Ini",
                        data: [
                            {{ is_null($transaksiBulanIni[0]) ? 0 : ($transaksiBulanIni[0]/1000) }},
                            {{ is_null($transaksiBulanIni[1]) ? 0 : ($transaksiBulanIni[1]/1000) }},
                            {{ is_null($transaksiBulanIni[2]) ? 0 : ($transaksiBulanIni[2]/1000) }},
                            {{ is_null($transaksiBulanIni[3]) ? 0 : ($transaksiBulanIni[3]/1000) }},
                            {{ is_null($transaksiBulanIni[4]) ? 0 : ($transaksiBulanIni[4]/1000) }},
                            {{ is_null($transaksiBulanIni[5]) ? 0 : ($transaksiBulanIni[5]/1000) }}
                        ],
                        backgroundColor: [
                            'rgba(0, 137, 132, .2)',
                        ],
                        borderColor: [
                            'rgba(0, 10, 130, .7)',
                        ],
                        borderWidth: 2
                        }
                    ]
                    },
                    options: {
                    responsive: true,
                    plugins: {
                    datalabels: false
                    }
                    }
                });

                var canvas = document.getElementById("barChart");
                var ctx = canvas.getContext('2d');

                // Global Options:
                Chart.defaults.global.defaultFontColor = 'black';
                Chart.defaults.global.defaultFontSize = 16;

                var data = {
                    labels: ["Siswa", "Alumni","Guru","Umum"],
                    datasets: [
                        {
                            fill: true,
                            backgroundColor: [
                                "#4b77a9",
                                "#5f255f",
                                "#d21243",
                                "#B27200"
                            ],
                            data: [{{$userSiswa}}, {{$userAlumni}}, {{$userGuru}}, {{$userUmum}}],
                // Notice the borderColor 
                            borderColor:	['black', 'black','black','black'],
                            borderWidth: [2,2]
                        }
                    ]
                };

                // Notice the rotation from the documentation.

                var options = {
                        title: {
                                display: true,
                                text: 'Presentase Komposisi Pengguna',
                                position: 'top'
                            },
                        rotation: -0.7 * Math.PI,
                        plugins: {
                        datalabels: {
                            formatter: function(value, ctx) {
                                let datasets = ctx.chart.data.datasets;

                                if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
                                let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value / sum) * 100) + '%';
                                return percentage;
                                } else {
                                return percentage;
                                }
                            },
                            color: 'white'
                        }
                        }
                    };


                // Chart declaration:
                var myBarChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: options
                });

            </script>
</div>
@endsection

@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
@endsection