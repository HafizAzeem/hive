<?php $__env->startSection('content'); ?>

<?php

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
 $roomQty = 3;

if($roomQty == 0)
{
  $roomQty = 1;
}

 $totalRoomAmount = ($durOfStay * $bookingAmount * $roomQty);
$amount=$totalRoomAmount;
}else
{
 $roomQty = $data_row->room_qty;
 $bookingAmount = $data_row->per_room_price;
$totalRoomAmount = ($durOfStay * $bookingAmount * $roomQty);
 $amount=$totalRoomAmount;
}



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

$multi_room = $data_row->room_num;
$arramount = [];
$totadvancepayment= [];
$totsecadvancepayment = [];

array_push($arramount, $amount);
array_push($totadvancepayment, $advancePayment);
array_push($totsecadvancepayment, $secadvancePayment);

if($customer_room_data != "empty")
{
  
    foreach($customer_room_data as $room_dt)
    {
        $multi_room .=  ','.$room_dt->room_num;
        array_push($arramount, $room_dt->booking_payment);
        array_push($totadvancepayment, $room_dt->advance_payment);
        array_push($totsecadvancepayment, $room_dt->sec_advance_payment);
    }
    $roomQty = count(explode(',',$multi_room));
    $totamount = array_sum($arramount);
   
    $amount = $totamount;

    $totamount = ($durOfStay * $bookingAmount * $roomQty); 
    $amount = ($durOfStay * $bookingAmount * $roomQty);


    if(($totamount>=0) && ($totamount<=999))
    {
        $gstPerc=$settings['gst_0'];
        $cgstPerc=$settings['cgst_0'];
    }
    else if(($totamount>=1000) && ($totamount<=2499))
    {
        $gstPerc=$settings['gst'];
        $cgstPerc=$settings['cgst'];
    }
    else if(($totamount>2499) && ($totamount<=7499))
    {
        $gstPerc=$settings['gst_1'];
        $cgstPerc=$settings['cgst_1'];
    }
    else
    {
        $gstPerc=$settings['gst_2'];
        $cgstPerc=$settings['cgst_2'];
    }

    $gstCal = gstCalc($totamount,'room_gst',$gstPerc,$cgstPerc);


    $roomAmountGst = $gstCal['gst'];
    $roomAmountCGst = $gstCal['cgst'];
    $totalRoomAmount= $totamount-$roomAmountGst-$roomAmountCGst;

   $advancePayment = (array_sum($totadvancepayment)>0 ) ? $bookingAmount : 0;
    $secadvancePayment = (array_sum($totsecadvancepayment)>0 ) ? array_sum($totsecadvancepayment) : 0;
    $finalRoomAmount = $totalRoomAmount+$roomAmountGst+$roomAmountCGst-$advancePayment-$secadvancePayment-$thirdadvancePayment-$fourthadvancePayment-$fifthadvancePayment-$sixthadvancePayment-$roomAmountDiscount;
    

  }

