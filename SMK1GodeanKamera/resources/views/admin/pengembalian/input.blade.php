@extends('layouts.AdminMain')
@section('title','Pengembalian '.$user->name)
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')
{{-- add new sewa modal start --}}
<div class="modal fade" id="addSewaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Sewa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_sewa_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
            <label for="barcode">Kode barcode</label>
              <input type="text" pattern="\d*" id="add_barcode" name="barcode" class="form-control" placeholder="Kode Barcode" required maxlength="6">
              <span id="error_add_barcode" class="invalid-feedback d-block" role="alert">

              </span>
              
            </div>

            <div class="form-group">
            <label >Tanggal Kembali</label>
            <input type="date" id="add_tgl_kembali" name="tgl_kembali" class="form-control">
            <span id="error_add_tgl_kembali" class="invalid-feedback d-block" role="alert">
                  
            </span>
            </div>
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_sewa_btn" class="btn btn-primary">Add Sewa</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new sewa modal end --}}

{{-- edit sewa modal start --}}
<div class="modal fade" id="editSewaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Sewa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="edit_sewa_form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="sewa_id" id="sewa_id">
      <input type="hidden" name="tgl_sewa" id="tgl_sewa">
        <div class="modal-body p-4 bg-light">
        <div class="form-group">
            <label >Tanggal Kembali</label>
            <input type="date" id="tgl_kembali" name="tgl_kembali" class="form-control">
            <span id="error_tgl_kembali" class="invalid-feedback d-block" role="alert">
                  
            </span>
        </div>
        <div class="my-2">
            <label for="denda_lain">Denda Lain</label>
              <input type="number" id="denda_lain" name="denda_lain" class="form-control" placeholder="Denda Lain">
              <span id="error_denda_lain" class="invalid-feedback d-block" role="alert">

              </span>
              
            </div>
          <div class="my-2">
            <label for="keterangan">Keterangan Kembali</label>
            <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10" placeholder="Keterangan"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_sewa_btn" class="btn btn-success">Update Sewa</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit sewa modal end --}}

