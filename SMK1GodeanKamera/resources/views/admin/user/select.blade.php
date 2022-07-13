@extends('layouts.AdminMain')
@section('title','Pilih Penyewa')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')
<div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 70rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Pilih Penyewa</h3>
          </div>
          <div class="card-body">
          <table class="table table-striped table-sm align-middle">
        <thead>
          <tr>
            <th style="vertical-align: top;">Nama</th>
            <th style="vertical-align: top;">Email</th>
            <th style="vertical-align: top;">Jenis Kelamin</th>
            <th style="vertical-align: top;">Alamat</th>
            <th style="vertical-align: top;">No Telepon</th>
            <th style="vertical-align: top;">Status</th>
            <th style="vertical-align: top;">Pilih Penyewa</th>
            <thead>
            <tbody>
                @foreach($users as $user)
                  <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->jenis_kelamin}}</td>
                    <td>{{$user->alamat}}</td>
                    <td>{{$user->no_tlp}}</td>
                    <td>{{$user->role}}</td>
                    <td><a href="{{url(route($route, ['user_id' => $user->id]))}}" class="btn btn-sm btn-primary">Pilih</a></td>
                  </tr>
                @endforeach
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  
$("table").DataTable({
dom: "<'row py-2'<'col-sm-2'l><'col-sm-6'><'col-sm-4'f>>tip",
lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
order: [0, 'asc'],
columnDefs: [
{ "orderable": false, "targets": "#no_sort" }
]
});
  </script>
@endsection