?>
<div class="">
      <div class="row" id="new_guest_section">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_guest_info')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-bordered">
                            <tr>

                              <th>Booking ID</th>
                              <td><?php echo e($data_row->customer->Booking_id); ?></td>

                              <th><?php echo e(lang_trans('txt_fullname')); ?></th>
                              <td><?php echo e($data_row->customer->name); ?></td>
                             
                            </tr>
                            <tr>

                              <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                              <td><?php echo e($data_row->customer->mobile); ?></td>

                              <th><?php echo e(lang_trans('txt_email')); ?></th>
                              <td><?php echo e($data_row->customer->email); ?></td>

                            </tr>
                            <tr>
                              <th><?php echo e(lang_trans('txt_age')); ?></th>
                              <td><?php echo e(date('d-m-Y', strtotime($data_row->customer->dob))); ?></td>

                              <th><?php echo e(lang_trans('txt_gender')); ?></th>
                              <td><?php echo e($data_row->customer->gender); ?></td>

                            </tr>
                            <tr>
                              <th>Age</th>
                              <td><?php echo e($data_row->customer->age); ?> <?php echo e(lang_trans('txt_years')); ?></td>
                              <th>Address</th>
                              <td><?php echo e($data_row->customer->address); ?></td>
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
                  <h2><?php echo e(lang_trans('heading_checkInOut_info')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                       <div class="col-md-12 col-sm-12 col-xs-12">
                          <table class="table table-bordered">
                            <tr>
                              <th><?php echo e(lang_trans('Check In')); ?></th>
                              <td><?php echo e(dateConvert($data_row->created_at_checkin,'d-m-Y')); ?></td>

                              <th><?php echo e(lang_trans('btn_checkout')); ?></th>
                              <td><?php echo e(date('d-m-Y',  strtotime($data_row->created_at_checkin. ' + '.$data_row->duration_of_stay.' days'))); ?></td>
                            </tr>
                            <!-- <tr>
                              <th><?php echo e(lang_trans('txt_checkin_from_date')); ?></th>
                              <td><?php echo e(($data_row->created_at_checkin!=null) ? dateConvert($data_row->created_at_checkin,'d-m-Y H:i') : 'NA'); ?></td>
                              <th><?php echo e(lang_trans('txt_checkout_from_date')); ?></th>
                              <td><?php echo e(($data_row->user_checkout!=null) ? dateConvert($data_row->user_checkout,'d-m-Y H:i') : 'NA'); ?></td>
                            </tr> -->
                            <tr>
                              <th><?php echo e(lang_trans('txt_room_num')); ?></th>
                              <td><?php echo e($multi_room); ?></td>
                              <th><?php echo e(lang_trans('txt_persons')); ?></th>
                              <td><b><?php echo e(lang_trans('txt_adults')); ?>:</b> <?php echo e($data_row->adult); ?> <b><?php echo e(lang_trans('txt_kids')); ?>:</b> <?php echo e($data_row->kids); ?>   <b>infant(Below 5):</b> <?php echo e($data_row->infant); ?>       </td>
                            </tr>
                            <tr>
                              <th><?php echo e(lang_trans('txt_idcard_type')); ?></th>
                              <td><?php echo e(@config('constants.TYPES_OF_ID')[$data_row->idcard_type]); ?></td>
                              <th><?php echo e(lang_trans('txt_idcard_num')); ?></th>
                              <td><?php echo e($data_row->idcard_no); ?></td>
                            </tr>
                            <tr>
                              <!-- <th><?php echo e(lang_trans('txt_inv_applicable')); ?></th>
                              <td><?php echo e(($data_row->invoice_num!='') ? 'Yes' : 'No'); ?></td> -->

                              <?php if( $data_row->meal_items): ?>
                              <th>Included Meals</th>
                              <td><?php echo e($data_row->meal_items->included_meal); ?></td>
                              <?php endif; ?>


                              <th><?php echo e(lang_trans('txt_company_gst_num')); ?></th>
                              <td><?php echo e($data_row->company_gst_num); ?></td>
                            </tr>

                             <tr>
                              <th><?php echo e(lang_trans('txt_referred_by_name')); ?></th>
                              <td><?php echo e($data_row->referred_by_name); ?></td>
                              <th>Referred Name</th>
                              <td><?php echo e($data_row->referred_by); ?></td>

                            </tr>
                            <tr>
                              <th><?php echo e(lang_trans('txt_payment_mode')); ?></th>
                              <td > <?php if(count($payment_mode) ==0): ?>
                                    NA
                              <?php else: ?>
                               <?php echo e($payment_mode[0]->payment_mode); ?>

                              <?php endif; ?></td>

                              <th>Booking Reason</th>
                              <td> <?php echo e($data_row->Booking_Reason); ?> </td>

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
                  <h2><?php echo e(lang_trans('txt_idcard_uploaded')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                       <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x: auto;">
                          <table class="table table-bordered">
                            <tr>
                              <th><?php echo e(lang_trans('txt_name')); ?></th>
                              <th><?php echo e(lang_trans('txt_gender')); ?></th>
                              <th>Age</th>

                             <!--  <th><?php echo e(lang_trans('txt_idcard_type')); ?></th>
                              <th><?php echo e(lang_trans('txt_idcard_num')); ?></th> -->
                              <th> Id Cards</th>

                              <!-- <th><?php echo e(lang_trans('txt_action')); ?></th> -->
                            </tr>

                                  <tr>


                                    <td><?php echo e($data_row->customer->name); ?></td>
                                     <td><?php echo e($data_row->customer->gender); ?></td>
                                      <td><?php echo e($data_row->customer->age); ?> Years</td>




                              <td>

                            <div class="col-sm-4 col-xs-12">



<img src="<?php echo e(asset('/storage/app/'.$data_row->customer->document)); ?>"  height="120px" width="120px"><br><br>

<a href="<?php echo e(asset('/storage/app/'.$data_row->customer->document)); ?>" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>

<button  class="btn btn-sm btn-success" title="Print" onclick="PrintImage('<?php echo e(asset('/storage/app/'.$data_row->customer->document)); ?>')">
            <i class="fa fa-print" ></i>
                                      </button>

                                      </div>
                            </td>
                            </tr>
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
                  <h2><?php echo e(lang_trans('heading_person_info')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                       <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x:auto;">
                          <table class="table table-bordered" >
                            <tr>
                              <th><?php echo e(lang_trans('txt_sno')); ?>.</th>
                              <th><?php echo e(lang_trans('txt_name')); ?></th>
                              <th><?php echo e(lang_trans('txt_gender')); ?></th>
                              <th>Age</th>
                              <!-- <th><?php echo e(lang_trans('txt_address')); ?></th> -->
                              <th><?php echo e(lang_trans('txt_idcard_type')); ?></th>
                              <th><?php echo e(lang_trans('txt_idcard_num')); ?></th>
                              <th> Id Cards</th>

                            </tr>
                            <?php if($data_row->persons): ?>
                              <?php $__currentLoopData = $data_row->persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                  <td><?php echo e($k+1); ?></td>
                                  <td><?php echo e($val->name); ?></td>
                                  <td><?php echo e($val->gender); ?></td>
                                  <td><?php echo e($val->age); ?></td>
                                  <!-- <td><?php echo e($val->address); ?></td> -->
                                  <td><?php echo e(@config('constants.TYPES_OF_ID')[$val->idcard_type]); ?></td>
                                  <td><?php echo e($val->idcard_no); ?></td>
                                  <td>
                                    
                                    <?php if($val->document == ""): ?>
                                              <img src="<?php echo e(asset('/'.$val->cnic_front)); ?>" alt="id card" height="120px" width="120px">

                                              <img src="<?php echo e(asset('/'.$val->cnic_back)); ?>" alt="id card" height="120px" width="120px">
                                    <?php else: ?>
                                   

                                    <img src="<?php echo e(asset('/'.$val->document)); ?>" alt="document" height="120px" width="120px">

                                    <img src="<?php echo e(asset('/'.$val->document)); ?>" alt="document" height="120px" width="120px">

                                    
                                    <?php endif; ?>

                                  </td>
                                </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                              <tr>
                                  <td colspan="7"><?php echo e(lang_trans('txt_no_record')); ?></td>
                              </tr>
                            <?php endif; ?>
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
                  <h2><?php echo e(lang_trans('heading_payment_info')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12" >
                        <table class="table table-bordered">
                          <tr>
                            <th><?php echo e(lang_trans('txt_payment_mode')); ?></th>
                           <td>
                              <?php if(count($payment_mode) ==0): ?>
                                    NA
                              <?php else: ?>
                              <?php echo e($payment_mode[0]->payment_mode); ?>

                              <?php endif; ?>
                            </td> 
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th width="2%"><?php echo e(lang_trans('txt_sno')); ?>.</th>
                              <th width="20%"><?php echo e(lang_trans('txt_room')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_room_qty')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_duration_of_stay')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_base_price')); ?></th>
                              <th width="10%"><?php echo e(lang_trans('txt_total_amount')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>
                                <?php if($data_row->room_type): ?>
                                  <?php echo e($data_row->room_type->title); ?><br/>
                                  ( <?php echo e(lang_trans('txt_room_num')); ?> : <?php echo e($multi_room); ?> )
                                <?php endif; ?>
                              </td>
                              <th><?php echo e($roomQty); ?></th>
                              <th id="td_dur_stay"><?php echo e($data_row->duration_of_stay); ?></th>
                              <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($bookingAmount); ?></td>
                              <td class="td_total_amount"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($amount)); ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-bordered">
                              <tr>
                                <th class="text-right"><?php echo e(lang_trans('txt_subtotal')); ?></th>
                                <td width="15%" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalRoomAmount)); ?></td>
                              </tr>
                              <tr>
                                <th class="text-right"><?php echo e(lang_trans('txt_sgst')); ?> (<?php echo e($gstPerc); ?>%)</th>
                                <td width="15%" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($roomAmountGst)); ?></td>
                              </tr>
                              <tr>
                                <th class="text-right"><?php echo e(lang_trans('txt_cgst')); ?>

                                 (<?php echo e($cgstPerc); ?>%)
                              </th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($roomAmountCGst)); ?></td>
                              </tr>
                               <tr>
                                <th class="text-right"><?php echo e(lang_trans('txt_advance_amount')." (".$paymentmode.")"); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($advancePayment)); ?></td>
                              </tr>
                              <?php if($secadvancePayment): ?>
                               <tr>
                                <th class="text-right"><?php echo e(lang_trans('Second Advance')." (".$paymentmodesec.")"); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($secadvancePayment)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($thirdadvancePayment): ?>
                               <tr>
                                <th class="text-right"><?php echo e(lang_trans('Third Advance')." (".$paymentmodethird.")"); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($thirdadvancePayment)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($fourthadvancePayment): ?>
                               <tr>
                                <th class="text-right"><?php echo e(lang_trans('Fourth Advance')." (".$paymentmodefourth.")"); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($fourthdadvancePayment)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($fifthadvancePayment): ?>
                               <tr>
                                <th class="text-right"><?php echo e(lang_trans('Fifth Advance')." (".$paymentmodefifth.")"); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($fifthdadvancePayment)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($sixthadvancePayment): ?>
                               <tr>
                                <th class="text-right"><?php echo e(lang_trans('Sixth Advance')." (".$paymentmodesixth.")"); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($sixthdadvancePayment)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <tr>
                                <th class="text-right"><?php echo e(lang_trans('txt_discount')); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($roomAmountDiscount)); ?></td>
                              </tr>
                              <tr class="bg-success">
                                <th class="text-right"><?php echo e(lang_trans('txt_amount_payable')); ?></th>
                                <td width="15%" id="td_final_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($finalRoomAmount)); ?></td>
                              </tr>
                        </table>
                        <div class="x_title">
                            <h2><?php echo e(lang_trans('txt_food_orders')); ?></h2>
                            <div class="clearfix"></div>
                        </div>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th width="2%"><?php echo e(lang_trans('txt_sno')); ?>.</th>
                              <th width="20%"><?php echo e(lang_trans('txt_item_details')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_date')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_item_qty')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_item_price')); ?></th>
                              <th width="10%"><?php echo e(lang_trans('txt_total_amount')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $data_row->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                              <?php
                                $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
                              ?>
                              <tr>
                                <td><?php echo e($k+1); ?></td>
                                <td><?php echo e($val->item_name); ?></td>
                                <td><?php echo e(dateConvert($val->created_at,'d-m-Y')); ?></td>
                                <td><?php echo e($val->item_qty); ?></td>
                                <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->item_price); ?></td>
                                <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->item_qty*$val->item_price); ?></td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <tr>
                                <td colspan="6"><?php echo e(lang_trans('txt_no_orders')); ?></td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                        <?php
                        $finalRoomAmount
                        ?>
                        <?php
                            $gst = gstCalc($totalOrdersAmount,'food_amount',$gstPercFood,$cgstPercFood);
                            $foodAmountGst = $gst['gst'];
                            $foodAmountCGst = $gst['cgst'];
                            ?>
                        <table class="table table-bordered">
                                    <tr>
                                      <th class="text-right"><?php echo e(lang_trans('txt_subtotal')); ?></th>
                                      <td width="15%" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalOrdersAmount)); ?></td>
                                    </tr>
                                    <tr>
                                      <th class="text-right"><?php echo e(lang_trans('txt_sgst')); ?> (<?php echo e($foodAmountGst); ?>%)</th>
                                      <td width="15%" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($foodAmountCGst)); ?></td>
                                    </tr>
                                    <tr>
                                      <th class="text-right"><?php echo e(lang_trans('txt_cgst')); ?> (<?php echo e($foodAmountCGst); ?>%)</th>
                                      <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($foodAmountCGst)); ?></td>
                                    </tr>
                                    <tr>
                                      <th class="text-right"><?php echo e(lang_trans('txt_discount')); ?></th>
                                      <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($foodOrderAmountDiscount)); ?></td>
                                    </tr>
                                    <tr class="bg-success">
                                      <th class="text-right"><?php echo e(lang_trans('txt_final_amount')); ?></th>
                                      <td width="15%" id="td_final_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalOrdersAmount)); ?></td>
                                    </tr>
                        </table>

                        <table class="table table-bordered">
                              <tr class="bg-warning">
                                <th class="text-right"><?php echo e(lang_trans('txt_grand_total')); ?></th>
                                <td width="15%" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($finalRoomAmount)); ?></td>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/new/Sourcecode/9aug/newpms/resources/views/backend/rooms/room_reservation_view.blade.php ENDPATH**/ ?>