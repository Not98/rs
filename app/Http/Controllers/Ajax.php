<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;//librey db
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;//librey hassh
use Illuminate\Support\Facades\Crypt;
use App\Mail\Mailpanggil;
use Illuminate\Support\Facades\Mail;
class Ajax extends Controller
{
// penyakit
    public function add_penyakit(Request $requst)
    {
        if ($requst->ajax()) {
            $msg=[];
            $valid = $requst->validate([
                'penyakit'    => 'required'
            ]);
            $input = $requst->input();
            if ($valid) {
                $wher = DB::table('penyakit')->where('penyakit',$input['penyakit'])->first();
                
                if (!$wher) {
                    $db = DB::table('penyakit')->insert([
                        'penyakit'=>$input['penyakit']
                    ]);
                    if ($db) {
                        $msg =['msg'=>'Data Berhasil Disimpan','sts'=>'success'];
                    }else {
                    $msg = ['msg'=>'Data Tidak Berhasil Disimpan','sts'=>'error'];
                        
                    }
                }else {
                    $msg = ['msg'=>'Nama Penyakit Sudah Ada','sts'=>'error'];
                }
            }else {
                $msg = ['msg'=>'Nama Penyakit Tidak Boleh Kosong','sts'=>'error'];
            }
           return $msg;
        }
    }
    public function gt_penyakit(Request $request)
    {
        $input=$request->input();
        $msg=[];
        // dd($input['id']);
        $wher = DB::table('penyakit')->where('id',$input['id'])->first();
        if ($wher) {
            // $db = DB::table('penyakit')->
            $msg =['msg'=>['data'=>$wher->penyakit,'id'=>$wher->id]];
          
        }else {
            $msg =['msg'=>'Data Tidak Ada','sts'=>'error'];
        }
        return $msg;
    }
    public function up_penyakit(Request $request)
    {
        $input=$request->input();
        $valid = $request->validate([
            'penyakit'    => 'required'
        ]);
        $msg=[];
        if ($valid) {
            if ($request->ajax()) {
              $wher = DB::table('penyakit')->where('id',$input['id'])->first();
                if ($wher) {
                    $db=  DB::table('penyakit')->where('id',$input['id'] )->update(['penyakit' => $input['penyakit'] ]);
                    if ($db) {
                        $msg =['msg'=>'Berhasil Di Rubah','sts'=>'success'];
                    }else {
                        $msg =['msg'=>'Data gagal Di Rubah','sts'=>'error'];
                    }
                }else {
                    $msg =['msg'=>'Data Tidak Ada','sts'=>'error'];
                }
            }else {
                $msg =['msg'=>'Ada yang salah','sts'=>'error'];
            }
        }else {
            $msg =['msg'=>'Data Tidak Valid','sts'=>'error'];
        }
        return $msg;

    }
    public function del_penyakit(Request $request)
    {
        $input=$request->input();
        $valid = $request->validate([
            'id'    => 'required'
        ]);
        $msg=[];
        if ($valid) {
            if ($request->ajax()) {
              $wher = DB::table('penyakit')->where('id',$input['id'])->first();
                if ($wher) {
                    $db=  DB::table('penyakit')->where('id',$input['id'] )->delete();
                    if ($db) {
                        $msg =['msg'=>'Berhasil Di Hapus','data'=>$wher->penyakit,'sts'=>'success'];
                    }else {
                        $msg =['msg'=>'Data gagal Di Hapus','sts'=>'error'];
                    }
                }else {
                    $msg =['msg'=>'Data Tidak Ada','sts'=>'error'];
                }
            }else {
                $msg =['msg'=>'Ada yang salah','sts'=>'error'];
            }
        }else {
            $msg =['msg'=>'Data Tidak Valid','sts'=>'error'];
        }
        return $msg;
    }
// user    
    public function gt_user(Request $request)
    {
        $input=$request->input();
        $msg=[];
        $valid = $request->validate([
            'id'    => 'required'
        ]);
        $msg=[];
        if ($valid) {
            if ($request->ajax()) {
                $wher = DB::table('user')->where('user',$input['id'])->first();
                $karyawan=DB::table('user')->join('karyawan', 'user.user', '=', 'karyawan.nik')
                                        ->join('level','user.id_level','=','level.id')
                                        ->where('user',$input['id'])->first();
                $pasien=DB::table('user')->join('pasien', 'user.user', '=', 'pasien.nik')->join('level','user.id_level','=','level.id')->where('user',$input['id'])->first();
                $dokter=DB::table('user')->join('dokter', 'user.user', '=', 'dokter.code')->join('level','user.id_level','=','level.id')->where('user',$input['id'])->first();
                if ($wher) {
                    if ($karyawan) {
                      $msg =['msg'=>['data'=>[
                            'nama'=>$karyawan->nama,
                            'hp'=>$karyawan->no_hp,
                            'alamat'=>$karyawan->alamat,
                            'masuk'=>date('m/d/Y',strtotime($karyawan->tanggal_masuk)),
                            'status'=>$karyawan->status
                        ],'id'=>$karyawan->user,'tipe'=>'karyawan']];
                    }
                    if ($dokter) {
                        $msg =['msg'=>['data'=>[
                            'nama'=>$dokter->nama,
                            'hp'=>$dokter->no_hp,
                            'status'=>$dokter->status
                        ],'id'=>$dokter->code,'tipe'=>'dokter']];
                    }
                    if ($pasien) {
                        $msg =['msg'=>['data'=>[
                            'nama'=>$pasien->nama,
                            'pn'=>$pasien->penanggungjawab,
                            'alamat'=>$pasien->alamat,
                            'email'=>$pasien->email,
                            'bbjs'=>$pasien->bbjs,
                            'status'=>$pasien->status,
                            'tgl' =>date('m/d/Y',strtotime($pasien->ttl))
                        ],'id'=>$pasien->user,'tipe'=>'pasien']];
                    }
                  
                }else {
                    $msg =['msg'=>'Data Tidak Ada','sts'=>'error'];
                }
            }else {
                
            }
        } else {
            # code...
        }
        return $msg;
    }
    public function add_user(Request $request)
    {
        $input=$request->input();
        $msg=[];
        
        if ($input['tipe']==1) {
            $valid = $request->validate([
                'nik'           => 'required|numeric',
                'nama'          => 'required',
                'tgl' => 'required',
                'no_hp'         => 'required|numeric',
                'alamat'        => 'required',
                'password'      => 'required|min:5'
            ]);
              $dat=[
                'nik'           => $input['nik'],
                'nama'          => $input['nama'],
                'no_hp'         => $input['no_hp'],
                'alamat'        => $input['alamat'],
                'tgl'           => $input['tgl']
              ];
        }elseif ($input['tipe']==2) {
            $valid = $request->validate([
                'code'           => 'required|numeric',
                'nama'          => 'required',
                'password'      => 'required|min:5'
            ]);
            $dat=[
                'code' =>$input['code'],
                'nama' =>$input['nama'],
                'no_hp' =>$input['no_hp']
            ];
        }elseif ($input['tipe']==3) {
            $valid = $request->validate([
                'nik'           => 'required|numeric',
                'nama'          => 'required',
                'tgl'           => 'required',
                'no_hp'         => 'required|numeric',
                'alamat'        => 'required',
                'password'      => 'required|min:5'
            ]);
            $dat=[
                'nik'           => $input['nik'],
                'nama'          => $input['nama'],
                'no_hp'         => $input['no_hp'],
                'alamat'        => $input['alamat'],
                'tgl' => $input['tgl']
            ];
        }elseif ($input['tipe']==4) {
            $valid = $request->validate([
                'nik'       => 'required|numeric',
                'nama'      => 'required',
                'pn'        => 'required',
                'alamat'    => 'required',
                'bbjs'      => 'required|numeric',
                'email'     => 'required|email',
                'password'  => 'required|min:5'
            ]);
            $dat=[
                'nik'                 => $input['nik'],
                'nama'                => $input['nama'],
                'pn'     => $input['pn'],
                'alamat'              => $input['alamat'],
                'ttl'                 => $input['ttl'],
                'alamat'              => $input['alamat'],
                'bbjs'                => $input['bbjs'],
                'email'               => $input['email']
            ];
        }
        $msg=[];
        if ($request->ajax()) {

        if ($valid) {
                if ($input['tipe']==3) {
                   $w= $input['nik'];
                }else{
                   $w= $input['code'];
                }
                $wher = DB::table('user')->where('user',$w)->first();
                if (!$wher) {
                    if ($input['tipe']==1) {
                        $admin = DB::table('karyawan')->insert([
                            'nik'           => $input['nik'],
                            'nama'          => $input['nama'],
                            'no_hp'         => $input['no_hp'],
                            'alamat'        => $input['alamat'],
                            'tanggal_masuk' => date('Y-m-d',strtotime($input['tgl']))
                        ]);
                        if ($admin) {
                            $user = DB::table('user')->insert([
                                'password' => Hash::make($input['password']),
                                'user'     => $input['nik'],
                                'id_level' =>'1',
                                'status'   =>$input['status']
                            ]);
                            if ($user) {
                                $msg =['msg'=>'Data Berhasil Disimpan','sts'=>'success'];
                            }else{
                                $msg = ['msg'=>'Data Tidak Berhasil Disimpan','sts'=>'error']; 
                            }
                        }
                    }elseif ($input['tipe']==2) {
                        $dokter = DB::table('dokter')->insert([
                            'code' =>$input['code'],
                            'nama' =>$input['nama'],
                            'no_hp' =>$input['no_hp']
                        ]);
                      if ($dokter) {
                        $user = DB::table('user')->insert([
                            'password' => Hash::make($input['password']),
                            'user'     => $input['code'],
                            'id_level' =>'2',
                            'status'   =>$input['status']
                        ]);
                        if ($user) {
                            $msg =['msg'=>'Data Berhasil Disimpan','sts'=>'success'];
                        }else{
                            $msg = ['msg'=>'Data Tidak Berhasil Disimpan','sts'=>'error']; 
                        }
                      }
                    }elseif ($input['tipe']==3) {
                        $karyawan = DB::table('karyawan')->insert([
                            'nik'           => $input['nik'],
                            'nama'          => $input['nama'],
                            'no_hp'         => $input['no_hp'],
                            'alamat'        => $input['alamat'],
                            'tanggal_masuk' => date('Y-m-d',strtotime($input['tgl']))
                        ]);
                        if ($karyawan) {
                            $user = DB::table('user')->insert([
                                'password' => Hash::make($input['password']),
                                'user'     => $input['nik'],
                                'id_level' =>'3',
                                'status'   =>$input['status']
                            ]);
                            if ($user) {
                                $msg =['msg'=>'Data Berhasil Disimpan','sts'=>'success'];
                            }else{
                                $msg = ['msg'=>'Data Tidak Berhasil Disimpan','sts'=>'error']; 
                            }
                        }
                    }elseif ($input['tipe']==4) {
                        $pasien = DB::table('pasien')->insert([
                            'nik'                 => $input['nik'],
                            'nama'                => $input['nama'],
                            'penanggungjawab'     => $input['pn'],
                            'alamat'              => $input['alamat'],
                            'ttl'                 => date('Y-m-d',strtotime($input['ttl'])),
                            'alamat'              => $input['alamat'],
                            'bbjs'                => $input['bbjs'],
                            'email'               => $input['email']
                        ]);
                        if ($pasien) {
                            $user = DB::table('user')->insert([
                                'password' => Hash::make($input['password']),
                                'user'     => $input['nik'],
                                'id_level' =>'4',
                                'status'   =>'0'
                            ]);
                            if ($user) {
                                $x=str_replace('/','-',Crypt::encryptString($input['nik']));
                              $details = [
                                    'title' => 'Verifikasi Account',
                                    'urlv'=>url("verif/{$x}"),
                                    'user'=>$input['nik']
                                    ];
                                    $send = Mail::to($input['email'])->send(new SendMail($details));
                                $msg =['msg'=>'Data Pasien Berhasil Di Simpan','sts'=>'success'];
                            }else {
                                $msg = ['msg'=>'Data Tidak Berhasil Disimpan','sts'=>'error']; 
                            }
                        }else {
                            $msg = ['msg'=>'Data Tidak Berhasil Disimpan','sts'=>'error']; 
                        }
                    }else {
                        $msg = ['msg'=>'Ada Yang salah','sts'=>'error']; 
                    }
                }else {
                    $msg =['msg'=>'Data Tidak Ada','sts'=>'error'];
                }
            }else {
                $msg = $request->assertInvalid([
                    'name' => 'The name field is required.',
                    'email' => 'valid email address',
                ]);
            }
        }
        
       
        
        return $msg;
    }
    public function del_user(Request $request)
    {
        $input=$request->input();
        $msg=[];
        // dd($input['id']);
        
        $valid = $request->validate([
            'id'    => 'required'
        ]);
        $msg=[];
        if ($valid) {
            if ($request->ajax()) {
                $wher = DB::table('user')->where('user',$input['id'])->first();
                $karyawan=DB::table('user')->join('karyawan', 'user.user', '=', 'karyawan.nik')
                                        ->join('level','user.id_level','=','level.id')
                                        ->where('user',$input['id'])->delete();
                $pasien=DB::table('user')->join('pasien', 'user.user', '=', 'pasien.nik')->join('level','user.id_level','=','level.id')->where('user',$input['id'])->delete();
                $dokter=DB::table('user')->join('dokter', 'user.user', '=', 'dokter.code')->join('level','user.id_level','=','level.id')->where('user',$input['id'])->delete();
                if ($wher) {
                    if ($karyawan) {
                            $msg =['msg'=>'Berhasil Di Hapus','data'=>$wher->user,'sts'=>'success'];
                    }else if ($dokter) {
                            $msg =['msg'=>'Berhasil Di Hapus','data'=>$wher->user,'sts'=>'success'];
                    }
                    if ($pasien) {
                            $msg =['msg'=>'Berhasil Di Hapus','data'=>$wher->user,'sts'=>'success'];
                    }else{
                        $msg =['msg'=>'Data gagal Di Hapus','sts'=>'error'];
                    }
                  
                }else {
                    $msg =['msg'=>'Data Tidak Ada','sts'=>'error'];
                }
            }else {
                $msg =['msg'=>'Ada yang salah','sts'=>'error'];
            }
        } else {
            $msg =['msg'=>'Data Tidak Valid','sts'=>'error'];
        }
        
        
        return $msg;
    }
    public function up_user(Request $request)
    {
        $input=$request->input();
        $msg=[];
        if ($input['tipe']=='pasien') {
            $valid = $request->validate([
                'nama'    => 'required',
                'pn'      => 'required',
                'bbjs'    => 'required',
                'alamat'  => 'required',
                'status'  => 'required',
                'id'      => 'required'
            ]);
            $tbjoin='pasien';
            $join='user.user';
            $on='pasien.nik';
            $data=['nama'=>$input['nama'],'penanggungjawab'=>$input['pn'],'bbjs'=>$input['bbjs'],'alamat'=>$input['alamat'],'status'=>$input['status'],'ttl'=>date('Y-m-d',strtotime($input['ttl']))];
        }
        if ($input['tipe']=='karyawan') {
            $valid = $request->validate([
                'nama'    => 'required',
                'hp'      => 'required',
                'alamat'    => 'required',
                'masuk'  => 'required',
                'status'  => 'required',
                'id'      => 'required'
            ]);
            $tbjoin='karyawan';
            $join='user.user';
            $on='karyawan.nik';
            $data=['nama'=> $input['nama'],'no_hp'=> $input['hp'],'alamat'=> $input['alamat'],'tanggal_masuk' => date('Y-m-d',strtotime($input['masuk'])),'status'=>$input['status']];
        }
        if ($input['tipe']=='dokter') {
            $valid = $request->validate([
                'nama'    => 'required',
                'hp'      => 'required'
            ]);
            $tbjoin='dokter';
            $join='user.user';
            $on='dokter.code';
            $data=['nama'=> $input['nama'],'no_hp'=> $input['hp'],'status'=>$input['status']];
        }
        if ($valid) {
            if ($request->ajax()) {
                $up=DB::table('user')->join($tbjoin,$join,'=',$on)->where('user.user',$input['id'])->update($data);
                if ($up) {
                    $msg =['msg'=>'Berhasil Di Rubah','sts'=>'success'];
                }else {
                    $msg =['msg'=>'Data gagal Di Rubah','sts'=>'error'];
                }
            }
        }else {
            $msg =['msg'=>'Data gagal Di Rubah','sts'=>'error'];
        }
        return $msg;
    }
    public function rest_user_p(Request $request)
    { 
        if ($request->ajax()) {
            $res = DB::table('user')->where('user',$request->input('id', 'default'))->update(['password'=>Hash::make('simpus123')]);
            if ($res) {
                $msg=['data'=>$request->input('id', 'default')];
            }else {
                $msg=['data'=>'er'];
            }    
        }
       return $msg;
    }
// jadwal
    public function gt_hari(Request $request)
    {
        
        if ($request->ajax()) {
            $hr= DB::table('hari')->get();
            $dokter=DB::table('dokter')->get();
            $data=['hari'=>$hr,'dokter'=>$dokter];
            return $data;
        }
    }
    public function add_jadwal(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $s=$input['hr'];
            $a=[];
            $cek= DB::table('jadwal')->where('code_doc',$input['id'])->first();
            if (!$cek) {
                if ($input['hr']) {
                    $a[]=['code_doc'=>$input['id'],'id_hari'=>$input['hr']];
                    $in=DB::table('jadwal')->insert($a);
                    if ($in) {
                        $msg =['msg'=>'Berhasil Di Simpan','sts'=>'success'];
                    }else {
                        $msg =['msg'=>'Data gagal Di Rubah','sts'=>'error'];
                    }
                }
            }else {
            $msg =['msg'=>'Silahkan Lakukan Update','sts'=>'warning'];
            }
            
        }
        return $msg;
    }
    public function get_up_jadwal(Request $request)
    {
        if ($request->ajax()) {
            $html=[];
            $input=$request->input();
            $jd=DB::table('jadwal')->where('code_doc',$input['code'])->get();
            $hr=DB::table('hari')->get();
            foreach ($jd as $key => $value) {
               $x=explode (",",$value->id_hari);
            }
            
            foreach ($hr as  $val) {
                if (in_array($val->id,$x)) {
                    $xx="checked";
                }else {
                    $xx="";
                }
                $html[]= '<div class="row justify-content-center"><div class="col-md-1"><input class="form-check-input hr" value="'. $val->id .'" type="checkbox"'.$xx.'></div><div class="col-md-2"><label class="form-check-label">'.$val->hari.'</label></div></div>';

            }
                
           return $html;
        }

    }
    public function up_jadwal(Request $request)
    {
        if ($request->ajax()) {
            $html=[];
            $input=$request->input();
            $hr=DB::table('jadwal')->where('code_doc',$input['id'])->get();
            if ($hr) {
                $up = DB::table('jadwal')->where('code_doc',$input['id'])->update([
                    'id_hari'=>$input['hr']
                ]);
                if ($up) {
                    $msg =['msg'=>'Jadwal Berhasil Di Ubah','sts'=>'success'];

                }else {
                    $msg =['msg'=>'Jadwal Gagal Di Ubah','sts'=>'error'];

                }
            }else {
                $msg =['msg'=>'Jadwal Gagal Di Ubah','sts'=>'error'];

            }
          

           return $msg;
        }
    }
    public function del_jadwal(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $msg=[];
            $s=DB::table('dokter')->join('jadwal','dokter.code','=','jadwal.code_doc')->where('jadwal.code_doc',$input['id'])->first();
            $del=DB::table('jadwal')->where('code_doc',$input['id'])->delete();
            if ($del) {
                $msg =['msg'=>'Kriteria " '.$s->nama.' " Spesialis Berhasil Di Hapus','sts'=>'success'];
            }else {
                $msg =['msg'=>'jadwal Gagal Di Hapus','sts'=>'error'];
            }
        }
        return $msg;
    }
