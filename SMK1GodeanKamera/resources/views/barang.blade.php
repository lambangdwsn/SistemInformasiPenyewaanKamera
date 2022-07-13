@extends('layouts.Main')
@section('title','Alat')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" />
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<link rel="stylesheet" href="{{asset('/css/table2card.css')}}">
@endsection


@section('content')
<div class="container">
<fieldset class="py-1 px-2 card" runat="server" visible="true" style="border: solid; border-width: thin;">
                <legend class="card text-white bg-info px-2" runat="server" visible="true" style="width:auto;">@if($katagori === "semua")
                Semua Alat
                @else
				{{ucfirst($katagori)}}
                @endif
                </legend>
  
  <table class="table bg-light tablecard">
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
    @foreach($barang as $item)
      <tr>				
        <td style="text-align: center;vertical-align: middle;"><img src="../storage/images/{{$item->image}}" class="avatar border" style="width:180px;height:120px;"></td>
        <td data-label="Nama">{{$item->nama}}</td>
        <td data-label="Jumlah">{{$item->jumlah}}</td>
        @guest
        <td data-label="Harga Sewa">{{$item->harga_umum}}</td>
        @else
        @if(Auth::guard('web')->user()->role === 'Siswa')
        <td data-label="Harga Sewa">{{$item->harga_siswa}}</td>
        @elseif(Auth::guard('web')->user()->role === 'Alumni')
        <td data-label="Harga Sewa">{{$item->harga_alumni}}</td>
        @elseif(Auth::guard('web')->user()->role === 'Guru')
        <td data-label="Harga Sewa">{{$item->harga_guru}}</td>
        @else
        <td data-label="Harga Sewa">{{$item->harga_umum}}</td>
        @endif
        @endguest
        <td style="text-align: center;vertical-align: middle;"><a href="#" class="btn btn-sm btn-info" onclick="event.preventDefault();
                                                              document.getElementById('pesanan_{{$item->id}}').submit();">Pesan Sekarang</a>
        <form id="pesanan_{{$item->id}}" action="{{ route('pesanan.index') }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="barang_id" value="{{$item->id}}">
        </form>
        </td>
      </tr>
    @endforeach
</tbody>
</table>

</fieldset>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

  $(document).ready(function(){
    $("table").DataTable({
      dom: "<'row py-2'<'col-12 float-right'f>><'row col-sm-12 py-2't>"+
      "<'row py-2'<'col-sm-6'i><'col-sm-6'p>>",
      lengthMenu: [
            [9],
            [9],
        ],
      order: [0, 'desc'],
      ordering: false
    });
	});
</script>
</div>
@endsection
