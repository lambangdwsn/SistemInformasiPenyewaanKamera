<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class DisewaController extends Controller
{
    public function index() {
		$user = User::get(['users.email']);
		$siswa = User::where('role','Siswa')->get(['users.email','users.role']);
		return view('admin.penyewaan.disewa', compact('user','siswa'));
	}

    public function fetchAll() {
		$penyewaans = Sewa::selectRaw("
		sewa.id,
        users.name,
        users.email,
        users.alamat,
        users.no_tlp,
        users.role,
		barang.nama as 'nama_barang',
		IF(sewa.keperluan ='Pribadi',
			IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
		IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'harga_satuan',
		sewa.jumlah,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa) as 'lama',
		IF(sewa.keperluan ='Pribadi',datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa)*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
           IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'total_harga',
           sewa.tgl_sewa, sewa.tgl_harus_kembali,sewa.keterangan_sewa as 'keterangan',sewa.keperluan")
		->Join('users','sewa.id_user','=','users.id')
		->Join('barang','sewa.id_barang','=','barang.id')
		->where('status_acc','disewa')
		->get();
		
		$output = '';
		if ($penyewaans->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle" style="font-size: 12px;">
            <thead>
              <tr>
                <th style="vertical-align: top;">Nama Penyewa</th>
                <th style="vertical-align: top;">Email</th>
                <th style="vertical-align: top;">Alamat</th>
                <th style="vertical-align: top;">No. Telepon</th>
                <th style="vertical-align: top;">Status User</th>
                <th style="vertical-align: top;">Nama Barang</th>
                <th style="vertical-align: top;">Harga Satuan</th>
                <th style="vertical-align: top;">Jumlah</th>
                <th style="vertical-align: top;">Lama Hari</th>
                <th style="vertical-align: top;">Total Harga</th>
                <th style="vertical-align: top;">Tanggal Sewa</th>
                <th style="vertical-align: top;">Tanggal Harus Kembali</th>
                <th style="vertical-align: top;">Keperluan</th>
                <th style="vertical-align: top;">Keterangan</th>';
				if (Auth::guard('admin')->user()->role === "Admin"){
				$output .='<th id="no_sort" style="vertical-align: top;">Action</th>';
				}
				$output .='</tr></thead><tbody>';
			foreach ($penyewaans as $penyewaan) { 
				$output .= '<tr>
				<td>' . $penyewaan->name . '</td>
				<td>' . $penyewaan->email . '</td>
				<td>' . $penyewaan->alamat . '</td>
				<td>' . $penyewaan->no_tlp . '</td>
				<td>' . $penyewaan->role . '</td>
				<td>' . $penyewaan->nama_barang . '</td>
				<td>' . $penyewaan->harga_satuan . '</td>
				<td>' . $penyewaan->jumlah . '</td>
				<td>' . $penyewaan->lama . '</td>
				<td>' . $penyewaan->total_harga . '</td>
				<td>' . $penyewaan->tgl_sewa . '</td>
				<td>' . $penyewaan->tgl_harus_kembali . '</td>
				<td>' . $penyewaan->keperluan . '</td>
				<td>' . $penyewaan->keterangan . '</td>';
				if (Auth::guard('admin')->user()->role === "Admin"){
                $output .='<td>
                  <a href="#" id="' . $penyewaan->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editSewaModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $penyewaan->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>';
				}
              $output .='</tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	public function store(Request $request) {
		if (Auth::guard('admin')->user()->role === "Admin"){
			$validator = Validator::make($request->all(), [
				'email' => ['required', 'exists:App\Models\User,email'],
				'barcode' => ['required', 'exists:App\Models\Barang,barcode'],
				'jumlah' => ['required', 'regex:/^([1-9]|[1-9][0-9]+)*$/'],
				'tgl_sewa' => ['required'],
				'tgl_harus_kembali' => ['required','after_or_equal:tgl_sewa']
			]);
			if ($validator->fails()){
				return response()->json(['errors' => $validator->errors()]);
			}else{
			
			$keperluan = is_null($request->keperluan) ? 'Pribadi' : $request->keperluan;
			$user_id = User::where('email',$request->email)->pluck('id')->first();
			$id_barang = Barang::where('barcode',$request->barcode)->pluck('id')->first();
			$jumlah_barang = Barang::where('barcode',$request->barcode)->pluck('jumlah')->first();
			$barang_disewa = Sewa::selectRaw('sum(jumlah) as total')
			->where('id_barang',$id_barang)
			->where('status_acc','disewa')->pluck('total')->first();

			if((int) $request->jumlah <= ((int) $jumlah_barang - (int) $barang_disewa)){
			$penyewaanData = [
				'id_user' => $user_id,
				'id_barang' => $id_barang,
				'jumlah' => $request->jumlah,
				'tgl_sewa' => $request->tgl_sewa,
				'keperluan' => $keperluan,
				'tgl_harus_kembali' => $request->tgl_harus_kembali,
				'keterangan_sewa' => $request->keterangan,
				'status_acc' => 'disewa',
			];
			Sewa::create($penyewaanData);
			return response()->json([
				'status' => 200,
			]);
			}else{
				return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
			}
			}
		}else{
			abort(404);
		}
	}


    public function edit(Request $request) {
		if (Auth::guard('admin')->user()->role === "Admin"){
			$id = $request->id;
			$penyewaan = Sewa::Join('barang', 'sewa.id_barang','=','barang.id')
			->Join('users','sewa.id_user','=','users.id')
			->where('sewa.id',$id)
			->get(['sewa.id','sewa.id_user','sewa.jumlah','sewa.tgl_sewa','sewa.tgl_harus_kembali','sewa.keperluan','sewa.keterangan_sewa','barang.barcode','users.role'])->first();
			return response()->json($penyewaan);
		}else{
			abort(404);
		}
	}

    public function update(Request $request) {
		if (Auth::guard('admin')->user()->role === "Admin"){
			$validator = Validator::make($request->all(), [
				'barcode' => ['required', 'exists:App\Models\Barang,barcode'],
				'jumlah' => ['required', 'regex:/^([1-9]|[1-9][0-9]+)*$/'],
				'tgl_sewa' => ['required'],
				'tgl_harus_kembali' => ['required','after_or_equal:tgl_sewa']
			]);
			if ($validator->fails()){
				return response()->json(['errors' => $validator->errors()]);
			}else{
					
			$id_barang = Barang::where('barcode',$request->barcode)->pluck('id')->first();
			$keperluan = is_null($request->keperluan) ? 'Pribadi' : $request->keperluan;
			
			$jumlah_barang = Barang::where('barcode',$request->barcode)->pluck('jumlah')->first();
			$barang_disewa = Sewa::selectRaw('sum(jumlah) as total')
			->where('id_barang',$id_barang)
			->where('id','!=',$request->sewa_id)
			->where('status_acc','disewa')->pluck('total')->first();
			
			if((int) $request->jumlah <= ((int) $jumlah_barang - (int) $barang_disewa)){
			$penyewaanData = [
				'id_barang' => $id_barang,
				'jumlah'  => $request->jumlah,
				'tgl_sewa' => $request->tgl_sewa,
				'tgl_harus_kembali' => $request->tgl_harus_kembali,
				'keperluan' => $keperluan,
				'keterangan_sewa' => $request->keterangan,
			];
			
			$penyewaan = Sewa::find($request->sewa_id);
			$penyewaan->update($penyewaanData);
			return response()->json([
				'status' => 200,
			]);
			}else{
				return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
			}
			}
		}else{
			abort(404);
		}
	}

    public function delete(Request $request) {
		if (Auth::guard('admin')->user()->role === "Admin"){
			$id = $request->id;
			Sewa::destroy($id);
		}else{
			abort(404);
		}
	}
    
}
