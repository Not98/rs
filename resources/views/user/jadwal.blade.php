@extends('templet.main')
@section('content')
<div class="row a"></div>





@endsection


@section('js')

<script src="{{asset('/thems/vendor/jquery/jquery-ui.js')}}"></script>
<script src="{{asset('/thems/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('/thems/vendor/bootstrap/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/thems/vendor/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('/thems/vendor/moment/moment.min.js')}}"></script>
<script src="{{asset('/thems/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/thems/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/thems/vendor/sweetalert2/sweetalert2.all.js')}}"></script>
<script src="{{asset('/thems/vendor/date/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script src="{{asset('/thems/vendor/jquery/jquery-ui.js')}}"></script>
    <script src="{{asset('/thems/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('/thems/vendor/bootstrap/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('/thems/vendor/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('/thems/vendor/moment/moment.min.js')}}"></script>
    <script src="{{asset('/thems/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/thems/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('/thems/vendor/sweetalert2/sweetalert2.all.js')}}"></script>
    <script src="{{asset('/thems/vendor/date/js/bootstrap-datetimepicker.min.js')}}"></script>


    <script type="text/javascript">
      $(function () {
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });
          function jad() {
              $.ajax({
                  type: "get",
                  url: "{{route('get-jadwal')}}",
                  dataType: "json",
                  success: function (res) {
                      console.log(res);
                    var html=[];
                   for (let i = 0; i < res.length; i++) {
                       if (res[i].spesialis) {
                           xx=res[i].spesialis;
                       }else{
                           xx='';
                       }
                    html+=   '<div class="col-md-3">'+
                            '  <div class="card shadow mb-3">'+
                                '<div class="card-header py-3">'+
                                    '<h6 class="m-0 font-weight-bold text-primary">Nama : '+res[i].nama+'<br>Spesialis :'+xx+'</h6>'+
                                '</div>'+
                                '<div class="card-body">';
                               var x= res[i].hari.filter((c, index) => {return res[i].hari.indexOf(c) === index;})
                                   for (let j = 0; j < x.length; j++) {
                             
                                    
                                html+=  '<p>'+x[j]+'</p>';
                                   }
                               html+= '</div>'+
                            '</div></div>';
                       
                   }
                  $('.a').append(html);
                  }
              });
            }
            jad();
      });

    </script>

@endsection
