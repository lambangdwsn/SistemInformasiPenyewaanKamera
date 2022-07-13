<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangRusak;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Validator;
use Illuminate\Support\Facades\Auth;

class BarangRusakController extends Controller
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
		return view('admin.barang.rusak');
	}

    public function fetchAll() {
		$barangs = BarangRusak::Join('barang', 'barang_rusak.id_barang','=','barang.id')
        ->leftJoin('katagori', 'barang.id_katagori','=', 'katagori.id')->get(['barang_rusak.*','barang.nama','barang.barcode','katagori.katagori']);
		
		$output = '';
		if ($barangs->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle" style="font-size: 14px;">
            <thead>
              <tr>
                <th style="vertical-align: top;">ID</th>
                <th style="vertical-align: top;">Nama</th>
                <th style="vertical-align: top;">Barcode</th>
                <th style="vertical-align: top;">Katagori</th>
                <th style="vertical-align: top;">Status</th>
                <th style="vertical-align: top;">Jumlah</th>
                <th style="vertical-align: top;">Keterangan</th>
                <th style="vertical-align: top;">Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($barangs as $barang) { 
				$generator = new BarcodeGeneratorPNG;
				$barcode = $generator->getBarcode($barang->barcode, $generator::TYPE_CODE_128);
				$output .= '<tr>
                <td>' . $barang->id_barang_rusak . '</td>
				<td>' . $barang->nama . '</td>
                <td><img src="data:image/png;base64,' . base64_encode($barcode) . '"><br>'.$barang->barcode.'</td>
                <td>' . $barang->katagori . '</td>
                <td>' . $barang->status . '</td>
                <td>' . $barang->jumlah . '</td>
                <td>' . $barang->keterangan . '</td>
                <td>
                  <a href="#" id="' . $barang->id_barang_rusak . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editBarangModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $barang->id_barang_rusak . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	// handle insert a new BarangRusak ajax request
	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
            'barcode' => ['required', 'exists:App\Models\Barang,barcode'],
            'jumlah' => ['required', 'regex:/^([1-9]|[1-9][0-9]+)*$/'],
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
        $barang_id = Barang::where('barcode','=',$request['barcode'])->pluck('id')->first();

		$BarangRusakData = [
            'id_barang' => $barang_id,
            'jumlah' => $request['jumlah'],
            'status' => $request['status']
        ];
		BarangRusak::create($BarangRusakData);
		return response()->json([
			'status' => 200,
		]);
        }
	}

    public function edit(Request $request) {
		
		$BarangRusak = BarangRusak::Join('barang', 'barang_rusak.id_barang','=','barang.id')->get(['barang_rusak.*','barang.barcode'])->where('id_barang_rusak',$request->id)->first();
		return response()->json($BarangRusak);
	}

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'barcode' => ['required', 'exists:App\Models\Barang,barcode'],
            'jumlah' => ['required', 'regex:/^([1-9]|[1-9][0-9]+)$/'],
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }else{
        $BarangRusak = BarangRusak::find($request->barang_id);
        $barang_id = Barang::where('barcode','=',$request['barcode'])->pluck('id')->first();

		$BarangRusakData = [
            'id_barang' => $barang_id,
            'jumlah' => $request['jumlah'],
            'keterangan' => $request['keterangan'],
            'status' => $request['status']
        ];

		$BarangRusak->update($BarangRusakData);

		return response()->json([
			'status' => 200,
		]);
        }
	}

    public function delete(Request $request) {
		$id = $request->id;
        BarangRusak::destroy($id);
	}
    
}
