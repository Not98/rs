<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SIMPUS Bantarkawung">

    <title>SIMPUS Bantarkawung</title>

    <link href="{{asset('/thems/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/thems/css/sb-admin-2.min.css')}}" rel="stylesheet">

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
                                        <h1 class="h4 text-gray-900 mb-4">SIMPUS Bantarkawung</h1>
                                    </div>
                                    @if(session()->has('erroruser'))
                                    <div class="alert alert-danger" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                      <strong class="d-block d-sm-inline-block-force">{{session('erroruser')}}</strong>
                                    </div>
                                             
                                  @endif
                                  <form action="/reset" method="post" class="user">
                                    @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user  @error('user') is-invalid @enderror"
                                            id="user" name="user"  value="{{old('user')}}"  aria-describedby="user"
                                                placeholder="Masukan User ">
                                                @error('user')
                                                {{$message}}
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Confirmasi</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="daftar">Create an Account!</a>
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

      <!-- Custom scripts for all pages-->
      <script src="{{asset('/thems/js/sb-admin-2.min.js')}}"></script>
</body>

</html>