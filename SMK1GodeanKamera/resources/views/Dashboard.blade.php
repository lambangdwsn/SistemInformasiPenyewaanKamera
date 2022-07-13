@extends('layouts.Main')
@section('title','Dashboard')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</script><link rel="stylesheet" href="{{asset('/css/table2card.css')}}">
<style>
  .transbox {
  margin: 30px;
  background-color:rgba(0, 0, 0, 0.6);
  border: 1px solid black;
}
</style>
@endsection


@section('content')
<div class="container">
@if(count($artikel)>0)
<div id="carouselExampleIndicators" class="carousel slide my-3" data-ride="carousel">
  <ol class="carousel-indicators">
    
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    @for ($i = 0; $i < count($artikel)-1; $i++)
    <li data-target="#carouselExampleIndicators" data-slide-to="{{$i+1}}"></li>
    @endfor
  </ol>
  <div class="carousel-inner">
        
    <div class="carousel-item active">
      <img class="d-block w-100" style="object-fit: cover;height: 300px;" src="../storage/images/{{$artikel[0]->image}}" alt="First slide">
      <div class="carousel-caption d-none d-md-block transbox">
        <h5>{{$artikel[0]->judul}}</h5>
        <p>{!!str_ireplace(array("\r\n",'\r\n'),'<br>',$artikel[0]->isi)!!}</p>
      </div>
    </div>
    @if (count($artikel) > 1)    
    <div class="carousel-item">
      <img class="d-block w-100" style="object-fit: cover;height: 300px;" src="../storage/images/{{$artikel[1]->image}}" alt="Second slide">
      <div class="carousel-caption d-none d-md-block transbox">
      <h5>{{$artikel[1]->judul}}</h5>
      <p>{!!str_ireplace(array("\r\n",'\r\n'),'<br>',$artikel[1]->isi)!!}</p>
      </div>
    </div>
    @endif
    @if (count($artikel) > 2)
    <div class="carousel-item">
      <img class="d-block w-100" style="object-fit: cover;height: 300px;" width="1500rem" height="250px" src="../storage/images/{{$artikel[2]->image}}" alt="Third slide">
      <div class="carousel-caption d-none d-md-block transbox">
      <h5>{{$artikel[2]->judul}}</h5>
      <p>{!!str_ireplace(array("\r\n",'\r\n'),'<br>',$artikel[2]->isi)!!}</p>
      </div>
    </div>
    @endif
    
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
@endif
<fieldset class="py-1 px-2 card" runat="server" visible="true" style="border: solid; border-width: thin;">
                <legend class="card text-white bg-info px-2" runat="server" visible="true" style="width:auto;">
                Barang Terbaru
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
</div>
@endsection
