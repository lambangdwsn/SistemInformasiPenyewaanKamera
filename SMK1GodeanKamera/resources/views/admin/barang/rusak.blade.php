@extends('layouts.AdminMain')
@section('title','Barang Rusak/Hilang')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" />

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')
{{-- add new barang modal start --}}
<div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_barang_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
            <label for="barcode">Kode barcode</label>
              <input type="text" pattern="\d*" id="add_barcode" name="barcode" class="form-control" placeholder="Kode Barcode" required maxlength="6">
              <span id="error_add_barcode" class="invalid-feedback d-block" role="alert">

              </span>
              
            </div>
          <div class="my-2">
            <label for="jumlah">Jumlah Barang</label>
            <input type="number" id="add_jumlah" name="jumlah" class="form-control" placeholder="Jumlah Barang" required>
            <span id="error_add_jumlah" class="invalid-feedback d-block" role="alert">
                  
            </span>
          </div>
          <div class="my-2">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control" cols="30" rows="10" placeholder="Keterangan"></textarea>
          </div>
          <div class="my-2">
            <label for="status">Status</label><br>
            <label>
            <input type="radio" name="status" value="Rusak" required="required"> Rusak
            </label><br>
            <label>
            <input type="radio" name="status" value="Hilang"> Hilang
            </label><br>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_barang_btn" class="btn btn-primary">Add Barang</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new barang modal end --}}

{{-- edit barang modal start --}}
<div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="edit_barang_form" enctype="multipart/form-data">
      @csrf
        <input type="hidden" name="barang_id" id="barang_id">
        <div class="modal-body p-4 bg-light">
        <div class="my-2">
            <label for="barcode">Kode barcode</label>
            <input type="text" pattern="\d*" id="barcode" name="barcode" class="form-control" placeholder="Kode Barcode" required maxlength="6">
            <span id="error_barcode" class="invalid-feedback d-block" role="alert">
                  
            </span>
        </div>
          <div class="my-2">
            <label for="jumlah">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah Barang" required>
            <span id="error_jumlah" class="invalid-feedback d-block" role="alert">
                  
            </span>
          </div> 
          <div class="my-2">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10" placeholder="Keterangan"></textarea>
          </div>
          <div class="my-2">
            <label for="status">Status</label><br>
            <label>
              <input type="radio" id="status_rusak" name="status"  value="rusak" required="required"> rusak
            </label><br>
            <label>
            <input type="radio" id="status_hilang" name="status" value="hilang"> hilang
            </label><br>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_barang_btn" class="btn btn-success">Update Barang</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit barang modal end --}}

<div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 80rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Majemen Barang Rusak</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBarangModal"><i
                class="bi-plus-circle me-2"></i>Add New Barang Rusak</button>
          </div>
          <div class="card-body" id="show_all_Barangs">
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
    

    $(function() {
      // add new barang ajax request
      $("#add_barang_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_barang_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.rusak.store") }}',
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
                'Barang Added Successfully!',
                'success'
              )
              fetchAllBarangs();
              $("#add_barang_btn").text('Add Barang');
              $("#add_barang_form")[0].reset();
              $("#addBarangModal").modal('hide');
             }else{
                printErrorMsg(response.errors,false);
                $("#add_barang_btn").text('Add Barang');
             }
          }
        });
      });

      // edit Barang ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.rusak.edit") }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#barang_id").val(id);
            $("#barcode").val(response.barcode);
            $("#jumlah").val(response.jumlah);
            $("#keterangan").val(response.keterangan);
            $("#status_rusak").filter('[value="'+response.status+'"]').prop('checked', true);
            $("#status_hilang").filter('[value="'+response.status+'"]').prop('checked', true);
          }
        });
      });

      // update Barang ajax request
      $("#edit_barang_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_barang_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.rusak.update") }}',
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
                'Updated Barang Successfully!',
                'success'
              )
              fetchAllBarangs();
              $("#edit_barang_btn").text('Update Barang');
              $("#edit_barang_form")[0].reset();
              $("#editBarangModal").modal('hide');
            }else{
                printErrorMsg(response.errors,false);
                $("#edit_barang_btn").text('Update Barang');
              }
          }
        });
      });

      // delete Barang ajax request
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
              url: '{{ route("admin.rusak.delete") }}',
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
                fetchAllBarangs();
              }
            });
          }
        })
      });

      function printErrorMsg (msg,tp) {
        clear();
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

        $("#barcode").removeClass("is-invalid");
        $("#add_barcode").removeClass("is-invalid");
        $("#jumlah").removeClass("is-invalid");
        $("#add_jumlah").removeClass("is-invalid");
    }

      // fetch all Barangs ajax request
      fetchAllBarangs();

      function fetchAllBarangs() {
        $.ajax({
          url: '{{ route('admin.rusak.fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_Barangs").html(response);
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
