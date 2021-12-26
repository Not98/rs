@extends('templet.main')
@section('content')
<div class="card pd-20 pd-sm-40">
    <h6 class="card-body-title">Basic Responsive DataTable</h6>
    <p class="mg-b-20 mg-sm-b-30">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p>

    <div class="table-wrapper">
      <table id="datatable1" class="table display responsive nowrap">
        <thead>
          <tr>
            <th class="wd-10p">No</th>
            <th class="wd-20p">Penyakit </th>
            <th class="wd-20p">Action </th>
            
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Tiger</td>
            <td>Nixon</td>
            <td><a href="#" class="btn btn-primary btn-icon rounded-circle mg-r-5 mg-b-10">
                <div><i class="fa fa-send"></i></div>
              </a></td>
           
          </tr>
      
        </tbody>
      </table>
    </div><!-- table-wrapper -->
  </div><!-- card -->






@endsection