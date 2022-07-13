@extends('layouts.Main')
@section('title','Pesanan')

@section('head')
<link rel="stylesheet" href="{{asset('/css/table2card.css')}}">
@endsection

@section('content')
<div class="container">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </div>
@endif
<fieldset class="py-1 px-2 card" runat="server" visible="true" style="border: solid; border-width: thin;">
                <legend class="card text-white bg-info px-2" runat="server" visible="true" style="width:auto;">
                Pesanan
                </legend>
@if($isKosong)
    <div class="alert alert-danger">
        Anda tidak memiliki pesanan        
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </div>
@endif
  
  <table class="table bg-light tablecard">
    <thead>
      <tr>			
        <th>Gambar</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Harga Sewa</th>
        <th>Total harga</th>
        <th>Tanggal Tempo</th>
      </tr>
    </thead>
    <tbody>
    @foreach($sewa as $item)
      <tr>
        <td style="text-align: center;vertical-align: middle;"><img src="../storage/images/{{$item->image}}" class="avatar border" style="width:180px;height:120px;"></td>
        <td data-label="Nama">{{$item->nama}}</td>
        <td data-label="Jumlah">{{$item->jumlah}}</td>
        <td data-label="Harga">{{$item->harga}}</td>
        <td data-label="Total Harga">{{$item->total_harga}}</td>
        <td data-label="Tanggal harus kembali">{{$item->tgl_harus_kembali}}</td>
        <td data-label="Terlambat">Terlambat {{$item->terlambat}} hari</td>
      </tr>
    @endforeach
</tbody>
</table>
</fieldset>
<fieldset class="py-1 px-2 my-4 card" runat="server" visible="true" style="border: solid; border-width: thin;">
<legend class="card text-white bg-info px-2" runat="server" visible="true" style="width:auto;">
<div>
  <i class="fa-solid fa-wallet mr-2"></i>Tagihan
</div>
</legend>
<h2>Biaya Sewa : Rp. {{$sum}}</h2>
<h2>Biaya Denda : Rp. {{$denda}}</h2>
<h2>Total : Rp. {{$denda+$sum}}</h2>
</fieldset>
</div>
@endsection