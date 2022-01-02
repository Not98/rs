<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMPUS</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('/thems/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->

    <link href="{{asset('/thems/vendor/datatables/jquery.dataTables.min.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('/thems/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet"> --}}
    <link href="{{asset('/thems/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet">
    <link href="{{asset('/thems/vendor/jquery/jquery-ui.js')}}" rel="stylesheet">
    <link href="{{asset('/thems/vendor/date/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <link href="{{asset('/thems/vendor/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
   
    <link href="{{asset('/thems/css/sb-admin-2.min.css')}}" rel="stylesheet">
   <style>
   
    td.details-control {
        background: url("{{asset('thems/vendor/images/details_open.png')}}") no-repeat center center;
        cursor: pointer;
    }
    tr.details td.details-control {
        background: url("{{asset('/thems/vendor/images/details_close.png')}}") no-repeat center center;
    }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIMPUS <sup>1.0</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">




            @if (session('id_level'))
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="menu">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
             <!-- Divider -->
             <hr class="sidebar-divider">

             <!-- Heading -->
             <div class="sidebar-heading">
                 Menu
             </div>
             @if(session('id_level')==1)
                      <!-- Nav Item - Pages Collapse Menu -->
                      <li class="nav-item">
                        <a class="nav-link" href="dokter">
                            <i class="fas fa-user-md"></i>
                         
                            <span>Penanganan</span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="dokter-control">
                            <i class="fas fa-briefcase-medical"></i>
                         
                            <span>Controll</span></a>
                      </li>

             <li class="nav-item">
                <a class="nav-link" href="panggil-no">
                    <i class="far fa-address-book"></i>
                    <span>Antrian</span></a>
            </li>
             
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-hospital-user"></i>
                        <span>Settings</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Pengaturan Simpus:</h6>
                            <a class="collapse-item" href="setting-jadwal">Jadwal</a>
                            <a class="collapse-item" href="penyakit">Penyakit</a>
                            <a class="collapse-item" href="spesialis">Spesialis</a>
                            <a class="collapse-item" href="setting-user">User</a>
                        </div>
                    </div>
                </li>
             @elseif (session('id_level') == 4)
             <li class="nav-item">
                <a class="nav-link" href="regist-rawat">
                 <i class="fas fa-stethoscope"></i>
             <span>Daftar</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="jadwal">
                    <i class="fas fa-book-medical"></i>
             <span>Jadwal Dokter</span></a>
            </li>
             <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                     aria-expanded="true" aria-controls="collapseTwo">
                     <i class="fas fa-hospital-user"></i>
                     <span>Daftar Rawat</span>
                 </a>
                 <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                     <div class="bg-white py-2 collapse-inner rounded">
                         <h6 class="collapse-header">Pendaftaran Pasien:</h6>
                         <a class="collapse-item" href="rawat-jalan">Rawat Jalan</a>
                         <a class="collapse-item" href="rawat-umum">Berobat umum</a>
                     </div>
                 </div>
             </li>
             
             @elseif (session('id_level')==3)
             <li class="nav-item">
                <a class="nav-link" href="panggil-no">
                    <i class="far fa-address-book"></i>
                    <span>Antrian</span></a>
            </li>
             
             @elseif (session('id_level')==2)
                       <!-- Nav Item - Pages Collapse Menu -->
                       <li class="nav-item">
                        <a class="nav-link" href="dokter">
                            <i class="fas fa-user-md"></i>
                         
                            <span>Penanganan</span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="dokter-control">
                            <i class="fas fa-briefcase-medical"></i>
                         
                            <span>Controll</span></a>
                      </li>
                     
             @endif
            @else
            <li class="nav-item">
                <a class="nav-link" href="login">
                    <i class="fas fa-fw fa-user-alt"></i>
                    <span>Login</span></a>
            </li>
            @endif
           
      
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                    
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{session('nama')}}</span>
                                <img class="img-profile rounded-circle"
                                    src="/thems/user.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                            
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="log_out" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                  @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="log_out">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('/thems/vendor/jquery/jquery-3.6.0.js')}}"></script>
    <script src="{{asset('/thems/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('/thems/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
   
    <!-- Custom scripts for all pages-->
    <script src="{{asset('/thems/js/sb-admin-2.min.js')}}"></script>
    @yield('js')
    
</body>

</html>