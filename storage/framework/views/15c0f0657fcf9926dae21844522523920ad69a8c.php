<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2><?php echo e(lang_trans('Filter')); ?></h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <?php echo e(Form::model(array('url'=>route('billing'),'id'=>"search-report", 'class'=>"form-horizontal form-label-left"))); ?>

                <div class="form-group col-sm-3">
                  <label class="control-label"><?php echo e(lang_trans('Filter')); ?></label>
                    <!-- <?php echo e(Form::select('check_id',$corporates,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])); ?> -->
                    <select name="corporate" class="form-control">
                    <option selected disabled>Select billing</option>
                       <?php $__currentLoopData = $corporates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <option value="<?php echo e($corp); ?>"><?php echo e($corp); ?></option>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </select>
                  </div>
                    <div class="form-group col-sm-3">
                  <label class="control-label">Timely</label>
                     <input type="text" name ="date1" class ="form-control datefilter">
                     <!--,config('constants.Time'),null-->
                     <!--<?php echo e(Form::date('first_name', '', array('class' => 'form-control datefilter'))); ?>-->
                  </div>
               
                <div class="form-group col-sm-3">
                  <br/>
                  <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit"><?php echo e(lang_trans('btn_search')); ?></button>
                </div>
              <?php echo e(Form::close()); ?>

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e($reservationData[0]['referred_by_name'] ?? ''); ?> Billing List</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                        <th>SRN</th>
                        <td>Name</td>
                        <td>Type</td>
                        <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $totalAmount=0;?>
                    <?php $__currentLoopData = $reservationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php
                    $name=App\Customer::where('id',$value->customer_id)->first()->name;
                    ?>
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><a href="<?php echo e(route('view-reservation',[$value->id])); ?>"><?php echo e($name); ?></a></td>
                         <?php if(isset($value->corporates)): ?>
                            <td width="10%"><?php echo e($value->corporates); ?></td>
                            <?php elseif(isset($value->tas)): ?>
                            <td width="10%"><?php echo e($value->tas); ?></td>
                            <?php elseif(isset($value->ota)): ?>
                            <td width="10%"><?php echo e($value->ota); ?></td>
                            <?php else: ?>
                             <td></td>
                        <?php endif; ?>
                        <?php if($value->amount_json): ?>
                        <?php
                            $data=json_decode($value->amount_json);
                         $totalAmount = $totalAmount+$data->total_room_amount;?>
                        <th><?php echo e($data->total_room_amount ?? null); ?></th>
                        <?php else: ?>
                         <th>$0</th>
                         <?php endif; ?>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
                <table class="table table-striped table-bordered">
                      <tr>
                        <th class="text-right" width="70%"><?php echo e(lang_trans('txt_grand_total')); ?></th>
                        <th width="30%"><b><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalAmount)); ?></b></th>
                      </tr>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
    <script type="text/javascript">
    
$(function() {

  $('.datefilter').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('.datefilter').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('.datefilter').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/new/Sourcecode/9aug/newpms/resources/views/backend/billing.blade.php ENDPATH**/ ?>