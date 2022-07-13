@extends('layouts.AdminMain')
@section('title','Artikel')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" />

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')
{{-- add new artikel modal start --}}
<div class="modal fade" id="addArtikelModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Artikel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_artikel_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
              <label for="judul">Nama Artikel</label>
              <input type="text" name="judul" class="form-control" placeholder="judul Artikel" required>
            </div>
          <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
          </div>
          <div class="my-2">
            <label for="isi">Isi</label>
            <textarea name="isi" class="form-control" cols="30" rows="10" placeholder="Isi"></textarea>
          </div>
          <div class="my-2">
            <label for="status_tampil">Status Tampil</label><br>
            <label>
            <input type="radio" name="status_tampil" value="ya" required="required"> ya
            </label><br>
            <label>
            <input type="radio" name="status_tampil" value="tidak"> tidak
            </label><br>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_artikel_btn" class="btn btn-primary">Add Artikel</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new artikel modal end --}}

{{-- edit artikel modal start --}}
<div class="modal fade" id="editArtikelModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Artikel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="edit_artikel_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="artikel_id" id="artikel_id">
        <input type="hidden" name="artikel_image" id="artikel_image">
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
              <label for="judul">Judul Artikel</label>
              <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul Artikel" required>
            </div>
            <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
          </div>
          <div class="my-2" id="image">

          </div>
          <div class="my-2">
            <label for="isi">Isi</label>
            <textarea name="isi" id="isi" class="form-control" cols="30" rows="10" placeholder="Isi"></textarea>
          </div>
          <div class="my-2">
            <label for="status_tampil">Status Tampil</label><br>
            <label>
              <input type="radio" id="status_tampil_ya" name="status_tampil"  value="ya" required="required"> ya
            </label><br>
            <label>
            <input type="radio" id="status_tampil_tidak" name="status_tampil" value="tidak"> tidak
            </label><br>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_artikel_btn" class="btn btn-success">Update Artikel</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit artikel modal end --}}

  <div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 80rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Majemen Artikel</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addArtikelModal"><i
                class="bi-plus-circle me-2"></i>Add New Artikel</button>
          </div>
          <div class="card-body" id="show_all_Artikels">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src='https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
  <script src='https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js'></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>  
    $(document).ready(function(){ 
      $("select[id=katagori_add]").change( function() { 
      if ($("select[id=katagori_add] option:selected").text() !== "Kelengkapan") {
      $('select[id=kelengkapan_add]').prop('selectedIndex',0);
      $("select[id=kelengkapan_add]").prop("disabled", true);
      $("div[id=select_kelengkapan_add]").hide(); 
      } else { 
      $("select[id=kelengkapan_add]").prop("disabled", false);
      $("div[id=select_kelengkapan_add]").show();
      } 
      }); 
      
      $("select[id=katagori_edit]").change( function() { 
        if ($("select[id=katagori_edit] option:selected").text() !== "Kelengkapan") {
          $('select[id=kelengkapan_edit]').prop('selectedIndex',0);
          $("select[id=kelengkapan_edit]").prop("disabled", true);
          $("div[id=select_kelengkapan_edit]").hide(); 
        } else { 
          $("select[id=kelengkapan_edit]").prop("disabled", false);
          $("div[id=select_kelengkapan_edit]").show();
        } 
      }); 
      
      $("select[id=katagori_add]").trigger("change");
      
    });

    $(function() {
      // add new artikel ajax request
      $("#add_artikel_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_artikel_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.artikel.store") }}',
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
                'Artikel Added Successfully!',
                'success'
              )
              fetchAllArtikels();
            }
            $("#add_artikel_btn").text('Add Artikel');
            $("#add_artikel_form")[0].reset();
            $("#addArtikelModal").modal('hide');
          }
        });
      });

      // edit Artikel ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.artikel.edit") }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#judul").val(response.judul);
            $("#image").html(
              `<img src="../storage/images/${response.image}" width="500" class="img-fluid img-thumbnail">`);
            $("#isi").val(response.isi);
            $("#status_tampil_ya").filter('[value="'+response.status_tampil+'"]').prop('checked', true);
            $("#status_tampil_tidak").filter('[value="'+response.status_tampil+'"]').prop('checked', true);
            $("#artikel_id").val(response.id);
            $("#artikel_image").val(response.image);
          }
        });
      });

      // update Artikel ajax request
      $("#edit_artikel_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_artikel_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.artikel.update") }}',
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
                'Updated Artikel Successfully!',
                'success'
              )
              fetchAllArtikels();
            }
            $("#edit_artikel_btn").text('Update Artikel');
            $("#edit_artikel_form")[0].reset();
            $("#editArtikelModal").modal('hide');
          }
        });
      });

      // delete Artikel ajax request
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
              url: '{{ route("admin.artikel.delete") }}',
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
                fetchAllArtikels();
              }
            });
          }
        })
      });

      // fetch all Artikels ajax request
      fetchAllArtikels();

      function fetchAllArtikels() {
        $.ajax({
          url: '{{ route('admin.artikel.fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_Artikels").html(response);
            $("table").DataTable({
              dom: "<'row py-2'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>tip",
              buttons: [ 
                { "extend": 'copy', "text":'<i class="fa-solid fa-copy"></i>copy',"className": 'btn btn-sm' },
                { "extend": 'excel', "text":'<i class="fa-solid fa-file-excel mr-2"></i>excel',"className": 'btn btn-sm' },
                { "extend": 'pdf', "text":'<i class="fa-solid fa-file-pdf mr-2"></i>pdf',"orientation": 'landscape', "pageSize": 'LEGAL', "className": 'btn btn-sm' },
                { "extend": 'colvis', "text":'Column Visibility',"className": 'btn btn-sm' },
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
