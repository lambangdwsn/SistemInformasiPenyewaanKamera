@extends('layouts.AdminMain')
@section('title','User Account '. ucfirst($selector))
@section('head')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" />

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection

@section('container')
{{-- add new user modal start --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="add_user_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
              <label for="name">Nama</label>
              <input type="text" id="name_add" name="name" class="form-control" placeholder="Nama User" >
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
            <label for="kelamin">Jenis Kelamin</label><br>
            <label>
              <input type="radio" name="kelamin" value="laki-laki" required="required"> laki-laki
            </label><br>
            <label>
              <input type="radio" name="kelamin" value="perempuan"> perempuan
            </label><br>
          </div>
          <div class="my-2">
              <label for="Email">Alamat</label>
              <textarea id="add_alamat" name="alamat" class="form-control" cols="30" rows="3" placeholder="Alamat Lengkap" required="required"></textarea>
              <span id="error_add_alamat" class="invalid-feedback d-block" role="alert">
              
              </span>
           </div>
          @if($selector === 'siswa')
          <div class="my-2">
              <label for="NIS">NIS</label>
              <input type="text" id="add_NIS" name="NIS" class="form-control" placeholder="NIS" onkeypress="return isNumberKey(event)">
              <span id="error_add_NIS" class="invalid-feedback d-block" role="alert">
              
              </span>
          </div>
          @endif

          @if($selector === 'alumni' || $selector === 'umum')
          <div class="my-2">
              <label for="NIK">NIK</label>
              <input id="add_NIK" type="text" class="form-control" onkeypress="return isNumberKey(event)" name="NIK" autocomplete="NIK" maxlength="16">
              <span id="error_add_NIK" class="invalid-feedback d-block" role="alert">
              
              </span>
          </div>
          @endif
          
          @if($selector === 'siswa' || $selector === 'alumni')
          <div class="my-2">
            <label for="program">Program Keahlian</label>
            <select name="program" class="form-control">
              @foreach($program as $option)
              <option value="{{$option->id}}">{{$option->nama_program}}</option>
              @endforeach
            </select>
          </div>
          @endif
          
          @if($selector === 'alumni')
          <div class="my-2">
            <label for="tahun_lulus">Tahun Lulus</label>
            <input id="add_tahun_lulus" type="text" class="form-control" onkeypress="return isNumberKey(event)" name="tahun_lulus" required autocomplete="tahun_lulus" maxlength="4">
            <span id="error_add_tahun_lulus" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          @endif
          @if($selector === 'guru')
          <div class="my-2">
            <label for="add_NIP">NIP</label>
            <input id="add_NIP" type="text" class="form-control" name="NIP" onkeypress="return isNumberKey(event)" required autocomplete="NIP" maxlength="18">
            <span id="error_add_NIP" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          <div class="my-2">
            <label for="add_bidang_keahlian">Bidang Keahlian</label>
            <input id="add_bidang_keahlian" type="text" class="form-control" name="bidang_keahlian" required autocomplete="bidang_keahlian">
            <span id="error_add_bidang_keahlian" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          <div class="my-2">
            <label for="add_jabatan">Jabatan</label>
            <input id="add_jabatan" type="text" class="form-control" name="jabatan" required autocomplete="jabatan">
            <span id="error_add_jabatan" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          @endif

          @if($selector === 'siswa')
          <div class="my-2">
          <label for="Kelas">Kelas</label>
          <select name="Kelas" id="Kelas" class="form-control">
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
          </select>
        </div>
        @endif
        <div class="my-2">
          <label for="no_tlp">No Telepon (WA)</label>
          <input id="add_no_tlp" type="tel" class="form-control" name="no_tlp"  pattern="(08[0-9]{10}|[+][0-9]{13})" required autocomplete="no_tlp" maxlength="14">
          <span id="error_add_no_tlp" class="invalid-feedback d-block" role="alert">
              
          </span>
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_user_btn" class="btn btn-primary">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new user modal end --}}

{{-- edit user modal start --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" id="edit_user_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" id="user_id">
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
              <label for="name">Nama</label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Nama User" >
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
            <label for="kelamin">Jenis Kelamin</label><br>
            <label>
              <input type="radio" id="jkl" name="kelamin" value="laki-laki" required="required"> laki-laki
            </label><br>
            <label>
              <input type="radio" id="jkp" name="kelamin" value="perempuan"> perempuan
            </label><br>
          </div>
          <div class="my-2">
              <label for="Email">Alamat</label>
              <textarea id="alamat" name="alamat" class="form-control" cols="30" rows="3" placeholder="Alamat Lengkap" required="required"></textarea>
              <span id="error_alamat" class="invalid-feedback d-block" role="alert">
              
              </span>
           </div>
          @if($selector === 'siswa')
          <div class="my-2">
              <label for="NIS">NIS</label>
              <input type="text" id="NIS" name="NIS" class="form-control" placeholder="NIS" onkeypress="return isNumberKey(event)">
              <span id="error_NIS" class="invalid-feedback d-block" role="alert">
              
              </span>
          </div>
          @endif

          @if($selector === 'alumni' || $selector === 'umum')
          <div class="my-2">
              <label for="NIK">NIK</label>
              <input id="NIK" type="text" class="form-control" onkeypress="return isNumberKey(event)" name="NIK" autocomplete="NIK" maxlength="16">
              <span id="error_NIK" class="invalid-feedback d-block" role="alert">
              
              </span>
          </div>
          @endif
          
          @if($selector === 'siswa' || $selector === 'alumni')
          <div class="my-2">
            <label for="program">Program Keahlian</label>
            <select name="program" id="program_keahlian" class="form-control">
              @foreach($program as $option)
              <option value="{{$option->id}}">{{$option->nama_program}}</option>
              @endforeach
            </select>
          </div>
          @endif
          
          @if($selector === 'alumni')
          <div class="my-2">
            <label for="tahun_lulus">Tahun Lulus</label>
            <input id="tahun_lulus" type="text" class="form-control" onkeypress="return isNumberKey(event)" name="tahun_lulus" required autocomplete="tahun_lulus" maxlength="4">
            <span id="error_tahun_lulus" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          @endif

          @if($selector === 'guru')
          <div class="my-2">
            <label for="NIP">NIP</label>
            <input id="NIP" type="text" class="form-control" name="NIP" onkeypress="return isNumberKey(event)" required autocomplete="NIP" maxlength="18">
            <span id="error_NIP" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          <div class="my-2">
            <label for="bidang_keahlian">Bidang Keahlian</label>
            <input id="bidang_keahlian" type="text" class="form-control" name="bidang_keahlian" required autocomplete="bidang_keahlian">
            <span id="error_bidang_keahlian" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          <div class="my-2">
            <label for="jabatan">Jabatan</label>
            <input id="jabatan" type="text" class="form-control" name="jabatan" required autocomplete="jabatan">
            <span id="error_jabatan" class="invalid-feedback d-block" role="alert">
              
            </span>
          </div>
          @endif

          @if($selector === 'siswa')
          <div class="my-2">
          <label for="Kelas">Kelas</label>
          <select name="Kelas" id="Kelas" class="form-control">
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
          </select>
        </div>
        @endif
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
          <button type="submit" id="edit_user_btn" class="btn btn-success">Update User</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit user modal end --}}

  <div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow" style="width: 80rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light">Majemen {{ucfirst($selector)}}</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addUserModal"><i
                class="bi-plus-circle me-2"></i>Add New User</button>
          </div>
          <div class="card-body" id="show_all_users">
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
      // add new user ajax request
      $("#add_user_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_user_btn").text('Adding...');
        $.ajax({
          url: '{{ route("admin.user.store",["role" => $selector]) }}',
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
                'User Added Successfully!',
                'success'
              )
              fetchAllUsers();
              $("#add_user_btn").text('Add User');
              $("#add_user_form")[0].reset();
              $("#addUserModal").modal('hide');
            }else{
              printErrorMsg (response.errors,false);
              $("#add_user_btn").text('Add User');
            }
          }
        });
      });

      // edit User ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        clear();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route("admin.user.edit", ["role" => $selector]) }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#user_id").val(response.id);
            $("#name").val(response.name);
            $("#email").val(response.email);
            $("#jkl").filter('[value="'+response.jenis_kelamin+'"]').prop('checked', true);
            $("#jkp").filter('[value="'+response.jenis_kelamin+'"]').prop('checked', true);
            $("#alamat").val(response.alamat);
            $("#no_tlp").val(response.no_tlp);
            @if($selector === 'siswa')
            $("#NIS").val(response.NIS);
            $("#Kelas option:selected").prop("selected",false);
            $("#Kelas option[value=" + response.Kelas + "]").prop("selected",true);
            @endif
            @if($selector === 'siswa' || $selector ==="alumni")
            $("#program_keahlian option:selected").prop("selected",false);
            $("#program_keahlian option[value=" + response.id_program_keahlian + "]").prop("selected",true);
            @endif
            @if($selector === 'umum' || $selector ==="alumni")
            $("#NIK").val(response.NIK);
            @endif
            @if($selector ==="guru")
            $("#NIP").val(response.NIP);
            $("#jabatan").val(response.jabatan);
            $("#bidang_keahlian").val(response.bidang_keahlian);
            @endif
            @if($selector ==="alumni")
            $("#tahun_lulus").val(response.tahun_lulus);
            @endif
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
        @if($selector === 'siswa')
        $("#NIS").removeClass("is-invalid");
        $("#add_NIS").removeClass("is-invalid");
        @endif
        @if($selector === 'alumni' || $selector ==='umum')
        $("#NIK").removeClass("is-invalid");
        $("#add_NIK").removeClass("is-invalid");
        @endif
        @if($selector ==='guru')
        $("#NIP").removeClass("is-invalid");
        $("#add_NIP").removeClass("is-invalid");
        $("#jabatan").removeClass("is-invalid");
        $("#add_jabatan").removeClass("is-invalid");
        $("#bidang_keahlian").removeClass("is-invalid");
        $("#add_bidang_keahlian").removeClass("is-invalid");
        @endif
      }

      // update User ajax request
      $("#edit_user_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_user_btn").text('Updating...');
        $.ajax({
          url: '{{ route("admin.user.update",["role" => $selector]) }}',
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
                'Updated User Successfully!',
                'success'
              )
              fetchAllUsers();
                          
              $("#edit_user_btn").text('Update User');
              $("#edit_user_form")[0].reset();
              $("#editUserModal").modal('hide');
            }else{
              printErrorMsg (response.errors,true);
              $("#edit_user_btn").text('Update User');
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

      

      // delete User ajax request
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
              url: '{{ route("admin.user.delete",["role" => $selector]) }}',
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
                fetchAllUsers();
              }
            });
          }
        })
      });

      // fetch all Users ajax request
      fetchAllUsers();

      function fetchAllUsers() {
        $.ajax({
          url: '{{ route('admin.user.fetchAll',["role" => $selector]) }}',
          method: 'get',
          success: function(response) {
            $("#show_all_users").html(response);
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
