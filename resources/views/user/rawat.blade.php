@extends('templet.main')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                                <h6 class="m-0 font-weight-bold text-primary">Get No Antrian</h6>
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
                                    <button type="button" id="id_priksa"class="btn btn-primary">Antri</button>
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
                                <h6 class="m-0 font-weight-bold text-primary">Get No Control</h6>
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
                                    <button type="button" id="control"class="btn btn-primary">Antri</button>
                                  </div>
                       
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>


@endsection
@section('js')
<script src="{{asset('/thems/vendor/sweetalert2/sweetalert2.all.js')}}"></script>


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
                url: "{{route('no-control')}}",
                dataType: "JSON",
                success: function (res) {
                    $('#no_con').text(res['no'])
                }
            });
          } 
          function antri_cs() {
            $.ajax({
                type: "Get",
                url: "{{route('no-consul')}}",
                dataType: "JSON",
                success: function (res) {
                    $('#priksa').text(res['no'])
                }
            });
          } 
          antri_cs();
            antri_con();
        //   setInterval( function () {
        //     antri_cs();
        //     antri_con();
        // }, 1000); 
         
        $('#control').on('click',function(){
            var id =$('#no_con').text();
            $.ajax({
                type: "POST",
                url: "{{route('ambil-no')}}",
                data: {id:id,tipe:'1'},
                dataType: "JSON",
                success: function (res) {
                   messg(res);
                   antri_con();
                }
            });
        })
        $('#id_priksa').on('click',function(){
            var id =$('#priksa').text();
            $.ajax({
                type: "POST",
                url: "{{route('ambil-no')}}",
                data: {id:id,tipe:'2'},
                dataType: "JSON",
                success: function (res) {
                   messg(res);
                   antri_cs();
                }
            });
        })
    })
</script>
@endsection
