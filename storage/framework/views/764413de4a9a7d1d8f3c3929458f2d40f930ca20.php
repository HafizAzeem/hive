<?php $__env->startSection('css'); ?>
<style>
    table, th, td {
  border: 1px solid black;
}

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if(isset($flag)): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-Addavailedservices'),'id'=>"amenities-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-Addavailedservices'),'id'=>"amenities-form", 'class'=>"form-horizontal form-label-left"))); ?>

                  <?php endif; ?>
                  
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amenities_name"> <?php echo e(lang_trans('txt_name')); ?> <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('name',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"amenities_name", "required"=>"required"])); ?>

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amenities_desc"> <?php echo e(lang_trans('txt_description')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::textarea('description',null,['class'=>"form-control col-md-7 col-xs-12 txt-editor","id"=>"amenities_desc"])); ?>

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_status')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::select('status',config('constants.LIST_STATUS'),1,['class'=>'form-control'])); ?>                             
                          </div>
                      </div>
                     
                      <div class="ln_solid">
                      </div>
                      <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="reset"><?php echo e(lang_trans('btn_reset')); ?></button>
                              <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
                          </div>
                      </div>
                  <?php echo e(Form::close()); ?>

              </div>
          </div>
      </div>
  </div>
</div>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/new/Sourcecode/9aug/newpms/resources/views/backend/rooms/Addavailedservices.blade.php ENDPATH**/ ?>