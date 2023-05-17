@extends('layouts.master_backend')
@section('content')

@php
$userRole = Auth::user()->role_id;
$settings = getSettings();

$jsonDecode = json_decode($data_row->amount_json);
$roomAmountDiscount = (isset($jsonDecode->room_amount_discount)) ? $jsonDecode->room_amount_discount : 0;
$advancePayment = ($data_row->advance_payment>0 ) ? $data_row->advance_payment : 0;
$secadvancePayment = ($data_row->sec_advance_payment>0 ) ? $data_row->sec_advance_payment : 0;
$thirdadvancePayment = ($data_row->third_advance_payment>0 ) ? $data_row->third_advance_payment : 0;
$fourthadvancePayment = ($data_row->fourth_advance_payment>0 ) ? $data_row->fourth_advance_payment : 0;
$fifthadvancePayment = ($data_row->fifth_advance_payment>0 ) ? $data_row->fifth_advance_payment : 0;
$sixthadvancePayment = ($data_row->sixth_advance_payment>0 ) ? $data_row->sixth_advance_payment : 0;
$totalAdvance = $advancePayment + $secadvancePayment + $thirdadvancePayment + $fourthadvancePayment + $fifthadvancePayment + $sixthadvancePayment;
$gstPerc = $data_row->gst_perc;
$cgstPerc = $data_row->cgst_perc;

if($data_row->check_out == null){
$gstPerc = $settings['gst'];

$cgstPerc = $settings['cgst'];
}

$durOfStay = $data_row->duration_of_stay;
$perRoomPrice = $data_row->per_room_price;
if($perRoomPrice == '0.00' )
{
$perRoomPrice = 0.00;
$totalRoomAmount = $data_row->booking_payment;
}else
{
$roomQty = $data_row->room_qty;
$totalRoomAmount = ($durOfStay * $perRoomPrice * $roomQty);
}

$mode = $data_row->payment_mode;
 $modesec = $data_row->sec_advance_mode;
 $modethird = $data_row->third_advance_mode;
 $modefourth = $data_row->fourth_advance_mode;
 $modefifth = $data_row->fifth_advance_mode;
 $modesixth = $data_row->sixth_advance_mode;
  $paymentmode= Config::get('constants.PAYMENT_MODES.'.$mode);
  $paymentmodesec= Config::get('constants.PAYMENT_MODES.'.$modesec);
  $paymentmodethird= Config::get('constants.PAYMENT_MODES.'.$modethird);
  $paymentmodefourth= Config::get('constants.PAYMENT_MODES.'.$modefourth);
  $paymentmodefifth= Config::get('constants.PAYMENT_MODES.'.$modefifth);
  $paymentmodesixth= Config::get('constants.PAYMENT_MODES.'.$modesixth);



$gstCal = gstCalc($totalRoomAmount,'room_gst',$gstPerc,$cgstPerc);


$roomAmountGst = $gstCal['gst'];

$roomAmountCGst = $gstCal['cgst'];

