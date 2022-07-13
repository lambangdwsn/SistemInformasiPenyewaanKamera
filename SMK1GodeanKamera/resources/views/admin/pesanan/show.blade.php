@extends('layouts.AdminMain')
@section('title','Pemensanan '.$user->name)
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')

<div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 80rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Pemesanan</h3>
            <h3 class="text-light">Nama : {{$user->name}}</h3>
            <a href="{{url(route('admin.pesanan'))}}" class="btn btn-light">Ganti pesanan</a>
            <a href="#" id="btn-confirm" class="btn btn-primary">Konfirmasi Sewa</a>
            </div>
          <div class="card-body">
            <table class="table table-striped table-sm align-middle">
              <thead>
                <tr>
                  <th style="vertical-align: top;">Nama Barang</th>
                  <th style="vertical-align: top;">jumlah</th>
                  <th style="vertical-align: top;">Tanggal dibuat</th>
                  <thead>
                    <tbody>
                      @foreach($pesanans as $pesanan)
                  <tr>
                    <td>{{$pesanan->nama}}</td>
                    <td>{{$pesanan->jumlah}}</td>
                    <td>{{$pesanan->updated_at}}</td>
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

    $(function() {
      //confirm
      $(document).on('click', '#btn-confirm', function(e) {
        e.preventDefault();
        let id_user = '{{$user->id}}';
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, confirm it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route("admin.pesanan.confirm",["user_id" => $user->id]) }}',
              method: 'post',
              data: {
                id_user: id_user,
                _token: csrf
              },
              success: function(response) {
                Swal.fire(
                  'Confirm',
                  'You have confirmed the rental',
                  'success'
                )
                location.reload();
              }
            });
          }
        })
      });

      

      

          
      

    });
  </script>
@endsection
