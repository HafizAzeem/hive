<?php $__env->startSection('content'); ?>
<?php 
  $reservationId = Request::route('reservation_id');
  $i=1; 
  $settings = getSettings();
  $gstPercFood = $settings['food_gst'];
  $cgstPercFood = $settings['food_cgst'];
?>
<div class="">
<?php echo e(Form::open(array('url'=>route('save-food-order'),'id'=>"food-order-form", 'class'=>"form-horizontal form-label-left",'files'=>true))); ?>

  <?php echo e(Form::hidden('gst_perc',$gstPercFood)); ?>

  <?php echo e(Form::hidden('cgst_perc',$cgstPercFood)); ?>

  
    <?php if($reservationId==null): ?>
    <div class="row <?php echo e(($reservationId>0) ? 'hide_elem' : ''); ?>" id="new_guest_section">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo e(lang_trans('heading_customer_info')); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                  <div class="row"> 
                   
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_fullname')); ?> </label>
                      <?php echo e(Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname')])); ?>

                    </div>
                   <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_email')); ?> </label>
                      <?php echo e(Form::email('email',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_mobile_num')); ?> </label>
                      <?php echo e(Form::text('mobile',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_address')); ?> </label>
                      <?php echo e(Form::textarea('address',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_address'),"rows"=>1])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_table_num')); ?> </label>
                      <?php echo e(Form::select('table_num',getTableNums(),null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"table_num", "placeholder"=>lang_trans('ph_select'), "required"=>true])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_num_of_persons')); ?> </label>
                      <?php echo e(Form::text('num_of_person',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"num_of_person", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_num_of_persons')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_waiter_name')); ?> </label>
                      <?php echo e(Form::text('waiter_name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"waiter_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_waiter_name')])); ?>

                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_food_item')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type='text' id='txt_searchall' placeholder='Search Items...' class="form-control">
                  </div>
                  <div class="col-md-8 col-sm-8 col-xs-12 text-right pull-right">
                      <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
                  </div>
                  <br/>
                  <br/>
                  <br/>
                  <?php echo e(Form::hidden('reservation_id',$reservationId)); ?>

                  <table id="datatable__" class="table table-bordered">
                    <?php $__currentLoopData = $categories_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr class="tr-bg">
                        <td colspan="4"><b><?php echo e($val->name); ?></b></td>
                      </tr>
                      <?php $__currentLoopData = $val->food_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="tr-items">
                          <td width="5%"><?php echo e($i++); ?>.</td>
                          <td><?php echo e($value->name); ?></td>
                          <td width="15%"><?php echo e(getCurrencySymbol()); ?> <?php echo e($value->price); ?></td>
                          <td width="12%">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="<?php echo e('item_qty['.$value->id.']'); ?>">
                                      <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </span>
                                <?php echo e(Form::number('item_qty['.$value->id.']',0,['data-price'=>$value->price,'class'=>"form-control input-number text-center", "placeholder"=>lang_trans('ph_qty'),"min"=>0, 'max'=>100, 'readonly'=>true,'style'=>'height: 33px;'])); ?>

                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="<?php echo e('item_qty['.$value->id.']'); ?>">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </span>
                            </div>
                            
                            <?php echo e(Form::hidden('items['.$value->id.']',$val->id.'~'.$val->name.'~'.$value->name.'~'.$value->price,['data-price'=>$value->price,'class'=>"form-control col-md-6 col-xs-12 item_qty","min"=>0])); ?>

                          </td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                  </table>
                
              </div>
          </div>
      </div>
  </div>

 
    <div class="row <?php echo e((1==1) ? 'hide_elem' : ''); ?>">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
             <table class="table table-bordered">
                  <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_inv_applicable')); ?></th>
                    <td width="15%" id="td_invoice_apply" class="text-right"><?php echo e(Form::checkbox('food_invoice_apply',null,false ,['id'=>'apply_invoice'])); ?></td>
                  </tr>
                   <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_gst_apply')); ?></th>
                    <td width="15%" id="td_gst_apply" class="text-right"><?php echo e(Form::checkbox('food_gst_apply',0,false ,['id'=>'apply_gst'])); ?></td>
                  </tr>
                  <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_subtotal')); ?> <?php echo e(Form::hidden('subtotal_amount',null,['id'=>'subtotal_amount'])); ?></th>
                    <td width="15%" id="td_subtotal_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> 0.00</td>
                  </tr>
                  <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_sgst')); ?> (<?php echo e($gstPercFood); ?>%) <?php echo e(Form::hidden('gst_amount',null,['id'=>'gst_amount'])); ?></th>
                    <td width="15%" id="td_gst_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> 0.00</td>
                  </tr>
                  <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_cgst')); ?> (<?php echo e($cgstPercFood); ?>%) <?php echo e(Form::hidden('cgst_amount',null,['id'=>'cgst_amount'])); ?></th>
                    <td width="15%" id="td_cgst_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> 0.00</td>
                  </tr>
                  <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_discount')); ?></th>
                    <td width="15%" id="td_discount_amount" class="text-right">
                        <?php echo e(Form::number('discount_amount',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"discount_amount", "placeholder"=>"Enter Any Discount","min"=>0])); ?>

                    </td>
                  </tr>
                  <tr class="bg-warning">
                    <th class="text-right"><?php echo e(lang_trans('txt_total_amount')); ?> <?php echo e(Form::hidden('final_amount',null,['id'=>'final_amount'])); ?></th>
                    <td width="15%" id="td_final_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> 0.00</td>
                  </tr>
              </table>
          </div>
        </div>
      </div>
    </div>
 
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="col-md-12 col-sm-12 col-xs-12 text-right">
              <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php echo e(Form::close()); ?>

</div>    
  
<script>
  globalVar.page = 'food_order_page';
  globalVar.gstPercentFood = <?php echo e($gstPercFood); ?>;
  globalVar.cgstPercentFood = <?php echo e($cgstPercFood); ?>;
</script> 
<script type="text/javascript" src="<?php echo e(URL::asset('public/js/page_js/page.js')); ?>"></script>       
<?php $__env->stopSection(); ?>     
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/newpms/resources/views/backend/food_order_page.blade.php ENDPATH**/ ?>