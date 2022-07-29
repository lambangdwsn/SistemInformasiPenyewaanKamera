<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use App\Models\User;
use App\Models\Barang;
use App\Models\Kontak;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class PenyewaanController extends Controller
{
    public function index() {
		$users = User::all();
		$route ='admin.penyewaan.process';
		return view('admin.user.select', compact('users','route'));
	}

    public function process($user_id) {
		$user = User::where('id',$user_id)->first();
		
		return view('admin.penyewaan.input', compact('user'));
	}

    public function fetchAll($user_id) {
		$penyewaans = Sewa::selectRaw("
		sewa.id,
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
		->where('id_user',$user_id)
		->where('status_acc','proses-sewa')
		->get();

		$total = Sewa::selectRaw("sum(
		IF(sewa.keperluan ='Pribadi',datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa)*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
           IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)) as 'total_harga'")
		->Join('users','sewa.id_user','=','users.id')
		->Join('barang','sewa.id_barang','=','barang.id')
		->where('id_user',$user_id)
		->where('status_acc','proses-sewa')
		->get();
		
		$output = '';
		if ($penyewaans->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle" >
            <thead>
              <tr>
                <th style="vertical-align: top;">Nama Barang</th>
                <th style="vertical-align: top;">Harga Satuan</th>
                <th style="vertical-align: top;">Jumlah</th>
                <th style="vertical-align: top;">Lama Hari</th>
                <th style="vertical-align: top;">Total Harga</th>
                <th style="vertical-align: top;">Tanggal Sewa</th>
                <th style="vertical-align: top;">Tanggal Harus Kembali</th>
                <th style="vertical-align: top;">Keperluan</th>
                <th style="vertical-align: top;">Keterangan</th>
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
				<td>' . $penyewaan->tgl_sewa . '</td>
				<td>' . $penyewaan->tgl_harus_kembali . '</td>
				<td>' . $penyewaan->keperluan . '</td>
				<td>' . $penyewaan->keterangan . '</td>
                <td>
                  <a href="#" id="' . $penyewaan->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editSewaModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $penyewaan->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table><div class="d-flex justify-content-end my-2">
			<h2> Total Bayar '.$total[0]->total_harga.'</h2>
		  </div>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	// handle insert a new $penyewaan ajax request
	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'barcode' => ['required', 'exists:App\Models\Barang,barcode'],
            'jumlah' => ['required', 'regex:/^([1-9]|[1-9][0-9]+)*$/'],
			'tgl_sewa' => ['required'],
            'tgl_harus_kembali' => ['required','after_or_equal:tgl_sewa']
		]);
		if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
		
		$user_id = request()->route('user_id');
		$id_barang = Barang::where('barcode',$request->barcode)->pluck('id')->first();
		$jumlah_barang = Barang::where('barcode',$request->barcode)->pluck('jumlah')->first();
		$barang_disewa = Sewa::selectRaw('sum(jumlah) as total')
		->where('id_barang',$id_barang)
		->where('status_acc','disewa')->pluck('total')->first();

		if((int) $request->jumlah <= ((int) $jumlah_barang - (int) $barang_disewa)){
		$sewa = Sewa::where('id_user',$user_id)
		->where('id_barang',$id_barang)
		->where('tgl_sewa',$request->tgl_sewa)
        ->where('tgl_harus_kembali',$request->tgl_harus_kembali)
		->where('keperluan',$request->keperluan)
        ->where('status_acc','proses-sewa')->get();
		
		if($sewa->count()>0){
			
			$jumlah = (int)$sewa[0]->jumlah+ (int)$request->jumlah;
			$jumlah_proses = Sewa::selectRaw('sum(jumlah) as total')
			->where('id_user',$user_id)
			->where('id_barang',$id_barang)
			->where('status_acc','proses-sewa')->pluck('total')->first();
			
			if(($jumlah_proses + $request->jumlah) <= ((int) $jumlah_barang - (int) $barang_disewa)){
				$sewa[0]->update(['jumlah' => $jumlah]);
			}else{
				return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
			}

		}else{
			
			$jumlah_proses = Sewa::selectRaw('sum(jumlah) as total')
			->where('id_user',$user_id)
			->where('id_barang',$id_barang)
			->where('status_acc','proses-sewa')->pluck('total')->first();

			if(($jumlah_proses + $request->jumlah) <= ((int) $jumlah_barang - (int) $barang_disewa)){
			
                $penyewaanData = [
				'id_user' => $user_id,
				'id_barang' => $id_barang,
				'jumlah' => $request->jumlah,
				'tgl_sewa' => $request->tgl_sewa,
				'keperluan' => $request->keperluan,
				'tgl_harus_kembali' => $request->tgl_harus_kembali,
				'keterangan_sewa' => $request->keterangan,
			];
			Sewa::create($penyewaanData);
			}else{
				return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
			}
		}
		return response()->json([
			'status' => 200,
		]);
		}else{
			return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
		}
		}
	}

    public function edit(Request $request) {
		$id = $request->id;
		
		$penyewaan = Sewa::Join('barang', 'sewa.id_barang','=','barang.id')
		->where('sewa.id',$id)
		->get(['sewa.id','sewa.jumlah','sewa.tgl_sewa','sewa.tgl_harus_kembali','sewa.keperluan',"sewa.keterangan_sewa" ,'barang.barcode'])->first();

		return response()->json($penyewaan);
	}

    public function update(Request $request) {
		$validator = Validator::make($request->all(), [
			'barcode' => ['required', 'exists:App\Models\Barang,barcode'],
            'jumlah' => ['required', 'regex:/^([1-9]|[1-9][0-9]+)*$/'],
			'tgl_sewa' => ['required'],
            'tgl_harus_kembali' => ['required','after_or_equal:tgl_sewa']
		]);

		if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
			
        }else{
		
		$user_id =  request()->route('user_id');
		$id_barang = Barang::where('barcode',$request->barcode)->pluck('id')->first();
		
		$jumlah_barang = Barang::where('barcode',$request->barcode)->pluck('jumlah')->first();
		$barang_disewa = Sewa::selectRaw('sum(jumlah) as total')
		->where('id_barang',$id_barang)
		->where('status_acc','disewa')->pluck('total')->first();

		if((int) $request->jumlah <= ((int) $jumlah_barang - (int) $barang_disewa)){
		$sewa = Sewa::where('id_user',$user_id)
		->where('id_barang',$id_barang)
		->where('tgl_sewa',$request->tgl_sewa)
        ->where('tgl_harus_kembali',$request->tgl_harus_kembali)
        ->where('id','!=',$request->sewa_id)
		->where('keperluan',$request->keperluan)
        ->where('status_acc','proses-sewa')->get();
		
		if($sewa->count()>0){

			$jumlah = (int)$sewa[0]->jumlah+ (int)$request->jumlah;

			$jumlah_proses = Sewa::selectRaw('sum(jumlah) as total')
			->where('id_user',$user_id)
			->where('id_barang',$id_barang)
			->where('id','!=',$request->sewa_id)
			->where('status_acc','proses-sewa')->pluck('total')->first();
			
			if(($jumlah_proses + $jumlah) <= ((int) $jumlah_barang - (int) $barang_disewa)){
			$sewa[0]->update(['jumlah' => $jumlah]);
			Sewa::destroy($request->sewa_id);

			}else{
				return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
			}
		}else{
		
			$jumlah_proses = Sewa::selectRaw('sum(jumlah) as total')
			->where('id_user',$user_id)
			->where('id_barang',$id_barang)
			->where('id','!=',$request->sewa_id)
			->where('status_acc','proses-sewa')->pluck('total')->first();

			if(($jumlah_proses + $request->jumlah) <= ((int) $jumlah_barang - (int) $barang_disewa)){
			$penyewaanData = [
				'id_barang' => $id_barang,
				'jumlah'  => $request->jumlah,
				'tgl_sewa' => $request->tgl_sewa,
				'tgl_harus_kembali' => $request->tgl_harus_kembali,
				'keperluan' => $request->keperluan,
				'keterangan_sewa' => $request->keterangan,
			];
			
			$penyewaan = Sewa::find($request->sewa_id);
			$penyewaan->update($penyewaanData);
			}else{
				return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
			}
		}
		return response()->json([
			'status' => 200,
		]);
		}else{
			return response()->json(['errors' => ['jumlah' => 'Jumlah is not enough']]);
		}
		}
	}

    public function delete(Request $request) {
		$id = $request->id;
        Sewa::destroy($id);
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
		sewa.jumlah,datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa) as 'lama',
		IF(sewa.keperluan ='Pribadi',datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa)*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
           IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0) as 'total_harga',
           sewa.tgl_sewa, sewa.tgl_harus_kembali,sewa.keterangan_sewa as 'keterangan',sewa.keperluan")
		->Join('users','sewa.id_user','=','users.id')
		->Join('barang','sewa.id_barang','=','barang.id')
		->where('id_user',$user_id)
		->where('status_acc','proses-sewa')
		->get();

		$total = Sewa::selectRaw("sum(
		IF(sewa.keperluan ='Pribadi',datediff(sewa.tgl_harus_kembali,sewa.tgl_sewa)*sewa.jumlah*IF(users.role = 'Siswa', barang.harga_siswa,
        IF(users.role='Alumni',barang.harga_alumni,
           IF(users.role='Guru',barang.harga_guru,barang.harga_umum))),0)) as 'total_harga'")
		->Join('users','sewa.id_user','=','users.id')
		->Join('barang','sewa.id_barang','=','barang.id')
		->where('id_user',$user_id)
		->where('status_acc','proses-sewa')
		->pluck('total_harga')->first();
		
		return view('admin.penyewaan.nota',compact('kontak','user','penyewaans','total'));
	}
    
	public function confirm(Request $request) {
		$id_user = $request->id_user;
		$sewa = Sewa::where('id_user', '=', $id_user)
		->where('status_acc','proses-sewa');
		if($sewa->get()->count()>0){
			$sewa->update(['status_acc' => 'disewa']);
			$id_barang = DB::select("SELECT sewa.id_barang FROM sewa INNER JOIN (SELECT sewa.id_barang, sisa.boleh_disewa FROM sewa INNER JOIN (Select sewa.id_barang, barang.jumlah-sum(sewa.jumlah) as 'boleh_disewa' FROM sewa INNER Join barang on barang.id = sewa.id_barang WHERE sewa.status_acc = 'disewa' GROUP BY sewa.id_barang,barang.jumlah) sisa ON sewa.id_barang = sisa.id_barang WHERE status_acc = 'proses-sewa' GROUP BY sewa.id_barang,sisa.boleh_disewa) sisa_sewa ON sewa.id_barang = sisa_sewa.id_barang WHERE status_acc ='proses-sewa' AND sisa_sewa.boleh_disewa <=0 GROUP BY sewa.id_barang");
			if(!is_null($id_barang)){
					foreach($id_barang as $id){
						 Sewa::where('id_barang',$id->id_barang)->where('status_acc','proses-sewa')->delete();
					}	
			}
			
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
