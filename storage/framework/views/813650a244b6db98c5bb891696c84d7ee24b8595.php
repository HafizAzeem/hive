<?php $__env->startSection('content'); ?>
<?php 
$i = $j = 0; 
$totalAmount = 0;
?>
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

                <div class="form-group col-sm-3">
                  <label class="control-label"><?php echo e(lang_trans('txt_guest')); ?></label>
                  <?php echo e(Form::select('customer_id',null,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])); ?>

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
                    <h2><?php echo e(lang_trans('sidemenu_arrival_all')); ?></h2>
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
                        <th>Source</th>
                        <th>Duration</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                        <th><?php echo e(lang_trans('txt_checkin')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkout')); ?></th>
                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     
                        <tr>
                          <td><?php echo e(++$k); ?></td>
                          <td><?php echo e($val->name ?? 'NA'); ?></td>
                          <td><?php echo e($val->mobile ?? 'NA'); ?></td>
                          <td><?php echo e($val->source ?? 'NA'); ?></td>
                          
                          <?php if($val->duration == 1): ?>
                            <td><?php echo e($val->duration ?? ''); ?> Day</td>
                          <?php else: ?>
                            <td><?php echo e($val->duration ?? ''); ?> Days</td>
                          <?php endif; ?>
                          
                          <td><?php echo e($val->paymenttype ?? 'NA'); ?></td>
                          <td><?php echo e($val->bookingstatus ?? 'NA'); ?></td>
                          
                          <td><?php echo e(dateConvert($val->check_in,'d-m-Y H:i')); ?></td>
                             <td><?php echo e(dateConvert($val->check_out,'d-m-Y')); ?></td>
                          <td>
                            <!-- <a class="btn btn-sm btn-warning" href="<?php echo e(route('food-order',[$val->id])); ?>"><?php echo e(lang_trans('btn_food_order')); ?></i></a>
                            <a class="btn btn-sm btn-success" href="<?php echo e(route('view-reservation',[$val->id])); ?>"><?php echo e(lang_trans('btn_view')); ?></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('check-out-room',[$val->id])); ?>"><?php echo e(lang_trans('btn_checkout')); ?></i></a>  -->
                        
                            <a class="btn btn-danger btn-update-form"  href="<?php echo e(route('cancel-arrival',[$val->id])); ?>"><?php echo e(lang_trans('btn_cancel')); ?></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('room-reservation',[$val->id])); ?>"><?php echo e(lang_trans('sidemenu_checkin_add')); ?></i></a>
                            <?php if(strlen((string)$val->Booking_id) == 7): ?>
                            <a class="btn btn-sm btn-success" href="https://hotels.eglobe-solutions.com/pmsnet/channelmanager/bookingdetail/59SNIfarx0eiIa04gs06/<?php echo e($val->Booking_id); ?>" target="_blank">Bill</i></a>
                            <?php else: ?>
                            <a class="btn btn-sm btn-success" href="<?php echo e($val->bookingdetailurl); ?>" target="_blank">Bill</i></a>
                            <?php endif; ?>
                          </td>
                        </tr>
                 
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
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
                    <h2>No Show Arrivals</h2>
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
                        <th>Source</th>
                        <th>Duration</th>
                        <th><?php echo e(lang_trans('txt_checkin')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkout')); ?></th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                         <?php if(isset($datalist3)): ?>
                      <?php $__currentLoopData = $datalist3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     
                        <tr>
                          <td><?php echo e(++$k); ?></td>
                          <td><?php echo e($val->name ?? 'NA'); ?></td>
                          <td><?php echo e($val->mobile ?? 'NA'); ?></td>
                          <td><?php echo e($val->source ?? 'NA'); ?></td>
                          
                          <?php if($val->duration == 1): ?>
                            <td><?php echo e($val->duration ?? ''); ?> Day</td>
                          <?php else: ?>
                            <td><?php echo e($val->duration ?? ''); ?> Days</td>
                          <?php endif; ?>
                          
                          <td><?php echo e(dateConvert($val->check_in ,'d-m-Y H:i')); ?></td>
                          <td><?php echo e(dateConvert($val->check_out,'d-m-Y H:i')); ?></td>
                         <?php if($val->is_deleted == 1): ?>
                          <td>
                              <a class="btn btn-danger">void</a>

                          </td>
                          <?php elseif(dateConvert($val->check_in,'d-m-Y') < date('d-m-Y') ): ?>
                          <td>
                              <a class="btn btn-danger">No Show</a>

                          </td>
                          <?php endif; ?>
                        </tr>
                 
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?>
                      
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
  <?php endif; ?>
  
  
  
  
</div>          
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/rooms/room_arrival_reservation_list.blade.php ENDPATH**/ ?>