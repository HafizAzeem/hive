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
                  <h2><?php echo e($heading); ?> <?php echo e(lang_trans('heading_food_category')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if($flag==1): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-food-category'),'id'=>"food-category-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-food-category'),'id'=>"food-category-form", 'class'=>"form-horizontal form-label-left"))); ?>

                  <?php endif; ?>
                  
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cat_name"> <?php echo e(lang_trans('txt_category_name')); ?><span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('name',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"cat_name", "required"=>"required"])); ?>

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_category_name')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('status',config('constants.LIST_STATUS'),1,['class'=>'form-control'])); ?>    
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
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/food_category_add_edit.blade.php ENDPATH**/ ?>