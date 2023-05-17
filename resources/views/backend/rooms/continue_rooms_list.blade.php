@extends('layouts.master_backend')
@section('content')
@php
$i =1; $j = 0;
$k1=1;
$totalAmount = 0;

$type =  basename(request()->path());
@endphp

<!--<div class="card">-->
<!--    <div class="card-header">-->
<!--        <span style="float:right;"><a href="{{route('single-list-reservation')}}" class="btn btn{{$type=='single-list-reservation' ? '-success':''}}">Single Cheking</a>-->
<!--            <a href="{{route('multi-list-reservation')}}" class="btn btn{{$type=='multi-list-reservation' ? '-success':''}}">Multi-Cheking</a>-->
<!--            <a href="{{route('list-check-outs')}}" class="btn btn{{$type=='list-check-outs' ? '-success':''}}">All Check Out's</a>-->
<!--        </span>-->
<!--    </div>-->
<!--</div>-->

<div class="">
  @if($list=='continue_rooms_list')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Occupied Rooms List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>{{lang_trans('txt_guest_name')}}</th>
                        <th>{{lang_trans('txt_mobile_num')}}</th>
                        <th>{{lang_trans('txt_email')}}</th>
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
                          <td>{{($val->customer) ? $val->customer->name : 'NA'}}</td>
                          <td>{{($val->customer) ? $val->customer->mobile : 'NA'}}</td>
                          <td>{{($val->customer) ? $val->customer->email : 'NA'}}</td>
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
  @else
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Occupied Rooms List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered data-table">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>{{lang_trans('txt_guest_name')}}</th>
                        <th>{{lang_trans('txt_mobile_num')}}</th>
                        <th>{{lang_trans('txt_email')}}</th>
                        <th>{{lang_trans('txt_room')}}</th>
                        <th>{{lang_trans('txt_checkin')}}</th>
                        <th>{{lang_trans('txt_checkout')}}</th>
                        <th>{{lang_trans('txt_booking_amount')}}</th>
                        <th>{{lang_trans('txt_action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>No Data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>
                  </table>

                </div>
            </div>
        </div>
    </div>
  @endif
</div>
@endsection
