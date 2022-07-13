<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\ProgramKeahlian;
use App\Models\DetailSiswa;
use App\Models\DetailAlumni;
use App\Models\DetailGuru;
use App\Models\DetailUmum;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $program = ProgramKeahlian::all();
        if(Auth::guard('web')->user()->role === "Siswa"){
            $user = User::leftJoin('detail_siswa', 'users.id','=','detail_siswa.id_siswa')->where('users.id','=',Auth::guard('web')->user()->id)->first();
            return view('auth.profile', compact('program','user'));
        } else if(Auth::guard('web')->user()->role === "Alumni"){
            $user = User::leftJoin('detail_alumni', 'users.id','=','detail_alumni.id_alumni')->where('users.id','=',Auth::guard('web')->user()->id)->first();
            return view('auth.profile', compact('program','user'));
        } else if(Auth::guard('web')->user()->role === "Guru"){
            $user = User::leftJoin('detail_guru', 'users.id','=','detail_guru.id_guru')->where('users.id','=',Auth::guard('web')->user()->id)->first();
            return view('auth.profile', compact('user'));
        } else if(Auth::guard('web')->user()->role === "Umum"){
            $user = User::leftJoin('detail_umum', 'users.id','=','detail_umum.id_umum')->where('users.id','=',Auth::guard('web')->user()->id)->first();
            return view('auth.profile', compact('user'));
        }
    }

    public function update(Request $data)
    {
    if($data['role'] === 'Siswa'){
            $data->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$data['id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIS' => ['required','unique:detail_siswa,NIS,'.$data['id'].',id_siswa', 'min:4','max:5']
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);

            if(DetailSiswa::where('id_siswa', $data['id'])->exists()){
                DetailSiswa::where('id_siswa', $data['id'])
                    ->update([
                        'id_program_keahlian'=> $data['program'],
                        'NIS'=> $data['NIS'],
                        'Kelas'=> $data['Kelas']
                    ]);
            }else {
                DetailSiswa::Create([
                        'id_siswa' => $data['id'],
                        'id_program_keahlian'=> $data['program'],
                        'NIS'=> $data['NIS'],
                        'Kelas'=> $data['Kelas']
                    ]);
            }
        }else if($data['role'] === "Alumni"){
            $data->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$data['id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIK' => ['unique:detail_alumni,NIK,'.$data['id'].',id_alumni','unique:detail_umum,NIK,'.$data['id'].',id_umum', 'min:16','nullable'],
                'tahun_lulus' => ['required','min:4','max:4','regex:/(19[0-9]{2}|20[0-9]{2})/'],
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);

            if(DetailAlumni::where('id_alumni', $data['id'])->exists()){
                DetailAlumni::where('id_alumni', $data['id'])
                    ->update([
                        'id_program_keahlian'=> $data['program'],
                        'NIK'=> $data['NIK'],                        
                        'tahun_lulus'=> $data['tahun_lulus'],                        
                    ]);
            }else {
                DetailAlumni::Create([
                        'id_alumni' => $data['id'],
                        'id_program_keahlian'=> $data['program'],
                        'NIK'=> $data['NIK'],                        
                        'tahun_lulus'=> $data['tahun_lulus'],                        
                    ]);
            }
        }else if($data['role'] === "Guru"){
            $data->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$data['id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIP' => ['unique:detail_guru,NIP,'.$data['id'].',id_guru', 'min:16'],
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);

            if(DetailGuru::where('id_guru', $data['id'])->exists()){
                DetailGuru::where('id_guru', $data['id'])
                    ->update([                        
                        'NIP'=> $data['NIP'],
                        'bidang_keahlian'=> $data['bidang_keahlian'],
                        'jabatan'=> $data['jabatan'],
                    ]);
            }else {
                DetailGuru::Create([
                        'id_guru' => $data['id'],                        
                        'NIP'=> $data['NIP'],
                        'bidang_keahlian'=> $data['bidang_keahlian'],
                        'jabatan'=> $data['jabatan'],
                    ]);
            }
        }else if($data['role'] === "Umum"){
            $data->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$data['id']],                
                'alamat' => ['required','min:10','max:200','regex:/^([a-zA-Z0-9., ]|-)*$/'],
                'no_tlp' => ['required','min:12','max:15'],
    
                'NIK' => ['unique:detail_alumni,NIK,'.$data['id'].',id_alumni','unique:detail_umum,NIK,'.$data['id'].',id_umum', 'min:16','nullable'],
            ],
            [
                'alamat.min' => 'Address is too short, please complete your address',
                'alamat.max' => 'Address is too long, please check your address',
        ]);

            if(DetailUmum::where('id_umum', $data['id'])->exists()){
                DetailUmum::where('id_umum', $data['id'])
                    ->update([                        
                        'NIK'=> $data['NIK'],                        
                    ]);
            }else {
                DetailUmum::Create([
                        'id_umum' => $data['id'],                        
                        'NIK'=> $data['NIK'],                        
                    ]);
            }
        }

        User::where('id', $data['id'])
                    ->update([
                        'name'=> $data['name'],
                        'email'=> $data['email'],
                        'jenis_kelamin'=> $data['kelamin'],
                        'alamat'=> $data['alamat'],
                        'no_tlp'=> $data['no_tlp'],
                    ]);

        return redirect(url(route('profile')))->with('status','Data berhasil diupdate');

    }   
}