// Spesialis
    public function get_all_penyakit(Request $request)
    {
        if ($request->ajax()) {
            return DB::table('Penyakit')->get();
        }
    }
    public function add_spesialis(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $a=[];
            $cek= DB::table('spesialis')->where('spesialis',$input['spesial'])->first();
            if (!$cek) {
                if ($input['id_penyakit']&&$input['spesial']) {
                    $a=['spesialis'=>$input['spesial'],'id_penyakit'=>$input['id_penyakit']];
                    $in=DB::table('spesialis')->insert($a);
                    if ($in) {
                        $msg =['msg'=>'Berhasil Di Simpan','sts'=>'success'];
                    }else {
                        $msg =['msg'=>'Data gagal Di Simpan','sts'=>'error'];
                    }
                }
            }else {
            $msg =['msg'=>'Silahkan Lakukan Update','sts'=>'warning'];
            }
            
        }
        return $msg;
    }
    public function get_updat_spesialis(Request $request)
    {
        if ($request->ajax()) {
            $html=[];
            $input=$request->input();
            $sps=DB::table('spesialis')->where('id',$input['id'])->get();
            $pn=DB::table('penyakit')->get();
            foreach ($sps as $key => $value) {
                $nm=$value->spesialis;
                $x=explode (",",$value->id_penyakit);
            }
            $html []= '<input name="spesial" type="txet" name="spesialis" value="'.$nm.'" class="swal2-input form-control"><div class="row">';
            foreach ($pn as  $val) {
                if (in_array($val->id,$x)) {
                    $xx="checked";
                }else {
                    $xx="";
                }
                $html[]= '<div class="col-sm-6"><div class="row justify-content-center"><div class="col-md-1"><input class="form-check-input sps" value="'. $val->id .'" type="checkbox"'.$xx.'></div><div class="col-md-3"><label class="form-check-label">'.$val->penyakit.'</label></div></div></div>';
            }
                
           return $html;
        }
    }
    public function up_spesialis(Request $request)
    {
        if ($request->ajax()) {
            $html=[];
            $input=$request->input();
            $sps=DB::table('spesialis')->where('id',$input['id'])->get();
            if ($sps) {
                $up = DB::table('spesialis')->where('id',$input['id'])->update([
                    'id_penyakit'=>$input['id_sps'],
                    'spesialis' =>$input['spesialis']
                    
                ]);
                if ($up) {
                    $msg =['msg'=>'Spesialis Berhasil Di Ubah','sts'=>'success'];
                }else {
                    $msg =['msg'=>'Spesialis Gagal Di Ubah','sts'=>'error'];
                }
            }else {
                $msg =['msg'=>'Spesialis Gagal Di Ubah','sts'=>'error'];
            }
           return $msg;
        }
    }
    public function del_spesialis(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $msg=[];
            $s=DB::table('spesialis')->where('id',$input['id'])->first();
            $del=DB::table('spesialis')->where('id',$input['id'])->delete();
            if ($del) {
                $msg =['msg'=>'Kriteria " '.$s->spesialis.' " Spesialis Berhasil Di Hapus','sts'=>'success'];
            }else {
                $msg =['msg'=>'Kriteria Spesialis Gagal Di Hapus','sts'=>'error'];
            }
        }
        return $msg;
    }
