<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Katagori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KatagoriController extends Controller
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
		return view('admin.katagori.index');
	}

    public function fetchAll() {
		$katagoris = Katagori::all();
		
		$output = '';
		if ($katagoris->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th style="vertical-align: top;">ID</th>
                <th style="vertical-align: top;">Katagori</th>
				<th id="no_sort" style="vertical-align: top;">Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($katagoris as $katagori) { 
				$output .= '<tr>
                <td>' . $katagori->id . '</td>
				<td>' . $katagori->katagori . '</td>
                <td>
                  <a href="#" id="' . $katagori->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editKatagoriModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $katagori->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	// handle insert a new katagori$katagori ajax request
	public function store(Request $request) {
		

		$katagoriData = [
            'katagori' => ucfirst($request->katagori)
        ];
		Katagori::create($katagoriData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function edit(Request $request) {
		$id = $request->id;
		$katagori = Katagori::find($id);
		return response()->json($katagori);
	}

    public function update(Request $request) {
		$katagori = Katagori::find($request->katagori_id);
		$katagoriData = [
            'katagori' => ucfirst($request->katagori)
        ];

		$katagori->update($katagoriData);

		return response()->json([
			'status' => 200,
		]);
	}

    public function delete(Request $request) {
		$id = $request->id;
        Katagori::destroy($id);
	}
    
}
