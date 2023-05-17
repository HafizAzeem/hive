<?php $__env->startSection('content'); ?>
<?php
      $flag=0;
      $heading=lang_trans('btn_add');
      if(isset($data_row) && !empty($data_row)){
          $flag=1;
          $heading=lang_trans('btn_update');
      }
  ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Add Payment Mode</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if($flag==1): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-paymentmode'),'id'=>"payment-mode-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-paymentmode'),'id'=>"payment-mode-form", 'class'=>"form-horizontal form-label-left"))); ?>

                  <?php endif; ?>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('payment_mode',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"name", "required"=>"required"])); ?>

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-6 col-xs-12" id='status' name="status" >
                                <option value='1'>Active</option>
                                <option value='0'>Inactive</option>
                            </select>

                          </div>
                      </div>

                      <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="reset"><?php echo e(lang_trans('btn_reset')); ?></button>
                              <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/add_paymentmode.blade.php ENDPATH**/ ?>