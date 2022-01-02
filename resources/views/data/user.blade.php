@extends('templet.main')
@section('content')

<div class="row">
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="m-0 font-weight-bold text-primary">User Karyawan</h6>
                       
                    </div>
                    <div class="col-md-8 justify-content-right">
                            <div><a class="btn btn-success btn-right" style="float: right;"href="javascript:void(0)" id="addK"> Tambah User Karyawan</a><br> </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered yajra-datatable" id="user">
                    <thead>
                        <tr>
                          <th>id</th>
                          <th>User</th>
                          <th>Level</th>
                          <th>Tanggang Masuk </th>
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
 //Date picker
     var tm=$('#reservationdate').datetimepicker({
        format: 'L'
    });
    function messg(data){
      Swal.fire({
                title: data['sts'],
                text: data['msg'],
                icon: data['sts'],
              })
    }
    var table = $('#user').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data-user') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'user', name: 'user'},
            {data: 'level', name: 'level'},
            {data: 'status', name: 'status'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    $('#user').on('click','.edit',function () {
      var x = $(this).attr('data-id');
       $.ajax({
           type: "GET",
           url: "{{route('get-user')}}",
           data: {id:x},
           dataType: "Json",
           success: function (data) {
            if (data.msg['tipe']=='karyawan') {
              karyawan(data);
              $('#reservationdate').datetimepicker({
                    format: 'L'
                });
            }
            if (data.msg['tipe']=='dokter') {
              dokter(data)
            }
            if (data.msg['tipe']=='pasien') {
               pasien(data);
               $('#reservationdate').datetimepicker({
                  format: 'L'
              });
            }

           }
       });
    });
    $('#user').on('click','.del',function () {
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
                url: "{{route('del-user')}}",
                data: {id:x},
                dataType: "JSON",
                success: function (response) {
                  Swal.fire(
                    'Deleted!',
                    'User.<br>'+response.data+'Berhasil di Hapus',
                    'success'
                  )      
                  table.ajax.reload();

                }
              });
            
          }
        })
    });
    $('#addK').on('click',function () {
       var  html ='<div class="row">'+
                        '<div class="col-md-3">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]">'+
                          '<label class="form-check-label">Admin</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                            '<div class="form-check">'+
                            '<input class="form-check-input" value="2" type="radio" name="status[]" >'+
                            '<label class="form-check-label">Dokter</label>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                            '<div class="form-check">'+
                            '<input class="form-check-input" value="3" type="radio" name="status[]" >'+
                            '<label class="form-check-label">Karyawan</label>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                            '<div class="form-check">'+
                            '<input class="form-check-input" value="4" type="radio" name="status[]" >'+
                            '<label class="form-check-label">Pasien</label>'+
                            '</div>'+
                        '</div>'+
                        '</div>';    
        Swal.fire({
                title: 'Pilih user yang akan di buat',
                html:html,
                focusConfirm: false,
                preConfirm: () => {
                    var t =$('input[name="status[]"]:checked').val();
                    if (t==1) {
                        add_admin(t);
                        $('#reservationdate').datetimepicker({ format: 'L'});
                    }
                    if (t==2) {
                        add_dokter(t);
                    }
                    if (t==3) {
                        add_karyawan(t);
                        $('#reservationdate').datetimepicker({ format: 'L'});
                    }
                    if (t==4) {
                        add_pasien(t);
                        $('#reservationdate').datetimepicker({ format: 'L'});
                    }
                    
              }
            })
    })
    function add_pasien(t) { 
        var html=[];
        html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]">'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Tidak Aktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';    
        Swal.fire({
                title: 'Silahkan Isi Data Pasien',
                html:
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nik</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="nik" placeholder="Nik Pasien" required>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nama</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="nama" placeholder="Nama Pasien" required>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Tanggal Lahir Pasien</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<div class="input-group date" id="reservationdate" data-target-input="nearest">'+
                        '<input type="text" class="form-control" name="ttl" data-target="#reservationdate" placeholder="Tanggal lahir" required>'+                       
                            '<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >'+
                            '<div class="input-group-text">'+
                            '<i class="fa fa-calendar">'+
                            '</i></div>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">Penanggung jawab</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="pn" placeholder="Penanggung jawab"required>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">No BBJS</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control" name="bbjs" placeholder="No BBJS"required>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">alamat</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"name="alamat" placeholder="Alamat">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="Email" class=" col-form-label">Email</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="email" class="form-control"name="email" placeholder="Email"required>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="password" class=" col-form-label">Password</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="password" class="form-control"name="password" placeholder="Password"required>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="Status" class=" col-form-label">Status</label>'+
                    '</div>'+
                    '<div class="col-sm-8">'+
                        
                        html+
                    '</div>'+
                  '</div>',
                focusConfirm: false,
                preConfirm: () => {
                   var nik,nama,pn,alamat,ttl,email,bbjs,password,c;
                   c =$('input[name="status[]"]:checked') .val();
                   nik = $('[name="nik"]').val();
                   nama = $('[name="nama"]').val();
                   pn =$('[name=pn]').val();
                   alamat =$('[name=alamat]').val();
                   ttl = $('[name=ttl]').val();
                   email =$('[name=email]').val();
                   bbjs =$('[name=bbjs]').val();
                   password =$('[name=password]').val();
                  //  console.log(password);
                  if (nik&&nama&&pn&&alamat&&ttl&&email&&bbjs&&password&&c) {
                    $.ajax({
                    type: "POST",
                    url: "{{route('add-user')}}",
                    data: {nik:nik,nama:nama,pn:pn,alamat:alamat,ttl:ttl,email:email,bbjs:bbjs,password:password,status:c,tipe:t},
                    dataType: "JSON",
                    success: function (dat) {
                      console.log(dat);
                      table.ajax.reload();
                    }
                  });
                  }else{
                    Swal.fire('WARNING!','Data ada yang masih kosong','warning')   
                  }
                  
              }
            })
     }
    function add_dokter(t) { 
      var html=[];
        html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]">'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Tidak Aktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';    
        Swal.fire({
                title: 'Silahkan Isi Data Dokter',
                html:
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Code Dokter</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="code" placeholder="Code Dokter"required>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nama</label>'+
                     '</div>'+
                     '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="nama" placeholder="Nama">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">No HP</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"name="no_hp" placeholder="Nomer HP">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="password" class=" col-form-label">Password</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="password" class="form-control"name="password" placeholder="Password">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="Status" class=" col-form-label">Status</label>'+
                    '</div>'+
                    '<div class="col-sm-8">'+
                        
                        html+
                    '</div>'+
                  '</div>',
                focusConfirm: false,
                preConfirm: () => {
                  var code,nama,no_hp,password,c;
                   c =$('input[name="status[]"]:checked') .val();
                   code = $('[name="code"]').val();
                   nama = $('[name="nama"]').val();
                   no_hp =$('[name=no_hp]').val();
                   password =$('[name=password]').val();
                  if (code&&nama&&no_hp&&password&&c) {
                    $.ajax({
                    type: "POST",
                    url: "{{route('add-user')}}",
                    data: {code:code,nama:nama,no_hp:no_hp,password:password,status:c,tipe:t},
                    dataType: "JSON",
                    success: function (dat) {
                      messg(dat)
                      table.ajax.reload();
                    }
                  });
                  }else{
                    Swal.fire('WARNING!','Data ada yang masih kosong','warning')   
                  }
                 
              }
            })

     }
    function add_karyawan(t) {
      var html=[];
        html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]">'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Tidak Aktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';    
        Swal.fire({
                title: 'Silahkan Isi Data Karyawan',
                html:
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nik</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="nik" placeholder="Nik Pasien">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nama</label>'+
                     '</div>'+
                     '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="nama" placeholder="Nama">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">No HP</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"name="no_hp" placeholder="Nomer HP">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Tanggal Masuk</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<div class="input-group date" id="reservationdate" data-target-input="nearest">'+
                        '<input type="text" class="form-control" name="tgl" data-target="#reservationdate" placeholder="Tanggal Masuk">'+                       
                            '<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >'+
                            '<div class="input-group-text">'+
                            '<i class="fa fa-calendar">'+
                            '</i></div>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                  '</div>'+
             
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">alamat</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"name="alamat" placeholder="Alamat">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="password" class=" col-form-label">Password</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="password" class="form-control"name="password" placeholder="Password">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="Status" class=" col-form-label">Status</label>'+
                    '</div>'+
                    '<div class="col-sm-8">'+
                        
                        html+
                    '</div>'+
                  '</div>',
                focusConfirm: false,
                preConfirm: () => {
                  var nik,nama,alamat,tgl,no_hp,password,c;
                   c =$('input[name="status[]"]:checked') .val();
                   nik = $('[name="nik"]').val();
                   nama = $('[name="nama"]').val();
                   alamat =$('[name=alamat]').val();
                   no_hp = $('[name=no_hp]').val();
                   tgl = $('[name=tgl]').val();
                   password =$('[name=password]').val();
                   if (nik&&nama&&alamat&&tgl&&password&&c) {
                        $.ajax({
                        type: "POST",
                        url: "{{route('add-user')}}",
                        data: {nik:nik,nama:nama,alamat:alamat,tgl:tgl,no_hp:no_hp,password:password,status:c,tipe:t},
                        dataType: "JSON",
                        success: function (dat) {
                          messg(dat);
                          table.ajax.reload();
                        }
                      });
                   }else{
                    Swal.fire('WARNING!','Data ada yang masih kosong','warning')   
                  }
                  
              }
            })
      }
    function add_admin(t) {
      var html=[];
        html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]">'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Tidak Aktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';    
        Swal.fire({
                title: 'Silahkan Isi Data Karyawan',
                html:
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nik</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="nik" placeholder="Nik Pasien">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nama</label>'+
                     '</div>'+
                     '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  name="nama" placeholder="Nama">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">No HP</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"name="no_hp" placeholder="Nomer HP">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Tanggal Masuk</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<div class="input-group date" id="reservationdate" data-target-input="nearest">'+
                        '<input type="text" class="form-control" name="tgl" data-target="#reservationdate" placeholder="Tanggal Masuk">'+                       
                            '<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >'+
                            '<div class="input-group-text">'+
                            '<i class="fa fa-calendar">'+
                            '</i></div>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                  '</div>'+
             
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">alamat</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"name="alamat" placeholder="Alamat">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="password" class=" col-form-label">Password</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="password" class="form-control"name="password" placeholder="Password">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="Status" class=" col-form-label">Status</label>'+
                    '</div>'+
                    '<div class="col-sm-8">'+
                        
                        html+
                    '</div>'+
                  '</div>',
                focusConfirm: false,
                preConfirm: () => {
                  var nik,nama,alamat,tgl,no_hp,password,c;
                   c =$('input[name="status[]"]:checked') .val();
                   nik = $('[name="nik"]').val();
                   nama = $('[name="nama"]').val();
                   alamat =$('[name=alamat]').val();
                   no_hp = $('[name=no_hp]').val();
                   tgl = $('[name=tgl]').val();
                   password =$('[name=password]').val();
                   if (nik&&nama&&alamat&&tgl&&password&&c) {
                        $.ajax({
                        type: "POST",
                        url: "{{route('add-user')}}",
                        data: {nik:nik,nama:nama,alamat:alamat,tgl:tgl,no_hp:no_hp,password:password,status:c,tipe:t},
                        dataType: "JSON",
                        success: function (dat) {
                          messg(dat);
                          table.ajax.reload();
                        }
                      });
                   }else{
                    Swal.fire('WARNING!','Data ada yang masih kosong','warning')   
                  }
                  
              }
            })

      }
    
    
    
    
    // update
    function pasien(data) {
        var html=[];
            if (data.msg.data['status'] ==1) {
                html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]" checked>'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Tidak Aktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';    
            }else{
                html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" checked>'+
                          '<label class="form-check-label">Tidak Aktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';
                        
            }
   
            Swal.fire({
                title: 'Masukan Rubah Nama Penyakit',
                html:
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nama</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  value="'+data.msg.data['nama']+'" name="nama" placeholder="Nama Pasien">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">Penanggung jawab</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control" value="'+data.msg.data['pn']+'" name="pn" placeholder="Penanggung jawab">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">No BBJS</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"" value="'+data.msg.data['bbjs']+'" name="bbjs" placeholder="No BBJS">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">alamat</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"" value="'+data.msg.data['alamat']+'" name="alamat" placeholder="Email">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Tanggal Lahir Pasien</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<div class="input-group date" id="reservationdate" data-target-input="nearest">'+
                        '<input type="text" class="form-control" name="ttl" data-target="#reservationdate"value="'+data.msg.data['tgl']+'" placeholder="Tanggal lahir" required>'+                       
                            '<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >'+
                            '<div class="input-group-text">'+
                            '<i class="fa fa-calendar">'+
                            '</i></div>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="Status" class=" col-form-label">Status</label>'+
                    '</div>'+
                    '<div class="col-sm-8">'+
                        
                        html+
                    '</div>'+
                  '</div>'
                  ,
                  focusConfirm: false,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Update Data',
                preConfirm: () => {
                  var nama,pn,bbjs,alamat,c,tipe,id,tgl;
                  c=$('input[name="status[]"]:checked').val();
                  nama=$('[name="nama"]').val();
                  pn=$('[name="pn"]').val();
                  bbjs=$('[name="bbjs"]').val();
                  alamat=$('[name="alamat"]').val();
                  tgl=$('[name="ttl"]').val();
                  id=data.msg['id'];
                  tipe = data.msg['tipe'];
                  // console.log();
                  $.ajax({
                    type: "POST",
                    data:{nama:nama,pn:pn,bbjs:bbjs,alamat:alamat,status:c,tipe:tipe,id:id,ttl:tgl},
                    dataType:"JSON",
                    url:"{{route('up-user')}}",
                    success:function(data){
                      messg(data);
                      table.ajax.reload();
                    }
                  });

              }
            })
     }
    function karyawan(data) {
        var html=[];
            if (data.msg.data['status'] ==1) {
                html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]" checked>'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Tida kAktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';    
            }else{
                html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" checked>'+
                          '<label class="form-check-label">Tida kAktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';
                        
            }
            Swal.fire({
                title: 'Masukan Rubah Nama Penyakit',
                html:
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nama</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  value="'+data.msg.data['nama']+'" name="nama" placeholder="Nama">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">Nomer HP</label>'+
                     '</div>'+
                  
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"" value="'+data.msg.data['hp']+'" name="hp" placeholder="Nomer HP">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">alamat</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"" value="'+data.msg.data['alamat']+'" name="alamat" placeholder="Alamat">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Tanggal Masuk Kerja</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<div class="input-group date" id="reservationdate" data-target-input="nearest">'+
                        '<input type="text" class="form-control" name="ttl" data-target="#reservationdate"value="'+data.msg.data['masuk']+'" placeholder="Tanggal Masuk" required>'+                       
                            '<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >'+
                            '<div class="input-group-text">'+
                            '<i class="fa fa-calendar">'+
                            '</i></div>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">Status</label>'+
                    '</div>'+
                    '<div class="col-sm-8">'+
                        
                        html+
                    '</div>'+
                  '</div>'
                  ,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update Data',
                preConfirm: () => {
                  var  nama,hp,alamat,c,tipe,id,masuk
                  nama = $('[name="nama"]').val();
                  hp = $('[name="hp"]').val();
                  alamat = $('[name="alamat"]').val();
                  masuk = $('[name="ttl"]').val();
                  id=data.msg['id'];
                  tipe = data.msg['tipe'];
                  c=$('input[name="status[]"]:checked').val();
                  $.ajax({
                    type: "POST",
                    data:{nama:nama,hp:hp,alamat:alamat,status:c,tipe:tipe,id:id,masuk:masuk},
                    dataType:"JSON",
                    url:"{{route('up-user')}}",
                    success:function(data){
                      messg(data);
                      table.ajax.reload();
                    }
                });

            }
           
        })
     }
    function dokter(data) {
      var html=[];
            if (data.msg.data['status'] ==1) {
                html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]" checked>'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Tida kAktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';    
            }else{
                html+='<div class="row">'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="1" type="radio" name="status[]" >'+
                          '<label class="form-check-label">Aktiv</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                          '<input class="form-check-input" value="0" type="radio" name="status[]" checked>'+
                          '<label class="form-check-label">Tida kAktiv</label>'+
                        '</div>'
                        '</div>'+
                        '</div>';
                        
            }
            Swal.fire({
                title: 'Masukan Rubah Nama Penyakit',
                html:
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="nama" class="col-form-label">Nama</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"  value="'+data.msg.data['nama']+'" name="nama" placeholder="Nama">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">Nomer HP</label>'+
                     '</div>'+
                    '<div class="col-sm-8">'+
                      '<input type="text" class="form-control"" value="'+data.msg.data['hp']+'" name="hp" placeholder="Nomer HP">'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group row">'+
                    '<div class="col-sm-4">'+
                        '<label for="inputEmail3" class=" col-form-label">Status</label>'+
                    '</div>'+
                    '<div class="col-sm-8">'+
                        
                        html+
                    '</div>'+
                  '</div>'
                  ,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update Data',
                preConfirm: () => {
                  var  nama,hp,c,tipe,id;
                  nama = $('[name="nama"]').val();
                  hp = $('[name="hp"]').val();
                  id=data.msg['id'];
                  tipe = data.msg['tipe'];
                  c=$('input[name="status[]"]:checked').val();
                  $.ajax({
                    type: "POST",
                    data:{nama:nama,hp:hp,status:c,tipe:tipe,id:id},
                    dataType:"JSON",
                    url:"{{route('up-user')}}",
                    success:function(data){
                      messg(data);
                      table.ajax.reload();
                    }
                });

            }
        })
     }
    $('#user').on('click','.reset',function () {
      var x = $(this).attr('data-id');
      Swal.fire({
          title: 'Apakah Anda Yakin?',
          html: '<p id="p" data="'+x+'">Anda Akan Melakukan Perubah Default Password</p>',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Reset!'
        }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                type: "POST",
                url: "{{route('res-pas-user')}}",
                data: {id:x},
                dataType: "JSON",
                success: function (response) {
                  Swal.fire(
                    'Reset Password',
                    'User. '+response.data+'<br> Di Rubah DenganPasswort Default simpus123',
                    'success'
                  )      
                  table.ajax.reload();

                }
              });
            
          }
        })
    });





  
  });
</script>
@endsection