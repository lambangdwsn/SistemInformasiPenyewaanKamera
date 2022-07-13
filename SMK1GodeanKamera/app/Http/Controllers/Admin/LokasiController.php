<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LokasiController extends Controller
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
		return view('admin.lokasi.index');
	}

    public function fetchAll() {
		$lokasis = Lokasi::all();
		
		$output = '';
		if ($lokasis->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th style="vertical-align: top;">ID</th>
                <th style="vertical-align: top;">Lokasi</th>
                <th id="no_sort" style="vertical-align: top;">Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($lokasis as $lokasi) { 
				$output .= '<tr>
                <td>' . $lokasi->id . '</td>
				<td>' . $lokasi->lokasi . '</td>
                <td>
                  <a href="#" id="' . $lokasi->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editLokasiModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $lokasi->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	// handle insert a new lokasi ajax request
	public function store(Request $request) {
		

		$lokasiData = [
            'lokasi' => $request->lokasi
        ];
		Lokasi::create($lokasiData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function edit(Request $request) {
		$id = $request->id;
		$lokasi = Lokasi::find($id);
		return response()->json($lokasi);
	}

    public function update(Request $request) {
        $lokasi = Lokasi::find($request->lokasi_id);
		$lokasiData = [
            'lokasi' => $request->lokasi
        ];

		$lokasi->update($lokasiData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function delete(Request $request) {
		$id = $request->id;
        Lokasi::destroy($id);
	}
    
}
