<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
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
        $kontak = Kontak::all();
        if($kontak->count() > 0 ){
            $kontak = $kontak->first();
            return view('admin.kontak', compact('kontak'));
        }else{
            Kontak::create();
            $kontak = Kontak::all();
            $kontak = $kontak->first();
            return view('admin.kontak', compact('kontak'));
        }
	}

    public function update(Request $request) {
		$kontak = Kontak::all()->first();
        $kontakData = [
            'alamat' => $request->alamat,
            'wa_link' => $request->wa_link,
            'jam_buka' => $request->jam_buka,
            'keterangan' => $request->keterangan,
            'no_tlp' => $request->no_tlp,
        ];

		$kontak->update($kontakData);

        return redirect(route('admin.kontak'))->with('status','Kontak berhasil diubah');
	}
}
