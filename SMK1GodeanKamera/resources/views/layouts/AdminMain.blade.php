<?php
use App\Models\Katagori;
use App\Models\Pesanan;

$menukatagori= Katagori::pluck('katagori')->toArray();
$pesananCount= Pesanan::selectRaw('pesanan.id_user, users.name, min(pesanan.updated_at) as date_create')
->Join('users', 'pesanan.id_user','=','users.id')
->groupBy('pesanan.id_user')
->groupBy('users.name')->get()->count();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('/css/sidebar.css')}}">
    
    @yield('head')
</head>
<body background="{{ asset('background.png') }}">
<div id="mySidebar" class="sidebar">
  <a class="navbar-brand" href="{{ url(route('admin.home')) }}">
                    <img src="{{asset('logoSMKbulat.png')}}" alt="logo smk">
                </a>
  <a href="{{ url(route('admin.home')) }}"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
  @if((Auth::guard('admin')->user()->role === "Admin"))
  <button class="dropdown-btn"><i class="fa fa-suitcase" aria-hidden="true"></i>Daftar Barang
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="{{ url(route('admin.barang.index')) }}"><i class="fa-solid fa-boxes-stacked"></i>Semua Barang</a>
    @foreach($menukatagori as $menu)
    @if($menu === 'Kamera')
    <a href="{{url(route('admin.barang.katagori',['katagori' => 'kamera']))}}"><i class="fa fa-camera" aria-hidden="true"></i>Kamera</a>
    @elseif($menu === 'Drone')
    <a href="{{url(route('admin.barang.katagori',['katagori' => 'drone']))}}"><i class="fa fa-plane" aria-hidden="true"></i>Drone</a>
    @elseif($menu === 'Audio')
    <a href="{{url(route('admin.barang.katagori',['katagori' => 'audio']))}}"><i class="fa fa-microphone" aria-hidden="true"></i>Audio</a>
    @elseif($menu !== 'Kelengkapan')
    <a href="{{url(route('admin.barang.katagori',['katagori' => strtolower($menu)]))}}"><i class="fa-brands fa-dropbox"></i>{{$menu}}</a>
    @else
    <a href="{{url(route('admin.barang.katagori',['katagori' => 'kelengkapan']))}}"><i class="fa-solid fa-screwdriver-wrench"></i>Kelengkapan</a>
    @endif
    @endforeach
    <a href="{{url(route('admin.rusak.index'))}}"><i class="fa-solid fa-gears"></i>Barang Rusak</a>
  </div>
  
  <button class="dropdown-btn"><i class="fa fa-address-card" aria-hidden="true"></i>Daftar User
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="{{url(route('admin.user.index', ['role' => 'siswa']))}}"><i class="fa fa-graduation-cap" aria-hidden="true"></i>Siswa</a>
    <a href="{{url(route('admin.user.index', ['role' => 'alumni']))}}"><i class="fa fa-graduation-cap" aria-hidden="true"></i>Alumni</a>
    <a href="{{url(route('admin.user.index', ['role' => 'guru']))}}"><i class="fa fa-briefcase" aria-hidden="true"></i>Guru</a>
    <a href="{{url(route('admin.user.index', ['role' => 'umum']))}}"><i class="fa fa-address-card" aria-hidden="true"></i>Umum</a>
  </div>
  <a href="{{url(route('admin.artikel.index'))}}"><i class="fa fa-file-text" aria-hidden="true"></i>Berita</a>
  <a href="{{url(route('admin.petugas.index'))}}"><i class="fa-solid fa-person-walking-luggage"></i>Petugas</a>
  @endif
  <button class="dropdown-btn"><i class="fa-solid fa-sack-dollar"></i>Transaksi
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    @if(Auth::guard('admin')->user()->role === "Admin")  
    <a href="{{url(route('admin.denda'))}}"><i class="fa-regular fa-credit-card"></i>Pengaturan Denda</a>
    @endif
      <button class="dropdown-btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Penyewaan
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container">
        <a href="{{url(route('admin.penyewaan.index'))}}"><i class="fa-solid fa-feather-pointed"></i>Input Penyewaan</a>
        <a href="{{url(route('admin.disewa.index'))}}"><i class="fa-solid fa-book"></i>Note Penyewaan</a>
      </div>
      
      <button class="dropdown-btn"><i class="fa-solid fa-arrow-right-arrow-left"></i>Pengembalian
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container">
        <a href="{{url(route('admin.pengembalian.index'))}}"><i class="fa-solid fa-feather-pointed"></i>Input Pengembalian</a>
        <a href="{{url(route('admin.selesai.index'))}}"><i class="fa-solid fa-book"></i>Note Pengembalian</a>
      </div>

    
    </div>
    <a href="{{url(route('admin.pesanan'))}}"><i class="fa-solid fa-list-check"></i>Pesanan @if($pesananCount>0)<span class="badge badge-light">{{$pesananCount}}</span>@endif</a>
    @if(Auth::guard('admin')->user()->role === "Admin")
    <a href="{{url(route('admin.kontak'))}}"><i class="fa-solid fa-address-book"></i>Pengaturan Kontak</a>
    @endif
</div>
</div>


<nav id="headbar" class="navbar navbar-expand navbar-dark bg-light rounded fixed-top d-flex">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav me-auto">
            <button class="btn btn-side d-inline mt-2 mb-2" onclick="btn()">☰</button><h2 class="d-inline p-2">@yield('title')</h2>
          </ul>
          
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto mr-2">
            <li class="nav-item">
            <a href="{{url(route('admin.penyewaan.index'))}}" class="nav-link text-dark"><i class="fa-solid fa-feather-pointed mr-2"></i>Input Penyewaan</a>
            </li>
            <li class="nav-item">
            <a href="{{url(route('admin.pengembalian.index'))}}" class="nav-link text-dark"><i class="fa-solid fa-feather-pointed mr-2"></i>Input Pengembalian</a>
            </li>

            <div class="dropdown">
              <button class="dropdown-toggle text-dark nav-link" style="background-color: transparent;border:0;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-user mr-2 rounded-circle"></i>{{ Auth::guard('admin')->user()->name }}
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                          </a>
                                          
                  <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>            
                </div>
              </div>
            </ul>
</nav>
<div id="main" style="padding-top: 6rem;">
  @yield('container')
</div>

<script>
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("border-bottom");
  this.classList.toggle("border-success");
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.height === "auto") {
  dropdownContent.style = "height: auto;transform: scaleY(0);animation: drob_hide 0.4s;";
  setTimeout(function() {
    dropdownContent.style = "height: 0;"
  }, 200);
  } else {
  dropdownContent.style = "height: auto; transform: scaleY(1);animation: drob_show 0.4s;";
  }
  });
}
</script>
<script>
let isOpen = false;
function btn(){
  if (isOpen){
    closeNav();
    isOpen = false;
  }else{
    openNav();
    isOpen = true;
  }
}

function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.getElementById("headbar").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.getElementById("headbar").style.marginLeft= "0";
}
</script>
   
</body>
</html> 