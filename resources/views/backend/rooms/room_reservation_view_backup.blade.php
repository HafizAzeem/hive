@extends('layouts.master_backend')
@section('content')

@php 
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
 $modesec = $data_row->sec_payment_mode;
 $modethird = $data_row->third_payment_mode;
 $modefourth = $data_row->fourth_payment_mode;
 $modefifth = $data_row->fifth_payment_mode;
 $modesixth = $data_row->sixth_payment_mode;
$paymentmode= Config::get('constants.PAYMENT_MODES.'.$mode);
  $paymentmodesec= Config::get('constants.PAYMENT_MODES.'.$modesec);
  $paymentmodethird= Config::get('constants.PAYMENT_MODES.'.$modethird);
  $paymentmodefourth= Config::get('constants.PAYMENT_MODES.'.$modefourth);
  $paymentmodefifth= Config::get('constants.PAYMENT_MODES.'.$modefifth);
  $paymentmodesixth= Config::get('constants.PAYMENT_MODES.'.$modesixth);


$gstCal = gstCalc($totalRoomAmount,'room_gst',$gstPerc,$cgstPerc);


$roomAmountGst = $gstCal['gst'];

$roomAmountCGst = $gstCal['cgst'];

$finalRoomAmount = $totalRoomAmount+$roomAmountGst+$roomAmountCGst-$advancePayment-$secadvancePayment-$thirdadvancePayment-$fourthadvancePayment-$fifthadvancePayment-$sixthadvancePayment-$roomAmountDiscount;
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
      <div class="row" id="new_guest_section">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('heading_guest_info')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content"> 
                <div class="row"> 
                  <div class="col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-bordered">
                            <tr>
                              <th>{{lang_trans('txt_fullname')}}</th>
                              <td>{{$data_row->customer->name}}</td>
                              <th>{{lang_trans('txt_email')}}</th>
                              <td>{{$data_row->customer->email}}</td>
                            </tr>
                            <tr>
                            
                              <th>{{lang_trans('txt_mobile_num')}}</th>
                              <td>{{$data_row->customer->mobile}}</td>
                               <th>{{lang_trans('txt_age')}}</th>
                              <td>{{$data_row->customer->age}} {{lang_trans('txt_years')}}</td>
                            </tr>
                            <tr>
                              <th>{{lang_trans('txt_gender')}}</th>
                              <td>{{$data_row->customer->gender}}</td>
                             
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
                  <h2>{{lang_trans('heading_checkInOut_info')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                       <div class="col-md-12 col-sm-12 col-xs-12">
                          <table class="table table-bordered">
                            <tr>
                              <th>{{lang_trans('Check In')}}</th>
                              <td>{{dateConvert($data_row->check_in,'d-m-Y H:i')}}</td>
                              
                              <th>{{lang_trans('btn_checkout')}}</th>
                              <td>{{ $date}}</td>
                            </tr>
                            <!-- <tr>
                              <th>{{lang_trans('txt_checkin_from_date')}}</th>
                              <td>{{ ($data_row->created_at_checkin!=null) ? dateConvert($data_row->created_at_checkin,'d-m-Y H:i') : 'NA'}}</td>
                              <th>{{lang_trans('txt_checkout_from_date')}}</th>
                              <td>{{ ($data_row->user_checkout!=null) ? dateConvert($data_row->user_checkout,'d-m-Y H:i') : 'NA'}}</td>
                            </tr> -->
                            <tr>
                              <th>{{lang_trans('txt_room_num')}}</th>
                              <td>{{$data_row->room_num}}</td>
                              <th>{{lang_trans('txt_persons')}}</th>
                              <td><b>{{lang_trans('txt_adults')}}:</b> {{$data_row->adult}} <b>{{lang_trans('txt_kids')}}:</b> {{$data_row->kids}}</td>
                            </tr>
                            <tr>
                              <th>{{lang_trans('txt_idcard_type')}}</th>
                              <td>{{@config('constants.TYPES_OF_ID')[$data_row->idcard_type]}}</td>
                              <th>{{lang_trans('txt_idcard_num')}}</th>
                              <td>{{$data_row->idcard_no}}</td>
                            </tr>
                            <tr>
                              <th>{{lang_trans('txt_inv_applicable')}}</th>
                              <td>{{($data_row->invoice_num!='') ? 'Yes' : 'No'}}</td>
                              <th>{{lang_trans('txt_company_gst_num')}}</th>
                              <td>{{$data_row->company_gst_num}}</td>
                            </tr>
                           
                             <tr>
                              <th>{{lang_trans('txt_referred_by')}}</th>
                              <td>{{$data_row->referred_by}}</td>
                              <th>{{lang_trans('txt_referred_by_name')}}</th>
                              <td>{{$data_row->referred_by_name}}</td>
                            </tr>
                             <tr>
                              <th>{{lang_trans('txt_payment_mode')}}</th>
                              <td colspan="3">{{ @config('constants.PAYMENT_MODES')[$data_row->payment_mode]}}</td>
                            </tr>
                            <tr>
                              <th>{{lang_trans('txt_reason_of_visit')}}</th>
                              <td colspan="3">{{$data_row->reason_visit_stay}}</td>
                            </tr>
                            
                          </table>
                        </div>
                           
                  </div>                  
              </div>
          </div>
      </div>
  </div>
  
  
<!-- new -->


   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('txt_idcard_uploaded')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                       <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x: auto;">
                          <table class="table table-bordered">
                            <tr>
                              <th>{{lang_trans('txt_sno')}}.</th>

                           
                             
                              <th>{{lang_trans('txt_name')}}</th>
                              <th>{{lang_trans('txt_gender')}}</th>
                              <th>{{lang_trans('txt_age')}}</th>
                              
                             <!--  <th>{{lang_trans('txt_idcard_type')}}</th>
                              <th>{{lang_trans('txt_idcard_num')}}</th> -->
                              <th> Id Cards</th>
                              <th>Document</th>
                              <!-- <th>{{lang_trans('txt_action')}}</th> -->
                            </tr>
                            
                            @if($data_row->id_cards)
                              @foreach($data_row->id_cards as $k=>$val)
                              
                                
                                  <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$data_row->customer->name}}</td>
                                     <td>{{$data_row->customer->gender}}</td>
                                      <td>{{$data_row->customer->age}}</td>
                                      
                                    <td>
                                      <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                          <img src="{{asset('public/uploads/id_cards/'.$val->file)}}" height="120px" width="120px" style="margin-left:10px"><br><br>


 <a href="{{checkFile($val->file,'uploads/id_cards/','blank_id.jpg')}}"  class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>
  
   <button  class="btn btn-sm btn-success" title="Print" onclick="PrintImage('https://58.dsrhotelgroup.com/public/uploads/id_cards/{{$val->file}}')">                                     
