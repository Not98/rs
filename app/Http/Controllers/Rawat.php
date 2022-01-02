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
class Rawat extends Controller
{
    public function index()
    {
        return view('user.rawat');
    }
    public function panggil_no(Request $request)
    {
        return view('user.panggil_rawat');
    }
    public function r_jalan()
    {
        return view('user.histori_rj');
    }
    public function r_um()
    {
        return view('user.histori_um');
    }
}
