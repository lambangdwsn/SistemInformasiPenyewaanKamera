@extends('layouts.AdminMain')
@section('title','Lokasi')
@section('head')
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
@endsection

@section('container')
{{-- add new lokasi modal start --}}
<div class="modal fade" id="addLokasiModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_lokasi_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
              <label for="lokasi">Nama lokasi</label>
              <input type="text" name="lokasi" class="form-control" placeholder="Nama lokasi" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_lokasi_btn" class="btn btn-primary">Add Lokasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new lokasi modal end --}}

{{-- edit lokasi modal start --}}
<div class="modal fade" id="editLokasiModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="edit_lokasi_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="lokasi_id" id="lokasi_id">
        <div class="modal-body p-4 bg-light">
        <div class="modal-body p-4 bg-light">  
            <div class="my-2">
              <label for="lokasi">Nama lokasi</label>
              <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Nama lokasi" required>
            </div>  
        </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_lokasi_btn" class="btn btn-success">Update Lokasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit lokasi modal end --}}

  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 70rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Majemen lokasi</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addLokasiModal"><i
                class="bi-plus-circle me-2"></i>Add New lokasi</button>
          </div>
          <div class="card-body" id="show_all_lokasi">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
   
    $(function() {

      // add new lokasi ajax request
      $("#add_lokasi_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_lokasi_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.lokasi.store") }}',
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
                'Lokasi Added Successfully!',
                'success'
              )
              fetchAlllokasis();
            }
            $("#add_lokasi_btn").text('Add Lokasi');
            $("#add_lokasi_form")[0].reset();
            $("#addLokasiModal").modal('hide');
          }
        });
      });

      // edit Lokasi ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.lokasi.edit") }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#lokasi").val(response.lokasi);
            $("#lokasi_id").val(response.id);
          }
        });
      });

      // update Lokasi ajax request
      $("#edit_lokasi_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_lokasi_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.lokasi.update") }}',
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
                'Updated Lokasi Successfully!',
                'success'
              )
              fetchAlllokasis();
            }
            $("#edit_lokasi_btn").text('Update Lokasi');
            $("#edit_lokasi_form")[0].reset();
            $("#editLokasiModal").modal('hide');
          }
        });
      });

      // delete Lokasi ajax request
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
              url: '{{ route("admin.lokasi.delete") }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              error: function (request, error) {
              console.log(arguments);
                Swal.fire(
                'Error',
                'Data Lokasi is being used or system error!',
                'error'
                );
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAlllokasis();
              }
            });
          }
        })
      });

      // fetch all Lokasis ajax request
      fetchAlllokasis();

      function fetchAlllokasis() {
        $.ajax({
          url: '{{ route('admin.lokasi.fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_lokasi").html(response);
            $("table").DataTable({
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
