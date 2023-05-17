@extends('layouts.master_backend')
@section('content')
<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>{{lang_trans('heading_filter_orders')}}</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            {{ Form::model($search_data,array('url'=>route('search-orders'),'id'=>"search-orders", 'class'=>"form-horizontal form-label-left")) }}
              <div class="form-group col-sm-3">
                <label class="control-label">{{lang_trans('txt_type')}}</label>
                {{Form::select('order_type',config('constants.LIST_ORDER_TYPES'),null,['class'=>"form-control"])}}
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">{{lang_trans('txt_date_from')}}</label>
                {{Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])}}
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">{{lang_trans('txt_date_to')}}</label>
                {{Form::text('date_to',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_to')])}}
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

  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('heading_all_orders')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>{{lang_trans('txt_sno')}}</th>
                      <th>{{lang_trans('txt_order_by')}}</th>
                      <th>{{lang_trans('txt_inv_num')}}</th>
                      <th>{{lang_trans('txt_tbl_room_num')}}</th>
                      <th>{{lang_trans('txt_customer_name')}}</th>
                      <th>{{lang_trans('txt_customer_email')}}</th>
                      <th>{{lang_trans('txt_customer_mobile')}}</th>
                      <th>{{lang_trans('txt_order_date')}}</th>
                      <th>{{lang_trans('txt_pay_date')}}</th>
                      <th>{{lang_trans('txt_order_list')}}</th>
                      <th>{{lang_trans('txt_total_amount')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($datalist as $key=>$value)
                      @php 
                      $totalOrdersAmount = $finalOrderAmount = 0; 
                      $totalOrderAmountGst = $totalOrderAmountCGst = $totalOrderAmountDiscount = $orderGst = $orderCGst = 0;
                      $orderInfo = $value;
                      if($orderInfo){
                        $orderGst = $orderInfo->gst_perc;
                        $orderCGst = $orderInfo->cgst_perc;

                        $totalOrderAmountGst = $orderInfo->gst_amount;
                        $totalOrderAmountCGst = $orderInfo->cgst_amount;
                        $totalOrderAmountDiscount = $orderInfo->discount;
                      }
                                   
                      $countOrderHistory = ($value->order_history) ? $value->order_history->count() : 0;
                      $reservationId = $value->reservation_id;

                      $name = $value->name;
                      $email = $value->email;
                      $mobile = $value->mobile;
                      $checkOutDate = '';
                      if($reservationId>0){
                        if($value->reservation_data){
                          if($value->reservation_data->customer){
                            $name = $value->reservation_data->customer->name;
                            $email = $value->reservation_data->customer->email;
                            $mobile = $value->reservation_data->customer->mobile;
                            $checkOutDate = $value->reservation_data->check_out;
                          }
                        }
                        $type = lang_trans('txt_room_order');
                      } else {
                        $type = lang_trans('txt_tbl_order');
                      }
                      @endphp
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$type}}</td>
                        <td>{{$value->invoice_num}}</td>
                        <td>{{($value->reservation_data!=null) ? $value->reservation_data->room_num : $value->table_num }}</td>
                        <td>{{$name}}</td>
                        <td>{{$email}}</td>
                        <td>{{$mobile}}</td>
                        <td>{{dateConvert($value->created_at,'d-m-Y H:i')}}</td>
                        <td>{{ ($value->original_date!=null) ? dateConvert($value->original_date,'d-m-Y H:i') : 'NA'}}</td>
                        <td width="40%">
                          <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#tbl-{{$key}}">{{lang_trans('btn_view_item')}}</button>
                          @if($value->reservation_data==null)
                          <a href="{{route('order-invoice-final',[$orderInfo->id])}}" class="btn btn-sm btn-warning" target="_blank">{{lang_trans('txt_invoice')}}</a>
                          @endif
                          <div id="tbl-{{$key}}" class="collapse">
                            <table class="table table-bordered items-tbl">
                              <thead>
                                <tr>
                                  <th width="2%">{{lang_trans('txt_sno')}}</th>
                                  <th width="20%">{{lang_trans('txt_item_details')}}</th>
                                  <th width="5%">{{lang_trans('txt_item_qty')}}</th>
                                  <th width="5%">{{lang_trans('txt_item_price')}}</th>
                                  <th width="10%">{{lang_trans('txt_subtotal')}}</th>
                                  <th width="10%">{{lang_trans('txt_date')}}</th>
                                  <th width="5%">{{lang_trans('txt_action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($value->orders_items as $k=>$val)
                                  @php
                                    $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
                                    $finalOrderAmount = ($totalOrdersAmount+$totalOrderAmountGst+$totalOrderAmountCGst-$totalOrderAmountDiscount);

                                    $flag = false;

                                    if(Auth::user()->role_id==1){
                                      if($reservationId>0){
                                          if($checkOutDate=='' & $checkOutDate==null){
                                            $flag = true;
                                          }
                                      } else if($countOrderHistory>0){
                                        $flag = true;
                                      }
                                    }
                                  @endphp
                                  <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$val->item_name}}</td>
                                    <td>{{$val->item_qty}}</td>
                                    <td>{{getCurrencySymbol()}} {{$val->item_price}}</td>
                                    <td>{{getCurrencySymbol()}} {{$val->item_qty*$val->item_price}}</td>
                                     <td>{{dateConvert($val->created_at,'d-m-Y H:i')}}</td>
                                    <td> 
                                      @if($flag)
                                        <button class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-order-item',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
                                      @else
                                        <button class="btn btn-default btn-sm bgcolor-eee" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash color-cbc"></i></button>
                                      @endif
                                    </td>
                                  </tr>
                                @empty
                                  <tr>
                                    <td colspan="6">{{lang_trans('txt_no_orders')}}</td>
                                  </tr>
                                @endforelse
                                <tr>
                                    <th colspan="5" class="text-right">{{lang_trans('txt_total_amount')}}</td>
                                    <td>{{getCurrencySymbol()}} {{numberFormat($finalOrderAmount)}}</td>
                                    <td></td>
                                </tr>
                              </tbody>
                            </table>
                          </th>
                        </td>
                       <td>{{getCurrencySymbol()}} {{numberFormat($finalOrderAmount)}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
               
              </div>
          </div>
      </div>
  </div>
</div>  
     
@endsection