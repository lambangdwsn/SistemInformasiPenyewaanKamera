@extends('layouts.AdminMain')
@section('title','Petugas ')
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" />

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')
{{-- add new petugas modal start --}}
<div class="modal fade" id="addPetugasModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_petugas_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
              <label for="name">Nama</label>
              <input type="text" id="name_add" name="name" class="form-control" placeholder="Nama Petugas" >
          </div>

          <span id="error_add_name" class="invalid-feedback d-block" role="alert">
              
          </span>

          <div class="my-2">
              <label for="Email">Email</label>
              <input type="text" id="email_add" name="email" class="form-control" placeholder="Email" >
              <span id="error_add_email" class="invalid-feedback d-block" role="alert">
                  
              </span> 
          </div>
          <div class="row mb-3">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

              <div class="input-group col-md-6">
                  <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                  <div class="input-group-append">
                  <span id="showPassword" class="btn input-group-text form-control" onClick="eye('password','showPassword')"><i class="fa-solid fa-eye-slash"></i></span>
                  </div>
                  <span id="error_add_password" class="invalid-feedback d-block" role="alert">
                  
                  </span>
              </div>
          </div>

          <div class="row mb-3">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>

              <div class="input-group col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  <div class="input-group-append">
                  <span id="showPasswordConfirm" class="btn input-group-text form-control" onClick="eye('password-confirm','showPasswordConfirm')"><i class="fa-solid fa-eye-slash"></i></span>
                  </div>
                  <span id="error_add_password_confirmation" class="invalid-feedback d-block" role="alert">
                  
                  </span>
              </div>
          </div>

            <script>
                function eye(w,x) {
                var y = document.getElementById(w);
                var z = document.getElementById(x);
                if (y.type === "password") {
                    z.innerHTML  = '<i class="fa-solid fa-eye"></i>';
                    y.type = "text";
                } else {
                    z.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                    y.type = "password";
                }
                }
            </script>
          
          <div class="my-2">
              <label for="Email">Alamat</label>
              <textarea id="add_alamat" name="alamat" class="form-control" cols="30" rows="3" placeholder="Alamat Lengkap" required="required"></textarea>
              <span id="error_add_alamat" class="invalid-feedback d-block" role="alert">
              
              </span>
           </div>
          <div class="my-2">
            <label for="add_NIP">NIP</label>
            <input id="add_NIP" type="text" class="form-control" onkeypress="return isNumberKey(event)" name="NIP" required autocomplete="NIP" maxlength="18">
            <span id="error_add_NIP" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>

          
        <div class="my-2">
          <label for="no_tlp">No Telepon (WA)</label>
          <input id="add_no_tlp" type="tel" class="form-control" name="no_tlp" pattern="(08[0-9]{10}|[+][0-9]{13})" required autocomplete="no_tlp" maxlength="14">
          <span id="error_add_no_tlp" class="invalid-feedback d-block" role="alert">
              
          </span>
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_petugas_btn" class="btn btn-primary">Add Petugas</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new petugas modal end --}}

{{-- edit petugas modal start --}}
<div class="modal fade" id="editPetugasModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="edit_petugas_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="petugas_id" id="petugas_id">
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
              <label for="name">Nama</label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Nama Petugas" >
          </div>

          <span id="error_name" class="invalid-feedback d-block" role="alert">
              
          </span>

          <div class="my-2">
              <label for="Email">Email</label>
              <input type="text" id="email" name="email" class="form-control" placeholder="Email" >
              <span id="error_email" class="invalid-feedback d-block" role="alert">
                  
              </span> 
          </div>
          <div class="my-2">
              <label for="Email">Alamat</label>
              <textarea id="alamat" name="alamat" class="form-control" cols="30" rows="3" placeholder="Alamat Lengkap" required="required"></textarea>
              <span id="error_alamat" class="invalid-feedback d-block" role="alert">
              
              </span>
           </div>
         
          <div class="my-2">
            <label for="NIP">NIP</label>
            <input id="NIP" type="text" class="form-control" name="NIP" onkeypress="return isNumberKey(event)" required autocomplete="NIP" maxlength="18">
            <span id="error_NIP" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          
        <div class="my-2">
          <label for="no_tlp">No Telepon (WA)</label>
          <input id="no_tlp" type="tel" class="form-control" name="no_tlp" pattern="(08[0-9]{10}|[+][0-9]{13})" required autocomplete="no_tlp" maxlength="14">
          <span id="error_no_tlp" class="invalid-feedback d-block" role="alert">
              
          </span>
        </div>

        </div>
        
        <script>
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }  
        </script>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_petugas_btn" class="btn btn-success">Update Petugas</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit petugas modal end --}}

  <div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 80rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Majemen Petugas</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addPetugasModal"><i
                class="bi-plus-circle me-2"></i>Add New Petugas</button>
          </div>
          <div class="card-body" id="show_all_petugass">
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
    $('span[id ^= "error_"]').each(function(key) {
      $( this ).html('');
      });
    }); 

    $(function() {
      // add new petugas ajax request
      $("#add_petugas_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_petugas_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.petugas.store") }}',
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
                'Petugas Added Successfully!',
                'success'
              )
              fetchAllPetugass();
              $("#add_petugas_btn").text('Add Petugas');
              $("#add_petugas_form")[0].reset();
              $("#addPetugasModal").modal('hide');
            }else{
              printErrorMsg (response.errors,false);
              $("#add_petugas_btn").text('Add petugas');
            }
          }
        });
      });

      // edit Petugas ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        clear();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.petugas.edit") }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#petugas_id").val(response.id);
            $("#name").val(response.name);
            $("#email").val(response.email);
            $("#alamat").val(response.alamat);
            $("#no_tlp").val(response.no_tlp);
            $("#NIP").val(response.NIP);
          }
        });
      });

      function clear(){
        
        $('span[id ^= "error_"]').each(function(key) {
        $( this ).html('');
        });
        $('span[id ^= "error_add_"]').each(function(key) {
        $( this ).html('');
        });

        $("#name").removeClass("is-invalid");
        $("#add_name").removeClass("is-invalid");
        $("#email").removeClass("is-invalid");
        $("#add_email").removeClass("is-invalid");
        $("#alamat").removeClass("is-invalid");
        $("#add_alamat").removeClass("is-invalid");
        $("#no_tlp").removeClass("is-invalid");
        $("#add_no_tlp").removeClass("is-invalid");
        $("#NIP").removeClass("is-invalid");
        $("#add_NIP").removeClass("is-invalid");
      }

      // update Petugas ajax request
      $("#edit_petugas_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_petugas_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.petugas.update") }}',
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
                'Updated Petugas Successfully!',
                'success'
              )
              fetchAllPetugass();
                          
              $("#edit_petugas_btn").text('Update Petugas');
              $("#edit_petugas_form")[0].reset();
              $("#editPetugasModal").modal('hide');
            }else{
              printErrorMsg (response.errors,true);
              $("#edit_petugas_btn").text('Update Petugas');
            }
          }
        });
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

      

      // delete Petugas ajax request
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
              url: '{{ route("admin.petugas.delete") }}',
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
                fetchAllPetugass();
              }
            });
          }
        })
      });

      // fetch all Petugass ajax request
      fetchAllPetugass();

      function fetchAllPetugass() {
        $.ajax({
          url: '{{ route('admin.petugas.fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_petugass").html(response);
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
