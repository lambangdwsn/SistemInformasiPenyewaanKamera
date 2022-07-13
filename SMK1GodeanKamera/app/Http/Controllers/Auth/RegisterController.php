<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\ProgramKeahlian;
use App\Models\DetailSiswa;
use App\Models\DetailAlumni;
use App\Models\DetailGuru;
use App\Models\DetailUmum;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm($role){
        $program = ProgramKeahlian::all();
        if($role === 'siswa'){
            return view('auth.register.siswa', compact('program'));
        }elseif($role === 'alumni'){
            return view('auth.register.alumni', compact('program'));
        }elseif($role === 'guru'){
            return view('auth.register.guru');
        }elseif($role === 'umum'){
            return view('auth.register.umum');
        }else {
            abort(404);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        if($data['role'] === 'Siswa'){
            return Validator::make($data, [
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
        }else if($data['role'] === "Alumni"){
            return Validator::make($data, [
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
        }else if($data['role'] === "Guru"){
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIP' => ['unique:detail_guru,NIP', 'min:18'],
                'jabatan' => ['required', 'min:2','regex:/^([a-zA-Z0-9]|-)*$/'],
                'bidang_keahlian' => ['required', 'min:2','regex:/^([a-zA-Z0-9., ]|-)*$/'],
            ],[
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);
        }else if($data['role'] === "Umum"){
            return Validator::make($data, [
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
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role = $data['role'];
        $user->jenis_kelamin = $data['kelamin'];
        $user->alamat = $data['alamat'];
        $user->no_tlp = $data['no_tlp'];
        $user->save();

        if($data['role'] === 'Siswa'){
            $detailSiswa = new DetailSiswa;
            $detailSiswa->id_siswa = $user->id;
            $detailSiswa->NIS = $data['NIS'];
            $detailSiswa->id_program_keahlian = $data['program'];
            $detailSiswa->Kelas = $data['Kelas'];
            $detailSiswa->save();
        }else if($data['role'] === 'Alumni'){
            $detailAlumni = new DetailAlumni;
            $detailAlumni->id_alumni = $user->id;
            $detailAlumni->NIK = $data['NIK'];
            $detailAlumni->id_program_keahlian = $data['program'];
            $detailAlumni->tahun_lulus = $data['tahun_lulus'];
            $detailAlumni->save();
        }else if($data['role'] === 'Guru'){
            $detailGuru = new DetailGuru;
            $detailGuru->id_guru = $user->id;
            $detailGuru->NIP = $data['NIP'];
            $detailGuru->bidang_keahlian = $data['bidang_keahlian'];
            $detailGuru->jabatan = $data['jabatan'];
            $detailGuru->save();
        }else if($data['role'] === 'Umum'){
            $detailUmum = new DetailUmum;
            $detailUmum->id_umum = $user->id;
            $detailUmum->NIK = $data['NIK'];
            $detailUmum->save();
        }

        return $user;
    }
}
