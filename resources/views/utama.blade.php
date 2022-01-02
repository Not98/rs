@extends('templet.main')
@section('content')
@if (session('id_level') == 1)
<center>
<h1><b>SELAMAT DATANG  {{session('nama')}} DI SISTEM INFORMASI PENDAFTARAN ONLINE PASIEN RAWAT JALAN PUSKESMAS BANTARKAWUNG<br>
    Anda login sebagai  Admin</b></h1>
</center>
@elseif(session('id_level') == 2)
<center>
<h1><b>SELAMAT DATANG  {{session('nama')}} DI SISTEM INFORMASI PENDAFTARAN ONLINE PASIEN RAWAT JALAN PUSKESMAS BANTARKAWUNG<br>
    Anda login sebagai  Dokter</b></h1>
</center>
@elseif(session('id_level') == 3)
<center>
<h1><b>SELAMAT DATANG  {{session('nama')}} DI SISTEM INFORMASI PENDAFTARAN ONLINE PASIEN RAWAT JALAN PUSKESMAS BANTARKAWUNG<br>
    Anda login sebagai  Petugas</b></h1>
</center>
@elseif(session('id_level') == 4)
<center> 
    <h1><b>SELAMAT DATANG  {{session('nama')}} DI SISTEM INFORMASI PENDAFTARAN ONLINE PASIEN RAWAT JALAN PUSKESMAS BANTARKAWUNG<br>
        Anda login sebagai  Pasien</b></h1>
    
</center>

@else

<center> <h1><b>SELAMAT DATANG DI SISTEM INFORMASI PENDAFTARAN ONLINE PASIEN RAWAT JALAN PUSKESMAS BANTARKAWUNG
  <br>  Anda belum login, silahkan login untuk mengaskses sistem ini
    </b></h1></center>
@endif
@endsection


@section('js')
@endsection
