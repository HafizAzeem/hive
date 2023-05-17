<?php 
  $settings = getSettings();
  $gst_0 = $settings['gst_0'];
  $cgst_0 = $settings['cgst_0'];

  $gst = $settings['gst'];
  $cgst = $settings['cgst'];

  $gst_1 = $settings['gst_1'];
  $cgst_1 = $settings['cgst_1'];
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
        <style>
          .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
            {
                padding:4px;
                font-size:12px;
            }
            .dsfht{
                position: absolute;
                right: 10%;
                top: 5%;
            }
        </style>
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
 
 if($totalamountwithextrastay > 0){
    $amount+=$totalamountwithextrastay;
 }else{
    $totalamountwithextrastay = 0;
 }
 

    if(($amount>=0) && ($amount<=1000))
    {
        $gstPerc= $gst_0;
        $cgstPerc= $cgst_0;
        $applyGst= ($gstPerc + $cgstPerc)/100;
        $multiplyGst= $gstPerc/100;
        $multiplyCGst=  $cgstPerc/100;
    }
    else if(($amount>=1001) && ($amount<=7500))
    {
        $gstPerc= $gst;
        $cgstPerc= $cgst;
        $applyGst= ($gstPerc + $cgstPerc)/100;
        $multiplyGst= $gstPerc/100;
        $multiplyCGst=  $cgstPerc/100;
    }
    else if(($amount>=7501))
    {
        $gstPerc= $gst_1;
        $cgstPerc= $cgst_1;
        $applyGst= ($gstPerc + $cgstPerc)/100;
        $multiplyGst= $gstPerc/100;
        $multiplyCGst=  $cgstPerc/100;
    }
        
$mode = $data_row->payment_mode;
$gstCal = gstCalc($amount,'room_gst',$gstPerc,$cgstPerc);


//$totalRoomAmountGst= ($amount/$applyGst);
//$totalRoomAmountGst= ($totalRoomAmount/$applyGst);
//print_r($totalRoomAmountGst);

$totalRoomAmountGst= round($totalRoomAmount- ($totalRoomAmount * $applyGst));
$fullGST= $totalRoomAmount*$multiplyGst;
$fullCGST= $totalRoomAmount*$multiplyCGst;
$roomAmountGst = numberFormat($fullGST);
$roomAmountCGst = numberFormat($fullCGST);

//$fullGST=$totalRoomAmountGst*$multiplyGst;
//$roomAmountGst = numberFormat($fullGST/2);
//$roomAmountCGst = numberFormat($fullGST/2);

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
?>
<button onClick="printpage()" id="printpagebutton" class="dsfht">Print this page</button>
<!--<input id="printpagebutton" type="button" value="Print this page"  önclick="printpage()"/>-->
<script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
         var printButton = document.getElementById("printpagebutton");
         printButton.style.visibility = 'hidden';
        //Print the page content
        window.print();
        //Set the print button to 'visible' again 
        //[Delete this line if you want it to stay hidden after printing]
        printButton.style.visibility = 'visible';
    }
