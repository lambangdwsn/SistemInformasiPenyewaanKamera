<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProgramKeahlian;
use App\Models\DetailSiswa;
use App\Models\DetailAlumni;
use App\Models\DetailGuru;
use App\Models\DetailUmum;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        $selector = request()->route('role');
        if($selector === 'siswa' || $selector === 'alumni'){
        $program = ProgramKeahlian::all();
        return view('admin.user.index', compact('selector', 'program'));
        }elseif($selector === 'guru' || $selector === 'umum'){
            return view('admin.user.index', compact('selector'));
        }else{
            abort(404);
        }
	}

    public function fetchAll() {
		$selector = request()->route('role');
        $output = '<table class="table table-striped table-sm text-center align-middle">
        <thead>
          <tr>
            <th style="vertical-align: top;">ID</th>
            <th style="vertical-align: top;">Nama</th>
            <th style="vertical-align: top;">Email</th>
            <th style="vertical-align: top;">Jenis Kelamin</th>
            <th style="vertical-align: top;">Alamat</th>
            <th style="vertical-align: top;">No Telepon</th>';
        if(ucfirst($selector) === 'Siswa'){
            $users = User::leftJoin('detail_siswa', 'users.id','=','detail_siswa.id_siswa')
            ->leftJoin('program_keahlian', 'detail_siswa.id_program_keahlian','=','program_keahlian.id')
            ->where('role','=','Siswa')->get(['users.id as uuid','users.*','detail_siswa.*','program_keahlian.*']);
            
            

            if ($users->count() > 0) {
                $output .= '<th style="vertical-align: top;">NIS</th>
                <th style="vertical-align: top;">Program Keahlian</th>
                <th style="vertical-align: top;">Kelas</th>
                <th id="no_sort" style="vertical-align: top;">Action</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($users as $user) {
                    $user->id = $user->uuid;
                    $output .= '<tr>
                    <td>' . $user->id . '</td>
                    <td>' . $user->name . '</td>
                    <td>' . $user->email . '</td>
                    <td>' . $user->jenis_kelamin . '</td>
                    <td>' . $user->alamat . '</td>
                    <td>' . $user->no_tlp . '</td>
                    <td>' . $user->NIS . '</td>
                    <td>' . $user->nama_program . '</td>
                    <td>' . $user->Kelas . '</td>
                    <td>
                    <a href="#" id="' . $user->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editUserModal"><i class="bi-pencil-square h4"></i></a>

                    <a href="#" id="' . $user->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            }else {
                echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
            }
        }else if( ucfirst($selector) === 'Alumni'){
            $users = User::leftJoin('detail_alumni', 'users.id','=','detail_alumni.id_alumni')
            ->leftJoin('program_keahlian', 'detail_alumni.id_program_keahlian','=','program_keahlian.id')
            ->where('role','=','alumni')->get(['users.id as uuid','users.*','detail_alumni.*','program_keahlian.*']);
             

            if ($users->count() > 0) {
                $output .= '<th style="vertical-align: top;">NIK</th>
                <th style="vertical-align: top;">Program Keahlian</th>
                <th style="vertical-align: top;">Tahun Lulus</th>
                <th id="no_sort" style="vertical-align: top;">Action</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($users as $user) { 
                    $user->id = $user->uuid;
                    $output .= '<tr>
                    <td>' . $user->id . '</td>
                    <td>' . $user->name . '</td>
                    <td>' . $user->email . '</td>
                    <td>' . $user->jenis_kelamin . '</td>
                    <td>' . $user->alamat . '</td>
                    <td>' . $user->no_tlp . '</td>
                    <td>' . $user->NIK . '</td>
                    <td>' . $user->nama_program . '</td>
                    <td>' . $user->tahun_lulus . '</td>
                    <td>
                    <a href="#" id="' . $user->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editUserModal"><i class="bi-pencil-square h4"></i></a>

                    <a href="#" id="' . $user->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            }else {
                echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
            }
        }else if( ucfirst($selector) === 'Guru'){
            $users = User::leftJoin('detail_guru', 'users.id','=','detail_guru.id_guru')
            ->where('role','=','guru')->get(['users.id as uuid','users.*','detail_guru.*']);
             

            if ($users->count() > 0) {
                $output .= '<th style="vertical-align: top;">NIP</th>
                <th style="vertical-align: top;">Bidang Keahlian</th>
                <th style="vertical-align: top;">Jabatan</th>
                <th id="no_sort" style="vertical-align: top;">Action</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($users as $user) { 
                    $user->id = $user->uuid;
                    $output .= '<tr>
                    <td>' . $user->id . '</td>
                    <td>' . $user->name . '</td>
                    <td>' . $user->email . '</td>
                    <td>' . $user->jenis_kelamin . '</td>
                    <td>' . $user->alamat . '</td>
                    <td>' . $user->no_tlp . '</td>
                    <td>' . $user->NIP . '</td>
                    <td>' . $user->bidang_keahlian . '</td>
                    <td>' . $user->jabatan . '</td>
                    <td>
                    <a href="#" id="' . $user->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editUserModal"><i class="bi-pencil-square h4"></i></a>

                    <a href="#" id="' . $user->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            }else {
                echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
            }
        }else if( ucfirst($selector) === 'Umum'){
            $users = User::leftJoin('detail_umum', 'users.id','=','detail_umum.id_umum')
            ->where('role','=','umum')->get(['users.id as uuid','users.*','detail_umum.*']);
             
            if ($users->count() > 0) {
                $output .= '<th style="vertical-align: top;">NIK</th>
                <th id="no_sort" style="vertical-align: top;">Action</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($users as $user) { 
                    $user->id = $user->uuid;
                    $output .= '<tr>
                    <td>' . $user->id . '</td>
                    <td>' . $user->name . '</td>
                    <td>' . $user->email . '</td>
                    <td>' . $user->jenis_kelamin . '</td>
                    <td>' . $user->alamat . '</td>
                    <td>' . $user->no_tlp . '</td>
                    <td>' . $user->NIK . '</td>
                    <td>
                    <a href="#" id="' . $user->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editUserModal"><i class="bi-pencil-square h4"></i></a>

                    <a href="#" id="' . $user->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            }else {
                echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
            }
        }else{
            abort(404);
        }
        
	}

	// handle insert a new user ajax request
	public function store(Request $request) {
		
        $selector = request()->route('role');
        if(ucfirst($selector) === 'Siswa'){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIS' => ['required','unique:detail_siswa', 'min:4','max:5']
            ],[
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        }else if(ucfirst($selector) === "Alumni"){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIK' => ['unique:detail_alumni,NIK','unique:detail_umum,NIK', 'min:16','nullable'],
                'tahun_lulus' => ['required','min:4','max:4','regex:/(19[0-9]{2}|20[0-9]{2})/'],
            ],[
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        }else if(ucfirst($selector) === "Guru"){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIP' => ['unique:detail_guru,NIP', 'min:18'],
                'jabatan' => ['required', 'min:2','regex:/^([a-zA-Z0-9 ]|-)*$/'],
                'bidang_keahlian' => ['required', 'min:2','regex:/^([a-zA-Z0-9 ]|-)*$/'],
            ],[
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        }else if(ucfirst($selector) === "Umum"){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIK' => ['unique:detail_alumni,NIK','unique:detail_umum,NIK', 'min:16','nullable'],
            ],[
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        }

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
		$user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->role = ucfirst($selector);
        $user->jenis_kelamin = $request['kelamin'];
        $user->alamat = $request['alamat'];
        $user->no_tlp = $request['no_tlp'];
        $user->save();

        if(ucfirst($selector) === 'Siswa'){
            $detailSiswa = new DetailSiswa;
            $detailSiswa->id_siswa = $user->id;
            $detailSiswa->NIS = $request['NIS'];
            $detailSiswa->id_program_keahlian = $request['program'];
            $detailSiswa->Kelas = $request['Kelas'];
            $detailSiswa->save();
        }else if(ucfirst($selector) === 'Alumni'){
            $detailAlumni = new DetailAlumni;
            $detailAlumni->id_alumni = $user->id;
            $detailAlumni->NIK = $request['NIK'];
            $detailAlumni->id_program_keahlian = $request['program'];
            $detailAlumni->tahun_lulus = $request['tahun_lulus'];
            $detailAlumni->save();
        }else if(ucfirst($selector) === 'Guru'){
            $detailGuru = new DetailGuru;
            $detailGuru->id_guru = $user->id;
            $detailGuru->NIP = $request['NIP'];
            $detailGuru->bidang_keahlian = $request['bidang_keahlian'];
            $detailGuru->jabatan = $request['jabatan'];
            $detailGuru->save();
        }else if(ucfirst($selector) === 'Umum'){
            $detailUmum = new DetailUmum;
            $detailUmum->id_umum = $user->id;
            $detailUmum->NIK = $request['NIK'];
            $detailUmum->save();
        }
        }

		return response()->json([
			'status' => 200,
		]);
	}

    public function edit(Request $request) {
        $selector = request()->route('role');
		 $id = $request->id;
         if($selector === 'siswa'){
             $user = User::leftJoin('detail_siswa', 'users.id','=','detail_siswa.id_siswa')->where('users.id','=',$id)->first();
         }elseif($selector === 'alumni'){
            $user = User::leftJoin('detail_alumni', 'users.id','=','detail_alumni.id_alumni')->where('users.id','=',$id)->first();
        }elseif($selector === 'guru'){
            $user = User::leftJoin('detail_guru', 'users.id','=','detail_guru.id_guru')->where('users.id','=',$id)->first();
        }elseif($selector === 'umum'){
            $user = User::leftJoin('detail_umum', 'users.id','=','detail_umum.id_umum')->where('users.id','=',$id)->first();
        }else {
             abort(404);
         }
		 return response()->json($user);
	}

    public function update(Request $request) {
        $selector = request()->route('role');
        
        if(ucfirst($selector) === 'Siswa'){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request['user_id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIS' => ['required','unique:detail_siswa,NIS,'.$request['user_id'].',id_siswa', 'min:4','max:5']
            ]
            ,
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
            ]
        );
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{

            if(DetailSiswa::where('id_siswa', $request['user_id'])->exists()){
                DetailSiswa::where('id_siswa', $request['user_id'])
                    ->update([
                        'id_program_keahlian'=> $request['program'],
                        'NIS'=> $request['NIS'],
                        'Kelas'=> $request['Kelas']
                    ]);
            }else {
                DetailSiswa::Create([
                        'id_siswa' => $request['user_id'],
                        'id_program_keahlian'=> $request['program'],
                        'NIS'=> $request['NIS'],
                        'Kelas'=> $request['Kelas']
                    ]);
            }
            }
        }else if($selector === "alumni"){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request['user_id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIK' => ['unique:detail_alumni,NIK,'.$request['user_id'].',id_alumni','unique:detail_umum,NIK', 'min:16','nullable'],
                'tahun_lulus' => ['required','min:4','max:4','regex:/(19[0-9]{2}|20[0-9]{2})/'],
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
            if(DetailAlumni::where('id_alumni', $request['user_id'])->exists()){
                DetailAlumni::where('id_alumni', $request['user_id'])
                    ->update([
                        'id_program_keahlian'=> $request['program'],
                        'NIK'=> $request['NIK'],                        
                        'tahun_lulus'=> $request['tahun_lulus'],                        
                    ]);
            }else {
                DetailAlumni::Create([
                        'id_alumni' => $request['user_id'],
                        'id_program_keahlian'=> $request['program'],
                        'NIK'=> $request['NIK'],                        
                        'tahun_lulus'=> $request['tahun_lulus'],                        
                    ]);
            }
        }
        }else if($selector === "guru"){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request['user_id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIP' => ['unique:detail_guru,NIP,'.$request['user_id'].',id_guru', 'min:18'],
                'jabatan' => ['required', 'min:2','regex:/^([a-zA-Z0-9 ]|-)*$/'],
                'bidang_keahlian' => ['required', 'min:2','regex:/^([a-zA-Z0-9 ]|-)*$/'],
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
            if(DetailGuru::where('id_guru', $request['user_id'])->exists()){
                DetailGuru::where('id_guru', $request['user_id'])
                    ->update([                        
                        'NIP'=> $request['NIP'],
                        'bidang_keahlian'=> $request['bidang_keahlian'],
                        'jabatan'=> $request['jabatan'],
                    ]);
            }else {
                DetailGuru::Create([
                        'id_guru' => $request['user_id'],                        
                        'NIP'=> $request['NIP'],
                        'bidang_keahlian'=> $request['bidang_keahlian'],
                        'jabatan'=> $request['jabatan'],
                    ]);
            }
        }
        }else if($selector === "umum"){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request['user_id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIK' => ['unique:detail_alumni,NIK','unique:detail_umum,NIK,'.$request['user_id'].',id_umum', 'min:16','nullable'],
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
            if(DetailUmum::where('id_umum', $request['user_id'])->exists()){
                DetailUmum::where('id_umum', $request['user_id'])
                    ->update([                        
                        'NIK'=> $request['NIK'],                        
                    ]);
            }else {
                DetailUmum::Create([
                        'id_umum' => $request['user_id'],                        
                        'NIK'=> $request['NIK'],                        
                    ]);
            }
        }
        }

        User::where('id', $request['user_id'])
                    ->update([
                        'name'=> $request['name'],
                        'email'=> $request['email'],
                        'jenis_kelamin'=> $request['kelamin'],
                        'alamat'=> $request['alamat'],
                        'no_tlp'=> $request['no_tlp'],
                    ]);
        
            return response()->json([
                'status' => 200,
            ]);
    
     
	}

    public function delete(Request $request) {
		$id = $request->id;
        User::destroy($id);
	}
    
}
