<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use App\Models\User;
use App\Models\Kontak;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index() {
		$users = User::Join('sewa','users.id','=','sewa.id_user')->where('sewa.status_acc','disewa')->distinct()->get(['users.*']);
		$route ='admin.pengembalian.process';
		return view('admin.user.select', compact('users','route'));
	}

    public function process($user_id) {
		$user = User::where('id',$user_id)->first();
		return view('admin.pengembalian.input', compact('user'));
	}

    public function fetchAll($user_id) {
		$penyewaans = Sewa::selectRaw("
		sewa.id,
		barang.nama as 'nama_barang',
		IF(sewa.keperluan ='Pribadi',
			IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
		IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'harga_satuan',
		IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa)) as 'lama',
		IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
           IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'total_harga',
            sewa.tgl_harus_kembali,sewa.tgl_kembali,
			IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0) as 'terlambat',
			IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum))) as 'denda_terlambat',
			sewa.keterangan_sewa,sewa.keterangan_kembali, sewa.keperluan, IFNULL(sewa.denda_lain,'-') as 'denda_lain'")
		->Join('users','sewa.id_user','=','users.id')
		->Join('denda','denda.id','=','denda.id')
		->Join('barang','sewa.id_barang','=','barang.id')
		->where('id_user',$user_id)
		->where('status_acc','proses-kembali')
		->get();
		$total = Sewa::selectRaw("sum(
			IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
			IF(users.role='Alumni',barang.harga_alumni,
			   IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
			   IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
			   IFNULL(sewa.denda_lain,0)
			   ) as 'total_harga'")
			->Join('users','sewa.id_user','=','users.id')
			->Join('barang','sewa.id_barang','=','barang.id')
			->Join('denda','denda.id','=','denda.id')
			->where('id_user',$user_id)
			->where('status_acc','proses-kembali')
			->pluck('total_harga')->first();
		$output = '';
		if ($penyewaans->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th style="vertical-align: top;">Nama Barang</th>
                <th style="vertical-align: top;">Harga Satuan</th>
                <th style="vertical-align: top;">Jumlah</th>
                <th style="vertical-align: top;">Lama Hari</th>
                <th style="vertical-align: top;">Total Harga</th>
                <th style="vertical-align: top;">Tanggal Harus Kembali</th>
                <th style="vertical-align: top;">Tanggal Kembali</th>
                <th style="vertical-align: top;">Terlambat (Hari)</th>
                <th style="vertical-align: top;">Denda Terlambat</th>
                <th style="vertical-align: top;">Denda Lain</th>
                <th style="vertical-align: top;">Keperluan</th>
                <th style="vertical-align: top;">Keterangan Sewa</th>
                <th style="vertical-align: top;">Keterangan Kembali</th>
				<th id="no_sort" style="vertical-align: top;">Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($penyewaans as $penyewaan) { 
				$output .= '<tr>
				<td>' . $penyewaan->nama_barang . '</td>
				<td>' . $penyewaan->harga_satuan . '</td>
				<td>' . $penyewaan->jumlah . '</td>
				<td>' . $penyewaan->lama . '</td>
				<td>' . $penyewaan->total_harga . '</td>
				<td>' . $penyewaan->tgl_harus_kembali . '</td>
				<td>' . $penyewaan->tgl_kembali . '</td>
				<td>' . $penyewaan->terlambat . '</td>
				<td>' . $penyewaan->denda_terlambat . '</td>
				<td>' . $penyewaan->denda_lain . '</td>
				<td>' . $penyewaan->keperluan . '</td>
				<td>' . $penyewaan->keterangan_sewa . '</td>
				<td>' . $penyewaan->keterangan_kembali . '</td>
                <td>
				<a href="#" id="' . $penyewaan->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editSewaModal"><i class="bi-pencil-square h4"></i></a>
                  <a href="#" id="' . $penyewaan->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table><div class="d-flex justify-content-end my-2">
			<h2> Total Bayar '.$total.'</h2>
		  </div>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	// handle insert a new katagori$penyewaan ajax request
	public function store(Request $request) {

		$validator = Validator::make( $request->all() , [
			'barcode' => ['required', 'exists:App\Models\Barang,barcode']
		]);

		if ($validator->fails()){
			return response()->json(['errors' => $validator->errors()]);
		}else{

		$id_barang = Barang::where('barcode',$request->barcode)->pluck('id')->first();
		$user_id = $selector = request()->route('user_id');
		$disewa = Sewa::where('id_user',$user_id)
			->where('id_barang',$id_barang)
			->where('status_acc','disewa')->orderBy('sewa.tgl_harus_kembali', 'asc')->get();
		if($disewa->count()>0){
		
		$kembaliInput = Sewa::where('id_user',$user_id)
		->where('id_barang',$id_barang)
		->where('tgl_sewa','<=',$request->tgl_kembali)
		->where('status_acc','disewa')->get();
		if($kembaliInput->count()>0){
		$disewa[0]->update(['tgl_kembali' => $request->tgl_kembali,'status_acc' => 'proses-kembali']);
		return response()->json([
			'status' => 200,
		]);
		}else{
			return response()->json(['errors' => ['tgl_kembali' => 'The tgl kembali must be a date after or equal to tgl sewa.']]);
		}

		}else{
			return response()->json(['errors' => ['barcode' => 'The selected barcode is invalid.']]);
		}
		
		}
	}

	public function edit(Request $request) {
		$id = $request->id;
		
		$penyewaan = Sewa::where('sewa.id',$id)
		->get(['sewa.id','sewa.tgl_sewa','sewa.tgl_kembali','sewa.keterangan_kembali','sewa.denda_lain'])->first();

		return response()->json($penyewaan);
	}

    public function update(Request $request) {
		$validator = Validator::make($request->all(), [
			'denda_lain' => ['nullable','regex:/^([1-9][0-9][0-9]|[1-9][0-9][0-9]+)$/'],
			'tgl_sewa' => ['required'],
            'tgl_kembali' => ['required','after_or_equal:tgl_sewa']
		]);
		if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
			$penyewaanData = [
				'tgl_kembali' => $request->tgl_kembali,
				'denda_lain' => $request->denda_lain,
				'keterangan_kembali' => $request->keterangan,
			];
			
			$penyewaan = Sewa::find($request->sewa_id);
			$penyewaan->update($penyewaanData);
			
			return response()->json([
				'status' => 200,
			]);
		}
		
	}

    public function delete(Request $request) {
		$id = $request->id;
        $sewa = Sewa::where('id',$id)->get();

		$disewa = Sewa::where('id_user',$sewa[0]->id_user)
		->where('id_barang',$sewa[0]->id_barang)
		->where('tgl_sewa',$sewa[0]->tgl_sewa)
		->where('tgl_harus_kembali',$sewa[0]->tgl_harus_kembali)
		->where('status_acc','disewa')
		->where('keperluan',$sewa[0]->keperluan)->get();
		
		if($disewa->count()>0){
			$jumlah = (int) $sewa[0]->jumlah + (int) $disewa[0]->jumlah;

			$disewa[0]->update(['jumlah' => $jumlah]);
			$sewa[0]->delete();
		}else{
			$sewa[0]->update(['status_acc' =>'disewa', 'tgl_kembali' => null,'denda_lain' => null]);
		}
	}
    
	public function nota($user_id) {
		$user = User::where('id',$user_id)->first();
		$kontak = Kontak::get()->first();
        $penyewaans = Sewa::selectRaw("
		barang.nama as 'nama_barang',
		IF(sewa.keperluan ='Pribadi',
			IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
		IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'harga_satuan',
		IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa)) as 'lama',
		IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
           IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'total_harga',
            sewa.tgl_harus_kembali,sewa.tgl_kembali,
			IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0) as 'terlambat',
			IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum))) as 'denda_terlambat',
			sewa.keterangan_sewa,sewa.keterangan_kembali, sewa.keperluan, IFNULL(sewa.denda_lain,'-') as 'denda_lain'")
		->Join('users','sewa.id_user','=','users.id')
		->Join('denda','denda.id','=','denda.id')
		->Join('barang','sewa.id_barang','=','barang.id')
		->where('id_user',$user_id)
		->where('status_acc','proses-kembali')
		->get();

		$total = Sewa::selectRaw("sum(
			IF(sewa.keperluan ='Pribadi',IF(sewa.tgl_kembali>=sewa.tgl_harus_kembali,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa),datediff(sewa.tgl_kembali,sewa.tgl_sewa))*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
			IF(users.role='Alumni',barang.harga_alumni,
			   IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)+
			   IF(datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali)>0,datediff(sewa.tgl_kembali,sewa.tgl_harus_kembali),0)* IF(users.role = 'Siswa',denda.denda_siswa,IF(users.role ='Alumni',denda.denda_alumni,IF(users.role = 'Guru',denda.denda_guru,denda.denda_umum)))+
			   IFNULL(sewa.denda_lain,0)
			   ) as 'total_harga'")
			->Join('users','sewa.id_user','=','users.id')
			->Join('barang','sewa.id_barang','=','barang.id')
			->Join('denda','denda.id','=','denda.id')
			->where('id_user',$user_id)
			->where('status_acc','proses-kembali')
			->pluck('total_harga')->first();
		
		return view('admin.pengembalian.nota',compact('kontak','user','penyewaans','total'));
	}

	public function confirm(Request $request) {
		$id_user = $request->id_user;
        $sewa = Sewa::where('id_user', '=', $id_user)
		->where('status_acc','proses-kembali');
		if($sewa->get()->count()>0){
			$sewa->update(['status_acc' => 'selesai']);
			return response()->json([
				'status' => 200,
			]);
		}else{
			return response()->json([
				'status' => 500,
			]);
		}
	}

	public function semua(Request $request)
	{
		$sewa = Sewa::where('id_user', '=', $request->id_user)
		->where('status_acc','disewa')
		->where('status_acc','disewa');
	if($sewa->get()->count()>0){
		$sewa->update(['tgl_kembali' => date("Y-m-d"),'status_acc' => 'proses-kembali']);
			return response()->json([
				'status' => 200,
			]);
	}else{
		return response()->json([
			'status' => 500,
		]);	
	}
	}
}
