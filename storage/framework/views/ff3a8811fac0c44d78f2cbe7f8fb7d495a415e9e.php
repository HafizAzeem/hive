<?php $__env->startSection('content'); ?>
<?php 
      $flag=0;
      $heading=lang_trans('heading_add_product');
      if(isset($data_row) && !empty($data_row)){
          $flag=1;
          $heading=lang_trans('heading_update_product');
      }
  ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e($heading); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if($flag==1): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-product'),'id'=>"update-product-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-product'),'id'=>"add-product-form", 'class'=>"form-horizontal form-label-left"))); ?>

                  <?php endif; ?>
                  
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name"> <?php echo e(lang_trans('txt_product_name')); ?><span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('name',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"product_name", "required"=>"required"])); ?>

                          </div>
                      </div>
                      <?php if($flag==0): ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="prod_quantity"> <?php echo e(lang_trans('txt_qty')); ?><span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="col-md-6 col-sm-6 col-xs-12 p-left-0 p-right-0">
                                <?php echo e(Form::number('stock_qty',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"prod_quantity", "required"=>"required"])); ?>

                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12 p-left-0 p-right-0">
                                <?php echo e(Form::select('measurement',getUnits(),null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>    
                              </div>
                            </div>
                        </div>
                      <?php else: ?>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="prod_quantity"> <?php echo e(lang_trans('txt_curr_stock')); ?><span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo e(Form::number('curr_stock',$data_row->stock_qty,['class'=>"form-control col-md-7 col-xs-12", "id"=>"prod_quantity", "readonly"=>"readonly"])); ?>

                            </div>
                          </div>
                      <?php endif; ?>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_status')); ?></label>
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
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/product_add_edit.blade.php ENDPATH**/ ?>