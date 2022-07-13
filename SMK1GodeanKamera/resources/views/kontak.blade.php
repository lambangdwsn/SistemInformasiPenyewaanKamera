@extends('layouts.Main')
@section('title','Kontak')

@section('content')
<div class="container">
<div class="row border border-success d-flex justify-content-center p-2 m-1">
  <div class="col-md-6 col-lg-8 my-2">
    <a href="https://goo.gl/maps/sLEBziP6Mre2YiEp7" target="_blank" rel="noopener noreferrer"><img src="{{ asset('map-smkn1godean.png') }}" style="object-fit: cover;height: 300px;" class="w-100 mx-auto d-block" alt="Lokasi SMKN 1 Godean"></a>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="card mb-3 w-100 h-100">
      <div class="card-header font-weight-bold">CONTACT US</div>
      <div class="card-body text-dark">
        <h5 class="card-title font-weight-bold">Alamat :</h5>
        
          <address class="card-text">
            <p>
            {!!str_ireplace(array("\r\n",'\r\n'),'<br>',$kontak->alamat)!!}
            </p>
            <abbr title="Phone">WhatApps : <a href="{{$kontak->wa_link}}" target="_blank" rel="noopener noreferrer"> {{$kontak->no_tlp}} <i class="fa-brands fa-whatsapp"></i></a></abbr>
          </address>
          <h5 class="card-title font-weight-bold">Jam Buka :</h5>
          <address class="card-text">
            <p>{!!str_ireplace(array("\r\n",'\r\n'),'<br>',$kontak->jam_buka)!!}</p>
            <p>{!!str_ireplace(array("\r\n",'\r\n'),'<br>',$kontak->keterangan)!!}</p>
          </address>   
      </div>
    </div>
  </div>
</div>
</div>
@endsection
