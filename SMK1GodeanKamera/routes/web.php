<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPagesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('/admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->middleware('auth:admin')->group(function(){
    Route::get('/dashboard','HomeController@index')->name('home');

    Route::get('/kontak','KontakController@index')->name('kontak');
    Route::post('/kontak','KontakController@update');

    
    Route::get('barang/', 'BarangController@index')->name('barang.index');
    Route::get('barang/katagori-{katagori}', 'BarangController@katagori')->name('barang.katagori');
    Route::post('barang/store', 'BarangController@store')->name('barang.store');
    Route::get('barang/fetchall', 'BarangController@fetchAll')->name('barang.fetchAll');
    Route::get('barang/barcode/{type}', 'BarangController@barcode')->name('barang.barcode');
    Route::get('barang/fetch{katagori}', 'BarangController@fetchKatagori')->name('barang.fetchKatagori');
    Route::delete('barang/delete', 'BarangController@delete')->name('barang.delete');
    Route::get('barang/edit', 'BarangController@edit')->name('barang.edit');
    Route::post('barang/update', 'BarangController@update')->name('barang.update'); 

    Route::get('barang-rusak/', 'BarangRusakController@index')->name('rusak.index');
    Route::post('barang-rusak/store', 'BarangRusakController@store')->name('rusak.store');
    Route::get('barang-rusak/fetchall', 'BarangRusakController@fetchAll')->name('rusak.fetchAll');
    Route::delete('barang-rusak/delete', 'BarangRusakController@delete')->name('rusak.delete');
    Route::get('barang-rusak/edit', 'BarangRusakController@edit')->name('rusak.edit');
    Route::post('barang-rusak/update', 'BarangRusakController@update')->name('rusak.update'); 
    
    Route::get('petugas/', 'PetugasController@index')->name('petugas.index');
    Route::post('petugas/store', 'PetugasController@store')->name('petugas.store');
    Route::get('petugas/fetchall', 'PetugasController@fetchAll')->name('petugas.fetchAll');
    Route::delete('petugas/delete', 'PetugasController@delete')->name('petugas.delete');
    Route::get('petugas/edit', 'PetugasController@edit')->name('petugas.edit');
    Route::post('petugas/update', 'PetugasController@update')->name('petugas.update'); 
    
    Route::get('katagori/', 'KatagoriController@index')->name('katagori.index');
    Route::post('katagori/store', 'KatagoriController@store')->name('katagori.store');
    Route::get('katagori/fetchall', 'KatagoriController@fetchAll')->name('katagori.fetchAll');
    Route::delete('katagori/delete', 'KatagoriController@delete')->name('katagori.delete');
    Route::get('katagori/edit', 'KatagoriController@edit')->name('katagori.edit');
    Route::post('katagori/update', 'KatagoriController@update')->name('katagori.update'); 

    Route::get('lokasi/', 'LokasiController@index')->name('lokasi.index');
    Route::post('lokasi/store', 'LokasiController@store')->name('lokasi.store');
    Route::get('lokasi/fetchall', 'LokasiController@fetchAll')->name('lokasi.fetchAll');
    Route::delete('lokasi/delete', 'LokasiController@delete')->name('lokasi.delete');
    Route::get('lokasi/edit', 'LokasiController@edit')->name('lokasi.edit');
    Route::post('lokasi/update', 'LokasiController@update')->name('lokasi.update');

    Route::get('artikel/', 'ArtikelController@index')->name('artikel.index');
    Route::post('artikel/store', 'ArtikelController@store')->name('artikel.store');
    Route::get('artikel/fetchall', 'ArtikelController@fetchAll')->name('artikel.fetchAll');
    Route::delete('artikel/delete', 'ArtikelController@delete')->name('artikel.delete');
    Route::get('artikel/edit', 'ArtikelController@edit')->name('artikel.edit');
    Route::post('artikel/update', 'ArtikelController@update')->name('artikel.update');
     
    Route::get('user/{role}', 'UserController@index')->name('user.index');
    Route::post('user/{role}/store', 'UserController@store')->name('user.store');
    Route::get('user/{role}/fetchall', 'UserController@fetchAll')->name('user.fetchAll');
    Route::delete('user/{role}/delete', 'UserController@delete')->name('user.delete');
    Route::get('user/{role}/edit', 'UserController@edit')->name('user.edit');
    Route::post('user/{role}/update', 'UserController@update')->name('user.update'); 

    Route::get('input-penyewaan/', 'PenyewaanController@index')->name('penyewaan.index');
    Route::get('input-penyewaan/{user_id}', 'PenyewaanController@process')->name('penyewaan.process');
    Route::post('input-penyewaan/{user_id}/store', 'PenyewaanController@store')->name('penyewaan.store');
    Route::get('input-penyewaan/{user_id}/fetchall', 'PenyewaanController@fetchAll')->name('penyewaan.fetchAll');
    Route::delete('input-penyewaan/{user_id}/delete', 'PenyewaanController@delete')->name('penyewaan.delete');
    Route::get('input-penyewaan/{user_id}/edit', 'PenyewaanController@edit')->name('penyewaan.edit');
    Route::post('input-penyewaan/{user_id}/update', 'PenyewaanController@update')->name('penyewaan.update'); 
    Route::post('input-penyewaan/{user_id}/confirm', 'PenyewaanController@confirm')->name('penyewaan.confirm'); 
    Route::get('input-penyewaan/{user_id}/nota', 'PenyewaanController@nota')->name('penyewaan.nota'); 
    
    Route::get('input-pengembalian/', 'PengembalianController@index')->name('pengembalian.index');
    Route::get('input-pengembalian/{user_id}', 'PengembalianController@process')->name('pengembalian.process');
    Route::post('input-pengembalian/{user_id}/store', 'PengembalianController@store')->name('pengembalian.store');
    Route::get('input-pengembalian/{user_id}/fetchall', 'PengembalianController@fetchAll')->name('pengembalian.fetchAll');
    Route::delete('input-pengembalian/{user_id}/delete', 'PengembalianController@delete')->name('pengembalian.delete');
    Route::get('input-pengembalian/{user_id}/edit', 'PengembalianController@edit')->name('pengembalian.edit');
    Route::post('input-pengembalian/{user_id}/update', 'PengembalianController@update')->name('pengembalian.update'); 
    Route::post('input-pengembalian/{user_id}/confirm', 'PengembalianController@confirm')->name('pengembalian.confirm'); 
    Route::get('input-pengembalian/{user_id}/nota', 'PengembalianController@nota')->name('pengembalian.nota'); 
    Route::post('input-pengembalian/{user_id}/semua', 'PengembalianController@semua')->name('pengembalian.semua'); 

    Route::get('barang-disewa/', 'DisewaController@index')->name('disewa.index');    
    Route::post('barang-disewa/store', 'DisewaController@store')->name('disewa.store');
    Route::get('barang-disewa/fetchall', 'DisewaController@fetchAll')->name('disewa.fetchAll');
    Route::delete('barang-disewa/delete', 'DisewaController@delete')->name('disewa.delete');
    Route::get('barang-disewa/edit', 'DisewaController@edit')->name('disewa.edit');
    Route::post('barang-disewa/update', 'DisewaController@update')->name('disewa.update');
    
    Route::get('barang-selesai/', 'SelesaiController@index')->name('selesai.index');
    Route::post('barang-sekesai/store', 'SelesaiController@store')->name('selesai.store');    
    Route::get('barang-selesai/fetchall', 'SelesaiController@fetchAll')->name('selesai.fetchAll');
    Route::delete('barang-selesai/delete', 'SelesaiController@delete')->name('selesai.delete');
    Route::delete('barang-selesai/deleteall', 'SelesaiController@deleteAll')->name('selesai.deleteAll');
    Route::get('barang-selesai/edit', 'SelesaiController@edit')->name('selesai.edit');
    Route::post('barang-selesai/update', 'SelesaiController@update')->name('selesai.update');


    Route::get('/pesanan','PesananController@index')->name('pesanan');
    Route::get('/pesanan/{user_id}','PesananController@show')->name('pesanan.show');
    Route::post('/pesanan/{user_id}/confirm','PesananController@confirm')->name('pesanan.confirm');

    Route::get('/denda','DendaController@index')->name('denda');
    Route::post('/denda','DendaController@update');
  

});


