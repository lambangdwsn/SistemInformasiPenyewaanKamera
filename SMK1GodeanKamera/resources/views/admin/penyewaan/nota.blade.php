<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @media print {
        body{
        height: 10.5cm;
        width: 15cm;
        margin-top: 50%;
        margin-left: auto;
        margin-right: auto;
        } 
}
    </style>
</head>
<body class="bg-white d-flex align-items-center justify-content-center">
        <div class="row m-3 p-3" style="width: 800px;">
            <div class="col-12 mb-3">
                <h5>Nota Penyewaan</h5>
                <p>{{$kontak->alamat}} <br>
                {{$kontak->no_tlp}}</p>
            </div>
            <div class="col-12">
                <p>Kepada : <br>
                {{$user->name}} <br>
                di {{$user->alamat}}</p>
            </div>
           <div class="col-12 d-flex align-items-center justify-content-center">
               <table style="width: 800px;" class="table table-striped table-sm text-center " >
                   <thead>
                     <tr>
                       <th style="vertical-align: top;">No</th>
                       <th style="vertical-align: top;">Nama Barang</th>
                       <th style="vertical-align: top;">Harga Satuan</th>
                       <th style="vertical-align: top;">Jumlah</th>
                       <th style="vertical-align: top;">Lama Hari</th>
                       <th style="vertical-align: top;">Total Harga</th>
                       <th style="vertical-align: top;">Tanggal Sewa</th>
                       <th style="vertical-align: top;">Tanggal Harus Kembali</th>
                       <th style="vertical-align: top;">Keperluan</th>
                       <th style="vertical-align: top;">Keterangan</th>
                     </tr>
                   </thead>
                   <tbody>
                       @foreach($penyewaans as $index => $penyewaan)
                           <tr>
                           <td>{{$index+1}}</td>
                           <td>{{ $penyewaan->nama_barang }}</td>
                           <td>{{ $penyewaan->harga_satuan }}</td>
                           <td>{{ $penyewaan->jumlah }}</td>
                           <td>{{ $penyewaan->lama }}</td>
                           <td>{{ $penyewaan->total_harga }}</td>
                           <td>{{ $penyewaan->tgl_sewa }}</td>
                           <td>{{ $penyewaan->tgl_harus_kembali }}</td>
                           <td>{{ $penyewaan->keperluan }}</td>
                           <td>{{ $penyewaan->keterangan }}</td>
                         </tr>
                       @endforeach
                       <tr class="bg-white">
                           <td colspan="9">Jumlah Tagihan</td>
                           <td>Rp. {{$total}}</td>
                       </tr>
                   </tbody>
               </table>
           </div>
           <div class="col-12 my-2">
               <table class="bg-white float-right" style="width: 200px;">
                   <tr>
                       <td class="p-2">{{date("d/m/Y")}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Petugas pencatat</td>
                    </tr>
                    <tr>
                        <td style="height: 80px;"></td>
                    </tr>
                    <tr>
                        <td class="p-2">{{Auth::guard('admin')->user()->name}}</td>
                    </tr>
               </table>
           </div> 
        </div>
        <script>
            window.print();
        </script>
</body>
</html>