@extends('templet.main')
@section('content')
<div><a class="btn btn-success" href="javascript:void(0)" id="addP"> Tambah Data Penyakit</a><br> </div>

<table class="table table-bordered yajra-datatable">
  <thead>
      <tr>
        
        <th>id</th>
        <th>id</th>
          <th>Action</th>
      </tr>
  </thead>
  <tbody>
  </tbody>
</table>
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
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data-penyakit') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'penyakit', name: 'penyakit'},
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
    $('.yajra-datatable').on('click','.edit',function () {
      var x = $(this).attr('data-id');
     
      });
      $('.yajra-datatable').on('click','.del',function () {
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
            var i = $('#p').attr('data');
              $.ajax({
                type: "POST",
                url: "{{route('del-penyakit')}}",
                data: {id:i},
                dataType: "JSON",
                success: function (response) {
                  Swal.fire(
                    'Deleted!',
                    'Nama Penyakit.<br>'+response.data+'Berhasil di Hapus',
                    'success'
                  )      
                  table.ajax.reload();

                }
              });
            
          }
        })
      });
      $('#addP').on('click',function () {
        
      })
      $('.yajra-datatable').on('click','.edit',function (){
        var x = $(this).attr('data-id');
       
        $.ajax({
          type: "GET",
          url:"{{url('get-penyakit/')}}",
          data: {id:x},
          dataType:"JSON",
          success: function (response) {
            Swal.fire({
                title: 'Maukan Rubah Nama Penyakit',
                html:
                  '<input name="penyakit" value="'+response.msg['data']+'" data="'+response.msg['id']+'" type="txet" class="swal2-input form-control">',
                focusConfirm: false,
                preConfirm: () => {
                  var p = $('[name="penyakit"]').val();
                  var id = $('[name="penyakit"]').attr('data');
                  $.ajax({
                    type: "POST",
                    data:{penyakit:p,id:id},
                    dataType:"JSON",
                    url:"{{route('up_penyakit')}}",
                    success:function(data){
                      messg(data);
                      table.ajax.reload();
                    }
                  });

          }
        })

          }
        });
      })
      


  });
</script>
@endsection