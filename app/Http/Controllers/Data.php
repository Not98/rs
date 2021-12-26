<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;//librey db
class Data extends Controller
{
    //
    public function index()
    {

    }
    public function penyakit(Request $request)
    {
    
        if ($request->ajax()) {
            $db = DB::table('penyakit')->get();
            
            return Datatables::of($db)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
    
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
    
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm del">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'penyakit' => function($user) {
                                        return 'row-' . $user->penyakit;
                                    }])
                    ->make(true);
        }
    }
    public function user(Request $request)
    {
        if ($request->ajax()) {
            $db = DB::table('user')->join('level','user.id_level','=','level.id')->select('user','level',DB::raw('IF(status>=1, "Aktiv", "Not Akctiv") as status'))->get();
            return Datatables::of($db)
            ->filter(function ($query) {
                if (request()->has('user')) {
                    $query->where('user', 'like', "%" . request('user') . "%");
                }
                if (request()->has('level')) {
                    $query->where('level', 'like', "%" . request('level') . "%");
                }
                if (request()->has('status')) {
                    $query->where('status', 'like', "%" . request('status') . "%");
                }
            },true)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->user.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->user.'" data-original-title="Reset" class="btn btn-success btn-sm reset">Resset Password</a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->user.'" data-original-title="Delete" class="btn btn-danger btn-sm del">Delete</a>';
                
                return $btn;
            })->rawColumns(['action'])->setRowData([
                              'user' => function($user) {
                                  return 'row-' . $user->user;
                                },
                                'level' => function($user) {
                                    return 'row-' . $user->level    ;
                                  },
                                  'status' => function($user) {
                                    
                                      return 'row-' . $user->status;
                                    }
                               ])->make(true);
        }
    }
    public function daftar(Request $request)
    {
    
        if ($request->ajax()) {
            $db = DB::table('penyakit')->get();
            
            return Datatables::of($db)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm del">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'user' => function($user) {
                                        return 'row-' . $user->penyakit;
                                    }])
                    ->make(true);
        }
          
        
    }
    public function jadwal_d(Request $request)
    {
        if ($request->ajax()) {
            
            $db = DB::table('jadwal')->join('dokter','dokter.code','=','jadwal.code_doc')->get();
            return Datatables::of($db)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->code.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->code.'" data-original-title="Delete" class="btn btn-danger btn-sm del">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'code' => function($user) {
                                        return 'row-' . $user->code;
                                    },
                                    'nama' => function($user) {
                                        return 'row-' . $user->nama;
                                    }])
                    ->make(true);
        }
    }
    public function spesialis(Request $request)
    {
        if ($request->ajax()) {
            $db = DB::table('spesialis')->get();
            return Datatables::of($db)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm del">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'spesialis' => function($user) {
                                        return 'row-' . $user->spesialis;
                                    },
                                    ])
                    ->make(true);
        }
    }
    public function d_spesialis(Request $request)
    {
        if ($request->ajax()) {
            $db = DB::table('dokter_spesialis')->join('dokter','dokter_spesialis.code_dokter','=','dokter.code')->get();
            return Datatables::of($db)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm del">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'spesialis' => function($user) {
                                        return 'row-' . $user->nama;
                                    },
                                    ])
                    ->make(true);
        }
    }
    public function no_antrian_c(Request $request)
    {
        if ($request->ajax()) {
            $db = DB::table('antri')->join('tipe','antri.tipe_id','=','tipe.id')->where('tanggal',date('Y-m-d'))->where('tipe_id',1)->where('status',1)->orderBy('no_antrian', 'desc')->get();
            
            return Datatables::of($db)
            ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->no_antrian.'" data-original-title="Panggil" class="edit btn btn-primary btn-sm panggil-c"><i class="fas fa-volume-up"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'no_antrian' => function($user) {
                                        return 'row-' . $user->no_antrian;
                                    },
                                    ])
                    ->make(true);
        }
    }
    public function no_antrian_b(Request $request)
    {
        if ($request->ajax()) {
            $db = DB::table('antri')->join('tipe','antri.tipe_id','=','tipe.id')->where('tanggal',date('Y-m-d'))->where('tipe_id',4)->where('status',1)->orderBy('no_antrian', 'desc')->get();
            
            return Datatables::of($db)
            ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->no_antrian.'" data-original-title="Panggil" class="edit btn btn-primary btn-sm panggil-b"><i class="fas fa-volume-up"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'no_antrian' => function($user) {
                                        return 'row-' . $user->no_antrian;
                                    },
                                    ])
                    ->make(true);
        }
    }
    public function data_rawat_j(Request $request)
    {
        if ($request->ajax()) {
// SELECT * FROM `user` join pasien ON user.user = pasien.nik join antri ON user.user = antri.nik_p JOIN pasien_brobat ON antri.no_antrian=pasien_brobat.no_antrian WHERE user =111 AND tipe =3 AND status_p='ok';
        $db = DB::table('user')->join('pasien','user.user','=','pasien.nik')->join('antri','user.user','=','antri.nik_p')
            ->join('pasien_brobat','antri.no_antrian','=','pasien_brobat.no_antrian')->join('tipe','antri.tipe_id','=','tipe.id')
            ->join('dokter','pasien_brobat.code_dokter','=','dokter.code')
            ->where('tanggal',date('Y-m-d'))->where('tipe_id',4)->where('pasien_brobat.tipe',3)->where('status_p',"ok")->where('user.user',session('user'))->get();  
            return Datatables::of($db)
            ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->code_rawat.'" data-original-title="View" class="view btn btn-primary btn-sm viewx"><i class="fas fa-eye"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])->setRowData([
                                    'code_rawat' => function($user) {
                                        return 'row-' . $user->code_rawat;
                                    },
                                    'nama' => function($user) {
                                        return 'row-' . $user->nama;
                                    },
                                    'tanggal_brobat' => function($user) {
                                        return 'row-' . $user->tanggal_brobat;
                                    },
                                    ])
                    ->make(true);
        }
    }


}
