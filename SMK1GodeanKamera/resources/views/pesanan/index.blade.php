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
        <th>Action</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Harga Sewa</th>
        <th>Jumlah</th>
        <th>Waktu Tersisa</th>
      </tr>
    </thead>
    <tbody>
    @foreach($pesanan as $item)
      <tr>
        <td style="text-align: right;vertical-align: middle;"><a class="btn btn-danger mx-2" href="{{url(route('pesanan.delete',['id' => $item['id']]))}}"><i class="fa-solid fa-trash-can"></i></a></td>				
        <td style="text-align: center;vertical-align: middle;"><img src="../storage/images/{{$item->image}}" class="avatar border" style="width:180px;height:120px;"></td>
        <td data-label="Nama">{{$item->nama}}</td>
        @if(Auth::guard('web')->user()->role === 'Siswa')
        <td data-label="Harga Sewa">{{$item->harga_siswa}}</td>
        @elseif(Auth::guard('web')->user()->role === 'Alumni')
        <td data-label="Harga Sewa">{{$item->harga_alumni}}</td>
        @elseif(Auth::guard('web')->user()->role === 'Guru')
        <td data-label="Harga Sewa">{{$item->harga_guru}}</td>
        @else
        <td data-label="Harga Sewa">{{$item->harga_umum}}</td>
        @endif
        <td data-label="Jumlah">{{$item->jumlah}} <a class="btn btn-sm btn-info mx-2" id="btn-edit_{{$item->id}}" href="{{ url(route('pesanan.show',['id' => $item['id']]))}}"><i class="fa-solid fa-pencil"></i></a></td>
        <td data-label="Otomatis Hapus Dalam"><p id="pesanan_{{$item->id}}"></p></td>
      </tr>
    @endforeach
</tbody>
</table>
<script>
@foreach($pesanan as $item)
timer('pesanan_{{$item->id}}','{{date("M d, Y H:i:s", strtotime($item->updated_at ." +2 hours"))}}','btn-edit_{{$item->id}}');
@endforeach
function timer(id,time,btn){
  
var countDownDate = new Date(time).getTime();
    
// Update the count down every 1 second
var x = setInterval(function() {

// Get today's date and time
var now = new Date().getTime();

// Find the distance between now and the count down date
var distance = countDownDate - now;
    
// Time calculations for days, hours, minutes and seconds
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
// Output the result in an element with id="demo"
document.getElementById(id).innerHTML = days + "d " + hours + "h "
+ minutes + "m " + seconds + "s ";

// If the count down is over, write some text 
if (distance < 0) {
    clearInterval(x);
    document.getElementById(id).innerHTML = "EXPIRED";
    document.getElementById(btn).style.display="none";
    }
}, 1000);
}
</script>
</fieldset>
<fieldset class="py-1 px-2 my-4 card" runat="server" visible="true" style="border: solid; border-width: thin;">
<legend class="card text-white bg-info px-2" runat="server" visible="true" style="width:auto;">
<div>
  <i class="fa-solid fa-wallet mr-2"></i>Tagihan
</div>
</legend>
<h2>Biaya Sewa : Rp. {{$sum}}</h2>
</fieldset>
</div>
@endsection