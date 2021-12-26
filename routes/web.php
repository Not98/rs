<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use App\Http\Controllers\Menu;
use App\Http\Controllers\Data;
use App\Http\Controllers\Ajax;
use App\Http\Controllers\Rawat;

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

Route::get('/', function () {
    return view('utama');
});



// auth
Route::get('/login',[User::class,'index'])->name('login')->middleware('guest');
Route::post('/login',[User::class,'login']);
Route::get('/daftar', [User::class,'regist'])->name('daftar')->middleware('guest');
Route::post('/x',[User::class,'daf']);
Route::get('/verif', [User::class,'veriv'])->name('verif')->middleware('guest');
Route::get('/verif/{id}', [User::class,'active']);
Route::get('/reset',[User::class,'reset']);
Route::get('/log_out',[User::class,'log_out']);



Route::get('/menu',[Menu::class,'index'])->name('menu');
// menu
Route::get('/admin',[Menu::class,'admin'])->name('utama_admin');
Route::get('/penyakit',[Menu::class,'penyakit'])->name('setting_penyakit');
Route::get('/setting-user',[Menu::class,'user_stting'])->name('setting-user');

Route::get('/setting',[Menu::class,'setting'])->name('setting-admin');
Route::get('/setting-jadwal',[Menu::class,'jadwal_stting'])->name('setting-jadwal');
Route::get('/spesialis',[Menu::class,'spesialis'])->name('spesialis');
Route::get('/dokter',[Menu::class,'dokter'])->name('dokter');


//daata table
Route::get('/data-penyakit',[Data::class,'penyakit'])->name('data-penyakit');
Route::get('/data-user',[Data::class,'user'])->name('data-user');
Route::get('/data-jadwal',[Data::class,'jadwal_d'])->name('data-jadwal');
Route::get('/data-spesialis',[Data::class,'spesialis'])->name('data-spesialis');
Route::get('/data-doc-spesialis',[Data::class,'d_spesialis'])->name('data-doc-spesialis');
Route::get('/data_rawat_j',[Data::class,'data_rawat_j'])->name('data_rawat_j');


//Ajax sistem
// penyakit
Route::POST('/add-penyakit',[Ajax::class,'add_penyakit'])->name('add-penyakit');
Route::get('/get-penyakit',[Ajax::class,'gt_penyakit'])->name('get-penyakit');
Route::POST('/up_penyakit',[Ajax::class,'up_penyakit'])->name('up_penyakit');
Route::POST('/del-penyakit',[Ajax::class,'del_penyakit'])->name('del-penyakit');

// user
Route::get('/get-user',[Ajax::class,'gt_user'])->name('get-user');
Route::POST('/add-user',[Ajax::class,'add_user'])->name('add-user');
Route::POST('/del-user',[Ajax::class,'del_user'])->name('del-user');
Route::POST('/up-user',[Ajax::class,'up_user'])->name('up-user');
Route::POST('/res-pas-user',[Ajax::class,'rest_user_p'])->name('res-pas-user');

// jadwal
Route::get('/get-hari',[Ajax::class,'gt_hari'])->name('get-hari');
Route::post('/add-jadwal',[Ajax::class,'add_jadwal'])->name('add-jadwal');
Route::get('/edit-jadwal',[Ajax::class,'get_up_jadwal'])->name('edit-jadwal');
Route::post('/update-jadwal',[Ajax::class,'up_jadwal'])->name('update-jadwal');
Route::post('/del-jadwal',[Ajax::class,'del_jadwal'])->name('del-jadwal');

// kriteria Spesialis 
Route::get('/get-all-penyakit',[Ajax::class,'get_all_penyakit'])->name('get-all-penyakit');
Route::get('/get-spesial',[Ajax::class,'get_updat_spesialis'])->name('get-spesial');
Route::POST('/add-kriteria-spesialis',[Ajax::class,'add_spesialis'])->name('add-kriteria-spesialis');
Route::POST('/up-kriteria-spesialis',[Ajax::class,'up_spesialis'])->name('up-kriteria-spesialis');
Route::POST('/del-kriteria-spesialis',[Ajax::class,'del_spesialis'])->name('del-kriteria-spesialis');

//dokter spesialis
Route::get('/get-dok-sps',[Ajax::class,'get_doc_sps'])->name('get-dok-sps');
Route::get('/get-up-dok-sps',[Ajax::class,'get_doc_up_sps'])->name('get-up-dok-sps');
Route::POST('/add-dok-sps',[Ajax::class,'add_doc_spesialis'])->name('add-dok-sps');
Route::POST('/del-dok-sps',[Ajax::class,'del_doc_spesialis'])->name('del-dok-sps');

// nomer rawat
Route::get('/regist-rawat',[Rawat::class,'index'])->name('regist-rawat');
Route::get('/no-control',[Ajax::class,'no_control'])->name('no-control');
Route::get('/no-consul',[Ajax::class,'no_consul'])->name('no-consul');
Route::POST('/notif',[Ajax::class,'notif'])->name('notif');
Route::POST('/ambil-no',[Ajax::class,'ambil_no'])->name('ambil-no');

// panggil no rawat
Route::get('/panggil-no',[Rawat::class,'panggil_no'])->name('panggil-no');
Route::POST('/panggil-no',[Ajax::class,'panggil']);
Route::GET('/get-no',[Ajax::class,'get_panggil'])->name('get-no');
Route::GET('/notif-mail',[Ajax::class,'get_panggil'])->name('notif-mail');
Route::get('/panggil-no-ulang-c',[Data::class,'no_antrian_c'])->name('panggil-no-ulang-c');
Route::get('/panggil-no-ulang-b',[Data::class,'no_antrian_b'])->name('panggil-no-ulang-b');


// priksa dokter
Route::get('/pasien-p',[Ajax::class,'get_pasien'])->name('pasien-p');
Route::get('/g-penyakit',[ajax::class,'get_pn'])->name('g-penyakit');
Route::POST('/rawat-simpan',[ajax::class,'pr_simpan'])->name('rawat-simpan');
Route::POST('/rawat-nex',[ajax::class,'nex'])->name('rawat-nex');


Route::get('/rawat-jalan',[Rawat::class,'r_jalan'])->name('rawat-jalan');
Route::get('/detail-ra',[Ajax::class,'detail_control'])->name('detail-ra');
