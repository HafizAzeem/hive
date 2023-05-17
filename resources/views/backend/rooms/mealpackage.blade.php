@extends('layouts.master_backend')
@section('content')
@php 
$i = $j = 0; 
$totalAmount = 0;
@endphp
<div class="">

  @if($list=='check_ins')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Meal Plan List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>Name</th>
                        <th>Included Meals</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($datalist as $k=>$val)
                       
                        <tr>
                            <td>{{++$k}}</td>
                         <td> 
                            {{$val->name}} 
                            </td>
                            <td> 
                            {{$val->included_meal}} 
                            </td>
                            
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>          
@endsection
@section('jquery')
<script>
    $(document).ready(function() {
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
            
        ]
    } );
} );
</script>
@endsection