// docter spesialis
    public function get_doc_sps(Request $request)
    {
        if ($request->ajax()) {
            $dokter = DB::table('dokter')->get();
            $sps =  DB::table('spesialis')->get();
            $data=['dokter'=>$dokter,'spesial'=>$sps];
            return $data;
        }
    }
    public function add_doc_spesialis(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $a=[];
            $cek= DB::table('dokter_spesialis')->where('code_dokter',$input['code'])->first();
            if (!$cek) {
                if ($input['code']&&$input['id_sps']) {
                    $a=['id_spesialis'=>$input['id_sps'],'code_dokter'=>$input['code']];
                    $in=DB::table('dokter_spesialis')->insert($a);
                    if ($in) {
                        $msg =['msg'=>'Berhasil Di Simpan','sts'=>'success'];
                    }else {
                        $msg =['msg'=>'Data gagal Di Simpan','sts'=>'error'];
                    }
                }
            }else {
            $msg =['msg'=>'Silahkan Lakukan Update','sts'=>'warning'];
            }
            
        }
        return $msg;
    }
    public function get_doc_up_sps(Request $request)
    {
        if ($request->ajax()) {
            $msg=[];
            $cekbok=[];
            $alldoc=[];
            $dok=[];
            $input=$request->input();
            $doc=DB::table('dokter')->get();
            $gt_sps=DB::table('dokter_spesialis')->join('dokter','dokter_spesialis.code_dokter','=','dokter.code')->where('dokter_spesialis.id',$input['id'])->first();
            $sps=DB::table('spesialis')->get();
            if ($gt_sps) {
                    $x=explode(",",$gt_sps->id_spesialis);
            }
            foreach ($sps as $key => $value) {
                if (in_array($value->id,$x)) {
                    $xx="checked";
                }else {
                    $xx="";
                }
                $cekbok[]=['id'=>$value->id,'spesialis'=>$value->spesialis,'status'=>$xx];
            }
           
            $dok=['dokter'=>$gt_sps->nama,'code'=>$gt_sps->code_dokter];
            $msg=['aktiv'=>$dok,'chekbok'=>$cekbok];
        }
        return $msg;
    }
    public function del_doc_spesialis(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $msg=[];
            $s=DB::table('dokter_spesialis')->join('dokter','dokter.code','=','dokter_spesialis.code_dokter')->where('dokter_spesialis.id',$input['id'])->first();
            $del=DB::table('dokter_spesialis')->where('id',$input['id'])->delete();
            if ($del) {
                $msg =['msg'=>'Kriteria " '.$s->nama.' " Spesialis Berhasil Di Hapus','sts'=>'success'];
            }else {
                $msg =['msg'=>'Kriteria Spesialis Gagal Di Hapus','sts'=>'error'];
            }
        }
        return $msg;
    }
