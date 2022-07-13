@extends('layouts.AdminMain')
@section('title','Katagori')
@section('head')
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
@endsection

@section('container')
{{-- add new katagori modal start --}}
<div class="modal fade" id="addKatagoriModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Katagori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_katagori_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
              <label for="katagori">Nama Katagori</label>
              <input type="text" name="katagori" class="form-control" placeholder="Nama Katagori" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_katagori_btn" class="btn btn-primary">Add Katagori</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new katagori modal end --}}

{{-- edit katagori modal start --}}
<div class="modal fade" id="editKatagoriModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Katagori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="edit_katagori_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="katagori_id" id="katagori_id">
        <div class="modal-body p-4 bg-light">
        <div class="modal-body p-4 bg-light">
          
            <div class="my-2">
              <label for="katagori">Nama Katagori</label>
              <input type="text" id="katagori" name="katagori" class="form-control" placeholder="Nama Katagori" required>
            </div>  

        </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_katagori_btn" class="btn btn-success">Update Katagori</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit katagori modal end --}}

  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 70rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Majemen Katagori</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addKatagoriModal"><i
                class="bi-plus-circle me-2"></i>Add New Katagori</button>
          </div>
          <div class="card-body" id="show_all_Katagori">
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

      // add new katagori ajax request
      $("#add_katagori_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_katagori_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.katagori.store") }}',
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
                'Katagori Added Successfully!',
                'success'
              )
              fetchAllKatagoris();
            }
            $("#add_katagori_btn").text('Add Katagori');
            $("#add_katagori_form")[0].reset();
            $("#addKatagoriModal").modal('hide');
          }
        });
      });

      // edit Katagori ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.katagori.edit") }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#katagori").val(response.katagori);
            $("#katagori_id").val(response.id);
          }
        });
      });

      // update Katagori ajax request
      $("#edit_katagori_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_katagori_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.katagori.update") }}',
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
                'Updated Katagori Successfully!',
                'success'
              )
              fetchAllKatagoris();
            }
            $("#edit_katagori_btn").text('Update Katagori');
            $("#edit_katagori_form")[0].reset();
            $("#editKatagoriModal").modal('hide');
          }
        });
      });

      // delete Katagori ajax request
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
              url: '{{ route("admin.katagori.delete") }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllKatagoris();
              }
            });
          }
        })
      });

      // fetch all Katagoris ajax request
      fetchAllKatagoris();

      function fetchAllKatagoris() {
        $.ajax({
          url: '{{ route('admin.katagori.fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_Katagori").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });
  </script>
@endsection
