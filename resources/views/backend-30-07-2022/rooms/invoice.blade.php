@php 
  $settings = getSettings();
@endphp
<!DOCTYPE html>
<html lang="en">
     <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>{{$settings['site_page_title']}}: Invoice</title>
        <link href="{{URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('public/css/invoice_style.css')}}" rel="stylesheet">
        <style>
          .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
            {
                padding:4px;
                font-size:12px;
            }
        </style>
    </head>
    <body>
        @php 
        $jsonDecode = json_decode($data_row->amount_json);
$roomAmountDiscount = (isset($jsonDecode->room_amount_discount)) ? $jsonDecode->room_amount_discount : 0;
$advancePayment = ($data_row->advance_payment>0 ) ? $data_row->advance_payment : 0;
$secadvancePayment = ($data_row->sec_advance_payment>0 ) ? $data_row->sec_advance_payment : 0;
$thirdadvancePayment = ($data_row->third_advance_payment>0 ) ? $data_row->third_advance_payment : 0;
$fourthadvancePayment = ($data_row->fourth_advance_payment>0 ) ? $data_row->fourth_advance_payment : 0;
$fifthadvancePayment = ($data_row->fifth_advance_payment>0 ) ? $data_row->fifth_advance_payment : 0;
$sixthadvancePayment = ($data_row->sixth_advance_payment>0 ) ? $data_row->sixth_advance_payment : 0;
$totalAdvance = $advancePayment + $secadvancePayment + $thirdadvancePayment + $fourthadvancePayment + $fifthadvancePayment + $sixthadvancePayment;
$total_pay_amount=0;
if($data_row->checkin_type=='single')
{
$multi_room=$data_row->room_num;
$durOfStay = $data_row->duration_of_stay;
$bookingAmount = $data_row->per_room_price;
$roomQty = $data_row->room_qty == 0 ? 1 : $data_row->room_qty;
$totalRoomAmount = $data_row->total_amount;
$amount=$bookingAmount;
}

if($data_row->checkin_type=='multiple')
{
    $multi_room=array();
    foreach($room_numbers as $room_dt)
    {
     array_push($multi_room,$room_dt->room_num);
    }
    $multi_room=implode(',',$multi_room);
    $roomQty = count($room_numbers);
    $room_data=$room_numbers[0];
    $bookingAmount=$room_data->per_room_price;
    $totalRoomAmount = $data_row->total_amount;
    $amount=$bookingAmount;
    
 }
 
 

  if(($amount>=0) && ($amount<=1000))
         {
              $applyGst=1;
              $gstPerc=0;
              $cgstPerc=0;
              $multiplyGst=0;
         }
         else if(($amount>=1001) && ($amount<=7500))
         {
              $applyGst=1.12;
              $gstPerc=6;
              $cgstPerc=6;
              $multiplyGst=0.12;
         }
        else if(($amount>7501))
         {
              $applyGst=1.18;
              $gstPerc=9;
              $cgstPerc=9;
              $multiplyGst=1.18;
              
         }
        
        
$mode = $data_row->payment_mode;
$gstCal = gstCalc($amount,'room_gst',$gstPerc,$cgstPerc);
$totalRoomAmountGst= ($totalRoomAmount/$applyGst);
//print_r($totalRoomAmount);

$fullGST=$totalRoomAmountGst*$multiplyGst;
$roomAmountGst = numberFormat($fullGST/2);
$roomAmountCGst = numberFormat($fullGST/2);

$finalRoomAmount = $totalRoomAmountGst+$roomAmountGst+$roomAmountCGst-$advancePayment-$secadvancePayment-$thirdadvancePayment-$fourthadvancePayment-$fifthadvancePayment-$sixthadvancePayment-$roomAmountDiscount;
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

$invoiceNum = $data_row->invoice_num;
  if($type==2){
    $invoiceNum = ($data_row->orders_info!=null) ? $data_row->orders_info->invoice_num : '';
  }
  $discount = (isset($jsonDecode->room_amount_discount)) ? $jsonDecode->room_amount_discount : 0;