<i class="fa fa-print" ></i>
                                        </button> 

                                        </div>
<div class="col-sm-4 col-xs-12">
 <img src="{{asset('public/uploads/id_cards/'.$val->cnic_back)}}"  height="120px" width="120px"><br><br>
                                  
 <a href="{{checkFile($val->cnic_back,'uploads/id_cards/','blank_id.jpg')}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a> 
    
  <button  class="btn btn-sm btn-success" title="Print" onclick="PrintImage('https://58.dsrhotelgroup.com/public/uploads/id_cards/{{$val->cnic_back}}')">                                     
              <i class="fa fa-print" ></i>
                                        </button>                               
                                     
                                        </div>
</div>                   
                                      
                                    </td>
                   
                                
                       
                              @endforeach
                              <td>
                            
                            <div class="col-sm-4 col-xs-12">
                               
<img src="{{asset('storage/app/'.$data_row->customer->document)}}"  height="120px" width="120px"><br><br>
                                
<a href="{{asset('storage/app/'.$data_row->customer->document)}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a> 
  
<button  class="btn btn-sm btn-success" title="Print" onclick="PrintImage('https://58.dsrhotelgroup.com/{{asset('storage/app/'.$data_row->customer->document)}}')">                                     
            <i class="fa fa-print" ></i>
                                      </button>                               
                                   
                                      </div>
                            </td>
                            </tr>
                            @else
                              <tr>
                                  <td colspan="2">{{lang_trans('txt_no_file')}}</td>
                              </tr>
                            @endif
                          </table>
                        </div>
                           
                  </div>                  
              </div>
          </div>
      </div>
  </div>
  <!-- end -->

  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('heading_person_info')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                       <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x:auto;">
                          <table class="table table-bordered" >
                            <tr>
                              <th>{{lang_trans('txt_sno')}}.</th>
                              <th>{{lang_trans('txt_name')}}</th>
                              <th>{{lang_trans('txt_gender')}}</th>
                              <th>{{lang_trans('txt_age')}}</th>
                              <!-- <th>{{lang_trans('txt_address')}}</th> -->
                              <th>{{lang_trans('txt_idcard_type')}}</th>
                              <th>{{lang_trans('txt_idcard_num')}}</th>
                              <th> Id Cards</th>
                            
                            </tr>
                            @if($data_row->persons)
                              @foreach($data_row->persons as $k=>$val)
                                <tr>
                                  <td>{{$k+1}}</td>
                                  <td>{{$val->name}}</td>
                                  <td>{{$val->gender}}</td>
                                  <td>{{$val->age}}</td>
                                  <!-- <td>{{$val->address}}</td> -->
                                  <td>{{@config('constants.TYPES_OF_ID')[$val->idcard_type]}}</td>
                                  <td>{{$val->idcard_no}}</td>
                                  <td>