Route::namespace('App\Http\Controllers\Admin\Auth')->group(function(){
        
    //Login Routes
    Route::get('admin/login','LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login','LoginController@login');
    Route::post('admin/logout','LoginController@logout')->name('admin.logout');

    //Forgot Password Routes
    Route::get('admin/password/reset','ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('admin/password/email','ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

    //Reset Password Routes
    Route::get('admin/password/reset/{token}','ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('admin/password/reset','ResetPasswordController@reset')->name('admin.password.update');
    
});

Route::namespace('App\Http\Controllers\Auth')->group(function(){
        
    //Login Routes
    Route::get('/login','LoginController@showLoginForm')->name('login');
    Route::post('/login','LoginController@login');
    Route::post('/logout','LoginController@logout')->name('logout');

    //Forgot Password Routes
    Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    //Reset Password Routes
    Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
    
    // Password Confirmation Routes...
    Route::get('password/confirm', 'Admin\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'Admin\ConfirmPasswordController@confirm');
    
    //Register
    Route::get('register/', function () {
        return view('register');
    })->name('register');

    Route::get('register/{role}', 'RegisterController@showRegistrationForm')->name('register.as');
    Route::post('register/{role}', 'RegisterController@register');

    Route::get('profile/', 'ProfileController@index')->name('profile');
    Route::post('profile/', 'ProfileController@update')->name('profile.update');

});

Route::middleware('auth:web')->group(function(){
    Route::get('/pesanan',[App\Http\Controllers\PageController::class, 'indexPesanan'])->name('pesanan.index');
    Route::post('/pesanan',[App\Http\Controllers\PageController::class, 'addPesanan']);
    
    Route::get('/pesanan/{id}',[App\Http\Controllers\PageController::class, 'showPesanan'])->name('pesanan.show');
    Route::post('/pesanan/{id}',[App\Http\Controllers\PageController::class, 'updatePesanan'])->name('pesanan.update');

    Route::get('/pesanan/delete/{id}',[App\Http\Controllers\PageController::class, 'deleteConfirmPesanan'])->name('pesanan.delete');
    Route::delete('/pesanan/delete/{id}',[App\Http\Controllers\PageController::class, 'deletePesanan']);
    Route::get('/peminjaman',[App\Http\Controllers\PageController::class, 'sewa'])->name('peminjaman');
});

Route::get('/', [App\Http\Controllers\PageController::class, 'home'] )->name('dashboard');
Route::get('/kontak', [App\Http\Controllers\PageController::class, 'kontak'] )->name('kontak');

Route::get('/berita', [App\Http\Controllers\PageController::class, 'berita'] )->name('berita');
Route::get('/berita/{id}', [App\Http\Controllers\PageController::class, 'beritaShow'] )->name('berita.show');

Route::get('/alat/{katagori}',[App\Http\Controllers\PageController::class, 'barang'])->name('barang.index');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

