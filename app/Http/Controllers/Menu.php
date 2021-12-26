<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;//librey db

class Menu extends Controller
{
    //
    public function __construct(){
      
    }

    public function index()
    {
        if (session('id_level')==4) {
            return view('user.utama');
        }else {
            return view('utama');
        }
    }
    public function admin()
    {
        return view('admin.data');
    }
    //setting
    public function setting()
    {
       return view('admin.setting');
    }
    public function penyakit()
    {
        return view('data.penyakit');
    }
    public function user_stting()
    {
        return view('data.user');
    }
    public function jadwal_stting()
    {
        return view('data.jadwal');
    }
    public function spesialis()
    {
       return view('data.s_dokter');
    }



    // User
    public function rawat()
    {
        return  view('user.daftar');
    }
    // dokter
    public function dokter()
    {
        return view('dokter.pasien');
    }
  

}
