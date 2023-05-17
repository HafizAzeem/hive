<?php $__env->startSection('content'); ?>
<?php
$i =1; $j = 0;
$k1=1;
$totalAmount = 0;


if(isset($datalist[0]->room_num))
{

$room = explode(',', $datalist[0]->room_num);

 $total_room = count($room);
}

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
                          <td><?php echo e(dateConvert($val->created_at_checkin,'d-m-Y H:i')); ?></td>
                          
                          <td>
                              <?php
                                                           if(isset($count_room))
                              {
                                $booking_payment = $val->booking_payment * $count_room;
                                 $total_room = $count_room;
                            }
                            else
                            {
                            
                             $booking_payment = $val->booking_payment;
                            }

                              
                              
                              ?>
                              
                               
                              
                            <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat( $booking_payment * $val->duration_of_stay * $total_room)); ?>

                          </td>
                          <td>
                            <a class="btn btn-sm btn-warning" href="<?php echo e(route('food-order',[$val->id])); ?>"><?php echo e(lang_trans('btn_food_order')); ?></i></a>
                            <a class="btn btn-sm btn-success" href="<?php echo e(route('view-reservation',[$val->id])); ?>"><?php echo e(lang_trans('btn_view')); ?></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('check-out-room',[$val->id])); ?>"><?php echo e(lang_trans('btn_checkout')); ?></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-room-reservation',[$val->id])); ?>"><?php echo e(lang_trans('btn_checkin_edit')); ?></i></a>
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

                      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($val->room_num): ?>
                        <?php if($val->check_out!=null): ?>
                        
                        <?php
                             $totalAmount +=$val->booking_payment;
                        ?>
                          <tr>
                          <td><?php echo e($k1); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->name : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->mobile : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->email : 'NA'); ?></td>
                          <td>
                            <?php if(($val->room_type)): ?>
                              <?php echo e($val->room_type->title); ?><br/>
                              ( <?php echo e(lang_trans('txt_room_num')); ?> : <?php echo e($val->room_num); ?> )
                            <?php endif; ?>
                            </td>
                          <td><?php echo e(dateConvert($val->created_at_checkin,'d-m-Y H:i')); ?></td>
                          <td><?php echo e(dateConvert($val->created_at_checkout,'d-m-Y H:i')); ?></td>

                          
                          <td>
                            <?php echo e(getCurrencySymbol()); ?> <?php echo e($val->booking_payment  * $val->duration_of_stay); ?>

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

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/58.dsrhotelgroup.com/58/resources/views/backend/rooms/room_reservation_list.blade.php ENDPATH**/ ?>