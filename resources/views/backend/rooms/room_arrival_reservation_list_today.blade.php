@extends('layouts.master_backend')
@section('content')
@php 
$i = $j = 0; 
$totalAmount = 0;
@endphp
<style>
    .modal-header{
        padding-left: 15px;
        padding-right: 15px;
        padding-top: 10px;
        padding-bottom: 1px;
    }
    #exampleModalLabel{
        font-size: 30px;
        color: black;
        font-weight: 600;
    }
    .modal-header .close {
        margin-top: -30px;
        color: white;
        opacity: 1;
        background: red;
        padding: 5px;
    }
    .pmain{
        color: red;
        font-size: 18px;
    }
    .labelnew{
        font-size: 20px;
        color: black;
    }
    .fl2btns{
        float:left;
    }
</style>
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
                <div class="form-group col-sm-3">
                  <label class="control-label">{{lang_trans('txt_guest')}}</label>
                  {{Form::select('customer_id',null,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])}}
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
  @endif

  @if($list=='check_ins')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('sidemenu_arrival_all')}}</h2>
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
                        <th>Source</th>
                        <th>Duration</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                        <th>{{lang_trans('txt_checkin')}}</th>
                        <th>{{lang_trans('txt_checkout')}}</th>
                        <th>{{lang_trans('txt_action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($datalist as $k=>$val)
                     
                        <tr>
                          <td>{{++$k}}</td>
                          <td>{{ $val->name ?? 'NA'}}</td>
                          <td>{{ $val->mobile ?? 'NA'}}</td>
                          <td>{{ $val->source ?? 'NA'}}</td>
                          
                          @if($val->duration == 1)
                            <td>{{$val->duration ?? ''}} Day</td>
                          @else
                            <td>{{$val->duration ?? ''}} Days</td>
                          @endif
                          
                          <td>{{ $val->paymenttype ?? 'NA'}}</td>
                          <td>{{ $val->bookingstatus ?? 'NA'}}</td>
                          
                          <td>{{dateConvert($val->check_in,'d-m-Y H:i')}}</td>
                             <td>{{dateConvert($val->check_out,'d-m-Y')}}</td>
                          <td>
                            <!-- <a class="btn btn-sm btn-warning" href="{{route('food-order',[$val->id])}}">{{lang_trans('btn_food_order')}}</i></a>
                            <a class="btn btn-sm btn-success" href="{{route('view-reservation',[$val->id])}}">{{lang_trans('btn_view')}}</i></a>
                            <a class="btn btn-sm btn-info" href="{{route('check-out-room',[$val->id])}}">{{lang_trans('btn_checkout')}}</i></a>  -->
                        
                            <!--<a class="btn btn-danger btn-update-form"  href="{{--route('cancel-arrival',[$val->id])--}}">{{--lang_trans('btn_cancel')--}}</a>-->
                            <a class="btn btn-sm btn-danger btn-update-form" data-toggle="modal" data-target="#exampleModal{{$val->id}}" value="{{$val->id}}" >Cancel</a>
                            <a class="btn btn-sm btn-info" href="{{route('room-reservation',[$val->id])}}">{{lang_trans('sidemenu_checkin_add')}}</i></a>
                            <span>
                            @if(strlen((string)$val->Booking_id) == 7)
                            <span class="fl2btns"><a class="btn btn-sm btn-success" href="https://hotels.eglobe-solutions.com/pmsnet/channelmanager/bookingdetail/59SNIfarx0eiIa04gs06/{{$val->Booking_id}}" target="_blank">Bill</i></a></span>
                            @else
                            <span class="fl2btns"><a class="btn btn-sm btn-success" href="{{$val->bookingdetailurl}}" target="_blank">Bill</i></a></span>
                            @endif
                            
                            <?php
                                $country_code = '+91';
                                $result = preg_replace("/^\+?{$country_code}/", '',$val->mobile ?? '');
                                $result = $result ?? '';
                                $mobile = str_replace(" ", "", $result);
                                $mobile = $mobile ?? '';
                            ?>
                                <span class="fl2btns">
                                    <form action="{{route('placeCall')}}" method="GET">
                                        @csrf
                                        <input type="hidden" name="clientnumber" class="form-control" id="clientnumber" value="{{ $mobile ?? ''}}">
                                        <button type="submit" class="btn btn-sm btn-primary">Call Me</button>
                                    </form>
                                </span>
                            </span>
                            
                          </td>
                        </tr>
                        
                        <!--Model start-->
                        
                        <div class="modal fade" id="exampleModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Booking Cancel Reason</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                           X
                                        </button>
                                    </div>
                                    <form action="{{route('cancel-arrival',[$val->id])}}" method="GET">
                                        <div class="modal-body">
                                            <div class="container">
                                                <p class="pmain">Are you sure you want to cancel this booking?</p><br>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label class="labelnew">Reason</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="id" value="{{$val->id}}">
                                                        <!--<input class="form-control" type="textarea" name="bcreason" id="bcreason" >-->
                                                        <textarea class="form-control" id="bcreason" name="bcreason" rows="2" cols="50" maxlength="80" required></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!--Model End-->
                 
                      @endforeach
                    </tbody>
                  </table>
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
                    <h2>No Show Arrivals</h2>
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
                        <th>Source</th>
                        <th>Duration</th>
                        <th>{{lang_trans('txt_checkin')}}</th>
                        <th>{{lang_trans('txt_checkout')}}</th>
                        <th>Reason</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                         @if(isset($datalist3))
                      @foreach($datalist3 as $k=>$val)
                     
                        <tr>
                          <td>{{++$k}}</td>
                          <td>{{ $val->name ?? 'NA'}}</td>
                          <td>{{ $val->mobile ?? 'NA'}}</td>
                          <td>{{ $val->source ?? 'NA'}}</td>
                          
                          @if($val->duration == 1)
                            <td>{{$val->duration ?? ''}} Day</td>
                          @else
                            <td>{{$val->duration ?? ''}} Days</td>
                          @endif
                          
                          <td>{{dateConvert($val->check_in ,'d-m-Y H:i')}}</td>
                          <td>{{dateConvert($val->check_out,'d-m-Y H:i')}}</td>
                          <td>{{$val->reason ?? ''}}</td>
                         @if($val->is_deleted == 1)
                          <td>
                              <a class="btn btn-danger">void</a>

                          </td>
                          @elseif(dateConvert($val->check_in,'d-m-Y') < date('d-m-Y') )
                          <td>
                              <a class="btn btn-danger">No Show</a>

                          </td>
                          @endif
                        </tr>
                 
                      @endforeach
                      @endif
                      
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
  @endif
  
  
  
  
</div>          
@endsection