@endphp
        <div class="container">
            <center><img src="https://f9hotels.com/web/dist/images/ezystayz-logo.png"></center>
            <h3 style="margin-top:1px;"><center>F9 GROUP OF HOTELS</center></h3>
            <h4><center>MARSROCK HOSPITALITY VENTURES PRIVATE LIMITED</center></h4>
            <h5><center>CIN: U55100UP2021PTC156143</center></h5>
            <h6><center>Reg. Office: House no. A-197, Sector-47 Noida, Noida, Gautam Buddha Nagar, U.P.-201301, IN</center></h6>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-11">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong>
                            GSTIN: {{$settings['gst_num']}}
                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <strong>
                            Ph. {{$settings['hotel_phone']}}
                        </strong>
                        
                        <strong>
                            (M) {{$settings['hotel_mobile']}}
                        </strong>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="class-inv-12">
                        {{$settings['hotel_name']}}
                    </span>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="class-inv-13">
                        {{$settings['hotel_tagline']}}
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-14">
                        {{$settings['hotel_address']}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-15">
                        <span>
                            {{$settings['hotel_website']}}
                        </span>
                        |
                        <span>
                            E-mail:-
                        </span>
                        <span>
                            {{$settings['hotel_email']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong class="fsize-label">
                            No.:
                            <span class="class-inv-19">
                                {{$invoiceNum}}
                            </span>
                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <br/>
                        <strong class="fsize-label">
                            Dated :
                        </strong>
                        <spa class-inv-16n="">
                            {{dateConvert($data_row->check_out,'d-m-Y H:i')}}
                        </spa>
                    </div>
                </div>
            </div>
     
    
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Customer Name:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
    
                {{$data_row->customer->name}}

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Address:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                {{$data_row->customer->address}}
            </span>
        </div>
    </div>
    
    @if(!empty($data_row->company_gst_num))
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                GST:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                {{$data_row->company_gst_num}}
            </span>
        </div>
    </div>
    @endif
    
    @if(!empty($data_row->gst_company))
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Company Name:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                {{$data_row->gst_company}}
            </span>
        </div>
    </div>
    @endif
    
    @if(!empty($data_row->gst_address))
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Company Address:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                {{$data_row->gst_address}}
            </span>
        </div>
    </div>
    @endif
    
    
</div>
@if($type==1)
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="5%">
                        {{lang_trans('txt_sno')}}.
                    </th>
                    <th class="text-center" width="30%">
                        Particulars
                    </th>
                    <th class="text-center" width="10%">
                        Room Qty
                    </th>
                    
                     <th class="text-center" width="10%">
                        Room Number
                    </th>
                    
                    <th class="text-center" width="10%">
                        Room Type
                    </th>
                    
                    <th class="text-center" width="10%">
                        Room Rent ({{getCurrencySymbol()}})
                    </th>
                    <th class="text-center" width="10%">
                        Total Days
                    </th>
                    <th class="text-center" width="10%">
                        Amount ({{getCurrencySymbol()}})
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        1.
                    </td>
                    <td class="text-center">
                        {{$data_row->customer->name}}
                    </td>
                    <td class="text-center">
                        {{$roomQty}}
                    </td>
                    
                     <td class="text-center">
                        {{$multi_room}}
                    </td>
                    
                    <td class="text-center">
                        {{$data_row->room_type->title}}
                    </td>
                    
                    <td class="text-center">
                       
                        {{ numberFormat($bookingAmount) }}
                    </td>
                    <td class="text-center">
                        {{$data_row->duration_of_stay}}
                    </td>
                    <td class="text-center">
                        {{ numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty) }}
                    </td>
                </tr>
                @php $extraamount=0;  @endphp
                @foreach($payment as $extra)
                @if($extra->remark=='Early Check In')
                <tr>
                    <th class="text-right" colspan="7">
                       {{$extra->remark}}
                    </th>
                    <td class="text-right">
                      {{$extra->payment}}
                    </td>
                </tr>
                @php $extraamount+=$extra->payment @endphp
                @endif
                @endforeach
                 <tr>
                    <th class="text-right" colspan="7">
                        Total
                    </th>
                    <td class="text-right">
                        
                        <?php 
                            echo round($totalRoomAmountGst);
                        ?>
                    
                    </td>
                </tr>
                
               
                <tr>
                    <th class="text-right" colspan="7">
                        SGST ({{$gstPerc}} %)
                    </th>
                    <td class="text-right">
                        <?php 
                        echo numberFormat($roomAmountGst);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="7">
                        CGST ({{$cgstPerc}} %)
                    </th>
                    <td class="text-right">
                        <?php 
                        echo numberFormat($roomAmountGst);
                        ?>
                    </td>
                </tr>
                <?php 
                 $total_pay_amount=0;
                 foreach($payment as $key=>$p)
                 {
                     $number=$key+1;
                     if($number==1)
                     {
                         $number='First';
                     }else if($number==2)
                     {
                         $number='Second';
                     }else if($number==3)
                     {
                         $number='Third';
                     } else if($number==4)
                     {
                         $number='Fourth';
                     }else if($number==5)
                     {
                         $number='Fifth';
                     }else 
                     {
                         $numnber=$number;
                     }
                     echo "<tr>
                      <th class='text-right' colspan='7'>".$number." Payment (Payment Date : ".$p->payment_date.") ".$p->remark."</th>
                      <td class='text-right'>".$p->payment."</td>
                     </tr>";
                     
                     $total_pay_amount+=$p->payment;
                 }
                  
                 
                  
                ?>
                
                
                <tr>
                    <th class="text-right" colspan="7">
                       Total Amount
                    </th>
                    <td class="text-right">
                        @if($totalRoomAmount<$total_pay_amount)
                            {{ numberFormat($total_pay_amount) }}
                        @else    
                            {{ numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty) }}
                        @endif    
                        
                    </td>
                </tr>
                
                
                  
                <tr>
                    <th class="text-right" colspan="7">
                        Less Advance
                    </th>
                    <td class="text-right">

                        {{ numberFormat($total_pay_amount) }}
                    </td>
                </tr>
             
                    
                
                
                
                <tr>
                    <th class="text-right" colspan="7">
                    {{lang_trans('txt_amount_payable')}}
                    </th>
                    <td class="text-right">
                        @if($totalRoomAmount<$total_pay_amount)
                            {{ numberFormat($total_pay_amount-$total_pay_amount) }}
                        @else    
                            {{ numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty - $total_pay_amount) }}
                        @endif    
                            
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="5">
                        Amount in Words:-
                    </th>
                    <td class="class-inv-17" colspan="5">
                        @if($totalRoomAmount<$total_pay_amount)
                            {{ getIndianCurrency(numberFormat($total_pay_amount-$total_pay_amount)) }}
                        @else    
                            {{ getIndianCurrency(numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty - $total_pay_amount)) }}
                        @endif    
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="class-inv-20" style="padding-top:5px;">
                            Customer Signature
                        </div>
                    </td>
                    <td class="text-right" colspan="5">
                        <div class="class-inv-20" style="padding-top:5px !important;">
                              <img src="{{asset('public/sign.jpeg')}}" style="width:150px;height:60px">
                              <br>
                            Manager Signature
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif

