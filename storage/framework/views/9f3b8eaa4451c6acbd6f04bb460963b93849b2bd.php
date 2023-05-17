<?php 
  $settings = getSettings();
?>
<!DOCTYPE html>
<html lang="en">
     <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title><?php echo e($settings['site_page_title']); ?>: Invoice</title>
        <link href="<?php echo e(URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/css/invoice_style.css')); ?>" rel="stylesheet">
    </head>
    <body>
        <?php 
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
$amount=$bookingAmount;
}else
{
$roomQty = $data_row->room_qty;
$totalRoomAmount = ($durOfStay * $perRoomPrice * $roomQty);
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

$invoiceNum = $data_row->invoice_num;
  if($type==2){
    $invoiceNum = ($data_row->orders_info!=null) ? $data_row->orders_info->invoice_num : '';
  }
  $discount = (isset($jsonDecode->room_amount_discount)) ? $jsonDecode->room_amount_discount : 0;
?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-11">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong>
                            GSTIN: <?php echo e($settings['gst_num']); ?>

                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <strong>
                            Ph. <?php echo e($settings['hotel_phone']); ?>

                        </strong>
                        <br/>
                        <strong>
                            (M) <?php echo e($settings['hotel_mobile']); ?>

                        </strong>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="class-inv-12">
                        <?php echo e($settings['hotel_name']); ?>

                    </span>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="class-inv-13">
                        <?php echo e($settings['hotel_tagline']); ?>

                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-14">
                        <?php echo e($settings['hotel_address']); ?>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-15">
                        <span>
                            <?php echo e($settings['hotel_website']); ?>

                        </span>
                        |
                        <span>
                            E-mail:-
                        </span>
                        <span>
                            <?php echo e($settings['hotel_email']); ?>

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
                                <?php echo e($invoiceNum); ?>

                            </span>
                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <br/>
                        <strong class="fsize-label">
                            Dated :
                        </strong>
                        <spa class-inv-16n="">
                            <?php echo e(dateConvert($data_row->check_out,'d-m-Y H:i')); ?>

                        </spa>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Customer Name:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                <?php echo e($data_row->customer->name); ?>

            </span>
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
                <?php echo e($data_row->customer->address); ?>

            </span>
        </div>
    </div>
</div>
<?php if($type==1): ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="5%">
                        <?php echo e(lang_trans('txt_sno')); ?>.
                    </th>
                    <th class="text-center" width="30%">
                        Particulars
                    </th>
                    <th class="text-center" width="10%">
                        Room Qty
                    </th>
                    <th class="text-center" width="10%">
                        Room Rent (<?php echo e(getCurrencySymbol()); ?>)
                    </th>
                    <th class="text-center" width="10%">
                        Total Days
                    </th>
                    <th class="text-center" width="10%">
                        Amount (<?php echo e(getCurrencySymbol()); ?>)
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        1.
                    </td>
                    <td class="text-center">
                        <?php echo e($data_row->customer->name); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($data_row->room_qty); ?>

                    </td>
                    <td class="text-center">
                        <!-- <?php echo e($data_row->per_room_price); ?> -->
                        <?php echo e(numberFormat($totalRoomAmount)); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($data_row->duration_of_stay); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e(numberFormat($totalRoomAmount)); ?>

                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="5">
                        Total
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($totalRoomAmount)); ?>

                    </td>
                </tr>
                <?php if($roomAmountGst>0): ?>
                <tr>
                    <th class="text-right" colspan="5">
                        GST (<?php echo e($gstPerc); ?> %)
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($roomAmountGst)); ?>

                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="5">
                        CGST (<?php echo e($cgstPerc); ?> %)
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($roomAmountCGst)); ?>

                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="5">
                       Total Amount
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($amount)); ?>

                    </td>
                </tr>
                
                <?php endif; ?>
                    <?php if($advancePayment>0): ?>
                <tr>
                    <th class="text-right" colspan="5">
                        Less Advance
                    </th>
                    <td class="text-right">

                        <?php echo e(numberFormat($advancePayment)); ?>

                    </td>
                </tr>
                <?php endif; ?>
                    <?php if($discount>0): ?>
                <tr>
                    <th class="text-right" colspan="5">
                        Discount
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($discount)); ?>

                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <th class="text-right" colspan="5">
                    <?php echo e(lang_trans('txt_amount_payable')); ?>

                    </th>
                    <td class="text-right">
                    <?php echo e(numberFormat($finalRoomAmount)); ?>

                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="3">
                        Amount in Words:-
                    </th>
                    <td class="class-inv-17" colspan="3">
                        <?php echo e(getIndianCurrency(numberFormat($finalRoomAmount))); ?>

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
<?php endif; ?>

       <?php if($type==2): ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="2%">
                        <?php echo e(lang_trans('txt_sno')); ?>.
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
                        Item Price (<?php echo e(getCurrencySymbol()); ?>)
                    </th>
                    <th class="text-center" width="10%">
                        Amount (<?php echo e(getCurrencySymbol()); ?>)
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $data_row->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <?php
                        $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
                        if($val->item_price == 0.00)
                            {
                                $totalOrdersAmount =  $val->booking_payment;
                            }
                      ?>
                <tr>
                    <td class="text-center">
                        <?php echo e($k+1); ?>

                    </td>
                    <td class="">
                        <?php echo e($val->item_name); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e(dateConvert($val->check_out,'d-m-Y')); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($val->item_qty); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($val->item_price); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($val->item_qty*$val->item_price); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">
                        No Orders
                    </td>
                </tr>
                <?php endif; ?>
                    <?php

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
                    ?>
                <tr>
                    <th class="text-right" colspan="5">
                        Total
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($totalOrdersAmount)); ?>

                    </td>
                </tr>
                <?php if($foodAmountGst>0): ?>
                <tr>
                    <th class="text-right" colspan="5">
                        GST (<?php echo e($gstPerc); ?> %)
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($foodAmountGst)); ?>

                    </td>
                </tr>
                <?php endif; ?>
                    <?php if($foodAmountCGst>0): ?>
                <tr>
                    <th class="text-right" colspan="5">
                        CGST (<?php echo e($cgstPerc); ?> %)
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($foodAmountCGst)); ?>

                    </td>
                </tr>
                <?php endif; ?>
                    <?php if($discount>0): ?>
                <tr>
                    <th class="text-right" colspan="5">
                        Discount
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($discount)); ?>

                    </td>
                </tr>
                <?php endif; ?>

                    <?php 
                      $finalFoodAmount = numberFormat($totalOrdersAmount+$foodAmountGst+$foodAmountCGst-$discount);
                    ?>
                <tr>
                    <th class="text-right" colspan="5">
                        Grand Total
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($finalFoodAmount)); ?>

                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="2">
                        Amount in Words:-
                    </th>
                    <td class="class-inv-17" colspan="4">
                        <?php echo e(getIndianCurrency(numberFormat($finalFoodAmount))); ?>

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
    <?php echo $settings['invoice_term_condition']; ?>

</div>
<?php endif; ?><?php /**PATH /home/passerine/public_html/58.dsrhotelgroup.com/58/resources/views/backend/rooms/invoice.blade.php ENDPATH**/ ?>