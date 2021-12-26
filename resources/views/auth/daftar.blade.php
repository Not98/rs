<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIMPUS</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('/thems/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link href="{{asset('/thems/vendor/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
        <link href="{{asset('/thems/vendor/date/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/thems/css/sb-admin-2.min.css')}}" rel="stylesheet">
  
    <style>
        .bg-register-s {
            background: url("{{asset('thems/bg.jpg')}}");
            background-position: center;
            background-size: cover;
            height: 551px;
            width: 500px;
            }
    </style>
</head>

<body class="bg-gradient-primary">

  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                   <div class="row">
                <div>
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Pendaftaran Akun SIMPUS</h1>
                        </div>
                        <form action="/x" method="post" class="user">
                          @csrf

                            <div class="form-group">
                                <input type="text"  class="form-control form-control-user @error('nik') is-invalid @enderror" id="nik" name="nik"  value="{{ old('nik')}}" placeholder="Masukan Nik">
                                  @error('nik')
                                    {{$message}}
                                @enderror
                              </div><!-- form-group -->
                              
                              <div class="form-group">
                                <input type="text"  class="form-control form-control-user @error('nama') is-invalid @enderror" id="nama" name="nama"  value="{{old('nama')}}"placeholder="Masukan Nama Sesuai KTP">
                                  @error('nama')
                                    {{$message}}
                                @enderror
                      
                              </div><!-- form-group -->


                              <div class="form-group">
                                <input type="text"  class="form-control form-control-user @error('bbjs') is-invalid @enderror" id="bbjs" name="bbjs"  value="{{old('bbjs')}}" placeholder="Masukan No BBJS">
                                  @error('bbjs')
                                    {{$message}}
                                  @enderror
                              </div><!-- form-group -->


                              <div class="form-group">
                                <input type="text"  class="form-control form-control-user @error('pnjb') is-invalid @enderror" id="pnjb" name="pnjb"  value="{{old('pnjb')}}" placeholder="Masukan Penanggung jawab">
                                  @error('pnjb')
                                    {{$message}}
                                  @enderror
                              </div><!-- form-group -->
                            


                              <div class="form-group">
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                  <input type="text" class="form-control" name="ttl" data-target="#reservationdate">                       
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                      <div class="input-group-text">
                                      <i class="fa fa-calendar">
                                      </i></div>
                                  </div>
                             
                                @error('ttl')
                                {{$message}}
                               @enderror
                              </div>
                              <br>
                              <div class="form-group">
                                <input type="text"  class="form-control form-control-user  @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{old('alamat')}}" placeholder="Masukan Alamat Lengkap">
                                  @error('alamat')
                                    {{$message}}
                                @enderror
                                </div><!-- form-group -->
                              <div class="form-group">
                                <input type="email"  class="form-control form-control-user @error('email') is-invalid @enderror"  id="email" name="email" value="{{old('email')}}" placeholder="Masukan Email">
                                @error('email')
                                    {{$message}}
                                @enderror
                              </div><!-- form-group -->
                              <div class="form-group">
                                <input type="password"  class="form-control form-control-user @error('password') is-invalid @enderror"  id="password" name="password"  placeholder="Enter your password">
                                @error('password')
                                    {{$message}}
                                @enderror
                              </div><!-- form-group -->
                        <button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
                            
                         
                            
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="/login">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
    
        </div>
    </div>
    <!-- Outer Row -->
    
</div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('/thems/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/thems/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('/thems/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('/thems/vendor/daterangepicker/daterangepicker.js')}}" ></script>
    <script src="{{asset('/thems/vendor/moment/moment.min.js')}}" ></script>
    <script src="{{asset('/thems/vendor/date/js/bootstrap-datetimepicker.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('/thems/js/sb-admin-2.min.js')}}"></script>
    
<script>
  
  $(function() {
    
 //Date picker

    //Date range picker
    
    //Date range picker with time picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    });
  </script>

</body>

</html>


