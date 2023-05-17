@extends('layouts.master_backend')
@section('content')
@php
$i =1; $j = 0;
$k1=1;
$totalAmount = 0;

$type =  basename(request()->path());
@endphp

<div class="card">
    <div class="card-header">
        <span style="float:right;">
            <a href="{{route('single-list-reservation')}}" class="btn btn{{$type=='single-list-reservation' ? '-success':''}}">Single Cheking</a>
            <a href="{{route('multi-list-reservation')}}" class="btn btn{{$type=='multi-list-reservation' ? '-success':''}}">Multi-Cheking</a>
            <a href="{{route('list-check-outs')}}" class="btn btn{{$type=='list-check-outs' ? '-success':''}}">All Check Out's</a>
        </span>
    </div>
</div>

<div class="">
  @if($list=='all_check_outs')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_checkout_list')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <table id="newtableid" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>{{lang_trans('txt_guest_name')}}</th>
                        <th>{{lang_trans('txt_mobile_num')}}</th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th>{{lang_trans('txt_room')}}</th>
                        <th>{{lang_trans('txt_checkin')}}</th>
                        <th>{{lang_trans('txt_checkout')}}</th>
                        <th>{{lang_trans('txt_booking_amount')}}</th>
                        <th>{{lang_trans('txt_action')}}</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($datalist as $k=>$val)
                      @if($val->room_num)
                        @if($val->check_out!=null)
                        @php $totalAmount +=$val->booking_payment; @endphp
                          <tr>
                          <td>{{$k1}}</td>
                          <td>{{($val->customer) ? $val->customer->name : 'NA'}}</td>
                          <td>{{($val->customer) ? $val->customer->mobile : 'NA'}}</td>
                          
                          @if($val->referred_by)
                            <td>{{$val->referred_by ?? ''}} (MID : {{$val->mid}})</td>
                          @else
                            <td>{{$val->referred_by_name ?? ''}} (MID : {{$val->mid}})</td>
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
                          <td>{{dateConvert($val->created_at_checkin,'d-m-Y H:i')}}</td>
                          <td>{{dateConvert($val->created_at_checkout,'d-m-Y H:i')}}</td>

                          <td>
                            {{getCurrencySymbol()}} {{$val->booking_payment}}
                          </td>
                          <td>
                            <a class="btn btn-sm btn-success" href="{{route('view-reservation',[$val->id])}}">{{lang_trans('btn_view')}}</i></a>
                            <a class="btn btn-sm btn-danger" href="{{route('invoice',[$val->id,1])}}" target="_blank">{{lang_trans('btn_invoice_room')}}</i></a>
                            <a class="btn btn-sm btn-warning" href="{{route('invoice',[$val->id,2])}}" target="_blank">{{lang_trans('btn_invoice_food')}}</i></a>
                          </td>
                        </tr>
                        @endif
                        @endif
                       @php $k1++; @endphp
                      
                      @endforeach
                      
                       
                        
                    </tbody>
                     
                            <div class="mt-4 p-4 box has-text-centered">
                                {{-- $datalist->links('vendor.laravel.framework.src.Illuminate.Pagination.bootstrap-4') --}}
                                {{ $datalist->links(pagination::bootstrap-4) }}
                            </div>
                        
                  </table>
                    
                </div>
                
            </div>
        </div>
    </div>
  @endif
</div>
@endsection

