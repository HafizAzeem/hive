@extends('layouts.master_backend')
@section('content')

@php 

$i = $j = 0; 
$totalAmount = 0;
@endphp
<div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2>{{lang_trans('Filter')}}</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              {{ Form::model($search_data,array('url'=>route('search-reports'),'id'=>"search-report", 'class'=>"form-horizontal form-label-left")) }}
                <div class="form-group col-sm-3">
                  <label class="control-label">{{lang_trans('Filter')}}</label>
                    {{Form::select('check_id',array(
                      'show_all' => 'Show All',
                      'Check_in' => 'Check In', 'Check_out' => 'Check Out'),null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])}}
                </div>
                
                <div class="form-group col-sm-2">
                  <label class="control-label">{{lang_trans('txt_payment_mode')}}</label>
                  {{Form::select('payment_mode',config('constants.PAYMENT_MODES'),config('constants.PAYMENT_MODES')[1],['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select"])}}
                </div>
                <div class="form-group col-sm-2">
                  <label class="control-label">{{lang_trans('txt_date_from')}}</label>
                  {{Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])}}
                </div>
                <div class="form-group col-sm-2">
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
              <h2>Set Time For Sheduling Report List</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              {{ Form::model($search_data,array('url'=>route('set-time'),'id'=>"search-report", 'class'=>"form-horizontal form-label-left")) }}
                <div class="form-group col-sm-2 pl-5">
                  <label class="control-label">Set Time</label>
                  {{Form::time('time', $emails[0]->time ?? '',['class'=>"form-control", 'placeholder'=>lang_trans('ph_date_to')])}}
                </div>
                <div class="form-group col-sm-3">
                  <br/>
                  <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit">Update Time</button>
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
                    <h2>{{lang_trans('Reports')}}</h2>
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
                        <th>{{lang_trans('txt_checkout')}}</th>
                        <th>{{lang_trans('Booking Payment')}}</th>
                        <th>{{lang_trans('txt_advance_payment')}}</th>
                        <th>{{lang_trans('txt_action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($datalist_checkin as $k=>$val)
                        
                        @php 
                        $payment = array();
                        $mode = $val->payment_mode ;
                        $modesec = $val->sec_advance_mode;
                          $paymentmode= Config::get('constants.PAYMENT_MODES.'.$mode);
                          $paymentmodesec= Config::get('constants.PAYMENT_MODES.'.$modesec);
                          $calc = calcFinalAmount($val);
                          $totalAmount = $totalAmount+$calc['finalRoomAmount']+$calc['finalOrderAmount'];
                          $i++; 
                          $method = array('Cash', 'Debit-Credit Card', 'Google Pay', 'Paytm', 'PhonePe', 'UPI', 'Send Payment Link');
                          foreach($method as $methods){
                            if($paymentmode == $methods){
                              $payment[] = array($methods => $val->advance_payment);
                            }else{
                              $payment[] = array($methods => 0);
                            }
                          }
                         
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
                          <td>{{dateConvert($val->user_checkout,'d-m-Y H:i')}}</td>
                          <td>{{getCurrencySymbol()}} {{ $val->booking_payment }}</td>
                          <td data-toggle="tooltip" title="@foreach($payment as $payments) @foreach($payments as $key => $value) {{$key}} : {{$value}}   | @endforeach @endforeach">{{getCurrencySymbol()}} {{ $val->advance_payment }} ({{ (".$paymentmode.") }}) </td>
                          <td>
                        
                            <a class="btn btn-sm btn-success" href="{{route('view-reservation',[$val->id])}}">{{lang_trans('btn_view')}}</i></a>
                           
                          </td>
                        </tr>
                       
                      @endforeach
                    </tbody>
                  </table>
                  <!--<table class="table table-striped table-bordered">-->
                  <!--    <tr>-->
                  <!--      <th class="text-right" width="70%">{{lang_trans('txt_grand_total')}}</th>-->
                  <!--      <th width="30%"><b>{{getCurrencySymbol()}} {{numberFormat($totalAmount)}}</b></th>-->
                  <!--    </tr>-->
                  <!--</table>-->
                </div>
            </div>
        </div>
    </div>
</div>          
@endsection