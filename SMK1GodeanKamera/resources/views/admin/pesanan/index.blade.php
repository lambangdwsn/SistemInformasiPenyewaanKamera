@extends('layouts.AdminMain')
@section('title','Pilih Pemesan')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />


@endsection

@section('container')
<div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 70rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Pilih Pemesan</h3>
          </div>
          <div class="card-body">
          <table class="table table-striped table-sm align-middle">
        <thead>
          <tr>
            <th style="vertical-align: top;">Nama</th>
            <th style="vertical-align: top;">Tanggal dibuat</th>
            <th style="vertical-align: top;">Pilih Pemesan</th>
            </tr>
          </thead>
            <tbody>
                @foreach($pesanans as $pesanan)
                  <tr>
                    <td>{{$pesanan->name}}</td>
                    <td>{{$pesanan->date_create}}</td>
                    <td><a href="{{url(route('admin.pesanan.show', ['user_id' => $pesanan->id_user]))}}" class="btn btn-sm btn-primary">Pilih</a></td>
                  </tr>
                @endforeach
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
