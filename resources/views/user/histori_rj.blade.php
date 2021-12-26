@extends('templet.main')
@section('content')

<div class="row">
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="m-0 font-weight-bold text-primary">Histori Rawat Jalan</h6>
                       
                    </div>
                    
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered yajra-datatable" id="rwj">
                    <thead>
                        <tr>
                          <th>NO</th>
                          <th>Code Priksa</th>
                          <th>Nama Dokter</th>
                          <th>Tanggal</th>
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



    <script type="text/javascript">
        $(function () {
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });
          var table = $('#rwj').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('data_rawat_j') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'code_rawat', name: 'code_rawat'},
                  {data: 'nama', name: 'nama'},
                  {data: 'tanggal_brobat', name: 'tanggal_brobat'},
                  {
                      data: 'action', 
                      name: 'action', 
                      orderable: true, 
                      searchable: true
                  },
              ]
          });
          $('#rwj').on('click','.viewx',function () {
              var code =$(this).attr('data-id');
             $.ajax({
                 type: "get",
                 url: "{{ route('detail-ra') }}",
                 data: {code:code},
                 dataType: "JSON",
                 success: function (res) {
                     console.log(res);
                 }
             });
          });
     
         
        //   end
        })
        </script>
@endsection