$finalRoomAmount = $totalRoomAmount+$roomAmountGst+$roomAmountCGst-$advancePayment-$secadvancePayment-$roomAmountDiscount;
$checkout = date_create($data_row->user_checkout);
$date = date_format($checkout,"Y-m-d H:i");
if($data_row->orders_info == null || $data_row->payment_status==0){
$gstPercFood = $settings['food_gst'];
$cgstPercFood = $settings['food_cgst'];
$foodOrderAmountDiscount = 0;
$gstFoodApply = 1;
} else {
$gstPercFood = $data_row->orders_info->gst_perc;
$cgstPercFood = $data_row->orders_info->cgst_perc;
$foodOrderAmountDiscount = ($data_row->orders_info->discount>0) ? $data_row->orders_info->discount : 0;
$gstFoodApply = ($data_row->orders_info->gst_apply==1) ? 1 : 0;
}
$totalOrdersAmount = $finalFoodAmount = $finalAmount = 0;
@endphp
<div class="">
    {{ Form::model($data_row,array('url'=>route('check-out'),'id'=>"check-out-form", 'class'=>"form-horizontal form-label-left",'files'=>true,'autocomplete'=>"off")) }}
    {{Form::hidden('id',null)}}
    <div class="row" id="new_guest_section">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_guest_type')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{lang_trans('txt_fullname')}}</th>
                                        <td>{{$data_row->customer->name}}</td>
                                        <th>{{lang_trans('txt_email')}}</th>
                                         <td id="email">{{$data_row->customer->email}}</td>
                                    </tr>
                                    <tr>

                                        <th>{{lang_trans('txt_mobile_num')}}</th>
                                        <td>{{$data_row->customer->mobile}}</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_checkin_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_checkin')}} <span class="required">*</span></label>
                            {{Form::text('check_in_date',$data_row->check_in,['class'=>"form-control col-md-6 col-xs-12", "id"=>"check_in_date", "placeholder"=>lang_trans('ph_date'),'readonly'=>true,'disabled'=>true])}}
                        </div>
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_checkout')}} <span class="required">*</span></label>
                            {{Form::text('check_out_date',$date,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_out_date", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_duration_of_stay')}} <span class="required">*</span></label>
                            {{Form::number('duration_of_stay',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"duration_of_stay", "placeholder"=>lang_trans('ph_day_night'),"min"=>1,'required'=>true])}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_idcard_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    @if($data_row->id_cards->count())
                    <div class="row">
                        <div class="col-sm-12">
                            <br />
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="2">{{lang_trans('txt_uploaded_files')}}</th>
                                </tr>
                                <tr>
                                    <th>{{lang_trans('txt_sno')}}.</th>
                                    <th>{{lang_trans('txt_action')}}</th>
                                </tr>
                                @if($data_row->id_cards)
                                @foreach($data_row->id_cards as $k=>$val)
                                @if($val->file!='')
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>
                                        <img src="{{asset('public/uploads/id_cards/'.$val->file)}}" alt="">
                                        <a href="{{checkFile($val->file,'uploads/id_cards/','blank_id.jpg')}}" data-toggle="lightbox" data-title="{{lang_trans('txt_idcard')}}" data-footer="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> </a>
                                        <a href="{{checkFile($val->file,'uploads/id_cards/','blank_id.jpg')}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>
                                        <button type="button" class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-mediafile',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="2">{{lang_trans('txt_no_file')}}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_payment_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>{{lang_trans('heading_tax_type')}}</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                {{Form::radio('tax_type','inclusive',true,['class'=>"flat tax_type", 'id'=>'inclusive'])}} <label for="inclusive">{{lang_trans('txt_inclusive_tax')}}</label>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                {{Form::radio('tax_type','exclusive',false,['class'=>"flat tax_type", 'id'=>'exclusive'])}} <label for="exclusive">{{lang_trans('txt_exclusive_tax')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="2%">{{lang_trans('txt_sno')}}.</th>
                                        <th width="20%">{{lang_trans('txt_room')}}</th>
                                        <th width="5%">{{lang_trans('txt_room_qty')}}</th>
                                        <th width="5%">{{lang_trans('txt_duration_of_stay')}}</th>
                                        <th width="5%">{{lang_trans('txt_base_price')}}</th>
                                        <th width="10%">{{lang_trans('txt_total_amount')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            @if($data_row->room_type)
                                            {{$data_row->room_type->title}}<br />
                                            ( {{lang_trans('txt_room_num')}} : {{$data_row->room_num}} )
                                            @endif
                                        </td>
                                        <th>{{$data_row->room_qty}}</th>
                                        <th id="td_dur_stay">{{$data_row->duration_of_stay}}</th>
                                        <td>
                                            {{Form::number('amount[per_room_price]',$data_row->per_room_price,['id'=>'per_room_price','class'=>'form-control', 'min'=>$data_row->per_room_price])}}
                                            <span class="error base_price_err_msg"></span>
                                        </td>
                                        <td class="td_total_room_amount">{{getCurrencySymbol()}} {{ $totalRoomAmount }}</td>
                                    </tr>
                                </tbody>
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="text-right">{{lang_trans('txt_subtotal')}} {{Form::hidden('amount[total_room_amount]',$totalRoomAmount,['id'=>'total_room_amount'])}}</th>
                                        <td width="15%" class="text-right td_total_room_amount">{{getCurrencySymbol()}} {{ $totalRoomAmount }}</td>
                                    </tr>
                                    <tr class="exclusive">
                                        <th class="text-right">{{lang_trans('txt_sgst')}} ({{$gstPerc}}%) {{Form::hidden('amount[total_room_amount_gst]',null,['id'=>'total_room_amount_gst'])}}</th>
                                        <td width="15%" id="td_total_room_amount_gst" class="text-right">{{getCurrencySymbol()}} {{ $roomAmountGst }}</td>
                                    </tr>
                                    <tr class="exclusive">
                                        <th class="text-right">{{lang_trans('txt_cgst')}} ({{$cgstPerc}}%) {{Form::hidden('amount[total_room_amount_cgst]',null,['id'=>'total_room_amount_cgst'])}}</th>
                                        <td width="15%" id="td_total_room_amount_cgst" class="text-right">{{getCurrencySymbol()}} {{ $roomAmountCGst }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">{{lang_trans('txt_advance_amount')." (".$paymentmode.")"}}</th>
                                        <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($advancePayment) }}</td>
                                    </tr>
                                    @if($secadvancePayment)
                                    <tr>
                                        <th class="text-right">{{lang_trans('Second Advance')." (".$paymentmodesec.")"}}</th>
                                        <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($secadvancePayment) }}</td>
                                    </tr>
                                    @endif
                                    @if($thirdadvancePayment)
                               <tr>
                                <th class="text-right">{{lang_trans('Third Advance')." (".$paymentmodethird.")"}}</th>
                                <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($thirdadvancePayment) }}</td>
                              </tr>
                              @endif
                              @if($fourthadvancePayment)
                               <tr>
                                <th class="text-right">{{lang_trans('Fourth Advance')." (".$paymentmodefourth.")"}}</th>
                                <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($fourthdadvancePayment) }}</td>
                              </tr>
                              @endif
                              @if($fifthadvancePayment)
                               <tr>
                                <th class="text-right">{{lang_trans('Fifth Advance')." (".$paymentmodefifth.")"}}</th>
                                <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($fifthdadvancePayment) }}</td>
                              </tr>
                              @endif
                              @if($sixthadvancePayment)
                               <tr>
                                <th class="text-right">{{lang_trans('Sixth Advance')." (".$paymentmodesixth.")"}}</th>
                                <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($sixthdadvancePayment) }}</td>
                              </tr>
                              @endif
                                    <tr>
                                        <th class="text-right">{{lang_trans('txt_discount')}}</th>
                                        <td width="15%" id="td_advance_amount" class="text-right">
                                            {{Form::number('discount_amount',$roomAmountDiscount,['class'=>"form-control col-md-7 col-xs-12", "id"=>"discount", "placeholder"=>lang_trans('ph_any_discount'),"min"=>0])}}
                                            <span class="error discount_room_err_msg"></span>
                                        </td>
                                    </tr>
                                    <tr class="exclusive">
                                    <th class="text-right">{{lang_trans('txt_total_amount')}} {{Form::hidden('amount[total_room_final_amount]',null,['id'=>'total_room_final_amount'])}}</th>
                                        <td width="15%" id="td_room_final_amount" class="text-right">{{getCurrencySymbol()}} {{ $finalRoomAmount }}</td>
                                    </tr>
                                    <tr id="second" style="display:none">
                                        <th class="text-right">{{lang_trans('txt_total_amount')}} {{Form::hidden('amount[total_room_final_amount]',null,['id'=>'total_room_final_amount'])}}</th>
                                        <td width="15%" id="td_room_final_amount"  class="text-right">{{getCurrencySymbol()}} {{ $finalRoomAmount-$roomAmountGst-$roomAmountCGst }}</td>
                                    </tr>
                                    </tr>
                                </table>
                            </table>


                            <div class="x_title">
                                <h2>{{lang_trans('txt_food_orders')}}</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>{{lang_trans('heading_tax_type')}}</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                                        {{Form::radio('tax_type_food','inclusive',true,['class'=>"flat tax_type_food", 'id'=>'inclusive'])}} <label for="inclusive">{{lang_trans('txt_inclusive_tax')}}</label>
                                                    </div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                                        {{Form::radio('tax_type_food','existing',false,['class'=>"flat tax_type_food", 'id'=>'exclusive'])}} <label for="exclusive">{{lang_trans('txt_exclusive_tax')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="2%">{{lang_trans('txt_sno')}}.</th>
                                        <th width="20%">{{lang_trans('txt_item_details')}}</th>
                                        <th width="5%">{{lang_trans('txt_date')}}</th>
                                        <th width="5%">{{lang_trans('txt_item_qty')}}</th>
                                        <th width="5%">{{lang_trans('txt_item_price')}}</th>
                                        <th width="10%">{{lang_trans('txt_total_amount')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_row->orders_items as $k=>$val)
                                    @php
                                    $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
                                    @endphp
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$val->item_name}}</td>
                                        <td>{{dateConvert($val->created_at,'d-m-Y')}}</td>
                                        <td>{{$val->item_qty}}</td>
                                        <td>{{getCurrencySymbol()}} {{$val->item_price}}</td>
                                        <td>{{getCurrencySymbol()}} {{$val->item_qty*$val->item_price}}</td>
                                    </tr>
                                    @if(count($data_row->orders_items) == ($k+1) )
                                    <tr>
                                        <th colspan="5" class="text-right">{{lang_trans('txt_gst_apply')}}</th>
                                        <td>{{ Form::checkbox('food_gst_apply',$gstFoodApply,($gstFoodApply==1) ? true : false,['id'=>'apply_gst']) }}</td>
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td colspan="6">{{lang_trans('txt_no_orders')}}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @php
                            $gst = gstCalc($totalOrdersAmount,'food_amount',$gstPercFood,$cgstPercFood);
                            $foodAmountGst = $gst['gst'];
                            $foodAmountCGst = $gst['cgst'];
                            @endphp
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-right">{{lang_trans('txt_subtotal')}} {{Form::hidden('amount[order_amount]',$totalOrdersAmount,['id'=>'total_order_amount'])}}</th>
                                    <td width="15%" id="td_total_order_amount" class="text-right">{{getCurrencySymbol()}} {{ $totalOrdersAmount }}</td>
                                </tr>
                                <tr class="exclusive-food">
                                    <th class="text-right">{{lang_trans('txt_sgst')}} ({{$gstPercFood}}%) {{Form::hidden('amount[order_amount_gst]',$foodAmountGst,['id'=>'total_order_amount_gst'])}}</th>
                                    <td width="15%" id="td_order_amount_gst" class="text-right">{{getCurrencySymbol()}} {{$foodAmountGst}}</td>
                                </tr>
                                <tr class="exclusive-food">
                                    <th class="text-right">{{lang_trans('txt_cgst')}} ({{$cgstPercFood}}%) {{Form::hidden('amount[order_amount_cgst]',$foodAmountCGst,['id'=>'total_order_amount_cgst'])}}</th>
                                    <td width="15%" id="td_order_amount_cgst" class="text-right">{{getCurrencySymbol()}} {{$foodAmountCGst}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">{{lang_trans('txt_discount')}}</th>
                                    <td width="15%" id="td_advance_amount" class="text-right">
                                        {{Form::number('discount_order_amount',$foodOrderAmountDiscount,['class'=>"form-control col-md-7 col-xs-12", "id"=>"order_discount", "placeholder"=>lang_trans('ph_any_discount'),"min"=>0])}}
                                        <span class="error discount_order_err_msg"></span>
                                    </td>
                                </tr>
                                <tr class="bg-warning">
                                    <th class="text-right">{{lang_trans('txt_total_amount')}} {{Form::hidden('amount[order_final_amount]',null,['id'=>'total_order_final_amount'])}}</th>
                                    <td width="15%" id="td_order_final_amount" class="text-right">{{getCurrencySymbol()}} {{ $totalOrdersAmount }}</td>
                                </tr>
                            </table>

                            <table class="table table-bordered">
                                <tr class="bg-success">
                                    <th class="text-right">{{lang_trans('txt_grand_total')}} {{Form::hidden('amount[total_final_amount]',null,['id'=>'total_final_amount'])}}</th>
                                    <td width="15%" id="td_final_amount" class="text-right">{{getCurrencySymbol()}} {{ $finalAmount }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="x_title">
                            <h2>{{lang_trans('heading_additional_info')}}</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="col-md-12 col-sm-12 col-xs-12">{{lang_trans('txt_inv_applicable')}}</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    {{Form::radio('invoice_applicable',1,true,['class'=>"flat invoice_applicable", 'id'=>'yes_invoice'])}}
                                    <label for="yes_invoice">{{lang_trans('txt_yes')}}</label>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    {{Form::radio('invoice_applicable',0,false,['class'=>"flat invoice_applicable", 'id'=>'no_invoice'])}}
                                    <label for="no_invoice">{{lang_trans('txt_no')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label"> {{lang_trans('txt_company_gst_num')}}</label>
                                {{Form::text('company_gst_num',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"company_gst_num", "placeholder"=>"Enter GST Number"])}}
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label"> {{lang_trans('txt_payment_mode')}}</label>
                                {{Form::select('payment_mode',config('constants.PAYMENT_MODES'),null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select","required"=>"true"])}}
                            </div>

                            



                        </div>
                        

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                <button class="btn btn-success" style="display:none" id="first" type="button" onclick="payment_link()">{{lang_trans('Verify')}}</button>
                    <button class="btn btn-success btn-submit-form" type="submit">{{lang_trans('btn_submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
</div>

{{-- require set php var in js var --}}

<script>
    globalVar.page = 'checkout';
    globalVar.userRole = {
        {
            $userRole
        }
    };
    globalVar.checkInDate = '';
    globalVar.checkOutDate = '';
    globalVar.gstPercent = {
        {
            $gstPerc
        }
    };
    globalVar.cgstPercent = {
        {
            $cgstPerc
        }
    };
    globalVar.gstPercentFood = {
        {
            $gstPercFood
        }
    };
    globalVar.cgstPercentFood = {
        {
            $cgstPercFood
        }
    };
    globalVar.durationOfStayDays = {
        {
            $durOfStay
        }
    };
    globalVar.basePriceOneRoomOriginal = {
        {
            $perRoomPrice
        }
    };
    globalVar.basePriceOneRoom = {
        {
            $perRoomPrice
        }
    };
    globalVar.roomQty = {
        {
            $roomQty
        }
    };
    globalVar.advanceAmount = {
        {
            $advancePayment
        }
    };
    globalVar.totalOrdersAmount = {
        {
            $totalOrdersAmount
        }
    };
    globalVar.subTotalRoomAmount = {
        {
            $totalRoomAmount
        }
    };
    globalVar.discount = {
        {
            $roomAmountDiscount
        }
    };
    globalVar.foodOrderDiscount = {
        {
            $foodOrderAmountDiscount
        }
    };
    globalVar.gstOrderAmount = 0;
    globalVar.gstRoomAmount = {
        {
            $roomAmountGst
        }
    };
    globalVar.applyFoodGst = {
        {
            $gstFoodApply
        }
    };
    globalVar.isError = false;
    globalVar.startDate = moment("{{$data_row->check_in}}", "YYYY.MM.DD");

</script>
<script type="text/javascript" src="{{URL::asset('public/js/page_js/page.js')}}"></script>

<script type="application/javascript">
    var mindate = new Date();
    $("#check_out_date_my").datetimepicker({
        format: "yyyy-mm-dd hh:mm",
        minDate: mindate,
    });

    $('.tax_type').on('ifChanged', function() {

        var type = $(this).val();
        if (type == 'inclusive') {
            $('.exclusive').show();
            $("#second").hide();
        } else {
            $('.exclusive').hide();
            $("#second").show();
        }
    });
    $(document).on('change', '#payment', function( event ) {
                            loadSelectedDeviceOptions($(this).val());
                        });
                        function loadSelectedDeviceOptions(selectedOption) {

                        console.log(selectedOption);
                        if (selectedOption == 7)
                            {
                                $("#first").show();
                                
                            }
                            else{
                                $("#first").hide();
                            }
                            
                    }
    $('.tax_type_food').on('ifChanged', function() {

        var type = $(this).val();
        if (type == 'inclusive') {
            $('.exclusive-food').show();
        } else {
            $('.exclusive-food').hide();
        }
    });
    function payment_link(){
        var val=$('input[name="guest_type"]:checked').val();
        if(val=="existing"){
            var customer_id=$('input[name="selected_customer_id"]').val();
            if(customer_id==""){
                alert('please select a customer');
            }else{
                  
                $.ajax({
                    url: "{{route('sendpaymentlink')}}?guest_type=existing&customer="+customer_id,
                    type: "get",
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                    }
                });

            }
        }else{
            var name=$('#name').val();
            var email=document.getElementById('email').innerText;
            var phone=$('#phone').val();
            var payment=$('#advance_payment').val();
            console.log(phone);
            console.log()
            if(name!="" && email!="" && phone!="" && payment!=""){
                $.ajax({
                    url: "{{route('sendpaymentlink')}}?guest_type=new&name="+name+"&email="+email+"&phone="+phone+"&payment="+payment,
                    type: "get",
                    dataType: 'json',
                    success: function (response) {
                         console.log(response);
                         alert('Payment Link Sent Sucessfully');
                    }
                });
               
            }else{
                alert('Enter Customer Information');
            }



           
        }
        
    }

</script>
@endsection
