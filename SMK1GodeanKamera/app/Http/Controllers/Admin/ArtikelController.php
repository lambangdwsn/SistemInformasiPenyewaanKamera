<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
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
		return view('admin.artikel.index');
	}    

    public function fetchAll() {
		$artikels = Artikel::all();
		
		$output = '';
		if ($artikels->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle" style="font-size: 14px;">
            <thead>
              <tr>
                <th style="vertical-align: top;">ID</th>
                <th style="vertical-align: top;">Judul</th>                
                <th style="vertical-align: top;">Image</th>
                <th style="vertical-align: top;">Keterangan</th>
                <th style="vertical-align: top;">Status Tampil</th>
                <th style="vertical-align: top;">Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($artikels as $artikel) { 
				$output .= '<tr>
                <td>' . $artikel->id . '</td>
				<td>' . $artikel->judul . '</td>
                <td><img src="../../storage/images/' . $artikel->image . '" width="50" class="img-thumbnail"></td>
                <td>' . $artikel->isi . '</td>
                <td>' . $artikel->status_tampil . '</td>
                <td>
                  <a href="#" id="' . $artikel->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editArtikelModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $artikel->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}    

	// handle insert a new artikel ajax request
	public function store(Request $request) {
		$file = $request->file('image');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/images', $fileName);
        
		$artikelData = [
            'judul' => $request->judul,
            'image' => $fileName,
            'isi' => $request->isi,
            'status_tampil' => $request->status_tampil
        ];
		Artikel::create($artikelData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function edit(Request $request) {
		$id = $request->id;
		$artikel = Artikel::find($id);
		return response()->json($artikel);
	}

    public function update(Request $request) {
		$fileName = '';
		$artikel = Artikel::find($request->artikel_id);
		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/images', $fileName);
			if ($artikel->image) {
				Storage::delete('public/images/' . $artikel->image);
			}
		} else {
		  $fileName = $request->artikel_image;
		}
		$artikelData = [
            'judul' => $request->judul,
            'image' => $fileName,
            'isi' => $request->isi,
            'status_tampil' => $request->status_tampil
        ];

		$artikel->update($artikelData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function delete(Request $request) {
		$id = $request->id;
		$emp = Artikel::find($id);
    if(Storage::exists('public/images/' . $emp->image)) {
    Storage::delete('public/images/' . $emp->image);
    }
		Artikel::destroy($id);
	}
}