<div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 80rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Pengembalian</h3>
            <h3 class="text-light">Nama : {{$user->name}}</h3>
            <a href="{{url(route('admin.pengembalian.index'))}}" class="btn btn-light">Ganti Penyewa</a>
            <a href="#" id="btn-semua" class="btn btn-light"><i class="fa-solid fa-border-all mr-2"></i>Input Semua</a>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addSewaModal"><i
                class="bi-plus-circle me-2"></i>Tambah Alat</button>
          </div>
          <div class="card-body">
            <div id="show_all_Sewas">
              <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
            <div class="d-flex justify-content-end my-2">
              <a href="{{ route("admin.pengembalian.nota",["user_id" => $user->id]) }}" class="btn btn-primary mx-2"><i class="fa-solid fa-print mr-2"></i>Print Nota</a><a href="#" id="btn-confirm" class="btn btn-primary mx-2">Konfirmasi Pengembalian</a>
          </div>
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
            window.open('{{ route("admin.pengembalian.nota",["user_id" => $user->id]) }}','_blank');
            setTimeout(function (){
            $.ajax({
              url: '{{ route("admin.pengembalian.confirm",["user_id" => $user->id]) }}',
              method: 'post',
              data: {
                id_user: id_user,
                _token: csrf
              },
              success: function(response) {
                if(response.status == 200){
                Swal.fire(
                  'Confirm',
                  'You have confirmed the rental',
                  'success'
                );
                fetchAllSewas();
              }
            else{
              Swal.fire(
                'Error',
                'No Record!',
                'error'
                );
            }
          }
              
            });
          }, 2000);
          }
        })
      });

      //semua
      $(document).on('click', '#btn-semua', function(e) {
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
              url: '{{ route("admin.pengembalian.semua",["user_id" => $user->id]) }}',
              method: 'post',
              data: {
                id_user: id_user,
                _token: csrf
              },
              success: function(response) {
                if(response.status == 200){
                Swal.fire(
                  'Confirm',
                  'You have confirmed the rental',
                  'success'
                );
                fetchAllSewas();
              }
            else{
              Swal.fire(
                'Error',
                'No Record!',
                'error'
                );
            }
          }
            });
          }
        })
      });

      // add new sewa ajax request
      $("#add_sewa_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_sewa_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.pengembalian.store",["user_id" => $user->id]) }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Sewa Added Successfully!',
                'success'
              )
              fetchAllSewas();
              $("#add_sewa_btn").text('Add Sewa');
              $("#add_barcode").val('');
              $("#addSewaModal").modal('hide');
              document.getElementById('add_jumlah').value = 1;
             }else{
                printErrorMsg(response.errors,false);
                $("#add_sewa_btn").text('Add Sewa');
             }
          }
        });
      });

      // edit Sewa ajax request
      $(document).on('click', '.editIcon', function(e) {
        clear();
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.pengembalian.edit",["user_id" => $user->id]) }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#sewa_id").val(id);
            $("#tgl_sewa").val(response.tgl_sewa);
            $("#denda_lain").val(response.denda_lain);
            $("#tgl_kembali").val(response.tgl_kembali);
            $("#keterangan").val(response.keterangan_kembali);
          }
        });
      });

      // update Sewa ajax request
      $("#edit_sewa_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_sewa_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.pengembalian.update",["user_id" => $user->id]) }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Updated sewa Successfully!',
                'success'
              )
              fetchAllSewas();
              $("#edit_sewa_btn").text('Update Sewa');
              $("#edit_sewa_form")[0].reset();
              $("#editSewaModal").modal('hide');
            }else{
                printErrorMsg(response.errors,true);
                $("#edit_sewa_btn").text('Update Sewa');
             }
          }
        });
      });


      now();
      function now(){
        let date = new Date()
        document.getElementById('add_tgl_kembali').valueAsDate = date;       
      }

      // delete Sewa ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route("admin.pengembalian.delete",["user_id" => $user->id]) }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllSewas();
              }
            });
          }
        })
      });

      function printErrorMsg (msg,tp) {
        clear();
        //console.table(msg);
        if(tp){
              $.each( msg, function( key, value ) {
              $('#error_'+key).html("<strong>"+value+"</strong>");
              $('#'+key).addClass("is-invalid");
             });
         }else{
          $.each( msg, function( key, value ) {
              $('#error_add_'+key).html("<strong>"+value+"</strong>");
              $('#add_'+key).addClass("is-invalid");
             });
         }
        }
        function clear(){
        
        $('span[id ^= "error_"]').each(function(key) {
        $( this ).html('');
        });
        $('span[id ^= "error_add_"]').each(function(key) {
        $( this ).html('');
        });

        $("#add_barcode").removeClass("is-invalid");
        $("#add_tgl_kembali").removeClass("is-invalid");
        $("#tgl_kembali").removeClass("is-invalid");
        $("#denda_lain").removeClass("is-invalid");
    }

      // fetch all Sewas ajax request
      fetchAllSewas();

      function fetchAllSewas() {
        $.ajax({
          url: '{{ route('admin.pengembalian.fetchAll',['user_id' => $user->id]) }}',
          method: 'get',
          success: function(response) {
            $("#show_all_Sewas").html(response);
            $("table").DataTable({
              dom: "<'row py-2'<'col-sm-2'><'col-sm-6'><'col-sm-4'f>><'row'<'col-12't>><'row'<'#btnConfirm .col-12'>>",
              lengthMenu: [ [-1], ["All"] ],
              initComplete: function(settings, json) {$("#btnConfirm").html($("#extraDiv"))},
              order: [0, 'desc'],
              columnDefs: [
             { "orderable": false, "targets": "#no_sort" }
            ]
            });
          }
        });
      }
    });
  </script>
@endsection
