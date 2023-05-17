<?php $__env->startSection('rightColContent'); ?>
<?php
$c=1;
$arr = [];
$arr1 = [];
foreach($payment_today as $vals)
{
 if($vals->payment_mode != "")
 {
       $arr[]= $vals->payment_mode;
 }
 if($vals->sec_payment_mode != "")
 {
       $arr[]= $vals->sec_payment_mode;
 }
 if($vals->third_payment_mode != "")
 {
       $arr[]= $vals->third_payment_mode;
 }
 if($vals->fourth_payment_mode != "")
 {
       $arr[]= $vals->fourth_payment_mode;
 }
 if($vals->fifth_payment_mode != "")
 {
       $arr[]= $vals->fifth_payment_mode;
 }
  if($vals->sixth_payment_mode != "")
 {
       $arr[]= $vals->sixth_payment_mode;
 }
 if($vals->sixth_payment_mode != "")
 {
       $arr[]= $vals->sixth_payment_mode;
 }
 
 
 
 
 
}

 $count = array_count_values($arr);

foreach($revenue_today as $val1)
{
  if($val1->referred_by_name == "OTA")
  {
    $arr1[]= $val1->referred_by;
  }
   if($val1->referred_by_name == "TA")
  {
    $arr1[]= $val1->referred_by;
  }
  if($val1->referred_by_name == "Corporate")
  {
    $arr1[]= $val1->referred_by;
  }
  if($val1->referred_by_name == "FIT")
  {
    $arr1[]= $val1->referred_by_name;
  } 
  if($val1->referred_by_name == "Management")
  {
    $arr1[]= $val1->referred_by_name;
  } 
}
$count1 = array_count_values($arr1);

