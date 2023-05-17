<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_update_profile')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-profile'),'id'=>"profile-update-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('form_type','updateDetails')); ?>

                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_name')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname')])); ?>

                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_email')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::email('email',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "readonly"=>true])); ?>

                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_mobile_num')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('mobile',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num')])); ?>

                      </div>           
                      <div class="col-md-4 col-sm-4 col-xs-12">
                          <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> <span class="required">*</span></label>
                          <?php echo e(Form::select('gender',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')])); ?>                             
                      </div>
                  </div>
                      <div class="ln_solid"></div>
                      <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
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
                  <h2><?php echo e(lang_trans('heading_update_password')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                      <?php echo e(Form::open(array('url'=>route('save-profile'),'id'=>"password-update-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('form_type','updatePassword')); ?>

                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                          <label class="control-label"><?php echo e(lang_trans('txt_password_new')); ?> <span class="required">*</span></label>
                          <?php echo e(Form::password('new_password',['class'=>'form-control col-md-6 col-xs-12',"id"=>'password','placeholder'=>lang_trans('ph_enter').lang_trans('txt_password_new')])); ?>                             
                      </div> 
                       <div class="col-md-4 col-sm-4 col-xs-12">
                          <label class="control-label"><?php echo e(lang_trans('txt_password_conf')); ?> <span class="required">*</span> </label>
                          <?php echo e(Form::password('conf_password',['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_enter').lang_trans('txt_password_conf')])); ?>                             
                      </div> 
                  </div>
                      <div class="ln_solid"></div>
                      <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
                      </div>
                  <?php echo e(Form::close()); ?>

              </div>
          </div>
      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/users/logged_user_profile.blade.php ENDPATH**/ ?>