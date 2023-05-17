@extends('layouts.master_backend')
@section('content')
@php
$i =1; $j = 0;
$k1=1;
$totalAmount = 0;

$type =  basename(request()->path());
@endphp
<style>
    table.dataTable td:nth-child(5) {
        width: 120px;
        max-width: 120px;
        word-break: break-all;
        white-space: pre-line;
    }
</style>

<div class="card">
    <div class="card-header">
        <span style="float:right;"><a href="{{route('single-list-reservation')}}" class="btn btn{{$type=='single-list-reservation' ? '-success':''}}">Single Cheking</a>
            <a href="{{route('multi-list-reservation')}}" class="btn btn{{$type=='multi-list-reservation' ? '-success':''}}">Multi-Cheking</a>
            <a href="{{route('list-check-outs')}}" class="btn btn{{$type=='list-check-outs' ? '-success':''}}">All Check Out's</a>
        </span>
    </div>
</div>

<div class="">
    @if($list=='check_outs')
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('heading_filter_checkouts')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  {{ Form::model($search_data,array('url'=>route('search-checkouts'),'id'=>"search-checkouts", 'class'=>"form-horizontal form-label-left")) }}
                    <div class="form-group col-sm-2">
                      <label class="control-label">{{lang_trans('txt_room_type')}}</label>
                      {{Form::select('room_type_id',$roomtypes_list,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])}}
                    </div>
                    <div class="form-group col-sm-2">
                      <label class="control-label">{{lang_trans('txt_date_from')}}</label>
                      {{Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from'), 'autocomplete'=>'off'])}}
                    </div>
                    <div class="form-group col-sm-2">
                      <label class="control-label">{{lang_trans('txt_date_to')}}</label>
                      {{Form::text('date_to',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_to'), 'autocomplete'=>'off'])}}
                    </div>
                    <div class="form-group col-sm-3">
                      <br/>
                       <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit">{{lang_trans('btn_search')}}</button>
                       <button class="btn btn-primary export-btn" name="submit_btn" value="export" type="submit">{{lang_trans('btn_export')}}</button>
                    </div>
                  {{ Form::close() }}
                </div>
              </div>
            </div>
        </div>
    @endif

  @if($list=='check_ins')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_checkin_list')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>And S.No.</th>
                        <th>{{lang_trans('txt_guest_name')}}</th>
                        <th>{{lang_trans('txt_mobile_num')}}</th>
                        <th>Email Id</th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th>{{lang_trans('txt_room')}}</th>
                        <th>{{lang_trans('txt_checkin')}}</th>
                        <th>{{lang_trans('txt_booking_amount')}}</th>
                        <th>{{lang_trans('txt_action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                      @foreach($datalist as $k=>$val)
                        @if($val->room_num)
                        @if($val->check_out==null)
                        {{-- @php
                          $calc = calcFinalAmount($val);
                          $totalAmount = $totalAmount+$calc['finalRoomAmount']+$calc['finalOrderAmount'];
                          $i++;
                        @endphp --}}
                        @php
                        $totalAmount +=$val->booking_payment;
                        @endphp
                        <tr>
                          <td>{{$i}}</td>
                          <td>{{($val->customer) ? $val->customer->and_number : 'NA'}}</td>
                          <td>{{($val->customer) ? $val->customer->name : 'NA'}}</td>
                          <td>{{($val->customer) ? $val->customer->mobile : 'NA'}}</td>
                          <td class="tdleft">{{($val->customer) ? $val->customer->email : 'NA'}}
                          <!--MID : {{$val->mid}}-->
                          </td>
                          
                          @if($val->referred_by)
                            <td>{{$val->referred_by ?? ''}}</td>
                          @else
                            <td>{{$val->referred_by_name ?? ''}}</td>
                          @endif
                          
                          @if($val->duration_of_stay == 1)
                            <td>{{$val->duration_of_stay ?? ''}} Day</td>
                          @else
                            <td>{{$val->duration_of_stay ?? ''}} Days</td>
                          @endif
                          
                          <td>
                            @if(($val->room_type))
                              {{$val->room_type->title}}<br/>
                              ( {{lang_trans('txt_room_num')}} : {{$val->room_num}} )
                            @endif
                            </td>
                          <td>{{dateConvert($val->check_in,'d-m-Y H:i')}}</td>
                          {{-- <td>{{getCurrencySymbol()}} {{numberFormat($calc['finalRoomAmount']+$calc['finalOrderAmount'])}}</td> --}}
                          <td>
                              @php
                                if(isset($count_room))
                                {
                                    $room = explode(',', $val->room_num);
                                    $total_room = count($room);
                                    
                                    
                                    
                                    
                                    $booking_payment = $val->per_room_price;
                                    $total_room = $count_room;
                                }
                                else
                                {
                                
                                    $booking_payment = $val->booking_payment ;
                                }

                             
                              
                              @endphp
                              
                               
                              
                          {{getCurrencySymbol()}} {{ numberFormat( $booking_payment) }}
                          
                            <?php $unique_id=$val->unique_id; ?>
                          </td>
                          <td>
                            <a class="btn btn-sm btn-warning" href="{{route('food-order',[$val->id])}}">{{lang_trans('btn_food_order')}}</i></a>
                            <a class="btn btn-sm btn-success" href="{{route('view-reservation',[$val->id])}}">{{lang_trans('btn_view')}}</i></a>
                            <a class="btn btn-sm btn-info" href="{{route('check-out-room',[$val->unique_id])}}">{{lang_trans('btn_checkout')}}</i></a>
                            <a class="btn btn-sm btn-info" href="{{url('admin/edit-check-in/'.$val->unique_id)}}">{{lang_trans('btn_checkin_edit')}}</i></a>
                          </td>
                        </tr>
                        @endif
                        @endif
                        
                        
                        
                        @php $i++; @endphp
                      @endforeach
                    </tbody>
                  </table>

                </div>
            </div>
        </div>
    </div>

  @elseif($list=='check_outs')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_checkout_list')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <!--<div class="row">-->
                    <!--    <div class="col-md-4">-->
                    <!--        <input type="text" name="from_date" id="from_date" class="form-control input-daterange" placeholder="From Date" autocomplete="off" />-->
                    <!--    </div>-->
                    <!--    <div class="col-md-4">-->
                    <!--        <input type="text" name="to_date" id="to_date" class="form-control input-daterange" placeholder="To Date" autocomplete="off" />-->
                    <!--    </div>-->
                    <!--    <div class="col-md-4">-->
                    <!--        <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>-->
                    <!--        <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <table id="datatablenew" class="table table-striped table-bordered data-table">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>And S.No.</th>
                        <th>{{lang_trans('txt_guest_name')}}</th>
                        <th>{{lang_trans('txt_mobile_num')}}</th>
                        <th>Email Id</th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th>{{lang_trans('txt_room')}}</th>
                        <th>{{lang_trans('txt_checkin')}}</th>
                        <th>{{lang_trans('txt_checkout')}}</th>
                        <th>Booking Amount (Rs.)</th>
                        <th>{{lang_trans('txt_action')}}</th>
                      </tr>
                    </thead>
                    <tbody>

                

                    </tbody>
                  </table>
                    
                </div>
            </div>
        </div>
    </div>
  @endif
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.input-daterange').datepicker({
        todayBtn:'linked',
        format:'yyyy-mm-dd'
        // autoclose:true
    });

    load_data();

    function load_data(from_date = '', to_date = '')
    {
    
    $('#datatablenew').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{ route("list-check-outs") }}',
            data:{from_date:from_date, to_date:to_date}
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'and_number', name: 'and_number'},
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
            {data: "source",
                    "render": function (data, type, row) {
                    if ( row.refby === '') {
                        return row.source;
                    }
                    else {
                        return row.refby;
                    }
                }
            },
            {data: "duration",
                    "render": function (data, type, row) {
                    if ( row.duration == '1') {
                        
                        return row.duration +' Day';
                    }
                    else {
                        return row.duration +' Days';
                    }
                }
            },
            {data: "room_type_id",
                    "render": function (data, type, row) {
                    if ( row.room_type_id == '1') {
                        return 'DELUXE ROOM (Room No: ' + row.room_num +')';
                    }
                    else if(row.room_type_id == '2') {
                        return 'PREMIUM ROOM (Room No: ' + row.room_num +')';
                    }else{
                        return 'EXECUTIVE ROOM (Room No: ' + row.room_num +')';
                    }
                }
            },
            {data: 'check_in', name: 'check_in'},
            {data: 'check_out', name: 'check_out'},
            {data: 'booking_payment', name: 'booking_payment'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            
        ]
    });
    
    }
    
    $('#filter').click(function(){
          var from_date = $('#from_date').val();
          var to_date = $('#to_date').val();
          if(from_date != '' &&  to_date != '')
          {
           $('#datatablenew').DataTable().destroy();
           load_data(from_date, to_date);
          }
          else
          {
           alert('Both Date is required');
          }
    });

    $('#refresh').click(function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('#datatablenew').DataTable().destroy();
        load_data();
    });
    
});
</script>
@endsection
