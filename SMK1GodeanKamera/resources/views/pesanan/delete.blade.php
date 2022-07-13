@extends('layouts.Main')

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

<form action="{{url(route('pesanan.delete',['id' => $pesanan->id]))}}" method="post">
@method('delete')
@csrf
    <fieldset class="py-1 px-2 card" runat="server" visible="true" style="border: solid; border-width: thin;">
        <legend class="card text-white bg-info px-2" runat="server" visible="true" style="width:auto;">
            Edit Pesanan
        </legend>
        <table class="table bg-light tablecard" style="width:17rem;margin-left: auto;margin-right: auto;" >
    <thead>
      <tr>			
          <th>Gambar</th>
          <th>Nama</th>
          <th>Harga Sewa</th>
          <th>Jumlah</th>
          <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="text-align: center;vertical-align: middle;"><img src="../../storage/images/{{$pesanan->image}}" class="avatar border" style="width:180px;height:120px;"></td>
        <td data-label="Nama">{{$pesanan->nama}}</td>
        @if(Auth::guard('web')->user()->role === 'Siswa')
        <td data-label="Harga Sewa">{{$pesanan->harga_siswa}}</td>
        @elseif(Auth::guard('web')->user()->role === 'Alumni')
        <td data-label="Harga Sewa">{{$pesanan->harga_alumni}}</td>
        @elseif(Auth::guard('web')->user()->role === 'Guru')
        <td data-label="Harga Sewa">{{$pesanan->harga_guru}}</td>
        @else
        <td data-label="Harga Sewa">{{$pesanan->harga_umum}}</td>
        @endif
        <td data-label="Jumlah">{{$pesanan->jumlah}}</td>
        <td style="text-align: right;vertical-align: middle;">
        <input type="submit" class="btn btn-danger" value="Hapus">
        <a href="{{url(route('pesanan.index'))}}" class="btn btn-light">Kembali</a>
        </td>
      </tr>
</tbody>
</table>
    </fieldset>
</form>
</div>
@endsection