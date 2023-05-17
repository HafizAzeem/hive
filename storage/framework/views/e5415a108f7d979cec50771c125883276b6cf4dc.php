<?php $__env->startSection('content'); ?>

<?php 

$i = $j = 0; 
$totalAmount = 0;
?>
<div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2><?php echo e(lang_trans('Filter')); ?></h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <?php echo e(Form::model($search_data,array('url'=>route('search-reports'),'id'=>"search-report", 'class'=>"form-horizontal form-label-left"))); ?>

                <div class="form-group col-sm-3">
                  <label class="control-label"><?php echo e(lang_trans('Filter')); ?></label>
                    <?php echo e(Form::select('check_id',array(
                      'show_all' => 'Show All',
                      'Check_in' => 'Check In', 'Check_out' => 'Check Out'),null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])); ?>

                </div>
                
                <div class="form-group col-sm-2">
                  <label class="control-label"><?php echo e(lang_trans('txt_payment_mode')); ?></label>
                  <?php echo e(Form::select('payment_mode',config('constants.PAYMENT_MODES'),config('constants.PAYMENT_MODES')[1],['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select"])); ?>

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
      <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2>Set Time For Sheduling Report List</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <?php echo e(Form::model($search_data,array('url'=>route('set-time'),'id'=>"search-report", 'class'=>"form-horizontal form-label-left"))); ?>

                <div class="form-group col-sm-2 pl-5">
                  <label class="control-label">Set Time</label>
                  <?php echo e(Form::time('time', $emails[0]->time ?? '',['class'=>"form-control", 'placeholder'=>lang_trans('ph_date_to')])); ?>

                </div>
                <div class="form-group col-sm-3">
                  <br/>
                  <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit">Update Time</button>
                </div>
              <?php echo e(Form::close()); ?>

            </div>
          </div>
        </div>
      </div>



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo e(lang_trans('Reports')); ?></h2>
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
                        <th><?php echo e(lang_trans('txt_checkout')); ?></th>
                        <th><?php echo e(lang_trans('Booking Payment')); ?></th>
                        <th><?php echo e(lang_trans('txt_advance_payment')); ?></th>
                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $datalist_checkin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php 
                        $payment = array();
                        $mode = $val->payment_mode ;
                        $modesec = $val->sec_advance_mode;
                          $paymentmode= Config::get('constants.PAYMENT_MODES.'.$mode);
                          $paymentmodesec= Config::get('constants.PAYMENT_MODES.'.$modesec);
                          $calc = calcFinalAmount($val);
                          $totalAmount = $totalAmount+$calc['finalRoomAmount']+$calc['finalOrderAmount'];
                          $i++; 
                          $method = array('Cash', 'Debit-Credit Card', 'Google Pay', 'Paytm', 'PhonePe', 'UPI', 'Send Payment Link');
                          foreach($method as $methods){
                            if($paymentmode == $methods){
                              $payment[] = array($methods => $val->advance_payment);
                            }else{
                              $payment[] = array($methods => 0);
                            }
                          }
                         
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
                          <td><?php echo e(dateConvert($val->user_checkout,'d-m-Y H:i')); ?></td>
                          <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->booking_payment); ?></td>
                          <td data-toggle="tooltip" title="<?php $__currentLoopData = $payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($key); ?> : <?php echo e($value); ?>   | <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>"><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->advance_payment); ?> (<?php echo e((".$paymentmode.")); ?>) </td>
                          <td>
                        
                            <a class="btn btn-sm btn-success" href="<?php echo e(route('view-reservation',[$val->id])); ?>"><?php echo e(lang_trans('btn_view')); ?></i></a>
                           
                          </td>
                        </tr>
                       
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                  <!--<table class="table table-striped table-bordered">-->
                  <!--    <tr>-->
                  <!--      <th class="text-right" width="70%"><?php echo e(lang_trans('txt_grand_total')); ?></th>-->
                  <!--      <th width="30%"><b><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalAmount)); ?></b></th>-->
                  <!--    </tr>-->
                  <!--</table>-->
                </div>
            </div>
        </div>
    </div>
</div>          
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/58.dsrhotelgroup.com/58/resources/views/backend/rooms/room_reservation_report.blade.php ENDPATH**/ ?>