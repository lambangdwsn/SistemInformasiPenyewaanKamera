@extends('layouts.AdminMain')
@section('title','Barang '. ucfirst($selector))
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
        <h5 class="modal-title" id="exampleModalLabel">Add New {{ucfirst($selector)}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_barang_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
              <label for="nama">Nama Barang</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
            </div>
          <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" class="form-control" required>
          </div>
          <div class="my-2">
            <label for="harga_siswa">Harga Sewa Siswa</label>
            <input type="number" name="harga_siswa" class="form-control" placeholder="Harga Sewa Siswa" required>
          </div>
          <div class="my-2">
            <label for="harga_alumni">Harga Sewa Alumni</label>
            <input type="number" name="harga_alumni" class="form-control" placeholder="Harga Sewa Alumni" required>
          </div>
          <div class="my-2">
            <label for="harga_guru">Harga Sewa Guru</label>
            <input type="number" name="harga_guru" class="form-control" placeholder="Harga Sewa Guru" required>
          </div>
          <div class="my-2">
            <label for="harga_umum">Harga Sewa Umum</label>
            <input type="number" name="harga_umum" class="form-control" placeholder="Harga Sewa Umum" required>
          </div>
          @foreach($katagori as $option)
                @if($option->katagori === ucfirst($selector))
                <input type="hidden" name="katagori" value="{{$option->id}}">
                @break
                @endif
          @endforeach

          @if($selector === 'kelengkapan')
          <div id="select_kelengkapan_add" class="my-2">
            <label for="kelengkapan">Kelengkapan untuk:</label><br>
            <select name="kelengkapan" id="kelengkapan_add" class="form-control">
            <option value="0" selected="selected">Bukan Kelengkapan Apapun</option>
            @foreach($barang as $option)
              <option value="{{$option->id}}">{{$option->nama}}</option>
            @endforeach
            </select>
          </div>
          @else
          <input type="hidden" name="kelengkapan" value="0">
          @endif

          <div class="my-2">
            <label for="Lokasi">Pilih Lokasi Penyimpanan:</label><br>
            <select name="lokasi" class="form-control">
            @foreach($lokasi as $option)
              <option value="{{$option->id}}">{{$option->lokasi}}</option>
            @endforeach
            </select>
          </div>
          <div class="my-2">
            <label for="merk">Merk</label>
            <input type="text" name="merk" class="form-control" placeholder="Merk">
          </div>
          <div class="my-2">
            <label for="jumlah">Jumlah Barang</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Jumlah Barang" required>
          </div>
          <div class="my-2">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control" cols="30" rows="10" placeholder="Keterangan"></textarea>
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
        <input type="hidden" name="barang_image" id="barang_image">
        <div class="modal-body p-4 bg-light">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="nama">Nama Barang</label>
              <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Barang" required>
            </div>
            <div class="col-lg">
              <label for="barcode">Kode barcode</label>
              <input type="number" id="barcode" name="barcode" class="form-control" placeholder="Kode Barcode" required>
            </div>
          </div>
          <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" class="form-control" >
          </div>
          <div class="mt-2" id="image">

          </div>
          <div class="my-2">
            <label for="harga_siswa">Harga Sewa Siswa</label>
            <input type="number" id="harga_siswa" name="harga_siswa" class="form-control" placeholder="Harga Sewa Siswa" required>
          </div>
          <div class="my-2">
            <label for="harga_alumni">Harga Sewa Alumni</label>
            <input type="number" id="harga_alumni" name="harga_alumni" class="form-control" placeholder="Harga Sewa Alumni" required>
          </div>
          <div class="my-2">
            <label for="harga_guru">Harga Sewa Guru</label>
            <input type="number" id="harga_guru" name="harga_guru" class="form-control" placeholder="Harga Sewa Guru" required>
          </div>
          <div class="my-2">
            <label for="harga_umum">Harga Sewa Umum</label>
            <input type="number" id="harga_umum" name="harga_umum" class="form-control" placeholder="Harga Sewa Umum" required>
          </div>
          <div class="my-2">
            <label for="katagori">Pilih Katagori:</label><br>
            <select name="katagori" id="katagori_edit" class="form-control">
            <option value="0">Tanpa Katagori</option>
            @foreach($katagori as $option)
              <option value="{{$option->id}}">{{$option->katagori}}</option>
            @endforeach
            </select>
          </div>
          <div id="select_kelengkapan_edit" class="my-2">
            <label for="kelengkapan">Kelengkapan untuk:</label><br>
            <select name="kelengkapan" id="kelengkapan_edit" class="form-control">
            <option value="0" selected="selected">Bukan Kelengkapan Apapun</option>
            @foreach($barang as $option)
              <option value="{{$option->id}}">{{$option->nama}}</option>
            @endforeach
            </select>
          </div>
          <div class="my-2">
            <label for="Lokasi">Pilih Lokasi Penyimpanan:</label><br>
            <select name="lokasi" id="lokasi" class="form-control">
            @foreach($lokasi as $option)
              <option value="{{$option->id}}">{{$option->lokasi}}</option>
            @endforeach
            </select>
          </div>
          <div class="my-2">
            <label for="merk">Merk</label>
            <input type="text" id="merk" name="merk" class="form-control" placeholder="Merk">
            {{-- type=tel untuk telepon --}}
          </div>
          <div class="my-2">
            <label for="jumlah">Jumlah Barang</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah Barang" required>
          </div>
          <div class="my-2">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10" placeholder="Keterangan"></textarea>
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
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_barang_btn" class="btn btn-success">Update Barang</button>
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
            <h3 class="text-light">Majemen Barang {{ucfirst($selector)}}</h3>
            <a href="{{ route("admin.katagori.index") }}" class="btn btn-light"><i class="bi bi-funnel"></i>Katagori</a>
            <a href="{{ route("admin.lokasi.index") }}" class="btn btn-light"><i class="bi bi-geo-alt me-2"></i>Lokasi</a>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBarangModal"><i
                class="bi-plus-circle me-2"></i>Add New {{ucfirst($selector)}}</button>
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
      // add new barang ajax request
      $("#add_barang_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_barang_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.barang.store") }}',
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
            }
            $("#add_barang_btn").text('Add Barang');
            $("#add_barang_form")[0].reset();
            $("#addBarangModal").modal('hide');
          }
        });
      });

      // edit Barang ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.barang.edit") }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#nama").val(response.nama);
            $("#barcode").val(response.barcode);
            $("#harga_siswa").val(response.harga_siswa);
            $("#harga_alumni").val(response.harga_alumni);
            $("#harga_guru").val(response.harga_guru);
            $("#harga_umum").val(response.harga_umum);
            $("#image").html(
              `<img src="../../storage/images/${response.image}" width="100" class="img-fluid img-thumbnail">`);
            let id_katagori='';
            if(response.id_katagori == null){
              id_katagori='0';
            }else{
              id_katagori=response.id_katagori;
            }
            $("#katagori_edit option:selected").prop("selected",false);
            $("#katagori_edit option[value=" + id_katagori + "]").prop("selected",true);
            let id_kelengkapan='';
            if(response.id_kelengkapan == null){
              id_kelengkapan='0';
            }else{
              id_kelengkapan=response.id_kelengkapan;
            }
            $("select[id=katagori_edit]").trigger("change"); 
            $("#kelengkapan_edit option:selected").prop("selected",false);
            $("#kelengkapan_edit").children("option[value^=" + response.id + "]").hide();
            $("#kelengkapan_edit option[value=" + id_kelengkapan + "]").prop("selected",true);
            $("#lokasi option:selected").prop("selected",false);
            $("#lokasi option[value=" + response.lokasi + "]").prop("selected",true);
            $("#merk").val(response.merk);
            $("#jumlah").val(response.jumlah);
            $("#keterangan").val(response.keterangan);
            $("#status_tampil_ya").filter('[value="'+response.status_tampil+'"]').prop('checked', true);
            $("#status_tampil_tidak").filter('[value="'+response.status_tampil+'"]').prop('checked', true);
            $("#barang_id").val(response.id);
            $("#barang_image").val(response.image);
          }
        });
      });

      // update Barang ajax request
      $("#edit_barang_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_barang_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.barang.update") }}',
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
            }
            $("#edit_barang_btn").text('Update Barang');
            $("#edit_barang_form")[0].reset();
            $("#editBarangModal").modal('hide');
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
              url: '{{ route("admin.barang.delete") }}',
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

      // fetch all Barangs ajax request
      fetchAllBarangs();

      function fetchAllBarangs() {
        $.ajax({
          url: '{{ route('admin.barang.fetchKatagori', ['katagori' => $selector]) }}',
          method: 'get',
          success: function(response) {
            $("#show_all_Barangs").html(response);
            $("table").DataTable({
              dom: "<'row py-2'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>tip",
              buttons: [ 
                { "text":'<i class="fa-solid fa-barcode mr-2"></i>Barcode',"className": 'btn btn-sm', "action": function (){window.location.href='{{url(route('admin.barang.barcode',['type'=> $selector]))}}'}},
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
