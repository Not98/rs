<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;//librey hassh
use Illuminate\Support\Facades\DB;//librey db
use lluminate\Database\Query\JoinClause;//query joun
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class User extends Controller
{
    //
    public function menu()
    {
        
    }
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $input = $request->input();
        $sess  = [];
        $karyawan=DB::table('user')->join('karyawan', 'user.user', '=', 'karyawan.nik')
                ->join('level','user.id_level','=','level.id')
                ->where('user',$request['user'])->first();
        $pasien=DB::table('user')->join('pasien', 'user.user', '=', 'pasien.nik')->join('level','user.id_level','=','level.id')->where('user',$request['user'])->first();
        $dokter=DB::table('user')->join('dokter', 'user.user', '=', 'dokter.code')->join('level','user.id_level','=','level.id')->where('user',$request['user'])->first();
        $valid = $request->validate([
            'user'    => 'required',
            'password'=> 'required'
        ]);
        if ($valid) {
            if ( csrf_token()) {// validasi csrf xss

                // validasi user
               if ($karyawan) {
                //    pembuatan sessen
                if (Hash::check($input['password'],$karyawan->password)) {
                    $sess = [
                        'user' => $karyawan->nik,
                        'nama' => $karyawan->nama,
                        'level'=> $karyawan->level ,
                        'id_level'=> $karyawan->id_level,
                        'status'=>$karyawan->status
                    ];
                    session($sess);
                    return redirect()->intended('menu');
                }else{
                    return back()->with('erroruser','Password salah');
                }
               }else if ($pasien) {
                if (Hash::check($input['password'],$pasien->password)) {
                        $sess = [
                            'user' => $pasien->nik,
                            'nama' => $pasien->nama,
                            'level'=> $pasien->level ,
                            'id_level'=> $pasien->id_level,
                            'status'=>$pasien->status
                        ];
                        session($sess);
                        return redirect()->intended('menu');
                    }else{
                        return back()->with('erroruser','Password salah');
                    }
                }else if ($dokter) {
                    if (Hash::check($input['password'],$dokter->password)) {
                        $sess = [
                            'user' => $dokter->code,
                            'nama' => $dokter->nama,
                            'level'=> $dokter->level ,
                            'id_level'=> $dokter->id_level,
                            'status'=>$dokter->status
                        ];
                        session($sess);
                      
                            return redirect()->intended('menu');
                    }else{
                        return back()->with('erroruser','Password salah');
                    }
              }else{
                return back()->with('erroruser','User Tidak Ada');
               }
            
            }else {
                return back()->with('e','Login error'); 
            }
        }else {
            return back()->with('e','Login error'); 
        }
    }
    public function regist()
    {
        return view('auth.daftar');
    }
    public function daf(Request $request)
    {
        $input = $request->input();

        $valid = $request->validate([
            'nik'      => 'required',
            'nama'     => 'required',
            'pnjb'     => 'required',
            'alamat'   => 'required',
            'ttl'      => 'required',
            'bbjs'      => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);
        $nik = DB::table('user')->join('pasien','user.user','=','pasien.nik')->where('user',$input['nik'])->first();
        // dd(date('Y-m-d',strtotime($input['ttl'])));
        if ($valid) {
            if (csrf_token()) {
             if (!$nik) {
                $pasien = DB::table('pasien')->insert([
                    'nik'                 => $input['nik'],
                    'nama'                => $input['nama'],
                    'penanggungjawab'     => $input['pnjb'],
                    'alamat'              => $input['alamat'],
                    'ttl'                 => date('Y-m-d',strtotime($input['ttl'])),
                    'alamat'              => $input['alamat'],
                    'email'               => $input['email'],
                    'bbjs'               => $input['bbjs']
                   
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
                        // dd(url("verif/{$x}"));
                            $details = [
                            'title' => 'Verifikasi Account',
                            'urlv'=>url("verif/{$x}"),
                            'user'=>$input['nik']
                            ];
                            $send = Mail::to($input['email'])->send(new SendMail($details));
                             return redirect('login');
                       
                    }
                }else {
                    echo "add error";
                }
             }else{
                 echo "user";
             }
            }else{
                echo "ada";
            }
        }
        
    }
    public function veriv()
    {
        // $x=str_replace('/','-',Hash::make("c"));
        // dd(url("verif/{$x}"));
        // $x=str_replace('/','-',Hash::make("c"));
        $x=str_replace('/','-',Crypt::encryptString('x'));
        // dd(url("verif/{$x}"));
            $details = [
            'title' => 'Verifikasi Account',
            'urlv'=>url("verif/{$x}")
            ];
            $send = Mail::to('faisal.faadi@gmail.com')->send(new SendMail($details));

    }
    public function active($id)
    {
        $up =DB::table('user')->where('user',Crypt::decryptString($id))->update(['status'=>1]);
        if ($up) {
            return redirect('login');
        }
        // if (Hash::check('c',str_replace('-','/',$id))) {
      

        // }
    }
    public function log_out(){
        $sess = ['user','nama','level','id_level'];
        session()->forget($sess);
        session()->flush();
        return redirect()->intended('/');
    }
    public function reset()
    {
        return view('auth.reset');
    }
    public function sendOTPree()
    {
        # code...
    }

}
