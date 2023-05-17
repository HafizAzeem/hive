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
                    <h2>HousingKeeping List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>{{lang_trans('txt_room')}}</th>
                         <th>Status</th>
                         <th>Stay</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($datalist as $k=>$val)
                       
                        <tr>
                            <td>{{++$k}}</td>
                         <td> 
                            {{$val->room_num}} 
                            </td>
                           @if ($val->status == 1)  <td>Active</td> @else <td>InActive</td> @endif
                          @if(dateConvert($val->user_checkout,'d-m-Y') == date('d-m-Y')) 
                          <td>Today Checkout</td> 
                          @else 
                          <td>Long Stay</td> 
                          @endif
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