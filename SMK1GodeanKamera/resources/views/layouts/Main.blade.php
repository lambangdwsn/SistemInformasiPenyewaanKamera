<?php
use App\Models\Katagori;
$menukatagori= Katagori::pluck('katagori')->toArray();
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('head')
        
    </head>
        <body style="padding-top: 8rem;">
        <nav class="navbar navbar-expand-md navbar-dark px-5 fixed-top" style="background-color:#286800;">
            <img src="{{ asset('logoSMK.png') }}" class="rounded" width="250px" height="auto" alt="logo">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="{{url(route('dashboard'))}}">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Daftar Alat
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{url(route('barang.index', ['katagori' => 'semua']))}}">Semua Alat</a>
                        @foreach($menukatagori as $menu)
                        <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="{{url(route('barang.index', ['katagori' => $menu]))}}">{{$menu}}</a>
                          @endforeach
                      </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="{{url(route('berita'))}}">Berita</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="{{url(route('kontak'))}}">Kontak</a>
                  </li>        
                  <ul class="navbar-nav ms-auto">
                                  <!-- Authentication Links -->
                                  @guest
                                      @if (Route::has('login'))
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                          </li>
                                      @endif
                                      @if (Route::has('register'))
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                          </li>
                                      @endif
                                  @else
                                  <li class="nav-item">
                                    <a class="nav-link active" href="{{route('pesanan.index')}}"><i class="fa-solid fa-cart-shopping mr-2"></i>Pesanan</a>
                                  </li>
                                  <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::guard('web')->user()->name }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                      <a href="{{route('profile',['uuid' => Auth::guard('web')->user()->id])}}" class="dropdown-item">Profile</a>
                                      <a href="{{route('peminjaman')}}" class="dropdown-item">Peminjaman</a>
                                      <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                              document.getElementById('logout-form').submit();">
                                                  {{ __('Logout') }}
                                              </a>
                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                              </form>
                                              
                                    </div>
                                  @endguest
                              </ul>
              </ul>
            </div>
          </nav>

        <main>
            @yield('content')
        </main>
        <footer class="container">
          <div class="row mt-5 pt-4 border-top">
          <div class="col-md-6 col-lg-8">
          <p class="copyright">
          Copyright © 2022 All Talenta SMK 1 Godean</p>
          </div>
          <div class="col-md-6 col-lg-4 text-md-right">
          <p class="copyright">This Website is made with <i class="fa-solid fa-heart"></i> by <a href="https://www.instagram.com/lambangdwsn/" target="_blank"><i class="fa-brands fa-instagram"></i>Lambang DWSN</a>
          </p>
          </div>
          </div>
        </footer>
</body>
</html>