@if($type==2)
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="2%">
                        {{lang_trans('txt_sno')}}.
                    </th>
                    <th class="text-center" width="20%">
                        Item Details
                    </th>
                    <th class="text-center" width="5%">
                        Date
                    </th>
                    <th class="text-center" width="5%">
                        Item Qty
                    </th>
                    <th class="text-center" width="5%">
                        Item Price ({{getCurrencySymbol()}})
                    </th>
                    <th class="text-center" width="10%">
                        Amount ({{getCurrencySymbol()}})
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($data_row->orders_items as $k=>$val)
                      @php
                        $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
                        if($val->item_price == 0.00)
                            {
                                $totalOrdersAmount =  $val->booking_payment;
                            }
                      @endphp
                <tr>
                    <td class="text-center">
                        {{$k+1}}
                    </td>
                    <td class="">
                        {{$val->item_name}}
                    </td>
                    <td class="text-center">
                        {{dateConvert($val->check_out,'d-m-Y')}}
                    </td>
                    <td class="text-center">
                        {{$val->item_qty}}
                    </td>
                    <td class="text-center">
                        {{$val->item_price}}
                    </td>
                    <td class="text-center">
                        {{$val->item_qty*$val->item_price}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        No Orders
                    </td>
                </tr>
                @endforelse
                    @php

                      $gstPerc = $cgstPerc = 0;
                      $discount = 0;
                      if($data_row->orders_info){
                        $gstPerc = $data_row->orders_info->gst_perc;
                        $cgstPerc = $data_row->orders_info->cgst_perc;
                        $discount = ($data_row->orders_info->discount>0) ? $data_row->orders_info->discount : 0;
                      }
                      $gst = gstCalc($totalOrdersAmount,'food_amount',$gstPerc,$cgstPerc);
                      $foodAmountGst = $gst['gst'];
                      $foodAmountCGst = $gst['cgst'];
                    @endphp
                <tr>
                    <th class="text-right" colspan="5">
                        Total
                    </th>
                    <td class="text-right">
                        {{ numberFormat($totalOrdersAmount) }}
                    </td>
                </tr>
                @if($foodAmountGst>0)
                <tr>
                    <th class="text-right" colspan="5">
                        GST ({{$gstPerc}} %)
                    </th>
                    <td class="text-right">
                        {{ numberFormat($foodAmountGst) }}
                    </td>
                </tr>
                @endif
                    @if($foodAmountCGst>0)
                <tr>
                    <th class="text-right" colspan="5">
                        CGST ({{$cgstPerc}} %)
                    </th>
                    <td class="text-right">
                        {{ numberFormat($foodAmountCGst) }}
                    </td>
                </tr>
                @endif
                    @if($discount>0)
                <tr>
                    <th class="text-right" colspan="5">
                        Discount
                    </th>
                    <td class="text-right">
                        {{ numberFormat($discount) }}
                    </td>
                </tr>
                @endif

                    @php 
                      $finalFoodAmount = numberFormat($totalOrdersAmount+$foodAmountGst+$foodAmountCGst-$discount);
                    @endphp
                <tr>
                    <th class="text-right" colspan="5">
                        Grand Total
                    </th>
                    <td class="text-right">
                        {{ numberFormat($finalFoodAmount) }}
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="2">
                        Amount in Words:-
                    </th>
                    <td class="class-inv-17" colspan="4">
                        {{ getIndianCurrency(numberFormat($finalFoodAmount)) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="class-inv-20">
                            Customer Signature
                        </div>
                    </td>
                    <td class="text-right" colspan="3">
                        <div class="class-inv-20">
                          
                            Manager Signature
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div>
    {!!$settings['invoice_term_condition']!!}
</div>
@endif