</script>
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
                            GSTIN: <?php echo e($settings['gst_num']); ?>

                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <strong>
                            Ph. <?php echo e($settings['hotel_phone']); ?>

                        </strong>
                        
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
                            Check In Date :
                        </strong>
                        <spa class-inv-16n="">
                            <?php echo e(dateConvert($data_row->check_in,'d-m-Y h:i:A')); ?>

                        </spa>
                        <br/>
                        <strong class="fsize-label">
                            Check Out Date :
                        </strong>
                        <spa class-inv-16n="">
                            <?php echo e(dateConvert($data_row->check_out,'d-m-Y h:i:A')); ?>

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
    
                <?php echo e($data_row->customer->name); ?>


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
    
    <?php if(!empty($data_row->company_gst_num)): ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                GST:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                <?php echo e($data_row->company_gst_num); ?>

            </span>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($data_row->gst_company)): ?>
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Company Name:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                <?php echo e($data_row->gst_company); ?>

            </span>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($data_row->gst_address)): ?>
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Company Address:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
                <?php echo e($data_row->gst_address); ?>

            </span>
        </div>
    </div>
    <?php endif; ?>
    
    
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
                        Room Number
                    </th>
                    
                    <th class="text-center" width="10%">
                        Room Type
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
                        <?php echo e($roomQty); ?>

                    </td>
                    
                     <td class="text-center">
                        <?php echo e($multi_room); ?>

                    </td>
                    
                    <td class="text-center">
                        <?php echo e($data_row->room_type->title); ?>

                    </td>
                    
                    <td class="text-center">
                       
                        <?php echo e(numberFormat($bookingAmount)); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($data_row->duration_of_stay); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e(numberFormat(($data_row->duration_of_stay*$data_row->per_room_price*$roomQty)+ $totalamountwithextrastay )); ?>

                    </td>
                </tr>
               
                 <tr>
                    <th class="text-right" colspan="7">
                        Total
                    </th>
                    <td class="text-right">
                        
                        <?php 
                            echo numberFormat($totalRoomAmountGst);
                        ?>
                    
                    </td>
                </tr>
                
               
                <tr>
                    <th class="text-right" colspan="7">
                        SGST (<?php echo e($gstPerc); ?> %)
                    </th>
                    <td class="text-right">
                        <?php 
                        echo numberFormat($roomAmountGst);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="7">
                        CGST (<?php echo e($cgstPerc); ?> %)
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
                      <td class='text-right'>".numberFormat($p->payment)."</td>
                     </tr>";
                     
                     $total_pay_amount+=$p->payment;
                 }
                  
                 
                  
                ?>
                
                
                <tr>
                    <th class="text-right" colspan="7">
                       Total Amount
                    </th>
                    <td class="text-right">
                        <?php if($totalRoomAmount<$total_pay_amount): ?>
                            <?php echo e(numberFormat($total_pay_amount)); ?>

                        <?php else: ?>    
                            <?php echo e(numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty)); ?>

                        <?php endif; ?>    
                        
                    </td>
                </tr>
                
                  
                <tr>
                    <th class="text-right" colspan="7">
                        Less Paid
                    </th>
                    <td class="text-right">

                        <?php echo e(numberFormat($total_pay_amount)); ?>

                    </td>
                </tr>
             
                    
                
                
                
                <tr>
                    <th class="text-right" colspan="7">
                    <?php echo e(lang_trans('txt_amount_payable')); ?>

                    </th>
                    <td class="text-right">
                        <?php if($totalRoomAmount<$total_pay_amount): ?>
                            <?php echo e(numberFormat($total_pay_amount-$total_pay_amount)); ?>

                        <?php else: ?>    
                            <?php echo e(numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty - $total_pay_amount)); ?>

                        <?php endif; ?>    
                            
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="5">
                        Amount in Words:-
                    </th>
                    <td class="class-inv-17" colspan="5">
                        <?php if($totalRoomAmount<$total_pay_amount): ?>
                            <?php echo e(ucwords(getIndianCurrency(numberFormat($total_pay_amount)))); ?>

                        <?php else: ?>    
                            <?php echo e(ucwords(getIndianCurrency(numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty)))); ?>

                        <?php endif; ?>    
                        
                        <!--<?php if($totalRoomAmount<$total_pay_amount): ?>-->
                        <!--    <?php echo e(getIndianCurrency(numberFormat($total_pay_amount-$total_pay_amount))); ?>-->
                        <!--<?php else: ?>    -->
                        <!--    <?php echo e(getIndianCurrency(numberFormat($data_row->duration_of_stay*$data_row->per_room_price*$roomQty - $total_pay_amount))); ?>-->
                        <!--<?php endif; ?>    -->
                        
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
                              <img src="<?php echo e(asset('public/sign.jpeg')); ?>" style="width:150px;height:60px">
                              <br>
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
                      $totalfoodamound = $totalOrdersAmount-$foodAmountGst-$foodAmountCGst;
                    ?>
                <tr>
                    <th class="text-right" colspan="5">
                        Total
                    </th>
                    <td class="text-right">
                        <?php echo e(numberFormat($totalfoodamound)); ?>

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
                      $finalFoodAmount = numberFormat($totalfoodamound+$foodAmountGst+$foodAmountCGst-$discount);
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
<?php endif; ?>

<?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/rooms/invoice.blade.php ENDPATH**/ ?>