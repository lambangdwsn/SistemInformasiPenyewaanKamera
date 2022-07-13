<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
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
        $denda = Denda::all();
        if($denda->count() > 0 ){
            $denda = $denda->first();
            return view('admin.denda', compact('denda'));
        }else{
            Denda::create();
            $denda = Denda::all();
            $denda = $denda->first();
            return view('admin.denda', compact('denda'));
        }
	}

    public function update(Request $request) {
		$denda = Denda::all()->first();
        $dendaData = [
            'denda_siswa' => $request->denda_siswa,
            'denda_alumni' => $request->denda_alumni,
            'denda_guru' => $request->denda_guru,
            'denda_umum' => $request->denda_umum,
        ];
        

		$denda->update($dendaData);

        return redirect(route('admin.denda'))->with('status','Denda berhasil diubah');
	}
}