<img src="{{asset($val->cnic_front)}}" alt="id card" height="120px" width="120px">
                                 
 <img src="{{asset($val->cnic_back)}}" alt="id card" height="120px" width="120px">
                                                                  
                                  
                                  </td>
                                </tr>
                              @endforeach
                            @else
                              <tr>
                                  <td colspan="7">{{lang_trans('txt_no_record')}}</td>
                              </tr>
                            @endif
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
                  <h2>{{lang_trans('heading_payment_info')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12" >
                        <table class="table table-bordered">
                          <tr>
                            <th>{{lang_trans('txt_payment_mode')}}</th>
                            <td>{{ ($data_row->payment_mode>0) ? config('constants.PAYMENT_MODES')[$data_row->payment_mode] : 'NA' }}</td>
                          </tr>
                        </table>
                      </div>
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
                                  {{$data_row->room_type->title}}<br/>
                                  ( {{lang_trans('txt_room_num')}} : {{$data_row->room_num}} )
                                @endif
                              </td>
                              <th>{{$data_row->room_qty}}</th>
                              <th id="td_dur_stay">{{$data_row->duration_of_stay}}</th>
                              <td>{{getCurrencySymbol()}} {{$data_row->per_room_price}}</td>
                              <td class="td_total_amount">{{getCurrencySymbol()}} {{ $totalRoomAmount }}</td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-bordered">
                              <tr>
                                <th class="text-right">{{lang_trans('txt_subtotal')}}</th>
                                <td width="15%" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($totalRoomAmount) }}</td>
                              </tr>
                              <tr>
                                <th class="text-right">{{lang_trans('txt_sgst')}} ({{$gstPerc}}%)</th>
                                <td width="15%" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($roomAmountGst) }}</td>
                              </tr>
                              <tr>
                                <th class="text-right">{{lang_trans('txt_cgst')}}
                                 ({{$cgstPerc}}%)
                              </th>
                                <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($roomAmountCGst) }}</td>
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
                                <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($roomAmountDiscount) }}</td>
                              </tr>
                              <tr class="bg-success">
                                <th class="text-right">{{lang_trans('txt_final_amount')}}</th>
                                <td width="15%" id="td_final_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($finalRoomAmount) }}</td>
                              </tr>
                        </table>
                        <div class="x_title">
                            <h2>{{lang_trans('txt_food_orders')}}</h2>
                            <div class="clearfix"></div>
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
                            @empty
                              <tr>
                                <td colspan="6">{{lang_trans('txt_no_orders')}}</td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                        @php
                        $finalRoomAmount
                        @endphp
                        @php
                            $gst = gstCalc($totalOrdersAmount,'food_amount',$gstPercFood,$cgstPercFood);
                            $foodAmountGst = $gst['gst'];
                            $foodAmountCGst = $gst['cgst'];
                            @endphp
                        <table class="table table-bordered">
                                    <tr>
                                      <th class="text-right">{{lang_trans('txt_subtotal')}}</th>
                                      <td width="15%" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($totalOrdersAmount) }}</td>
                                    </tr>
                                    <tr>
                                      <th class="text-right">{{lang_trans('txt_sgst')}} ({{$foodAmountGst}}%)</th>
                                      <td width="15%" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($foodAmountCGst) }}</td>
                                    </tr>
                                    <tr>
                                      <th class="text-right">{{lang_trans('txt_cgst')}} ({{$foodAmountCGst}}%)</th>
                                      <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($foodAmountCGst) }}</td>
                                    </tr>
                                    <tr>
                                      <th class="text-right">{{lang_trans('txt_discount')}}</th>
                                      <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($foodOrderAmountDiscount)}}</td>
                                    </tr>
                                    <tr class="bg-success">
                                      <th class="text-right">{{lang_trans('txt_final_amount')}}</th>
                                      <td width="15%" id="td_final_amount" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($totalOrdersAmount) }}</td>
                                    </tr>
                        </table>

                        <table class="table table-bordered">
                              <tr class="bg-warning">
                                <th class="text-right">{{lang_trans('txt_grand_total')}}</th>
                                <td width="15%" class="text-right">{{getCurrencySymbol()}} {{ numberFormat($finalAmount) }}</td>
                              </tr>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>   


	<script>
function ImagetoPrint(source) {
    
    return "<html><head><script>function step1(){\n" +
            "setTimeout('step2()', 10);}\n" +
            "function step2(){window.print();window.close()}\n" +
            "</scri" + "pt></head><body onload='step1()'>\n" +
            "<img src='" + source + "' /></body></html>";
            }
        function PrintImage(source) {
        Pagelink = "about:blank";
        var pwa = window.open(Pagelink, "_new");
        pwa.document.open();
        pwa.document.write(ImagetoPrint(source));
        pwa.document.close();
}
	</script>
@endsection