// daftar rawat
    public function no_control(Request $request)
    {
        if ($request->ajax()) {
            $data=[];
            $no = DB::table('antri')->join('tipe','antri.tipe_id','=','tipe.id')->where('tanggal',date('Y-m-d'))->where('tipe_id',1)->orderByDesc('antri.id')->pluck('no_antrian')->first();
            // dd($no);
            if ($no) {
                $x=explode('CN-',$no);
                $ss=1+(int)$x[1];
                $data=['no'=>'CN-'.$ss];
            }else {
                $data=['no'=>'CN-1'];
            }
        }
        return $data;
    }
    public function no_consul(Request $request)
    {
        if ($request->ajax()) {
            $data=[];
            $no = DB::table('antri')->join('tipe','antri.tipe_id','=','tipe.id')->where('tanggal',date('Y-m-d'))->where('tipe_id',4)->orderByDesc('antri.id')->pluck('no_antrian')->first();
            if ($no) {
                $x=explode('CL-',$no);
                $ss=1+(int)$x[1];
                $data=['no'=>'CL-'.$ss];
            }else {
                $data=['no'=>'CL-1'];
            }
        }
        return $data;
    }
    public function ambil_no(Request $request)
    {
        if ($request->ajax()) {
            $data=[];
            $input=$request->input();
            // $x=explode('CN-',$input['id']);
            // $ss=1+(int)$x;
            // dd($ss);
            if ($input['tipe']==1) {
                // $x=explode('CN-',$input['id']);
                // $no=1+(int)$x;
                $ins=DB::table('antri')->insert(['no_antrian'=>$input['id'],'nik_p'=>session('user'),'tipe_id'=>1,'tanggal'=>date('Y-m-d'),'status'=>0]);

                 if ($ins) {
                    $msg =['msg'=>'Nomer Antrian Telah Di Anbil Silahkn Tunggu','sts'=>'success'];
                 }
            }elseif ($input['tipe']==2) {
                // $x=explode('CN-',$input['id']);
                // $no=1+(int)$x;
                $ins=DB::table('antri')->insert(['no_antrian'=>$input['id'],'nik_p'=>session('user'),'tipe_id'=>4,'tanggal'=>date('Y-m-d'),'status'=>0]);
                 if ($ins) {
                    $msg =['msg'=>'Nomer Antrian Telah Di Anbil Silahkn Tunggu','sts'=>'success'];
                 }
            }

        }
        return $msg;
    }
    public function get_panggil(Request $request)
    {
        if ($request->ajax()) {
            $data=[];
            $input = $request->input();
            if ($input['tipe']==1) {
                $no = DB::table('antri')->join('tipe','antri.tipe_id','=','tipe.id')->where('tanggal',date('Y-m-d'))->where('tipe_id',1)->where('status',0)->orderBy('antri.id', 'asc')->pluck('no_antrian')->first();
                if ($no) {
                  
                    $data=['no'=>$no];
                }else {
                    $data=['no'=>'CN-0'];
                }
            }elseif ($input['tipe']==2) {
                $no = DB::table('antri')->join('tipe','antri.tipe_id','=','tipe.id')->where('tanggal',date('Y-m-d'))->where('tipe_id',4)->where('status',0)->orderBy('antri.id', 'asc')->pluck('no_antrian')->first();

                if ($no) {
                   
                    $data=['no'=>$no];
                }else {
                    $data=['no'=>'CL-0'];
                }
            }
            // dd($no);
           
        }
        return $data;
    }
    public function panggil(Request $request)
    {
        if ($request->ajax()) {
            $msg=[];
            $input=$request->input();
            if ($input['id']) {
                $panggil= DB::table('antri')->where('no_antrian',$input['id'])->where('tanggal',date('Y-m-d'))->update(['status'=>1]);
                if ($panggil) {
                    $msg =['msg'=>'Nomer Antrian Telah Di Panggil','sts'=>'success'];
                  
                    
                }
            }
        }
        return $msg;
    }
    public function notif(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $x=explode('CN-',$input['id']);
            if ($x[0]=='CN-') {
                $wher='CN-'.(3+(int)$x[1]);
            }else {
                $x=explode('CL-',$input['id']);
                $wher='CL-'.(3+(int)$x[1]);
            }
            $email= DB::table('user')->join('pasien','user.user','=','pasien.nik')->join('antri','user.user','=','antri.nik_p')->where('antri.no_antrian',$wher)->pluck('email')->first();
            if ($email) {
                $details=[
                    'title' => 'Panggilan Nomer Antrian',
                    'no'=>$input['id']
                ];
                $send = Mail::to($email)->send(new Mailpanggil($details));
            }else {
                
            }
        }
    }


    public function get_pasien(Request $request)
    {
        if ($request->ajax()) {
            $input=$request->input();
            $get= DB::table('antri')->join('user','antri.nik_p','=','user.user')->join('pasien','antri.nik_p','=','pasien.nik')->where('antri.status',1)->where('antri.tipe_id',4)->whereDate('antri.tanggal',date('Y-m-d'))->where('status_p',"")->orderBy('antri.id','asc')->get();
            if ($get) {
               $data=['antri'=>$get[0]->no_antrian,'nama'=>$get[0]->nama,'cod_p'=>$get[0]->no_antrian.date('md')];
            }
        }
        // dd($get);
        return $data;
    }
    public function get_pn(Request $request)
    {
        if ($request->ajax()) {
            return DB::table('penyakit')->get();
        }
        
    }
    public function pr_simpan(Request $request)
    {
        if ($request->ajax()) {

            $msg=[];
            $valid = $request->validate([
                'sakit'    => 'required',
                'code'=>'required',
                'tipe'=>'required',
            ]);
            $input = $request->input();
            if ($valid) {
                $data=[
                    'no_antrian'=>$input['antri'],
                    'code_rawat'=>$input['code'],
                    'id_penyakit'=>$input['sakit'],
                    'tipe'=>$input['tipe'],
                    'code_dokter'=>session('user'),
                    'keterangan'=>$input['ket'],
                    'tanggal_brobat'=>date('Y-m-d'),
    
                ];
            $wher = DB::table('pasien_brobat')->where('code_rawat',$input['code'])->first();
            if (!$wher) {
                $in=DB::table('pasien_brobat')->insert($data);
                if ($in) {
                    $up= DB::table('antri')->where('no_antrian',$input['antri'])->update('status_p','ok');
                    $msg =['msg'=>'Data Pasien Berhasil Di Simpan','sts'=>'success'];
                }else {
                    $msg =['msg'=>'Data Pasien Gagal Di Simpan','sts'=>'error'];
                    
                }
            }else {
                $msg =['msg'=>'Code Periksa sudah ada','sts'=>'error'];
            }
            }
        }
        return $msg;
    }

    public function nex(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->input();
            $msg=[];
            $up = DB::table('antri')->where('no_antrian',$input['code'])->update(['status_p'=>'nex']);
            if ($up) {
                $msg =['msg'=>'Next Pasien OK','sts'=>'success'];
            }
        }
        return $msg;
    }


    public function detail_control(Request $request)
    {
      if ($request->ajax()) {
        $input = $request->input();
        $gb= DB::table('pasien_brobat')->join('control','control.code_rw_jl','=','pasien_brobat.code_rawat')->join('antri','pasien_brobat.no_antrian','=','antri.no_antrian')->where('control.code_rw_jl',$input['code'])->get();
        return $gb;
      }
    }

    public function cek()
    {
        
        $db = DB::table('user')->join('pasien','user.user','=','pasien.nik')->join('antri','user.user','=','antri.nik_p')
            ->join('pasien_brobat','antri.no_antrian','=','pasien_brobat.no_antrian')->join('tipe','antri.tipe_id','=','tipe.id')
            ->join('dokter','pasien_brobat.code_dokter','=','dokter.code')
            ->where('tanggal',date('Y-m-d'))->where('tipe_id',4)->where('pasien_brobat.tipe',3)->where('status_p',"ok")->where('user.user',session('user'))->get();  
        echo json_encode($db);
        
    }
    
}
