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
                  <h2><?php echo e($heading); ?> <?php echo e(lang_trans('heading_food_item')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if($flag==1): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-food-item'),'id'=>"food-item-form", 'class'=>"form-horizontal form-label-left", 'files' => true))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-food-item'),'id'=>"food-item-form", 'class'=>"form-horizontal form-label-left", 'files' => true))); ?>

                  <?php endif; ?>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo e(lang_trans('txt_category')); ?> <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('category_id',$category_list,null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>    
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item_name"> <?php echo e(lang_trans('txt_item_name')); ?> <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('name',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"item_name", "required"=>"required"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="itemcode"> Item code <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('itemcode',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"itemcode", "required"=>"required"])); ?>

                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Strikethrough Price <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('strikethrough',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"Strikethrough"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> <?php echo e(lang_trans('txt_price')); ?> <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('price',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"price", "required"=>"required"])); ?>

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description"> <?php echo e(lang_trans('txt_desc')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::textarea('description',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"description", "rows"=>1])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('category',config('constants.LIST_CATEGORY'),1,['class'=>'form-control'])); ?>    
                          </div>
                      </div>
                      
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Units</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('units',config('constants.LIST_UNITS'),1,['class'=>'form-control'])); ?>    
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Cost/Unit <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('costunits',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"costunits", 'placeholder'=>"0.00"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> SKU <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('sku',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"sku", 'placeholder'=>"SKU"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Prep Time <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('preptime',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"preptime", 'placeholder'=>"In Mins"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Best For <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('bestfor',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"bestfor", 'placeholder'=>"Person"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Energy <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('energy',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"energy", 'placeholder'=>"In KCal"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Protein <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('protein',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"protein", 'placeholder'=>"In Gram"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Fat <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('fat',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"fat", 'placeholder'=>"In Gram"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Carb <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('carb',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"carb", 'placeholder'=>"In Gram"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_status')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('status',config('constants.LIST_STATUS'),1,['class'=>'form-control'])); ?>    
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Food Image</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::file('food_image',['class'=>"form-control col-md-7 col-xs-12", "id"=>"food_image"])); ?>

                          </div>
                      </div>
                      <?php if(!empty($data_row->food_image)): ?>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                          <input type="hidden" name="oldimage" value="<?php echo e($data_row->food_image); ?>">
                          <img src="/storage/app/public/productjack/<?php echo e($data_row->food_image); ?>" width="100">
                      </div>
                     <?php endif; ?>
                      <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="reset">
                                  <?php echo e(lang_trans('btn_reset')); ?>

                              </button>
                              <button class="btn btn-success" type="submit">
                                  <?php echo e(lang_trans('btn_submit')); ?>

                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/food_item_add_edit.blade.php ENDPATH**/ ?>