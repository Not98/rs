@extends('templet.main')
@section('content')

<div class="row">
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="m-0 font-weight-bold text-primary">Kriteria Spesialis</h6>
                       
                    </div>
                    <div class="col-md-8 justify-content-right">
                        <div><a class="btn btn-success btn-right" style="float: right;"href="javascript:void(0)" id="addS"> Tambah Spesialis</a><br> </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <table class="table table-bordered yajra-datatable" id="spesialis">
                    <thead>
                        <tr>
                            
                            <th>id</th>
                            <th>Nama Spesialis</th>
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


<div class="row">
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="m-0 font-weight-bold text-primary">Dokter Spesialis</h6>
                       
                    </div>
                    <div class="col-md-8 justify-content-right">
                        <div><a class="btn btn-success btn-right" style="float: right;"href="javascript:void(0)" id="addSd"> Tambah Dokter Spesialis</a><br> </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <table class="table table-bordered yajra-datatable" id="dokters">
                    <thead>
                        <tr>
                            
                            <th>id</th>
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
    var tabled = $('#dokters').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data-doc-spesialis') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama', name: 'nama'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    var tables = $('#spesialis').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data-spesialis') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'spesialis', name: 'spesialis'},
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
    $('#addS').on('click',function () { 
        $.ajax({
            type: "GET",
            url: "{{route('get-all-penyakit')}}",
            dataType: "JSON",
            success: function (data) {
            html=[] ;
                html = '<input name="spesial" type="txet" class="swal2-input form-control"><div class="row">';
                for (let i = 0; i < data.length; i++) {
                    html += '<div class="col-sm-6">'+
                                '<div class="row justify-content-center">'+
                                    '<div class="col-md-1">'+
                                        '<input class="form-check-input pn" value="'+ data[i]['id']+'" type="checkbox">'+
                                ' </div>'+
                                '  <div class="col-md-4">'+
                                    '<label class="form-check-label">'+data[i]['penyakit']+'</label>'+
                                '   </div>'+
                                '</div>'+
                            '</div>';
                }
                html +='</div>';
                Swal.fire({
                title: 'Pilih user yang akan di buat',
                html:html,
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    var spesial= $('[name="spesial"]').val();
                    var pnyakit = [];  
                    $('.pn').each(function(){  
                        if($(this).is(":checked"))  
                        {  
                            pnyakit.push($(this).val());  
                        }  
                        });  
                        pnyakit = pnyakit.toString();
                        $.ajax({
                            type: "POST",
                            url: "{{route('add-kriteria-spesialis')}}",
                            data: {id_penyakit:pnyakit,spesial:spesial},
                            dataType: "json",
                            success: function (response) {
                                messg(response);
                                tables.ajax.reload();
                                }
                        });
                 
                
                }
            })
                
            }
        });  
     })
   
    $('#spesialis').on('click','.edit',function () {
        var id=$(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "{{route('get-spesial')}}",
            data: {id:id},
            dataType: "Json",
            success: function (response) {
              
                Swal.fire({
                    title: 'Pilih user yang akan di buat',
                    html:response,
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                    var id_sps = [];
                    var spesialis=$('[name="spesial"]').val();
                    $('.sps').each(function(){
                        if($(this).is(":checked")){
                            id_sps.push($(this).val());
                        }
                    });  
                    id_sps = id_sps.toString();
                        $.ajax({
                            type: "POST",
                            url: "{{route('up-kriteria-spesialis')}}",
                            data: {spesialis:spesialis,id_sps:id_sps,id:id},
                            dataType: "json",
                            success: function (response) {
                                messg(response);
                                tables.ajax.reload();
                            }
                        });
                        
                    }
                })
            }
        });
    })
    $('#spesialis').on('click','.del',function () {
        var x = $(this).attr('data-id');
      Swal.fire({
          title: 'Apakah Anda Yakin?',
          html: '<p id="p" data="'+x+'">Anda tidak akan dapat mengembalikan ini!</p>',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                type: "POST",
                url: "{{route('del-kriteria-spesialis')}}",
                data: {id:x},
                dataType: "JSON",
                success: function (response) {
                    messg(response)
                  tables.ajax.reload();

                }
              });
            
          }
        })
      })
    $('#addSd').on('click',function () {
        $.ajax({
            type: "GET",
            url: "{{route('get-dok-sps')}}",
            dataType: "JSON",
            success: function (data) {
            //    console.log(data.dokter[0]['id']);
            html=[] ;
            //     html = '<input name="spesial" type="txet" class="swal2-input form-control"><div class="row">';
                html='<div class="form-group"><label>Nama Dokter</label>'+
                        '<select class="form-control" name="dok">';
                for (let d = 0; d < data.dokter.length; d++) {
                   html += '<option value="'+data.dokter[d]['code']+'">'+data.dokter[d]['nama']+'</option>';
                }
                html += ' </select></div>';
                for (let i = 0; i < data.spesial.length; i++) {
                    html += '<div class="col-sm-6">'+
                                '<div class="row justify-content-center">'+
                                    '<div class="col-md-1">'+
                                        '<input class="form-check-input sps" value="'+ data.spesial[i]['id']+'" type="checkbox">'+
                                ' </div>'+
                                '  <div class="col-md-4">'+
                                    '<label class="form-check-label">'+data.spesial[i]['spesialis']+'</label>'+
                                '   </div>'+
                                '</div>'+
                            '</div>';
                }
                html +='</div>';
                Swal.fire({
                    title: 'Dokter Spesialis',
                    html:html,
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        var code =$('[name="dok"]').val();
                        var sps = [];  
                        $('.sps').each(function(){  
                            if($(this).is(":checked"))  
                            {  
                                sps.push($(this).val());  
                            }  
                            });  
                            sps = sps.toString();
                        $.ajax({
                            type: "POST",
                            url: "{{route('add-dok-sps')}}",
                            data: {code:code,id_sps:sps},
                            dataType: "JSON",
                            success: function (res) {
                              messg(res);
                              tabled.ajax.reload();
                            }
                        });
                 
                    }    
                })
               
            }
        });


    })
    $('#dokters').on('click','.edit',function () {
        var id = $(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "{{route('get-up-dok-sps')}}",
            data: {id:id},
            dataType: "JSON",
            success: function (res) {
                // console.log(res.chekbok);
                html=[] ;
                html='<div class="form-group"><label>Nama Dokter</label>'+
                   '<input type="text" id="dok"class="form-control"dat="'+res.aktiv['code']+'" placeholder="'+res.aktiv['dokter']+'" disabled="">';
                if (res.chekbok.length >=1) {
                    for (let i = 0; i < res.chekbok.length; i++) {
                    html += '<div class="col-sm-6">'+
                                '<div class="row justify-content-center">'+
                                    '<div class="col-md-1">'+
                                        '<input class="form-check-input sps" value="'+ res.chekbok[i]['id']+'" type="checkbox"'+res.chekbok[i]['status']+
                                        '>'+
                                ' </div>'+
                                '  <div class="col-md-4">'+
                                    '<label class="form-check-label">'+res.chekbok[i]['spesialis']+'</label>'+
                                '   </div>'+
                                '</div>'+
                            '</div>';
                    }
                }else{
                    html += '<div class="col-sm-6">'+
                                '<div class="row justify-content-center">'+
                                    '<div class="col-md-1">'+
                                        '<input class="form-check-input sps" value="'+ res.chekbok['id']+'" type="checkbox"'+res.chekbok['status']+
                                        '>'+
                                ' </div>'+
                                '  <div class="col-md-4">'+
                                    '<label class="form-check-label">'+res.chekbok['spesialis']+'</label>'+
                                '   </div>'+
                                '</div>'+
                            '</div>';
                }
                html +='</div>';
                var dok=res.aktiv['code'];
                
            Swal.fire({
                    title: 'Dokter Spesialis',
                    html:html,
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        var sps = [];  
                        $('.sps').each(function(){  
                            if($(this).is(":checked"))  
                            {  
                                sps.push($(this).val());  
                            }  
                            });  
                            sps = sps.toString();
                        $.ajax({
                            type: "POST",
                            url: "{{route('up_doc_spesialis')}}",
                            data: {id_sps:sps,code:dok},
                            dataType: "JSON",
                            success: function (res) {
                                messg(res);
                            }
                        });
                    }
            });


            }
        });
    })
    $('#dokters').on('click','.del',function () {
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
                    url: "{{route('del-dok-sps')}}",
                    data: {id:id},
                    dataType: "JSON",
                    success: function (response) {
                        messg(response)
                    tabled.ajax.reload();

                    }
                });
                
            }
            })
    })



})
</script>
@endsection

