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

 $durOfStay = $data_row->duration_of_stay;
 $perRoomPrice = $data_row->per_room_price;
if($perRoomPrice == '0.00' )
{
$perRoomPrice = 0.00;
 $bookingAmount = $data_row->booking_payment;
 $roomQty = $data_row->room_qty; 
 $totalRoomAmount = ( $bookingAmount );

 $amount=$totalRoomAmount;
}else
{
 $roomQty = $data_row->room_qty;
 $bookingAmount = $data_row->per_room_price;
 
 
 
 $totalRoomAmount = ( $bookingAmount );
  $amount=$totalRoomAmount;
  
}
 ($customer_room_data == "empty");
if($customer_room_data == "empty")
{
    $roomQty = 1;
}
else
{
    $roomQty = $count;
}

 $bookingAmount *=$roomQty;
//$amount = $durOfStay * $bookingAmount * $roomQty;

if($data_row->check_out == null){
  if(($amount>=0) && ($amount<=999))
         {
            $gstPerc=$settings['gst_0'];
            $cgstPerc=$settings['cgst_0'];
         }
         else if(($amount>=1000) && ($amount<=2499))
         {
            $gstPerc=$settings['gst'];
            $cgstPerc=$settings['cgst'];
         }
            else if(($amount>2499) && ($amount<=7499))
         {
            $gstPerc=$settings['gst_1'];
            $cgstPerc=$settings['cgst_1'];
         }
         else
         {
            $gstPerc=$settings['gst_2'];
            $cgstPerc=$settings['cgst_2'];
         }
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

$gstCal = gstCalc($amount,'room_gst',$gstPerc,$cgstPerc);
$roomAmountGst = $gstCal['gst'];
$roomAmountCGst = $gstCal['cgst'];
$totalRoomAmount= $amount-$roomAmountGst-$roomAmountCGst;

$finalRoomAmount = $totalRoomAmount+$roomAmountGst+$roomAmountCGst-$advancePayment-$secadvancePayment-$roomAmountDiscount;
$exclusiveAmount = $amount+$roomAmountGst+$roomAmountCGst-$advancePayment-$secadvancePayment-$roomAmountDiscount;
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
    <input type="hidden" id="duration_of_stay" value="{{ $durOfStay }}">

    {{Form::hidden('email',$data_row->customer->email)}}
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
                                        <th>Booking ID</th>
                                        <td>{{$data_row->customer->Booking_id}}</td>

                                        <th>{{lang_trans('txt_fullname')}}</th>
                                        <td>{{$data_row->customer->name}}</td>
                                       
                                    </tr>
                                    <tr>

                                        <th>{{lang_trans('txt_mobile_num')}}</th>
                                        <td>{{$data_row->customer->mobile}}</td>

                                        <th>{{lang_trans('txt_email')}}</th>
                                        <td id="email">{{$data_row->customer->email}}</td>
                                    </tr>

                                    <tr>

                                        <th>Address</th>
                                        <td>{{$data_row->customer->address}}</td>

                                        <th> Booking Reason </th>
                                        <td> {{$data_row->Booking_Reason}} </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="new_guest_section">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Other Information</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th> Average Duration Spend in Room (In a Day) </th>
                                        <td><input class="form-control col-md-6 col-xs-12" id="Average_duration" value="" name="Average_duration" type="number"></td>

                                        <th>Guest Feedback</th>
                                        <td><input class="form-control col-md-6 col-xs-12" id="Guest_feedback" value="" name="Guest_feedback" type="text"></td>
                                       
                                    </tr>
                                    <tr>

                                        <th> Hotel Rate </th>
                                        <td>
                                            <select class="form-control" name="Hotel_rate" id="Hotel_rate">
                                                <option>--Select--</option>
                                                <option value="5">5</option>
                                                <option value="4">4</option>
                                                <option value="3">3</option>
                                                <option value="2">2</option>
                                                <option value="1">1</option>
                                            </select>
                                        </td>

                                        <th> Booking Device </th>
                                        <td>
                                            <select class="form-control" name="Booking_Device" id="Booking_Device">
                                                <option>--Select--</option>
                                                <option value="Laptop">Laptop</option>
                                                <option value="Mobile">Mobile</option>
                                            </select>

                                        </td>






                                    </tr>



                                    <tr>


                                        <th> Availed Services Details </th>
                                        <td>
                                            <select class="form-control" name="Availed_Services_Details[]" id="Booking_DAvailed_Services_Detailsevice" multiple>
                                                @foreach($availedservices as $val)
                                                <option value="{{$val->name}}">{{$val->name}}</option>



                                                @endforeach
                                            </select>

                                        </td>






                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




































    <table class="table table-bordered">
        <tr>
            <th>{{lang_trans('txt_name')}}</th>
            <th>{{lang_trans('txt_gender')}}</th>

            <th>{{lang_trans('txt_idcard_type')}}</th>
            <th> Id Cards</th>
            <th>Document</th>
        </tr>



        <tr>
            <td>{{$data_row->customer->name}}</td>
            <td>{{$data_row->customer->gender}}</td>

            <td>Aadhar Card</td>
            <td>
                 {{$data_row->idcard_no}}
            </td>
            <td>

                            <div class="col-sm-4 col-xs-12">
<?php
            
            $data_row1 = $data_row->customer->document;
?>
<img src="{{asset('storage/app/'.$data_row1)}}"  height="120px" width="120px"><br><br>

<a href="{{asset('storage/app/'.$data_row1)}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>

<button  class="btn btn-sm btn-success" title="Print" onclick="PrintImage('{{asset('/'.$data_row1)}}')">
            <i class="fa fa-print" ></i>
                                      </button>

                                      </div>

            </td>
        </tr>



        <!-- Other Persons Data -->
        @if($data_row->persons)
        @foreach($data_row->persons as $k=>$val)
        <tr>
            <td>{{$val->name}}</td>
            <input type="hidden" name="persons_info[name][]" id="persons_info[name][]" value="{{$val->name}}">
            <td>{{$val->gender}}</td>

            <td>{{@config('constants.TYPES_OF_ID')[$val->idcard_type]}}</td>
            <td>    {{$val->idcard_no}}   </td>
            <td>
                <input type="hidden" name="persons_info[document_upload_id][]" value="{{$val->id}}">
                <div style="visibility: hidden">
                    {{Form::file('persons_info[document_upload][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload1", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])}}
                    @php $documentsDetails =explode("/",$val->document);
                        $documentName = end($documentsDetails);
                    @endphp
                    <label>
                </div>
                @if($documentName!= "")
                    <img src="{{asset('/storage/files/'.$documentName)}}" height="120px" width="120px">
                    <input type="hidden" name="persons_info[document_upload][]" id="persons_info[document]" value="{{ $documentName }}">
                    <br><br>
                    <a href="{{asset('/storage/files/'.$documentName)}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>

                    <button  class="btn btn-sm btn-success" title="Print" onclick="PrintImage({{asset('storage/files/'.$documentName)}}')">
                                <i class="fa fa-print" ></i>
                                                        </button>
                @else

                

                <img src="{{asset('/'.$val->cnic_back)}}" height="120px" width="120px">
                    <input type="hidden" name="persons_info[document_upload][]" id="persons_info[document]" value="{{ $val->cnic_back }}">
                    <br><br>
                    <a href="{{asset('/'.$val->cnic_back)}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>

                    <button  class="btn btn-sm btn-success" title="Print" onclick="PrintImage({{asset('/'.$val->cnic_back)}}')">
                                <i class="fa fa-print" ></i>
                                                        </button>





           
                
                @endif

            </td>

        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7">{{lang_trans('txt_no_record')}}</td>
        </tr>
        @endif

        <!-- End Other Persons Data -->
    </table>

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
                            {{Form::text('check_in_date',$data_row->created_at_checkin,['class'=>"form-control col-md-6 col-xs-12", "id"=>"check_in_date", "placeholder"=>lang_trans('ph_date'),'readonly'=>true,'disabled'=>true])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_checkout')}} <span class="required">*</span></label>
                            <input class="form-control col-md-6 col-xs-12" id="check_out_date_my" placeholder="Select Date" required="" name="check_out_date" type="text" value='@php echo  date('Y-m-d',  strtotime($data_row->created_at_checkin. ' + '.$data_row->duration_of_stay.' days')); @endphp'>
                            
                        </div>
                        @if($customer_room_data != 'empty')
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Listed Rooms</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control col-md-12 col-xs-12" id='listed_rooms' required="required" name="listed_rooms[]" multiple>
                            <!--<option class="room_options" id="{{ $data_row->id}}" value='{{ $data_row->id}}' data-room='{{$data_row->room_num}} ' data-per-room-price = "{{$data_row->room_num}} " data-booking-payment="{{$data_row->room_num}} " data-advance-payment="{{$data_row->room_num}} " data-sec-advance-payment="{{$data_row->room_num}} ">{{$data_row->room_num}} </option>-->
                                @foreach($customer_room_data as $room_dt)
                                    <option class="room_options" id="{{ $room_dt->id }}" value='{{ $room_dt->id}}' data-room='{{ $room_dt->room_num }}' data-per-room-price = "{{ $room_dt->per_room_price }}" data-booking-payment="{{ $room_dt->booking_payment }}" data-advance-payment="{{ $room_dt->advance_payment }}" data-sec-advance-payment="{{ $room_dt->sec_advance_payment }}">{{ $room_dt->room_num }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        @endif
                         <!-- @if($data_row->duration_of_stay == 0)
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label"> {{lang_trans('txt_duration_of_stay')}} <span class="required">*</span></label>
                                                    {{Form::number('duration_of_stay',1,null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"duration_of_stay", "placeholder"=>lang_trans('ph_day_night'),"min"=>1,'required'=>true])}}
                                                </div>
                                              @else
                                              <th id="td_dur_stay"> {{$data_row->duration_of_stay }}</th>
                                            @endif -->


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--

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
-->

    <!--

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


                              <th> Id Cards</th>

                            </tr>
                            @if($data_row->id_cards)
                              @foreach($data_row->id_cards as $k=>$val)
                                @if($val->file!='')
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


                                        </div>
<div class="col-sm-4 col-xs-12">
 <img src="{{asset('public/uploads/id_cards/'.$val->cnic_back)}}"  height="120px" width="120px"><br><br>




 <a href="{{checkFile($val->cnic_back,'uploads/id_cards/','blank_id.jpg')}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>



                                        </div>
                                      </div>






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
              </div>
          </div>
      </div>
  </div>
-->

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
                                            <input class="flat tax_type" id="inclusive_amount" checked="checked" name="tax_type" type="radio" value="inclusive" style="position: absolute; opacity: 0;"> <label for="inclusive">{{lang_trans('txt_inclusive_tax')}}</label>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                            <input class="flat tax_type" id="inclusive_amount" name="tax_type" type="radio" value="exclusive" style="position: absolute; opacity: 0;"> <label for="exclusive">{{lang_trans('txt_exclusive_tax')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="table_inclusive1">
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
                                             ( {{lang_trans('txt_room_num')}} : <span id="room_num_span" data-room="{{ $data_row->room_num }}">{{$data_row->room_num}} </span>)
                                            @endif
                                        </td>
                                        <th>{{$roomQty }}</th>

                                            @if($data_row->duration_of_stay == 0)
                                                <th id="td_dur_stay">1</th>
                                              @else
                                              <th id="td_dur_stay"> {{$data_row->duration_of_stay }}</th>
                                            @endif
                                        <td>
                                            {{Form::number('amount[per_room_price]',$data_row->per_room_price,['id'=>'per_room_price','class'=>'form-control', 'min'=>$data_row->per_room_price])}}
                                            <input type="hidden" id="default_per_room_price" value="{{ $data_row->per_room_price }}">
                                            <input type="hidden" id="default_booking_payment" value="{{ $amount }}">
                                            <span class="error base_price_err_msg"></span>
                                        </td>
                                        <td class="td_total_room_amount exclusive">{{getCurrencySymbol()}} <span class="totalRoomAmount_span" id="total_booking_amount"> {{ numberFormat($amount) }} </span></td>

                                        <td class="td_total_room_amount" id="second_total_amount" style="display:none">{{getCurrencySymbol()}}    <span class="second_totalRoomAmount_span" > {{ numberFormat($amount) }} </span></td>
                                    </tr>
                                </tbody>
                                <table class="table table-bordered" id="table_inclusive2">
                                    <tr class="exclusive">
                                        <th class="text-right">{{lang_trans('txt_subtotal')}} {{Form::hidden('amount[total_room_amount]',numberFormat($totalRoomAmount),['id'=>'total_room_amount'])}}</th>
                                        <td width="15%" class="text-right td_total_room_amount">{{getCurrencySymbol()}} <span class="totalRoomAmount_span">{{ numberFormat($totalRoomAmount) }} </span></td>
                                    </tr>
                                    <tr id="second_sub_total" style="display: none;">
                                        <th class="text-right">{{lang_trans('txt_subtotal')}} {{Form::hidden('amount[total_room_amount]',numberFormat($totalRoomAmount),['id'=>'total_room_amount'])}}</th>
                                        <td width="15%" class="text-right td_total_room_amount">{{getCurrencySymbol()}} <span class="second_totalRoomAmount_span" >{{ numberFormat($amount) }} </span></td>
                                    </tr>
                                    <tr class="exclusive_new">
                                        <th class="text-right">{{lang_trans('txt_sgst')}} (
                                            <span id="gstPerc_span"> {{$gstPerc}} </span>%) {{Form::hidden('amount[total_room_amount_gst]',null,['id'=>'total_room_amount_gst'])}}</th>
                                        <td width="15%" id="td_total_room_amount_gst" class="text-right">{{getCurrencySymbol()}}<span id="gst_span">{{ numberFormat($roomAmountGst) }}</span></td>
                                    </tr>
                                    <tr class="exclusive_new">
                                        <th class="text-right">{{lang_trans('txt_cgst')}} (<span id="cgstPerc_span"> {{$cgstPerc}} </span>%) {{Form::hidden('amount[total_room_amount_cgst]',null,['id'=>'total_room_amount_cgst'])}}</th>
                                        <td width="15%" id="td_total_room_amount_cgst" class="text-right">{{getCurrencySymbol()}}<span id="cgst_span">{{ numberFormat($roomAmountGst) }}<span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">{{lang_trans('txt_advance_amount')." (".$paymentmode.")"}}</th>
                                        <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} <span id="advance_payment_span">{{ numberFormat($advancePayment) }} </span>
                                        <input type="hidden" id="default_advance_payment" value="{{ numberFormat($advancePayment) }}">
                                    </td>
                                    </tr>
                                    @if($secadvancePayment)
                                    <tr>
                                        <th class="text-right">{{lang_trans('Second Advance')." (".$paymentmodesec.")"}}</th>
                                        <td width="15%" id="td_advance_amount" class="text-right">{{getCurrencySymbol()}} <span id="advance_sec_payment_span">{{ numberFormat($secadvancePayment) }} </span>
                                            <input type="hidden" id="default_sec_advance_payment" value="{{ numberFormat($secadvancePayment) }}">
                                        </td>
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
                                            {{Form::text('discount_amount',$roomAmountDiscount,['class'=>"form-control col-md-7 col-xs-12", "id"=>"discount", "placeholder"=>lang_trans('ph_any_discount'),"min"=>0])}}
                                            <button type="button" class="btn btn-primary" style="margin-top: 10px;" id="discount_count">Calculate</button>
                                            <span class="error discount_room_err_msg"></span>
                                        </td>
                                    </tr>
                                    <tr class="exclusive">
                                        <th class="text-right">{{lang_trans('txt_amount_payable')}} {{Form::hidden('amount[total_room_final_amount]',null,['id'=>'total_room_final_amount'])}}</th>
                                        <td width="15%" id="td_room_final_amount" class="text-right">{{getCurrencySymbol()}} <span id="amount_payable_span" class="amount_payable_span">{{ numberformat($finalRoomAmount) }} </span></td>
                                        <input type="hidden" name="amount_payable" id="amount_payable" value="{{ $finalRoomAmount }}">
                                        <input type="hidden" name="default_amount_payable" id="default_amount_payable" value="{{ $finalRoomAmount }}">
                                    </tr>
                                    <tr id="second" style="display:none">
                                        <th class="text-right">{{lang_trans('txt_amount_payable')}} {{Form::hidden('amount[total_room_final_amount]',null,['id'=>'total_room_final_amount'])}}</th>
                                        <td width="15%" id="td_room_final_amount" class="text-right">{{getCurrencySymbol()}} <span id="amount_payable_span_2" class="amount_payable_span">{{ numberformat($exclusiveAmount) }} </span></td>

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
                                    <td width="15%" id="td_final_amount" class="text-right">{{getCurrencySymbol()}} <span id="grand_total_span">{{ numberFormat($finalRoomAmount) }}</span></td>
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
                                <label class="control-label">Enter Company Name</label>
                                {{Form::text('gst_company',null,['class'=>"form-control col-md-6 col-xs-12",  "placeholder"=>"Enter Company Name"])}}
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label">Enter  Company Address</label>
                                {{Form::text('gst_address',null,['class'=>"form-control col-md-6 col-xs-12",  "placeholder"=>"Enter Company Address"])}}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label"> {{lang_trans('txt_payment_mode')}}</label>
                                {{Form::select('payment_mode',$payment_mode_list,null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select"])}}
                            </div>





                        </div>


                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                    <button class="btn btn-success" style="display:none" id="first" type="button" onclick="payment_link()">{{lang_trans('Verify')}}</button>
                    <button class="btn btn-success btn-submit-form" id="submit" type="submit">{{lang_trans('btn_submit')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="default_row_id" value="{{ $data_row->id }}">
<input type="hidden" name="row_id" id="row_id" value="{{ $data_row->id }}">
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
        $("#second_total_amount").hide();
        $("#second_sub_total").hide();
    } else {
        $('.exclusive').hide();
        $("#second").show();
        $("#second_total_amount").show();
        $("#second_sub_total").show();
    }
});




       $(document).ready(function(){
           $("#submit").click(function(){
               var td_room_final_amount=$("#amount_payable_span").html();
               var check_out=$("#check_out_date_my").val();
               var today="{{date('Y-m-d')}}";
               if(check_out != today)
               {
                  return confirm("Are You confirm checkout")
               }
               if(td_room_final_amount>0)
               {
                  return confirm("Amount is pending. You Really want to checkout.")
               }
           })
       })









    
    // $(document).on('click', '.btn-submit-form', function(e) {
    //     val= '<?php echo $data_row->customer->document;?>';
    //     if (val === '') {
    //         swal({
    //             type: 'error',
    //             title: 'Oops...',
    //             text: 'Document not uploaded',
    //         })
    //         e.preventDefault();
    //     }

    // });
    $(document).on('change', '#payment', function(event) {
        loadSelectedDeviceOptions($(this).val());
    });

    function loadSelectedDeviceOptions(selectedOption) {

        console.log(selectedOption);
        if (selectedOption == 7) {
            $("#first").show();
            $("#first").attr("onclick", "payment_link()");
        } else if (selectedOption == 4) {
            $("#first").show();
            $("#first").attr("onclick", "paytm_Send_Link()");
        } else {
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

    function payment_link() {
        var val = $('input[name="guest_type"]:checked').val();
        if (val == "existing") {
            var customer_id = $('input[name="selected_customer_id"]').val();
            if (customer_id == "") {
                alert('please select a customer');
            } else {

                $.ajax({
                    url: "{{route('sendpaymentlink')}}?guest_type=existing&customer=" + customer_id,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                    }
                });

            }
        } else {
            var name = $('#name').val();
            var email = document.getElementById('email').innerText;
            var phone = $('#phone').val();
            var payment = $('#advance_payment').val();
            console.log(phone);
            console.log()
            if (name != "" && email != "" && phone != "" && payment != "") {
                $.ajax({
                    url: "{{route('sendpaymentlink')}}?guest_type=new&name=" + name + "&email=" + email + "&phone=" + phone + "&payment=" + payment,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        alert('Payment Link Sent Sucessfully');
                    }
                });

            } else {
                alert('Enter Customer Information');
            }




        }

    }

    function paytm_Send_Link() {
        var val = $('input[name="guest_type"]:checked').val();
        if (val == "existing") {
            var customer_id = $('input[name="selected_customer_id"]').val();
            if (customer_id == "") {
                alert('please select a customer');
            } else {

                $.ajax({
                    url: "{{route('paytmSendLink')}}?guest_type=existing&customer=" + customer_id,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                    }
                });

            }
        } else {
            var name = $('#name').val();
            var email = document.getElementById('email').innerText;
            var phone = $('#phone').val();
            var payment = $('#advance_payment').val();
            console.log(phone);
            console.log()
            if (name != "" && email != "" && phone != "" && payment != "") {
                $.ajax({
                    url: "{{route('paytmSendLink')}}?guest_type=new&name=" + name + "&email=" + email + "&phone=" + phone + "&payment=" + payment,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        alert('Payment Link Sent Sucessfully');
                    }
                });

            } else {
                alert('Enter Customer Information');
            }




        }

    }
</script>



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
    var total_amount_payable;
    // $(document).on('change', "#listed_rooms", function(){
    //     var gstPerc = '';var cgstPerc = '';
    //     var all_checked_room = [];
    //     var all_checked_room_id = [];
    //     var tot_booking_payment = [];
    //     var tot_advance_payment = [];
    //     var tot_sec_advance_payment = [];
    //     var all_row_id = [];
    //     var default_room = $("#room_num_span").attr('data-room'); //Default room entry
    //     all_checked_room.push(default_room);
    //     var default_booking_payment = $("#default_booking_payment").val();
    //     tot_booking_payment.push(parseFloat(default_booking_payment));
    //     var default_advance_payment = $("#default_advance_payment").val();
    //     tot_advance_payment.push(parseFloat(default_advance_payment));
    //     var default_sec_advance_payment = $("#default_sec_advance_payment").val();
    //     tot_sec_advance_payment.push(parseFloat(default_sec_advance_payment));

    //     var default_row_id = $("#default_row_id").val();
    //     all_row_id.push(default_row_id);
    //     var durationOfStay = $("#duration_of_stay").val();

    //     $("input:checkbox[type=checkbox]:checked").each(function (index) {
    //         var checked_room_id = $("input:checkbox[type=checkbox]:checked").eq(index).val();
    //         var checked_room = $("#"+checked_room_id).attr('data-room'); // Checked Room
    //         var checked_booking_payment = $("#"+checked_room_id).attr('data-booking-payment'); // Checked Room Booking Payment
    //         var checked_advance_payment = $("#"+checked_room_id).attr('data-advance-payment'); // Checked Room Advance Payment
    //         var checked_sec_advance_payment = $("#"+checked_room_id).attr('data-sec-advance-payment'); // Checked Room Advance Payment
    //         var checked_row_id = $("#"+checked_room_id).attr('id');

    //         all_checked_room_id.push(checked_room_id);
    //         all_checked_room.push(checked_room);
    //         tot_booking_payment.push(parseFloat(checked_booking_payment*durationOfStay));
    //         tot_advance_payment.push(parseFloat(checked_advance_payment));
    //         tot_sec_advance_payment.push(parseFloat(checked_sec_advance_payment));
    //         all_row_id.push(checked_row_id);
    //     });
    //     $("#row_id").val(all_row_id);
    //     /* All checked room num  */
    //     all_checked_room_str = all_checked_room.join(",");
    //     $("#room_num_span").html(all_checked_room_str);

    //     /* All checked per room price and gst calculations  */
    //     var totalBookingPayment = tot_booking_payment.reduce(function (accumVariable, curValue) {
    //         return accumVariable + curValue
    //         }, 0);
    //     if(isNaN(totalBookingPayment))
    //     {
    //         totalBookingPayment = 0;
    //     }
    //     var totalAdvancePayment = tot_advance_payment.reduce(function (accumVariable, curValue) {
    //         return accumVariable + curValue
    //         }, 0);
    //     if(isNaN(totalAdvancePayment))
    //     {
    //         totalAdvancePayment = 0;
    //     }

    //     var totalSecAdvancePayment = tot_sec_advance_payment.reduce(function (accumVariable, curValue) {
    //         return accumVariable + curValue
    //         }, 0);
    //     if(isNaN(totalSecAdvancePayment ))
    //     {
    //         totalSecAdvancePayment = 0;
    //     }
    //     var gst_check = getCheck(totalBookingPayment);
    //     gstPerc =gst_check['gstPerc'];
    //     cgstPerc =gst_check['cgstPerc'];
    //     $("#gstPerc_span").html(gstPerc);$("#cgstPerc_span").html(cgstPerc);

    //     $("#advance_payment_span").html(totalAdvancePayment.toFixed(2));
    //     $("#advance_sec_payment_span").html(totalSecAdvancePayment.toFixed(2));
    //     var gst_array = gstCalc(totalBookingPayment,'room_gst',gstPerc,cgstPerc);
    //     var totalRoomAmount = totalBookingPayment-gst_array['gst']-gst_array['cgst'];
    //     total_amount_payable = parseFloat(totalRoomAmount)+parseFloat(gst_array['gst'])+parseFloat(gst_array['cgst'])-parseFloat(totalAdvancePayment)-parseFloat(totalSecAdvancePayment);

    //     $(".amount_payable_span").html(total_amount_payable.toFixed(2));
    //     $("#amount_payable").val(total_amount_payable.toFixed(2));
    //     $("#grand_total_span").html(total_amount_payable.toFixed(2));
    //     $(".totalRoomAmount_span").html(totalRoomAmount.toFixed(2));
    //     $(".second_totalRoomAmount_span").html(totalBookingPayment.toFixed(2));
    //     $("#total_room_amount").val(totalRoomAmount.toFixed(2));
    //     $("#gst_span").html(gst_array['gst']);
    //     $("#cgst_span").html(gst_array['cgst']);

    // });
    function gstCalc(amount,type,gstPerc,cgstPerc)
    {
        if(type=='room_amount'){

                if(amount>999){
                    var total_inc_perc = (gstPerc+cgstPerc)/100+1;
                    var tot_inc_amount = (amount)/(total_inc_perc);
                    var totl_sub_inc_amount = (amount)-(tot_inc_amount);
                    var gstAmount = (totl_sub_inc_amount)/2;
                    var cgstAmount = (totl_sub_inc_amount)/2;
                }
            else {
                var total_inc_perc = (gstPerc+cgstPerc)/100+1;
                var tot_inc_amount = (amount)/(total_inc_perc);
                var totl_sub_inc_amount = (amount)-(tot_inc_amount);

                var gstAmount = (totl_sub_inc_amount)/2;

                var cgstAmount = (totl_sub_inc_amount)/2;
            }
        }
        else{
            if(amount>999){
                var total_inc_perc = (gstPerc+cgstPerc)/100+1;
                var tot_inc_amount = (amount)/(total_inc_perc);
                var totl_sub_inc_amount = (amount)-(tot_inc_amount);
                var gstAmount = (totl_sub_inc_amount)/2;
                var cgstAmount = (totl_sub_inc_amount)/2;
            }
            else {
                var total_inc_perc = (gstPerc+cgstPerc)/100+1;
                var tot_inc_amount = (amount)/(total_inc_perc);
                var totl_sub_inc_amount = (amount)-(tot_inc_amount);
                var gstAmount = (totl_sub_inc_amount)/2;
                var cgstAmount = (totl_sub_inc_amount)/2;
            }
        }
        return {'gst': gstAmount.toFixed(2), 'cgst' : cgstAmount.toFixed(2)};
    }
    function getCheck(amount)
    {
        var gstPerc;var cgstPerc;
        if((amount>=0) && (amount<=999))
         {
            gstPerc= 0;
            cgstPerc= 0;
         }
         else if((amount>=1000) && (amount<=2499))
         {
            gstPerc= 6;
            cgstPerc= 6;
         }
            else if((amount>2499) && (amount<=7499))
         {
            gstPerc= 9;
            cgstPerc=9;
         }
         else
         {
            gstPerc=14;
            cgstPerc=14;
         }
        return { "gstPerc" : gstPerc, "cgstPerc":cgstPerc}

    }
    $(document).on('click', '#discount_count', function(){
        var discount = $("#discount").val();

        var amount_payable = $("#default_amount_payable").val();

        total_amount_payable = (parseFloat(amount_payable)-parseFloat(discount));
        if(total_amount_payable > 0)
        {
            $(".amount_payable_span").html(total_amount_payable.toFixed(2));
            $("#amount_payable").val(total_amount_payable.toFixed(2));
            $("#grand_total_span").html(total_amount_payable.toFixed(2));
        }
    });




























    
</script>
@endsection
