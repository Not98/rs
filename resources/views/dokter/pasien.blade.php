@extends('templet.main')
@section('content')
<div class="row">
    <div class="col-xl col-lg">
        <div class="card shadow mb-4">
            {{-- <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan Pasien</h6>
            </div> --}}
            <div class="card-body">
               <div class="row">
                   <div class="col-md-3">
                    <div class="form-group row">
                        <label for="no_antrian" class="col-sm-5 col-form-label">No Antrian</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" value=""id="no_antrian" placeholder="No Antrian" disabled>
                        </div>
                      </div>
                   </div>
                   <div class="col-md-3">
                    <div class="form-group row">
                        <label for="cod_p" class="col-sm-5 col-form-label">Code Periksa</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control"value="" id="cod_p" placeholder="Code Periksa" disabled>
                        </div>
                      </div>
                   </div>
                   <div class="col-md-3">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-5 col-form-label">Nama Pasien</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control"value="" id="nm" placeholder="Nama Pasien" disabled>
                        </div>
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
                      <h6 class="m-0 font-weight-bold text-primary">Penyakit</h6>
          </div>
          <div class="card-body ">
                      @error('sakit')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
            <div class="row pnyakit"></div>
          </div>
      </div>
  </div>
</div>
  
<div class="row" hidden>
  <div class="col-xl col-lg">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Penyakit</h6>
          </div>
          <div class="card-body ">
            <div class="row "></div>
          </div>
      </div>
  </div>
</div>
  

<div class="row">
  <div class="col-xl col-lg">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Tipe </h6>
                      @error('tipe')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
          </div>
          <div class="card-body ">
          
             <div class="row">
                 <div class="col-md-3">
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input tipe" dat="4" type="radio" name="tipe">
                      <label class="form-check-label">Priksa Biasa</label>
                    </div>
                  </div>
                 </div>
                 <div class="col-md-3">
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input tipe" dat="3"type="radio" name="tipe">
                      <label class="form-check-label">Rawat Jalan</label>
                    </div>
                  </div>
                 </div>
                 <div class="col-md-3">
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input tipe"  dat="2" type="radio" name="tipe">
                      <label class="form-check-label">Rawat Inap</label>
                    </div>
                  </div>
                 </div>
                 <div class="col-md-3">
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input tipe"  dat="5"type="radio" name="tipe">
                      <label class="form-check-label">Rujukan</label>
                    </div>
                  </div>
                 </div>
                 <div class="col-md-3">
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input tipe"  dat="6"type="radio" name="tipe">
                      <label class="form-check-label">Pindahan</label>
                    </div>
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
                      <h6 class="m-0 font-weight-bold text-primary">Keterangan</h6>
          </div>
          <div class="card-body ">
            
<textarea class="form-control" rows="3" name="kete" placeholder="Masukan Keterangan" style="margin-top: 0px; margin-bottom: 0px; height: 90px;"></textarea>
</div>

      </div>
  </div>
</div>
  

<div class="row">
  <div class="col-xl col-lg">
      <div class="card shadow mb-4">
          {{-- <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Penyakit</h6>
          </div> --}}
          <div class="card-body ">
            <div class="row">
  <button type="button" class="btn btn-primary btn-user btn-block"  id='sim'>Simpan</button>
  <button type="button" class="btn btn-danger btn-user btn-block"  id='nex'>next</button>
            </div>

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
$(document).ready(function () {
  $.ajaxSetup({
    headers:{
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
  function ambil_pasien() { 
    $.ajax({
      type: "GET",
      url: "{{route('pasien-p')}}",
      dataType: "JSON",
      success: function (res) {
        console.log(res);
        if (res) {
          $('#no_antrian').val(res['antri']);
          $('#nm').val(res['nama']);
          $('#cod_p').val(res['cod_p']);
        }
      }
    });
   }
ambil_pasien();
  function penyakit() {  
    $.ajax({
      type: "GET",
      url: "{{route('g-penyakit')}}",
      dataType: "JSON",
      success: function (res) {
        var html=[];
        for (let i = 0; i < res.length; i++) {
                    html += '<div class="col-sm-4">'+
                                '<div class="row justify-content-center">'+
                                    '<div class="col-md-1">'+
                                        '<input class="form-check-input pn" value="'+ res[i]['id']+'" type="checkbox">'+
                                ' </div>'+
                                '  <div class="col-md-4">'+
                                    '<label class="form-check-label">'+res[i]['penyakit']+'</label>'+
                                '   </div>'+
                                '</div>'+
                            '</div>';
                }
        $('.pnyakit').append(html);
      }
    });
  }
 penyakit();
 function c() {
    var cc = $('.tipe:checked').attr('dat');
}
 
 $('#sim').on('click',function () { 
  $('#nm').val();
  console.log($('#nm').val());
  var x = $("input[name='tipe']:checked").attr('dat')
  var cod_p = $('#cod_p').val();
  var no_antrian = $('#no_antrian').val();
  var nama = $('#nm').val();
  var kete =$("[name='kete']").val();
  var sps = [];  
    $('.pn').each(function(){  
    if($(this).is(":checked"))  
    {  
        sps.push($(this).val());  
    }  
    });  
    sps = sps.toString(); 
    $.ajax({
      type: "POST",
      url: "{{route('rawat-simpan')}}",
      data: {sakit:sps,tipe:x,antri:no_antrian,code:cod_p,ket:kete,nama:nama},
      dataType: "JSON",
      success: function (res) {
  
        messg(res);
      }
    });
  })
  $('#nex').on('click',function(){
  var cod_p = $('#no_antrian').val();
    $.ajax({
      type: "POST",
      url: "{{route('rawat-nex')}}",
      data: {code:cod_p},
      dataType: "Json",
      success: function (res) {
        ambil_pasien();
        penyakit();
        $('input:checkbox').removeAttr('checked');
        $('input:radio').removeAttr('checked');
      }
    });
  })

// end
})

</script>
@endsection
