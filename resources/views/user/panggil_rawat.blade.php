@extends('templet.main')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                                <h6 class="m-0 font-weight-bold text-primary">No Antrian Priksa Umum</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group justify-content-center row">
                            <div class="inner center">
                                <h1 id="priksa">0</h1>
                
                                <p>No Antrian</p>
                              </div><br>    
                            </div>
                         
                                <div class="row justify-content-center">
                                    
                                    <button type="button" id="id_priksa"class="btn btn-primary">Panggil  <i class="fas fa-volume-up"></i></button>
                                  </div>
                       
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col-md-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                                <h6 class="m-0 font-weight-bold text-primary">No Antian Control</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group justify-content-center row">
                            <div class="inner">
                                <h1 id="no_con">0</h1>
                
                                <p>No Antrian</p>
                              </div><br>    
                            </div>
                         
                                <div class="row justify-content-center">
                                    <button type="button" id="control"class="btn btn-primary">Panggil   <i class="fas fa-volume-up"></i></button>
                                  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">No Antria Yang Sudah Di Panggil</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered yajra-datatable" id="biasa">
                    <thead>
                        <tr>
                          <th>No Antrian</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <h6 class="m-0 font-weight-bold text-primary">Anrtian Pasien Control Yang Sudah Di Panggil</h6>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered yajra-datatable" id="controll">
                    <thead>
                        <tr>
                            <th>No Antrian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>

<audio id="tingtung" src="{{asset('thems/tingtung.mp3')}}"></audio>

@endsection
@section('js')
        <script src="{{asset('/thems/vendor/jquery/jquery-ui.js')}}"></script>
        <script src="{{asset('/thems/vendor/jquery/jquery.js')}}"></script>
        <script src="{{asset('/thems/js/responsivevoice.js')}}"></script>
        <script src="{{asset('/thems/vendor/bootstrap/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('/thems/vendor/daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{asset('/thems/vendor/moment/moment.min.js')}}"></script>
        <script src="{{asset('/thems/vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('/thems/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('/thems/vendor/sweetalert2/sweetalert2.all.js')}}"></script>
        <script src="{{asset('/thems/vendor/date/js/bootstrap-datetimepicker.min.js')}}"></script>



<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        function messg(data){
         Swal.fire({
                    title: data['sts'],
                    text: data['msg'],
                    icon: data['sts'],
                })
        }
        function antri_con() {
            $.ajax({
                type: "Get",
                url: "{{route('get-no')}}",
                data:{tipe:1},
                dataType: "JSON",
                success: function (res) {
                    $('#no_con').text(res['no'])
                }
            });
          } 
          function antri_cs() {
            $.ajax({
                type: "Get",
                url: "{{route('get-no')}}",
                data:{tipe:2},
                dataType: "JSON",
                success: function (res) {
                    $('#priksa').text(res['no'])
                }
            });
          } 
          antri_cs();
            antri_con();
          setInterval( function () {
            antri_cs();
            antri_con();
            // table.ajax.reload();
            // tabl2.ajax.reload();
        }, 1000); 
         function panggil(tipe) { 
            $.ajax({
                type: "POST",
                url: "{{(route('panggil-no'))}}",
                data: {id:tipe},
                dataType: "JSON",
                success: function (res) {
                    antri_cs();
                    antri_con();
                    messg(res);
                }
            });
          }
        $('#control').on('click',function(){
            var id =$('#no_con').text();
            
            if (id !="CN-0") {
                panggil(id);
                var r = "Ruangan Controll";
                panggill(id,r);
                tabl2.ajax.reload();
            send(id);
            }
           
        });
        $('#id_priksa').on('click',function(){
            var id =$('#priksa').text();
            if (id !="CL-0") {
                table.ajax.reload();
                var r = "ruangan Priksa";
                panggill(id,r);
                panggil(id);
              
            }
           
        });
        function send(param) { 
            $.ajax({
                type: "POST",
                url: "{{route('notif')}}",
                data: {id:param},
                dataType: "JSON",
                success: function (res) {
                    console.log(res);
                }
            });
        }
        
        function panggill(data,r) { 
            var bell  = document.getElementById('tingtung');
            var loket ='loket 3';
            bell.pause();
            bell.currentTime=0;
            bell.play();
            totalwaktu = bell.duration * 100; 
            // MAINKAN SUARA NOMOR URUT  
            setTimeout(function() {
            return responsiveVoice.speak(" Nomor Antrian," +data+ ", ke "+r,"Indonesian Female", {rate: 0.8, pitch: 1, volume: 2});
                                // return responsiveVoice.speak(" Nomor Antrian, 37 ke Loket 3" ,"Indonesian Female", {rate: 0.8, pitch: 1, volume: 1});
                            }, totalwaktu);

                            totalwaktu = totalwaktu + 100;
         }
      
         $('#biasa').on('click','.panggil-b',function () {
            var x= $(this).attr('data-id');
            var r = "ruangan Priksa";
            panggill(x,r);
          });
          $('#controll').on('click','.panggil-c',function () {
            var x= $(this).attr('data-id');
            
            var r = "Ruangan Controll";
            panggill(x,r);
          });

        
        var table=$('#biasa').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('panggil-no-ulang-b') }}",
                    columns: [
                        {data: 'no_antrian', name: 'antri'},
                        {
                            data: 'action', 
                            name: 'action', 
                            orderable: true, 
                            searchable: true
                        },
                    ]
                });
        var tabl2 = $('#controll').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('panggil-no-ulang-c') }}",
            columns: [
              
                {data: 'no_antrian', name: 'antri'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });


    })
</script>
@endsection
