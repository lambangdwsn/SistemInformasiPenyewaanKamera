<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function __construct()
  {
      $this->middleware(function ($request, $next) {
        if (Auth::guard('admin')->user()->role === "Admin"){
          return $next($request);
        }else{
          abort(404);
        }
      });
  }
    public function index() {
        
        return view('admin.petugas.index');
        
	}

    public function fetchAll() {
		$petugass = Admin::where('role','Petugas')->get();
        $output ='';
            if ($petugass->count() > 0) {
                $output .= '<table class="table table-striped table-sm text-center align-middle">
                <thead>
                  <tr>
                    <th style="vertical-align: top;">ID</th>
                    <th style="vertical-align: top;">NIP</th>
                    <th style="vertical-align: top;">Nama</th>
                    <th style="vertical-align: top;">Email</th>
                    <th style="vertical-align: top;">Alamat</th>
                    <th style="vertical-align: top;">No Telepon</th>
                <th id="no_sort" style="vertical-align: top;">Action</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($petugass as $petugas) {
                    $output .= '<tr>
                    <td>' . $petugas->id . '</td>
                    <td>' . $petugas->NIP . '</td>
                    <td>' . $petugas->name . '</td>
                    <td>' . $petugas->email . '</td>
                    <td>' . $petugas->alamat . '</td>
                    <td>' . $petugas->no_tlp . '</td>
                    <td>
                    <a href="#" id="' . $petugas->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editPetugasModal"><i class="bi-pencil-square h4"></i></a>

                    <a href="#" id="' . $petugas->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            }else {
                echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
            }
        
	}

	// handle insert a new Petugas ajax request
	public function store(Request $request) {
		
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIP' => ['unique:detail_guru,NIP','unique:admins,NIP', 'min:16'],
            ],[
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
		$petugas = new Admin;
        $petugas->name = $request['name'];
        $petugas->email = $request['email'];
        $petugas->password = Hash::make($request['password']);
        $petugas->NIP = $request['NIP'];
        $petugas->alamat = $request['alamat'];
        $petugas->no_tlp = $request['no_tlp'];
        $petugas->save();
        }

		return response()->json([
			'status' => 200,
		]);
	}

    public function edit(Request $request) {
		 $id = $request->id;
         $petugas = Admin::find($id);
         return response()->json($petugas);
	}

    public function update(Request $request) {
        
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,'.$request['petugas_id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIP' => ['unique:admins,NIP,'.$request['petugas_id'],'unique:detail_guru,NIP', 'min:16','nullable'],
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{

        Admin::where('id', $request['petugas_id'])
                    ->update([
                        'name'=> $request['name'],
                        'email'=> $request['email'],
                        'alamat'=> $request['alamat'],
                        'NIP'=> $request['NIP'],
                        'no_tlp'=> $request['no_tlp'],
                    ]);
        
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    public function delete(Request $request) {
		$id = $request->id;
        Admin::destroy($id);
	}
    
}
