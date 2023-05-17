@extends('layouts.master_backend')
@section('content')
  <div class="">
     @section('rightColContent')
         <div class="row top_tiles">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-caret-square-o-right"></i>
                        </div>
                        <div class="count">{{$counts[0]->today_check_ins}}</div>
                        <h3><a href="{{route('list-reservation')}}">{{lang_trans('txt_today_checkin')}}</a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-comments-o"></i>
                        </div>
                        <div class="count">{{$counts[0]->today_check_outs}}</div>
                        <h3><a href="{{route('list-check-outs')}}">{{lang_trans('txt_today_checkout')}}</a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <div class="count">{{$counts[0]->today_orders}}</div>
                        <h3><a href="{{route('orders-list')}}">{{lang_trans('txt_today_orders')}}</a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
      @endsection
    
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="col-sm-12">
                                <div class="col-sm-8 p-left-0">
                                    <h2>{{lang_trans('txt_latest_orders')}}</h2>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="{{route('food-order')}}" class="btn btn-success">{{lang_trans('txt_add_new_orders')}}</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @foreach($orders as $k=>$val)
                                @php
                                     $totalAmount = 0.00;
                                @endphp
                                @if($val->order_history)
                                    @foreach($val->order_history as $key_OH=>$val_OH)
                                        @if($val_OH->orders_items)
                                            @foreach($val_OH->orders_items as $key_OI=>$val_OI)
                                                @php
                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                    $totalAmount = $totalAmount+$price;
                                                    $totalAmmountsArr[$val->id] = $totalAmount;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <table  class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>{{lang_trans('txt_sno')}}</th>
                              <th>{{lang_trans('txt_customer_name')}}</th>
                              <th>{{lang_trans('txt_table_num')}}</th>
                              <th>{{lang_trans('txt_order_amount')}}</th>
                              <th>{{lang_trans('txt_action')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($orders as $k=>$val)
                                <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{$val->table_num}}</td>
                                <td>{{getCurrencySymbol()}} {{@$totalAmmountsArr[$val->id]}}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="{{route('food-order-table',[$val->id])}}">{{lang_trans('btn_repeat_order')}}</i></a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view_modal_{{$k}}">{{lang_trans('btn_view_order')}}</button>
                                    <a class="btn btn-sm btn-warning" href="{{route('food-order-final',[$val->id])}}" target="_blank">{{lang_trans('btn_pay')}}</i></a>

                                    <div class="modal fade view_modal_{{$k}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">{{lang_trans('txt_order_details')}}: ({{lang_trans('txt_table_num')}}- #{{$val->table_num}})</h4>
                                                </div>
                                                <div class="modal-body">
                                                   <table  class="table table-striped table-bordered">
                                                        <tr>
                                                            <th>{{lang_trans('txt_sno')}}</th>
                                                            <th>{{lang_trans('txt_datetime')}}</th>
                                                            <th>{{lang_trans('txt_orderitem_qty')}}</th>
                                                        </tr>
                                                        @if($val->order_history)
                                                            @foreach($val->order_history as $key_OH=>$val_OH)
                                                                <tr>
                                                                  <td>{{$key_OH+1}}</td>
                                                                  <td>{{$val_OH->created_at}}</td>
                                                                  <td>
                                                                    @if($val_OH->orders_items)
                                                                        <table class="table table-bordered">
                                                                            @foreach($val_OH->orders_items as $key_OI=>$val_OI)
                                                                                @php
                                                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                                                    $totalAmount = $totalAmount+$price;
                                                                                @endphp
                                                                                <tr>
                                                                                    <td>{{$val_OI->item_name}}</td>
                                                                                    <td>{{$val_OI->item_qty}}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </table>
                                                                    @endif
                                                                  </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                      </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                              </tr>

                            @endforeach
                          </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{lang_trans('txt_room')}}</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable_" class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th>{{lang_trans('txt_sno')}}</th>
                                  <th>{{lang_trans('txt_title')}}</th>
                                  <th>{{lang_trans('txt_capacity')}}</th>
                                  <th>{{lang_trans('txt_base_price')}}</th>
                                  <th>{{lang_trans('txt_room')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($room_types as $key=>$val)
                                  <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$val->title}}</td>
                                    <td>{{lang_trans('txt_adults')}}: {{$val->adult_capacity}} &nbsp; {{lang_trans('txt_kids')}}: {{$val->kids_capacity}} </td>
                                    <td>{{getCurrencySymbol()}} {{$val->base_price}}</td>
                                    <td>
                                        @if($val->rooms->count())
                                            <table class="table table-striped table-bordered">
                                              <thead>
                                                <tr>
                                                    <th>{{lang_trans('txt_sno')}}</th>
                                                    <th>{{lang_trans('txt_room_num')}}</th>
                                                    <th>{{lang_trans('txt_floor')}}</th>
                                                    <th>{{lang_trans('txt_status')}}</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($val->rooms as $k=>$v)
                                                  <tr>
                                                    <td>{{$k+1}}</td>
                                                    <td>{{$v->room_no}}</td>
                                                    <td>{{config('constants.ROOM_FLOOR')[$v->floor]}}</td>
                                                    <td>
                                                        @if(in_array($v->room_no, $booked_rooms))
                                                            <button type="button" class="btn btn-danger btn-xs">{{lang_trans('txt_booked')}}</button>
                                                        @else
                                                            <a href="{{route('room-reservation-available',[$v->id])}}" type="button" class="btn btn-success btn-xs">{{lang_trans('txt_available')}}</a>
                                                        @endif
                                                    </td>
                                                  </tr>
                                                @endforeach
                                              </tbody>
                                            </table>
                                        @else
                                           {{lang_trans('txt_no_rooms')}}
                                           <a class="btn btn-xs btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                                        @endif
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{lang_trans('txt_product_stocks')}}</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable_" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>{{lang_trans('txt_sno')}}</th>
                              <th>{{lang_trans('txt_product')}}</th>
                              <th>{{lang_trans('txt_current_stocks')}}</th>
                              <th>{{lang_trans('txt_unit')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($products as $k=>$val)
                              <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{$val->stock_qty}}</td>
                                <td>{{($val->unit) ? $val->unit->name : ''}}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection