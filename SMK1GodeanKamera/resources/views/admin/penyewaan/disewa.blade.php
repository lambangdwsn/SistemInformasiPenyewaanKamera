@extends('layouts.AdminMain')
@section('title','Proses Sewa Berlangsung')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" />

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')
@if(Auth::guard('admin')->user()->role === "Admin")
{{-- add new sewa modal start --}}
<div class="modal fade" id="addSewaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Sewa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route("admin.disewa.store")}}" method="post" id="add_sewa_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
            <label for="email">Email Penyewa</label>
              <input id="add_email" list="add_allEmail" name="email" class="form-control" placeholder="Email Penyewa" autocomplete="off" autocorrect="off" autofocus="" role="combobox" spellcheck="false" required />
              <datalist id="add_allEmail">
                @foreach($user as $option)
                <option value="{{$option->email}}" />
                @endforeach
              </datalist>
              <span id="error_add_email" class="invalid-feedback d-block" role="alert">

              </span>
              
            </div>
            <div class="my-2">
            <label for="barcode">Kode barcode</label>
              <input type="text" pattern="\d*" id="add_barcode" name="barcode" class="form-control" placeholder="Kode Barcode" required maxlength="6">
              <span id="error_add_barcode" class="invalid-feedback d-block" role="alert">

              </span>
              
            </div>
          <div class="my-2">
            <label for="jumlah">Jumlah Sewa</label>
            <input type="number" id="add_jumlah" name="jumlah" class="form-control" placeholder="Jumlah Sewa" required>
            <span id="error_add_jumlah" class="invalid-feedback d-block" role="alert">
                  
            </span>
          </div>
          <div class="form-group">
            <label >Tanggal Sewa</label>
            <input type="date" id="add_tgl_sewa" name="tgl_sewa" class="form-control">
            <span id="error_add_tgl_sewa" class="invalid-feedback d-block" role="alert">
                  
            </span>
            </div>
            <div class="form-group">
            <label >Tanggal Harus Kembali</label>
            <input type="date" id="add_tgl_harus_kembali" name="tgl_harus_kembali" class="form-control">
            <span id="error_add_tgl_harus_kembali" class="invalid-feedback d-block" role="alert">
                  
            </span>
            </div>
            
            <div id="select_keperluan_add" class="my-2">
            <label for="keperluan">Keperluan</label>
            <select name="keperluan" id="keperluan_add" class="form-control">
              <option value="Pribadi">Pribadi</option>
              <option value="KBM">KBM</option>
              <option value="Lomba">Lomba</option>
            </select>
          </div>
        
          <div class="my-2">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control" cols="30" rows="10" placeholder="Keterangan"></textarea>
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
      <input type="hidden" name="user_id" id="user_id">
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
            <label for="barcode">Kode barcode</label>
              <input type="text" pattern="\d*" id="barcode" name="barcode" class="form-control" placeholder="Kode Barcode" required maxlength="6">
              <span id="error_barcode" class="invalid-feedback d-block" role="alert">

              </span>
              
            </div>
          <div class="my-2">
            <label for="jumlah">Jumlah Sewa</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah Sewa" required>
            <span id="error_jumlah" class="invalid-feedback d-block" role="alert">
                  
            </span>
          </div>
          <div class="form-group">
            <label >Tanggal Sewa</label>
            <input type="date" id="tgl_sewa" name="tgl_sewa" class="form-control">
            <span id="error_tgl_sewa" class="invalid-feedback d-block" role="alert">
                  
            </span>
            </div>
            <div class="form-group">
            <label >Tanggal Harus Kembali</label>
            <input type="date" id="tgl_harus_kembali" name="tgl_harus_kembali" class="form-control">
            <span id="error_tgl_harus_kembali" class="invalid-feedback d-block" role="alert">
                  
            </span>
            </div>
            <div id="keperluan-form" class="my-2">
            <label for="keperluan">Keperluan</label>
            <select id="keperluan" name="keperluan" class="form-control">
              <option value="Pribadi">Pribadi</option>
              <option value="KBM">KBM</option>
              <option value="Lomba">Lomba</option>
            </select>
          </div>
          <div class="my-2">
            <label for="keterangan">Keterangan</label>
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
@endif
<div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 80rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Barang sedang disewa</h3>
            @if(Auth::guard('admin')->user()->role === "Admin")
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addSewaModal"><i
                class="bi-plus-circle me-2"></i>Tambah</button>
            @endif
          </div>
          <div class="card-body">
            <div id="show_all_Sewas">
              <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
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
  @if(Auth::guard('admin')->user()->role === "Admin")  
  $(document).ready(function(){

      $("#add_email").on('input', function () {
      var val = this.value;
      
          @foreach($siswa as $option)
          if(this.value === '{{$option->email}}'){
            $("select[id=keperluan_add]").prop("disabled", false);
            $("div[id=select_keperluan_add]").show();
          }else
          @endforeach
          {
            $('select[id=keperluan_add]').prop('selectedIndex',0);
             $("select[id=keperluan_add]").prop("disabled", true);
             $("div[id=select_keperluan_add]").hide();
          }

  });
});
@endif
    $(function() {
      @if(Auth::guard('admin')->user()->role === "Admin")
      // add new sewa ajax request
      $("#add_sewa_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_sewa_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.disewa.store")}}',
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
        $("#keperluan-form").hide(); 
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.disewa.edit") }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {

            $("#sewa_id").val(id);
            $("#user_id").val(response.id_user);
            $("#barcode").val(response.barcode);
            $("#jumlah").val(response.jumlah);
            $("#tgl_sewa").val(response.tgl_sewa);
            $("#tgl_harus_kembali").val(response.tgl_harus_kembali);
            $("#keterangan").val(response.keterangan_sewa);
            $("#keperluan option:selected").prop("selected",false);
            if(response.role === 'Siswa'){
                $("#keperluan-form").show(); 
            }else{
                $("#keperluan-form").hide(); 
            }
            $("#keperluan option[value=" + response.keperluan + "]").prop("selected",true);
          }
        });
      });

      // update Sewa ajax request
      $("#edit_sewa_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_sewa_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.disewa.update") }}',
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
              url: '{{ route("admin.disewa.delete") }}',
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
        $("#add_email").removeClass("is-invalid");
        $("#jumlah").removeClass("is-invalid");
        $("#add_jumlah").removeClass("is-invalid");
        $("#tgl_sewa").removeClass("is-invalid");
        $("#add_tgl_sewa").removeClass("is-invalid");
        $("#tgl_harus_kembali").removeClass("is-invalid");
        $("#add_tgl_harus_kembali").removeClass("is-invalid");
    }
    @endif
      // fetch all Sewas ajax request
      fetchAllSewas();

      function fetchAllSewas() {
        $.ajax({
          url: '{{ route('admin.disewa.fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_Sewas").html(response);
            $("table").DataTable({
              dom: "<'row py-2'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>tip",
              buttons: [ 
                { "extend": 'copy', "text":'<i class="fa-solid fa-copy"></i>copy',"className": 'btn btn-sm' },
                { "extend": 'excel', "text":'<i class="fa-solid fa-file-excel mr-2"></i>excel',"className": 'btn btn-sm' },
                { "extend": 'pdf', "text":'<i class="fa-solid fa-file-pdf mr-2"></i>pdf',"orientation": 'landscape', "pageSize": 'LEGAL', "className": 'btn btn-sm' },
                { "extend": 'colvis', "text":'Column Visibility',"className": 'btn btn-sm' },
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
              order: [10, 'desc'],
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
