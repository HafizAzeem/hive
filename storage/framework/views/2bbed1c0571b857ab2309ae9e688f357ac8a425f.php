<?php $__env->startSection('content'); ?>

<?php

$userRole = Auth::user()->role_id;
$settings = getSettings();
$gst_0 = $settings['gst_0'];
$cgst_0 = $settings['cgst_0'];

$gst = $settings['gst'];
$cgst = $settings['cgst'];

$gst_1 = $settings['gst_1'];
$cgst_1 = $settings['cgst_1'];


$jsonDecode = json_decode($data_row->amount_json);
$roomAmountDiscount = (isset($jsonDecode->room_amount_discount)) ? $jsonDecode->room_amount_discount : 0;
$advancePayment = ($data_row->advance_payment>0 ) ? $data_row->advance_payment : 0;
$secadvancePayment = ($data_row->sec_advance_payment>0 ) ? $data_row->sec_advance_payment : 0;
$thirdadvancePayment = ($data_row->third_advance_payment>0 ) ? $data_row->third_advance_payment : 0;
$fourthadvancePayment = ($data_row->fourth_advance_payment>0 ) ? $data_row->fourth_advance_payment : 0;
$fifthadvancePayment = ($data_row->fifth_advance_payment>0 ) ? $data_row->fifth_advance_payment : 0;
$sixthadvancePayment = ($data_row->sixth_advance_payment>0 ) ? $data_row->sixth_advance_payment : 0;
$totalAdvance = $advancePayment + $secadvancePayment + $thirdadvancePayment + $fourthadvancePayment + $fifthadvancePayment + $sixthadvancePayment;

if($data_row->checkin_type=='single')
{
 $durOfStay = $data_row->duration_of_stay;
 $perRoomPrice = $data_row->per_room_price;
 $bookingAmount = $data_row->per_room_price;
 $roomQty = $data_row->room_qty;
 $totalRoomAmount = $data_row->total_amount;
 $amount=$perRoomPrice;
 $multi_room=$data_row->room_num;
}


if($customer_room_data != "empty")
{
    $multi_room=array();
    foreach($customer_room_data as $room_dt)
    {
     array_push($multi_room,$room_dt->room_num);
    }
    $multi_room=implode(',',$multi_room);
    $roomQty = count($customer_room_data);
    $room_data=$customer_room_data[0];
    $bookingAmount=$room_data->per_room_price;
    $totalRoomAmount = $data_row->total_amount;
    $amount=$bookingAmount;

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
    
    if($totalamountwithextrastay ?? '' > 0){
        $totalRoomAmount+=$totalamountwithextrastay ?? '';
    }


$mode = $data_row->payment_mode;
$gstCal = gstCalc($amount,'room_gst',$gstPerc,$cgstPerc);

$totalRoomAmountGst= round($totalRoomAmount- ($totalRoomAmount * $applyGst));

$fullGST= $totalRoomAmount*$multiplyGst;
$fullCGST= $totalRoomAmount*$multiplyCGst;
$roomAmountGst = numberFormat($fullGST);
$roomAmountCGst = numberFormat($fullCGST);

$total_payment_history=0;
foreach($payment_history as $p)
{
$total_payment_history +=$p->payment;
}

if($amount<$total_payment_history)
{
$finalRoomAmount=0;
}else
{
$finalRoomAmount=$amount-$total_payment_history;
}



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

?>
<style>
/*$applyGst= 1 + (($gstPerc + $cgstPerc)/100);*/
/*$totalRoomAmountGst= round($totalRoomAmount/$applyGst);*/
/*$fullGST=$totalRoomAmountGst*$multiplyGst;*/
/*$fullGST=$totalRoomAmountGst*$multiplyGst;*/
/*$roomAmountGst = numberFormat($fullGST/2);*/
/*$roomAmountCGst = numberFormat($fullGST/2);*/

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
    {
        padding:5px;
        font-size:12px;
    }
    h2
    {
        font-size:14px;
    }
</style>
<div class="">
    <?php echo e(Form::model($data_row,array('url'=>route('updateviewReservation'),'id'=>"updateviewReservation", 'class'=>"form-horizontal form-label-left",'files'=>true,'autocomplete'=>"off"))); ?>

    <?php echo e(Form::hidden('id',null)); ?>

    
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
                              
                              <?php if( $data_row->meal_items): ?>
                              <th>Included Meals</th>
                              <td><?php echo e($data_row->meal_items->included_meal); ?></td>
                              <?php endif; ?>

                              <th><?php echo e(lang_trans('txt_company_gst_num')); ?></th>
                              <td> <?php echo e(Form::text('company_gst_num',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"company_gst_num", "placeholder"=>"Enter GST Number"])); ?> </td>
                            </tr>
                            
                            <tr>
                                <th>Company Name</th>
                                <td><?php echo e(Form::text('gst_company',null,['class'=>"form-control col-md-6 col-xs-12",  "placeholder"=>"Enter Company Name"])); ?></td>
                                <th>Company Address</th>
                                <td><?php echo e(Form::text('gst_address',null,['class'=>"form-control col-md-6 col-xs-12",  "placeholder"=>"Enter Company Address"])); ?></td>
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
    <div class="col-md-12 col-sm-12 col-xs-12 text-right">
        <button class="btn btn-success btn-update-form" type="submit"  name="update_btn" value="update"><?php echo e(lang_trans('btn_update')); ?></button>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_payment_info')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th width="2%"><?php echo e(lang_trans('txt_sno')); ?>.</th>
                              <th width="18%"><?php echo e(lang_trans('txt_room')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_room_qty')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_duration_of_stay')); ?></th>
                              <th width="5%"><?php echo e(lang_trans('txt_base_price')); ?></th>
                               <th width="7%"><?php echo e(lang_trans('txt_payment_mode')); ?></th>
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
                               <td>
                              <?php if(count($payment_mode) ==0): ?>
                                    NA
                              <?php else: ?>
                              <?php echo e($payment_mode[0]->payment_mode); ?>

                              <?php endif; ?>
                            </td>
                              <td class="td_total_amount"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalRoomAmount)); ?></td>
                               
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-bordered">
                              <tr>
                                <th class="text-right"><?php echo e(lang_trans('txt_subtotal')); ?></th>
                                <td width="15%" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalRoomAmountGst)); ?></td>
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
                              
                              
                <?php 
                 $total_pay_amount=0;
                 foreach($payment_history as $key=>$p)
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
                      <th class='text-right'>".$number." Payment (Payment Date : ".$p->payment_date.") ".$p->remark."</th>
                      <td class='text-right'>".numberFormat($p->payment)."</td>
                     </tr>";
                     
                     $total_pay_amount+=$p->payment;
                 }
                 
                 
                  
                ?>
                              <tr>
                                <th class="text-right"><?php echo e(lang_trans('txt_discount')); ?></th>
                                <td width="15%" id="td_advance_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($roomAmountDiscount)); ?></td>
                              </tr>
                              <tr class="bg-success">
                                <th class="text-right"><?php echo e(lang_trans('txt_amount_payable')); ?></th>
                                <td width="15%" id="td_final_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalRoomAmount-$total_pay_amount)); ?></td>
                              </tr>
                        </table>
                      
                   
              </div>
          </div>
      </div>
  </div>
  
    <?php echo e(Form::close()); ?>

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

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/rooms/room_reservation_view.blade.php ENDPATH**/ ?>