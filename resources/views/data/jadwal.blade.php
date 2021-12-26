@extends('templet.main')
@section('content')

<div class="row">
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="m-0 font-weight-bold text-primary">Jadwal Dokter</h6>
                       
                    </div>
                    <div class="col-md-8 justify-content-right">
                        <div><a class="btn btn-success btn-right" style="float: right;"href="javascript:void(0)" id="addj"> Tambah Jadwal</a><br> </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <table class="table table-bordered yajra-datatable" id="jadwal">
                    <thead>
                        <tr>
                            
                            <th>id</th>
                            <th>Code Dokter</th>
                            <th>Nama Dokter</th>
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
<script src="{{asset('/thems/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/thems/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/thems/vendor/sweetalert2/sweetalert2.all.js')}}"></script>

<script type="text/javascript">
  $(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('#jadwal').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data-jadwal') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'code', name: 'code'},
            {data: 'nama', name: 'nama'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    function messg(data){
      Swal.fire({
                title: data['sts'],
                text: data['msg'],
                icon: data['sts'],
        })
    }
    $('#addj').on('click',function () {
        var x= $(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "{{route('get-hari')}}",
            dataType: "JSON",
            success: function (data) {
              html=[] ;
              html='<div class="form-group"><label>Nama Dokter</label>'+
                        '<select class="form-control" name="dok">';
                for (let d = 0; d < data.dokter.length; d++) {
                   html += '<option value="'+data.dokter[d]['code']+'">'+data.dokter[d]['nama']+'</option>';
                }
                html += ' </select></div>';
                for (let i = 0; i < data.hari.length; i++) {
                    html += '<div class="row justify-content-center">'+
                                '<div class="col-md-1">'+
                                    '<input class="form-check-input hr" value="'+ data.hari[i]['id']+'" type="checkbox">'+
                            ' </div>'+
                            '  <div class="col-md-2">'+
                                '<label class="form-check-label">'+data.hari[i]['hari']+'</label>'+
                            '   </div>'+
                            '</div>';
                }
                Swal.fire({
                title: 'Pilih user yang akan di buat',
                html:html,
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    var cod=$('[name="dok"]').val();
                    var hari = [];  
                    $('.hr').each(function(){  
                        if($(this).is(":checked"))  
                         {  
                            hari.push($(this).val());  
                         }  
                        });  
                        hari = hari.toString();
                        $.ajax({
                            type: "POST",
                            url: "{{route('add-jadwal')}}",
                            data: {hr:hari,id:cod},
                            dataType: "json",
                            success: function (response) {
                                messg(response);
                                table.ajax.reload();
                            }
                        });
                         
              }
            })
                
            }
        });        
                        
    })
    $('#jadwal').on('click','.edit',function () {
        var x=$(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "{{route('edit-jadwal')}}",
            data: {code:x},
            dataType: "Json",
            success: function (response) {
                Swal.fire({
                    title: 'Pilih user yang akan di buat',
                    html:response,
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                    var hari = [];  
                    $('.hr').each(function(){
                        if($(this).is(":checked")){
                            hari.push($(this).val());
                        }
                    });  
                    hari = hari.toString();

                        $.ajax({
                            type: "POST",
                            url: "{{route('update-jadwal')}}",
                            data: {hr:hari,id:x},
                            dataType: "json",
                            success: function (response) {
                                messg(response);
                                table.ajax.reload();
                            }
                        });
                        
                    }
                })
            }
        });
    })
    $('#jadwal').on('click','.del',function () {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            html: '<p id="p" data="'+id+'">Anda tidak akan dapat mengembalikan ini!</p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{route('del-jadwal')}}",
                    data: {id:id},
                    dataType: "JSON",
                    success: function (response) {
                        messg(response)
                    table.ajax.reload();

                    }
                });
                
            }
            })
    })

  })
</script>
@endsection
