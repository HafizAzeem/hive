<?php $__env->startSection('content'); ?>
<?php
$i =1; $j = 0;
$k1=1;
$totalAmount = 0;

$type =  basename(request()->path());
?>

<!--<div class="card">-->
<!--    <div class="card-header">-->
<!--        <span style="float:right;"><a href="<?php echo e(route('single-list-reservation')); ?>" class="btn btn<?php echo e($type=='single-list-reservation' ? '-success':''); ?>">Single Cheking</a>-->
<!--            <a href="<?php echo e(route('multi-list-reservation')); ?>" class="btn btn<?php echo e($type=='multi-list-reservation' ? '-success':''); ?>">Multi-Cheking</a>-->
<!--            <a href="<?php echo e(route('list-check-outs')); ?>" class="btn btn<?php echo e($type=='list-check-outs' ? '-success':''); ?>">All Check Out's</a>-->
<!--        </span>-->
<!--    </div>-->
<!--</div>-->

<div class="">
  <?php if($list=='continue_rooms_list'): ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Occupied Rooms List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th><?php echo e(lang_trans('txt_guest_name')); ?></th>
                        <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                        <th><?php echo e(lang_trans('txt_email')); ?></th>
                        <th><?php echo e(lang_trans('txt_room')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkin')); ?></th>
                        <th><?php echo e(lang_trans('txt_booking_amount')); ?></th>
                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($val->room_num): ?>
                        <?php if($val->check_out==null): ?>
                        
                        <?php
                        $totalAmount +=$val->booking_payment;
                        ?>
                        <tr>
                          <td><?php echo e($i); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->name : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->mobile : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->email : 'NA'); ?></td>
                          <td>
                            <?php if(($val->room_type)): ?>
                              <?php echo e($val->room_type->title); ?><br/>
                              ( <?php echo e(lang_trans('txt_room_num')); ?> : <?php echo e($val->room_num); ?> )
                            <?php endif; ?>
                            </td>
                          <td><?php echo e(dateConvert($val->check_in,'d-m-Y H:i')); ?></td>
                          
                          <td>
                              <?php
                                if(isset($count_room))
                                {
                                    $room = explode(',', $val->room_num);
                                    $total_room = count($room);
                                    
                                    
                                    
                                    
                                    $booking_payment = $val->per_room_price;
                                    $total_room = $count_room;
                                }
                                else
                                {
                                
                                    $booking_payment = $val->booking_payment ;
                                }

                             
                              
                              ?>
                              
                               
                              
                          <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat( $booking_payment)); ?>

                          
                            <?php $unique_id=$val->unique_id; ?>
                          </td>
                          <td>
                            <a class="btn btn-sm btn-warning" href="<?php echo e(route('food-order',[$val->id])); ?>"><?php echo e(lang_trans('btn_food_order')); ?></i></a>
                            <a class="btn btn-sm btn-success" href="<?php echo e(route('view-reservation',[$val->id])); ?>"><?php echo e(lang_trans('btn_view')); ?></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('check-out-room',[$val->unique_id])); ?>"><?php echo e(lang_trans('btn_checkout')); ?></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(url('admin/edit-check-in/'.$val->unique_id)); ?>"><?php echo e(lang_trans('btn_checkin_edit')); ?></i></a>
                          </td>
                        </tr>
                        <?php endif; ?>
                        <?php endif; ?>
                        
                        
                        
                        <?php $i++; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>

                </div>
            </div>
        </div>
    </div>
  <?php else: ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Occupied Rooms List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered data-table">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th><?php echo e(lang_trans('txt_guest_name')); ?></th>
                        <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                        <th><?php echo e(lang_trans('txt_email')); ?></th>
                        <th><?php echo e(lang_trans('txt_room')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkin')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkout')); ?></th>
                        <th><?php echo e(lang_trans('txt_booking_amount')); ?></th>
                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>No Data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>
                  </table>

                </div>
            </div>
        </div>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/rooms/continue_rooms_list.blade.php ENDPATH**/ ?>