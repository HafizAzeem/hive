<?php $__env->startSection('content'); ?>
<?php
$i =1; $j = 0;
$k1=1;
$totalAmount = 0;

$type =  basename(request()->path());
?>
<style>
    .tdleft {
        max-width:120px;
        word-wrap: break-word;
    }
    .tdleft1 {
        max-width:70px;
        word-wrap: break-word;
    }
</style>
<div class="card">
    <div class="card-header">
        <span style="float:right;"><a href="<?php echo e(route('single-list-reservation')); ?>" class="btn btn<?php echo e($type=='single-list-reservation' ? '-success':''); ?>">Single Cheking</a>
            <a href="<?php echo e(route('multi-list-reservation')); ?>" class="btn btn<?php echo e($type=='multi-list-reservation' ? '-success':''); ?>">Multi-Cheking</a>
            <a href="<?php echo e(route('list-check-outs')); ?>" class="btn btn<?php echo e($type=='list-check-outs' ? '-success':''); ?>">All Check Out's</a>
        </span>
    </div>
</div>

<div class="">
  <?php if($list=='check_outs'): ?>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2><?php echo e(lang_trans('heading_filter_checkouts')); ?></h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <?php echo e(Form::model($search_data,array('url'=>route('search-checkouts'),'id'=>"search-checkouts", 'class'=>"form-horizontal form-label-left"))); ?>

                <div class="form-group col-sm-2">
                  <label class="control-label"><?php echo e(lang_trans('txt_room_type')); ?></label>
                  <?php echo e(Form::select('room_type_id',$roomtypes_list,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])); ?>

                </div>
                <div class="form-group col-sm-2">
                  <label class="control-label"><?php echo e(lang_trans('txt_date_from')); ?></label>
                  <?php echo e(Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])); ?>

                </div>
                <div class="form-group col-sm-2">
                  <label class="control-label"><?php echo e(lang_trans('txt_date_to')); ?></label>
                  <?php echo e(Form::text('date_to',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_to')])); ?>

                </div>
                <div class="form-group col-sm-3">
                  <br/>
                   <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit"><?php echo e(lang_trans('btn_search')); ?></button>
                   <button class="btn btn-primary export-btn" name="submit_btn" value="export" type="submit"><?php echo e(lang_trans('btn_export')); ?></button>
                </div>
              <?php echo e(Form::close()); ?>

            </div>
          </div>
        </div>
      </div>
  <?php endif; ?>

  <?php if($list=='check_ins'): ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo e(lang_trans('heading_checkin_list')); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th>And S.No.</th>
                        <th><?php echo e(lang_trans('txt_guest_name')); ?></th>
                        <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                        <th>Email Id</th>
                        <th>Source</th>
                        <th>Duration</th>
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
                          <td><?php echo e(($val->customer) ? $val->customer->and_number : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->name : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->mobile : 'NA'); ?></td>
                          <td class="tdleft"><?php echo e(($val->customer) ? $val->customer->email : 'NA'); ?>

                          <!--MID : <?php echo e($val->mid); ?>-->
                          </td>
                          
                          <?php if($val->referred_by): ?>
                            <td><?php echo e($val->referred_by ?? ''); ?></td>
                          <?php else: ?>
                            <td><?php echo e($val->referred_by_name ?? ''); ?></td>
                          <?php endif; ?>
                          
                          <?php if($val->duration_of_stay == 1): ?>
                            <td><?php echo e($val->duration_of_stay ?? ''); ?> Day</td>
                          <?php else: ?>
                            <td><?php echo e($val->duration_of_stay ?? ''); ?> Days</td>
                          <?php endif; ?>
                          
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

  <?php elseif($list=='check_outs'): ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo e(lang_trans('heading_checkout_list')); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered data-table">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th>And S.No.</th>
                        <th><?php echo e(lang_trans('txt_guest_name')); ?></th>
                        <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                        <th>Email Id</th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th><?php echo e(lang_trans('txt_room')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkin')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkout')); ?></th>
                        <th><?php echo e(lang_trans('txt_booking_amount')); ?></th>
                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($val->room_num): ?>
                        <?php if($val->check_out!=null): ?>
                        
                        <?php
                             $totalAmount +=$val->booking_payment;
                        ?>
                          <tr>
                          <td><?php echo e($k1); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->and_number : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->name : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->mobile : 'NA'); ?></td>
                          <td class="tdleft1"><?php echo e(($val->customer) ? $val->customer->email : 'NA'); ?>

                          <!--MID : <?php echo e($val->mid); ?>-->
                          </td>
                          
                          <?php if($val->referred_by): ?>
                            <td><?php echo e($val->referred_by ?? ''); ?> (MID : <?php echo e($val->mid); ?>)</td>
                          <?php else: ?>
                            <td><?php echo e($val->referred_by_name ?? ''); ?> (MID : <?php echo e($val->mid); ?>)</td>
                          <?php endif; ?>
                          
                          <?php if($val->duration_of_stay == 1): ?>
                            <td><?php echo e($val->duration_of_stay ?? ''); ?> Day</td>
                          <?php else: ?>
                            <td><?php echo e($val->duration_of_stay ?? ''); ?> Days</td>
                          <?php endif; ?>
                          
                          <td>
                            <?php if(($val->room_type)): ?>
                              <?php echo e($val->room_type->title); ?><br/>
                              ( <?php echo e(lang_trans('txt_room_num')); ?> : <?php echo e($val->room_num); ?> )
                            <?php endif; ?>
                            </td>
                          <td><?php echo e(dateConvert($val->created_at_checkin,'d-m-Y H:i')); ?></td>
                          <td><?php echo e(dateConvert($val->created_at_checkout,'d-m-Y H:i')); ?></td>

                          
                          <td>
                            <?php echo e(getCurrencySymbol()); ?> <?php echo e($val->booking_payment); ?>

                          </td>
                          <td>
                            <a class="btn btn-sm btn-success" href="<?php echo e(route('view-reservation',[$val->id])); ?>"><?php echo e(lang_trans('btn_view')); ?></i></a>
                            <a class="btn btn-sm btn-danger" href="<?php echo e(route('invoice',[$val->id,1])); ?>" target="_blank"><?php echo e(lang_trans('btn_invoice_room')); ?></i></a>
                            <a class="btn btn-sm btn-warning" href="<?php echo e(route('invoice',[$val->id,2])); ?>" target="_blank"><?php echo e(lang_trans('btn_invoice_food')); ?></i></a>
                          </td>
                        </tr>
                        <?php endif; ?>
                        <?php endif; ?>
                       <?php $k1++; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                  </table>

                </div>
            </div>
        </div>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/rooms/room_reservation_list_search.blade.php ENDPATH**/ ?>