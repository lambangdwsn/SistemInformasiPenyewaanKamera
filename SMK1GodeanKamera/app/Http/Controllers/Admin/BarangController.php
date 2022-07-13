<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Katagori;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
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
    $katagori = Katagori::orderBy('katagori','asc')->get();
    $lokasi = Lokasi::orderBy('lokasi','asc')->get();
    $kelengkapanID = Katagori::select('id')
    ->where('katagori', '=', 'Kelengkapan')
    ->get(['id'])->pluck('id');
    $barang = Barang::Where('id_katagori','!=',$kelengkapanID[0])->orWhereNull('id_katagori')->get(['id','nama']);
		return view('admin.barang.index', compact('katagori','lokasi', 'barang'));
	}
    public function katagori($selector) {
    if(Katagori::where('katagori','=',ucfirst($selector))->exists()){
    $katagori = Katagori::orderBy('katagori','asc')->get();
    $lokasi = Lokasi::orderBy('lokasi','asc')->get();
    $kelengkapanID = Katagori::select('id')
    ->where('katagori', '=', 'Kelengkapan')
    ->get(['id'])->pluck('id')->first();
    $barang = Barang::Where('id_katagori','!=',$kelengkapanID)->orWhereNull('id_katagori')->get(['id','nama']);
		return view('admin.barang.katagori', compact('katagori','lokasi', 'barang','selector'));
    }else{
      abort(404);
    }
	}

    public function fetchAll() {
		$barangs = Barang::leftJoin('katagori', 'barang.id_katagori','=', 'katagori.id')
    ->leftJoin('lokasi', 'barang.id_lokasi','=', 'lokasi.id')
    ->leftJoin('barang as kelengkapan', 'barang.id_kelengkapan','=', 'kelengkapan.id')
    ->get(['barang.*', 'katagori.katagori', 'lokasi.lokasi','kelengkapan.nama as nama_kelengkapan']);
		
		$output = '';
		if ($barangs->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle" style="font-size: 14px;">
            <thead>
              <tr>
                <th rowspan="2" style="vertical-align: top;">ID</th>
                <th rowspan="2" style="vertical-align: top;">Nama</th>
                <th rowspan="2" style="vertical-align: top;">Barcode</th>
		        		<th rowspan="2" style="vertical-align: top;">Gambar</th>
                <th id="no_sort" colspan="4">Harga Sewa</th>
                <th rowspan="2" style="vertical-align: top;">Katagori</th>
                <th rowspan="2" style="vertical-align: top;">Merk</th>
                <th rowspan="2" style="vertical-align: top;">Jumlah</th>
                <th rowspan="2" style="vertical-align: top;">Lokasi Simpan</th>
                <th rowspan="2" style="vertical-align: top;">Kelengkapan Untuk</th>
                <th rowspan="2" style="vertical-align: top;">Keterangan</th>
                <th rowspan="2" style="vertical-align: top;">Status Tampil</th>
                <th rowspan="2" style="vertical-align: top;">Action</th>
              </tr>
			  <tr>
                <th>Siswa</th>
                <th>Alumni</th>
                <th>Guru</th>
                <th>Umum</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($barangs as $barang) { 
				$generator = new BarcodeGeneratorPNG;
				$barcode = $generator->getBarcode($barang->barcode, $generator::TYPE_CODE_128);
				$output .= '<tr>
                <td>' . $barang->id . '</td>
				<td>' . $barang->nama . '</td>
                <td><img src="data:image/png;base64,' . base64_encode($barcode) . '"><br>'.$barang->barcode.'</td>
                <td><img src="../../storage/images/' . $barang->image . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $barang->harga_siswa . '</td>
                <td>' . $barang->harga_alumni . '</td>
                <td>' . $barang->harga_guru . '</td>
                <td>' . $barang->harga_umum . '</td>
                <td>' . $barang->katagori . '</td>
                <td>' . $barang->merk . '</td>
                <td>' . $barang->jumlah . '</td>
                <td>' . $barang->lokasi . '</td>
                <td>' . $barang->nama_kelengkapan . '</td>
                <td>' . $barang->keterangan . '</td>
                <td>' . $barang->status_tampil . '</td>
                <td>
                  <a href="#" id="' . $barang->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editBarangModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $barang->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

    public function fetchKatagori($selector) {
    if(Katagori::where('katagori','=',ucfirst($selector))->exists()){
      $barangs = Barang::leftJoin('katagori', 'barang.id_katagori','=', 'katagori.id')
      ->leftJoin('lokasi', 'barang.id_lokasi','=', 'lokasi.id')
      ->leftJoin('barang as kelengkapan', 'barang.id_kelengkapan','=', 'kelengkapan.id')
      ->where('katagori.katagori','=',$selector)
      ->get(['barang.*', 'katagori.katagori', 'lokasi.lokasi','kelengkapan.nama as nama_kelengkapan']);
      
      $output = '';

      if ($barangs->count() > 0) {
        $kelengkapanHead ='';
        if($selector === 'kelengkapan'){
          $kelengkapanHead ='<th rowspan="2" style="vertical-align: top;">Kelengkapan Untuk</th>';
        }

        $output .= '<table class="table table-striped table-sm text-center align-middle" style="font-size: 14px;">
              <thead>
                <tr>
                  <th rowspan="2" style="vertical-align: top;">ID</th>
                  <th rowspan="2" style="vertical-align: top;">Nama</th>
                  <th rowspan="2" style="vertical-align: top;">Barcode</th>
                  <th rowspan="2" style="vertical-align: top;">Gambar</th>
                  <th id="no_sort" colspan="4">Harga Sewa</th>
                  <th rowspan="2" style="vertical-align: top;">Merk</th>
                  <th rowspan="2" style="vertical-align: top;">Jumlah</th>
                  <th rowspan="2" style="vertical-align: top;">Lokasi Simpan</th>
                  '.$kelengkapanHead.'
                  <th rowspan="2" style="vertical-align: top;">Keterangan</th>
                  <th rowspan="2" style="vertical-align: top;">Status Tampil</th>
                  <th rowspan="2" style="vertical-align: top;">Action</th>
                </tr>
          <tr>
                  <th>Siswa</th>
                  <th>Alumni</th>
                  <th>Guru</th>
                  <th>Umum</th>
                </tr>
              </thead>
              <tbody>';
        foreach ($barangs as $barang) { 
          $kelengkapanBody ='';
          if($selector === 'kelengkapan'){
            $kelengkapanBody ='<td>' . $barang->nama_kelengkapan . '</td>';
          }
          $generator = new BarcodeGeneratorPNG;
          $barcode = $generator->getBarcode($barang->barcode, $generator::TYPE_CODE_128);
          $output .= '<tr>
                  <td>' . $barang->id . '</td>
          <td>' . $barang->nama . '</td>
                  <td><img src="data:image/png;base64,' . base64_encode($barcode) . '"><br>'.$barang->barcode.'</td>
                  <td><img src="../../storage/images/' . $barang->image . '" width="50" class="img-thumbnail rounded-circle"></td>
                  <td>' . $barang->harga_siswa . '</td>
                  <td>' . $barang->harga_alumni . '</td>
                  <td>' . $barang->harga_guru . '</td>
                  <td>' . $barang->harga_umum . '</td>
                  <td>' . $barang->merk . '</td>
                  <td>' . $barang->jumlah . '</td>
                  <td>' . $barang->lokasi . '</td>
                  ' . $kelengkapanBody . '
                  <td>' . $barang->keterangan . '</td>
                  <td>' . $barang->status_tampil . '</td>
                  <td>
                    <a href="#" id="' . $barang->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editBarangModal"><i class="bi-pencil-square h4"></i></a>

                    <a href="#" id="' . $barang->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                  </td>
                </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
      }
    }else{
      abort(404);
    }
	}

	// handle insert a new barang$barang ajax request
	public function store(Request $request) {
		$file = $request->file('image');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/images', $fileName);
    
    $id_katagori;
    if($request->katagori == '0'){
      $id_katagori = null;
    }else{
      $id_katagori = $request->katagori;
    }

    $id_kelengkapan;
    if($request->kelengkapan == '0'){
      $id_kelengkapan = null;
    }else{
      $id_kelengkapan = $request->kelengkapan;
    }

		$barangData = [
            'nama' => $request->nama,
            'barcode' => $request->barcode,
            'image' => $fileName,
            'harga_siswa' => $request->harga_siswa,
            'harga_alumni' => $request->harga_alumni,
            'harga_guru' => $request->harga_guru,
            'harga_umum' => $request->harga_umum,
            'id_katagori' => $id_katagori,
            'merk' => $request->merk,
            'jumlah' => $request->jumlah,
            'id_lokasi' => $request->lokasi,
            'id_kelengkapan' => $id_kelengkapan,
            'keterangan' => $request->keterangan,
            'status_tampil' => $request->status_tampil
        ];
		Barang::create($barangData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function edit(Request $request) {
		$id = $request->id;
		$barang = Barang::find($id);
		return response()->json($barang);
	}

    public function update(Request $request) {
		$fileName = '';
		$barang = Barang::find($request->barang_id);
		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/images', $fileName);
			if ($barang->image) {
				Storage::delete('public/images/' . $barang->image);
			}
		} else {
		  $fileName = $request->barang_image;
		}

    $id_katagori;
    if($request->katagori == '0'){
      $id_katagori = null;
    }else{
      $id_katagori = $request->katagori;
    }

    $id_kelengkapan;
    if($request->kelengkapan == '0'){
      $id_kelengkapan = null;
    }else{
      $id_kelengkapan = $request->kelengkapan;
    }

		$barangData = [
            'nama' => $request->nama,
            'barcode' => $request->barcode,
            'image' => $fileName,
            'harga_siswa' => $request->harga_siswa,
            'harga_alumni' => $request->harga_alumni,
            'harga_guru' => $request->harga_guru,
            'harga_umum' => $request->harga_umum,
            'id_katagori' => $id_katagori,
            'merk' => $request->merk,
            'jumlah' => $request->jumlah,
            'id_kelengkapan' => $id_kelengkapan,
            'id_lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'status_tampil' => $request->status_tampil    
        ];

		$barang->update($barangData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function delete(Request $request) {
		$id = $request->id;
		$emp = Barang::find($id);
    if(Storage::exists('public/images/' . $emp->image)) {
    Storage::delete('public/images/' . $emp->image);
    }
		Barang::destroy($id);
	}
    public function barcode($type){
      $output = '<div class="row">';
      $barcodes;
      if($type === 'semua'){
      $barcodes = Barang::get(['barcode'])->toArray();
      }else if(Katagori::where('katagori','=',ucfirst($type))->exists()){
      $barcodes = Barang::leftJoin('katagori', 'barang.id_katagori','=', 'katagori.id')->where('katagori.katagori','=',ucfirst($type))->get(['barcode'])->toArray();
      }else{
        abort(404);
      }
      foreach($barcodes as $code){
        $generator = new BarcodeGeneratorPNG;
        $barcode = $generator->getBarcode($code['barcode'], $generator::TYPE_CODE_128);
        $output .= '<div class="col-4 text-center border py-3 px-2">'.
        '<img src="data:image/png;base64,' . base64_encode($barcode) . '"><br>'.
        $code['barcode'].
        '</div>';
      }
      $output .='</div>';
      return view('admin.barang.barcode', compact('output'));
      
    }
}