?>

  <h3><b><?php echo e(getSettings('hotel_name')); ?></b></h3>
         <div class="row top_tiles">

                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-caret-square-o-right"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->today_arrivals); ?></div>
                        <h3><a href="<?php echo e(route('list-arrival-reservation')); ?>"><?php echo e(lang_trans('txt_today_arrivals')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-caret-square-o-right"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->noShow_arrivals); ?></div>
                        <h3><a href="<?php echo e(route('list-arrival-reservation')); ?>">NoShow Arrivals</a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-caret-square-o-right"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->today_check_ins); ?></div>
                        <h3><a href="<?php echo e(route('list-reservation')); ?>"><?php echo e(lang_trans('txt_today_checkin')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-comments-o"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->today_check_outs); ?></div>
                        <h3><a href="<?php echo e(route('list-check-outs')); ?>"><?php echo e(lang_trans('txt_today_checkout')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->today_orders); ?></div>
                        <h3><a href="<?php echo e(route('orders-list')); ?>"><?php echo e(lang_trans('txt_today_orders')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if(isset($perc_room)): ?>
                          <div class="count"><?php echo e($perc_room); ?> % </div>
                          <?php else: ?>
                          <div class="count">0 %</div>
                          <?php endif; ?>

                        <h3><a href="javascript:void(0);"><?php echo e(lang_trans('txt_room_occupancy')); ?></a>(<?php echo e($occupied_rooms); ?>/<?php echo e($total_rooms); ?>)</h3>

                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if($payment_today1): ?>
                          <div class="count"><?php echo e($payment_today1); ?> </div>
                          <?php else: ?>
                          <div class="count">0</div>
                          <?php endif; ?>
                        <h3><a href="javascript:void(0);"><?php echo e(lang_trans('txt_today_revenue')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if($total_expense): ?>
                          <div class="count"><?php echo e($total_expense); ?> </div>
                          <?php else: ?>
                          <div class="count">0</div>
                          <?php endif; ?>
                        <h3><a href="javascript:void(0);"><?php echo e(lang_trans('txt_today_expenses')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                
                 <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if($month_expense): ?>
                          <div class="count"><?php echo e($month_expense); ?> </div>
                          <?php else: ?>
                          <div class="count">0</div>
                          <?php endif; ?>
                        <h3><a href="javascript:void(0);">Monthly Expense</a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if($counts[0]->continue_rooms): ?>
                          <div class="count"><?php echo e($counts[0]->continue_rooms); ?> </div>
                          <?php else: ?>
                          <div class="count">0</div>
                          <?php endif; ?>
                        <h3><a href="javascript:void(0);"><?php echo e(lang_trans('txt_continue_rooms')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if($counts[0]->same_day_checkout): ?>
                          <div class="count"><?php echo e($counts[0]->same_day_checkout); ?> </div>
                          <?php else: ?>
                          <div class="count">0</div>
                          <?php endif; ?>
                        <h3><a href="javascript:void(0);"><?php echo e(lang_trans('txt_same_day_checkout')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if(isset($today_perc_room)): ?>
                          <div class="count"><?php echo e($today_perc_room); ?> % </div>
                          <?php else: ?>
                          <div class="count">0 %</div>
                          <?php endif; ?>

                        <h3><a href="javascript:void(0);">Today <?php echo e(lang_trans('txt_room_occupancy')); ?></a>(<?php echo e($today_occupied_rooms); ?>/<?php echo e($total_rooms); ?>)</h3>

                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <?php if(isset($monthly_perc_room)): ?>
                          <div class="count"><?php echo e($monthly_perc_room); ?> % </div>
                          <?php else: ?>
                          <div class="count">0 %</div>
                          <?php endif; ?>

                        <h3><a href="javascript:void(0);">Monthly <?php echo e(lang_trans('txt_room_occupancy')); ?></a></h3>

                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
      <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<anytag data-tippy-content="some tooltip"></anytag>




<!-- Modal Today Check In -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Today Revenue </h4>
      </div>
      <div class="modal-body">
        
    <?php $__currentLoopData = $count; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php echo e($key); ?> : <?php echo e($vals); ?> <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="ex1" class="modal">
  <a href="#" rel="modal:close">Close</a>
</div>


<!-- End Modal Today Check In -->




<!-- Modal Today Revenue -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Today Check In </h4>
      </div>
      <div class="modal-body">
        
      <?php $__currentLoopData = $count1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vals1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php echo e($key); ?> : <?php echo e($vals1); ?> <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="ex1" class="modal">
  <a href="#" rel="modal:close">Close</a>
</div>


<!-- End Modal Today Revenue -->


















<div class="row-sm-12">
  <div class="col-lg-12 ">
    <!-- <h3>Rooms</h3> -->
    <div class="x_content">
      <table id="datatable_" class="table table-striped table-bordered">
        <tbody>

          <table class="table table-striped table-bordered">

            <tbody>
//   <?php
//                 echo "<pre>";
//                 print_r($inner);
//                 die();
                
//                 ?>
              <?php $__currentLoopData = $floor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$basic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php $__currentLoopData = $basic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="mt-5 ml-5">
                    <?php if($key == 0): ?>
               <button class="btn-sm" style="background:yellow;color:black;">Check Out&ensp;&ensp;</button>
                <?php elseif($key == 1): ?>
                <button class="btn-success btn-sm">Ready &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button>
                <?php elseif($key == 2): ?>
                <button class="btn-light btn-sm" style="background:pink;color:white;">Management </button>
                <?php elseif($key == 3): ?>
                <button class="btn-sm" style="background:blue;color:white;">OTA &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button>
                <?php elseif($key == 4): ?>
                <button class="btn-dark btn-sm">Corporate &ensp;&ensp;</button>
                <?php elseif($key == 5): ?>
                <button class="btn-info btn-sm">TA &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button>
                <?php elseif($key == 6): ?>
                <button class="btn-sm" style="background:red;color:white;" >Block or R&M issue &ensp;&ensp;</button>
                <?php elseif($key == 7): ?>
                <button class="btn-sm" style="background:#7CFC00;color:white;" >FIT &ensp;&ensp;</button>
                  <?php elseif($key == 8): ?>
                <button class="btn-sm" style="background:brown;color:white;" >Room Readiness &ensp;&ensp;</button>
                <?php endif; ?>
                
              
                
                <?php $__currentLoopData = $inner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                         <?php if($loop->first): ?>
                            <td>Floor-<?php echo e($inner[$key]->floor-1); ?></td>
                            <?php endif; ?>
                <?php if($val->count()): ?>
                <td>
                   <!--href="{{route('delete-reservation',[$reserv ?? '']-->
                 <?php if( $checked_rooms_count != 0 && in_array($val->room_no, $checked_rooms)): ?>
                  <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                  if(!$reserv){$reserv = 0;}
                  ?>
                  <a class="btn btn-sm" style="background:yellow;color:black;" href="<?php echo e(route('check-out-room',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($dirty_rooms_count != 0 && in_array($val->room_no, $dirty_rooms)): ?>
                  <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                  if(!$reserv){$reserv = 0;}
                  ?>

                  <a class="btn btn-sm" style="background:brown;color:white;" onclick="dirty(<?php echo e($reserv); ?>);"><?php echo e($val->room_no); ?></a>
                   <?php elseif($fit_rooms_count != 0 && in_array($val->room_no, $fit_rooms)): ?>
                     <?php //$reserv=$reservation->whereIn('room_num',$val->room_no)->pluck('id')->first();
                     $reserv=getBookRoomId($val->room_no);
                    //  echo $reserv;die();
                     if(!$reserv){$reserv = 0;}
                     ?>
                      <a class="btn btn-sm" style="background:#7CFC00;color:white;" href="<?php echo e(route('view-reservation',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($booked_rooms_count != 0 && in_array($val->room_no, $booked_rooms)): ?>
                   <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                   if(!$reserv){$reserv = 0;}?>
                   <a class="btn btn-info btn-sm"  href="<?php echo e(route('check-out-room',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($undermaintinance_count != 0 && in_array($val->room_no, $undermaintinance)): ?>
                  <?php $reason=App\Room::where('room_no',$val->room_no)->pluck('reason')->first();
                  if(!$reason){$reason = 'undefined';}?>
                  <button type="button"  style="background:red;color:white;" <?php echo e(Popper::arrow()->size('large')->distance(10)->position('bottom')->pop($reason ?? "")); ?>

                   class="btn  btn-sm"><?php echo e($val->room_no); ?></button>

                  <?php elseif($ota_rooms_count != 0 &&  in_array($val->room_no, $ota_rooms)): ?>
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:blue;color:white;" href="<?php echo e(route('check-out-room',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($corporate_rooms_count != 0 && in_array($val->room_no, $corporate_rooms)): ?>
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                    if(!$reserv){$reserv = 0;} ?>
                    <a class="btn btn-dark btn-sm"  href="<?php echo e(route('check-out-room',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($management_rooms_count != 0 && in_array($val->room_no, $management_rooms)): ?>
                  <button type="button" class="btn btn-sm" style="background:pink;color:white;" href="<?php echo e(route('check-out-room',[$reserv])); ?>"><?php echo e($val->room_no); ?></button>

                  <?php else: ?>
                  <a href="<?php echo e(route('room-reservation-available',[$val->id])); ?>" type="button" class="btn btn-success btn-sm"><?php echo e($val->room_no); ?></a>
                  <?php endif; ?>
                </td>
                <?php else: ?>
                <?php echo e(lang_trans('txt_no_rooms')); ?>

                <a class="btn btn-sm btn-success" href="<?php echo e(route('add-room')); ?>"><?php echo e(lang_trans('txt_add_new_rooms')); ?></a>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
          </table>
        </tbody>
      </table>
    </div>

  </div>
</div>
<div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="col-sm-12">
                                <div class="col-sm-8 p-left-0">
                                    <h2><?php echo e(lang_trans('txt_latest_orders')); ?></h2>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="<?php echo e(route('food-order')); ?>" class="btn btn-success"><?php echo e(lang_trans('txt_add_new_orders')); ?></a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                     $totalAmount = 0.00;
                                ?>
                                <?php if($val->order_history): ?>
                                    <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($val_OH->orders_items): ?>
                                            <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                    $totalAmount = $totalAmount+$price;
                                                    $totalAmmountsArr[$val->id] = $totalAmount;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <table  class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th><?php echo e(lang_trans('txt_sno')); ?></th>
                              <th><?php echo e(lang_trans('txt_customer_name')); ?></th>
                              <th><?php echo e(lang_trans('txt_table_num')); ?></th>
                              <th><?php echo e(lang_trans('txt_order_amount')); ?></th>
                              <th><?php echo e(lang_trans('txt_action')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <td><?php echo e($k+1); ?></td>
                                <td><?php echo e($val->name); ?></td>
                                <td><?php echo e($val->table_num); ?></td>
                                <td><?php echo e(getCurrencySymbol()); ?> <?php echo e(@$totalAmmountsArr[$val->id]); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?php echo e(route('food-order-table',[$val->id])); ?>"><?php echo e(lang_trans('btn_repeat_order')); ?></i></a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view_modal_<?php echo e($k); ?>"><?php echo e(lang_trans('btn_view_order')); ?></button>
                                    <a class="btn btn-sm btn-warning" href="<?php echo e(route('food-order-final',[$val->id])); ?>" target="_blank"><?php echo e(lang_trans('btn_pay')); ?></i></a>

                                    <div class="modal fade view_modal_<?php echo e($k); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title" id="myModalLabel"><?php echo e(lang_trans('txt_order_details')); ?>: (<?php echo e(lang_trans('txt_table_num')); ?>- #<?php echo e($val->table_num); ?>)</h4>
                                                </div>
                                                <div class="modal-body">
                                                   <table  class="table table-striped table-bordered">
                                                        <tr>
                                                            <th><?php echo e(lang_trans('txt_sno')); ?></th>
                                                            <th><?php echo e(lang_trans('txt_datetime')); ?></th>
                                                            <th><?php echo e(lang_trans('txt_orderitem_qty')); ?></th>
                                                        </tr>
                                                        <?php if($val->order_history): ?>
                                                            <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                  <td><?php echo e($key_OH+1); ?></td>
                                                                  <td><?php echo e($val_OH->created_at); ?></td>
                                                                  <td>
                                                                    <?php if($val_OH->orders_items): ?>
                                                                        <table class="table table-bordered">
                                                                            <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php
                                                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                                                    $totalAmount = $totalAmount+$price;
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo e($val_OI->item_name); ?></td>
                                                                                    <td><?php echo e($val_OI->item_qty); ?></td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </table>
                                                                    <?php endif; ?>
                                                                  </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                      </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                              </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo e(lang_trans('txt_product_stocks')); ?></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable_" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th><?php echo e(lang_trans('txt_sno')); ?></th>
                              <th><?php echo e(lang_trans('txt_product')); ?></th>
                              <th><?php echo e(lang_trans('txt_current_stocks')); ?></th>
                              <th><?php echo e(lang_trans('txt_unit')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td><?php echo e($k+1); ?></td>
                                <td><?php echo e($val->name); ?></td>
                                <td><?php echo e($val->stock_qty); ?></td>
                                <td><?php echo e(($val->unit) ? $val->unit->name : ''); ?></td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <script>
      function dirty(id)
   {
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to change status to ready",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No'
            }).then((result) => {
              if (result.isConfirmed) {

                  axios.get('delete-reservation/'+id,{
                          _method: 'DELETE',
                           headers: {
    'Content-type': 'application/json'
  },
                  })
                      .then(function (response) {
                        window.location.reload();
                      })
                      .catch(function (error) {
                        // handle error
                        console.log(error);
                      })
                      .then(function () {
                        // always executed
                      });
                Swal.fire(
                  'Status Changed!',
                  'Room switched to Ready',
                  'success'
                )
              }
            });
   }

 </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/newpms/resources/views/backend/new_dashboard.blade.php ENDPATH**/ ?>