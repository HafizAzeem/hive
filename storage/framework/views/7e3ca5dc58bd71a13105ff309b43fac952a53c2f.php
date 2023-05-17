<?php $__env->startSection('content'); ?>
<?php 
  $i=1; 
  $reservationId = Request::route('reservation_id');
  $settings = getSettings();
  $gstPercFood = $settings['food_gst'];
  $cgstPercFood = $settings['food_cgst'];

  $itemsQty = [];
  if($order_row->orders_items){
    foreach($order_row->orders_items as $k=>$val){
      $jsonData = json_decode($val->json_data);
      $itemId = $jsonData->item_id;

      if(isset($itemsQty[$itemId])){
        $itemsQty[$itemId] = $itemsQty[$itemId]+$val->item_qty;
      } else {
        $itemsQty[$itemId] = $val->item_qty;
      }
      
    }
  }

?>
<div class="">
<?php echo e(Form::open(array('url'=>route('save-room-order'),'id'=>"food-order-form", 'class'=>"form-horizontal form-label-left",'files'=>true))); ?>

  <?php echo e(Form::hidden('gst_perc',$gstPercFood)); ?>

  <?php echo e(Form::hidden('cgst_perc',$cgstPercFood)); ?>

  <?php echo e(Form::hidden('page','ff_order')); ?>

  <?php echo e(Form::hidden('order_id',$order_row->id)); ?>

  <?php echo e(Form::hidden('table_num',$order_row->table_num)); ?>

 
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
                      <?php echo e(Form::text('name',$order_row->name,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname')])); ?>

                    </div>
                   <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_email')); ?> </label>
                      <?php echo e(Form::email('email',$order_row->email,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_mobile_num')); ?> </label>
                      <?php echo e(Form::text('mobile',$order_row->mobile,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_address')); ?> </label>
                      <?php echo e(Form::textarea('address',$order_row->address,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_address'),"rows"=>1])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> Room No. </label>
                      <?php echo e(Form::text('table_num',$order_row->table_num,['class'=>"form-control col-md-6 col-xs-12", "id"=>"table_num", "placeholder"=>lang_trans('ph_select'), "required"=>true,'readonly'=>true,'disabled'=>true])); ?>

                      
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_num_of_persons')); ?> </label>
                      <?php echo e(Form::text('num_of_person',$order_row->num_of_person,['class'=>"form-control col-md-6 col-xs-12", "id"=>"table_num", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_num_of_persons')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"> <?php echo e(lang_trans('txt_waiter_name')); ?> </label>
                      <?php echo e(Form::text('waiter_name',$order_row->waiter_name,['class'=>"form-control col-md-6 col-xs-12", "id"=>"table_num", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_waiter_name')])); ?>

                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

     <div class="row <?php echo e(($reservationId>0) ? 'hide_elem' : ''); ?>">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
             <table class="table table-bordered">
                  <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_inv_applicable')); ?></th>
                    <td width="15%" id="td_invoice_apply" class="text-right"><?php echo e(Form::checkbox('food_invoice_apply',null,true ,['id'=>'apply_invoice'])); ?></td>
                  </tr>
                   <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_gst_apply')); ?></th>
                    <td width="15%" id="td_gst_apply" class="text-right"><?php echo e(Form::checkbox('food_gst_apply',1,true ,['id'=>'apply_gst'])); ?></td>
                  </tr>
                  <tr>
                    <th class="text-right"><?php echo e(lang_trans('txt_subtotal')); ?><?php echo e(Form::hidden('subtotal_amount',null,['id'=>'subtotal_amount'])); ?></th>
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
                        <?php echo e(Form::number('discount_amount',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"discount_amount", "placeholder"=>lang_trans('ph_any_discount'),"min"=>0])); ?>

                        <span class="error discount_err_msg"></span>
                    </td>
                  </tr>
                  <tr class="bg-warning">
                    <th class="text-right"><?php echo e(lang_trans('txt_total_amount')); ?> <?php echo e(Form::hidden('final_amount',null,['id'=>'final_amount'])); ?></th>
                    <td width="15%" id="td_final_amount" class="text-right"><?php echo e(getCurrencySymbol()); ?> 0.00</td>
                    
                    
                  </tr>
                  <input type="hidden"id=="td_final_amount" value="<?php echo e(getCurrencySymbol()); ?>">
                   <tr class="">
                    <th class="ss1 text-right"><?php echo e(lang_trans('txt_payment_mode')); ?></th>
                    <td width="15%"id="complementary">
                          <select class="form-control col-md-6 col-xs-12 com" name="payment_mode"><option selected="selected" value="0">--Select--</option><option value="1">Cash</option><option value="4">Paytm</option><option value="5">PhonePe</option><option value="6">complementary</option></select>
                        <!--<?php echo e(Form::select('payment_mode',config('constants.PAYMENT_MODES'),null,['class'=>"form-control col-md-6 col-xs-12", "placeholder"=>lang_trans('ph_select')])); ?></td>-->
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
              <button class="btn btn-success btn-submit-form"id="amount11" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_food_item')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <?php echo e(Form::hidden('reservation_id',$reservationId)); ?>

                  <table id="datatable__" class="table table-bordered">
                    <?php $__currentLoopData = $categories_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      
                      <?php $__currentLoopData = $val->food_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                          $iQty = 0;
                          if(isset($itemsQty[$value->id])) $iQty = $itemsQty[$value->id];
                        ?>
                        
                        <?php if($iQty > 0): ?>
                        <tr class="tr-bg">
                            <th colspan="4"><?php echo e($val->name); ?></th>
                        </tr>
                        <tr class="tr-items">
                          <td width="5%"><?php echo e($i++); ?>.</td>
                          <td><?php echo e($value->name); ?></td>
                          <td width="15%"><?php echo e(getCurrencySymbol()); ?> <?php echo e($value->price); ?></td>
                          <td width="12%">
                            <div class="input-group">
                                <?php echo e(Form::number('item_qty['.$value->id.']',$iQty,['data-price'=>$value->price,'class'=>"form-control input-number text-center", "placeholder"=>lang_trans('ph_qty'),"min"=>0, 'max'=>100, 'readonly'=>true,'style'=>'height: 33px;'])); ?>

                            </div>
                            
                            <?php echo e(Form::hidden('items['.$value->id.']',$val->id.'~'.$val->name.'~'.$value->name.'~'.$value->price,['data-price'=>$value->price,'class'=>"form-control col-md-6 col-xs-12 item_qty", "placeholder"=>lang_trans('ph_qty'),"min"=>0])); ?>

                          </td>
                        </tr>
                        <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                  </table>
                
              </div>
          </div>
      </div>
  </div>

<?php echo e(Form::close()); ?>

</div>  

<script>
$(document).ready(function(){
    var total = $("#td_subtotal_amount").html();
    
    var subtotal = total.replace(/\₹/g,'');
    var sub_amount = (subtotal/(1+(5.0/100)));
   
     $("#td_subtotal_amount").html('₹' + sub_amount.toFixed(2));
    var sub_amount1 =(sub_amount*5/100) ;
    var sub = (sub_amount1) + (sub_amount);
     $("#td_final_amount").html('₹' + sub.toFixed(2));
});
  globalVar.page = 'food_order_final';
  globalVar.gstPercentFood = <?php echo e($gstPercFood); ?>;
  globalVar.cgstPercentFood = <?php echo e($cgstPercFood); ?>;
  
  
 
  
  $("#complementary").on("change", function () {
  var data= $(".com").val();
 if(data== 6){
      $("#td_final_amount").html('₹' + 00);
 }else{
    var total = $("#td_subtotal_amount").html();
    // alert(total);
    var subtotal = total.replace(/\₹/g,'');
    var sub_amount = (subtotal/(1+(5.0/100)));
    // alert(sub_amount);
    //  $("#td_subtotal_amount").html('₹' + sub_amount.toFixed(2));
    var sub_amount1 =(sub_amount*5/100) ;
    // alert(sub_amount1);
    var sub = (sub_amount1) + (sub_amount);
   var sub_amount2 =(sub*5/100) ;
   var sub2 = (sub_amount2) + (sub);
//   alert(sub2);
     $("#td_final_amount").html('₹' + sub2.toFixed(2));
 }
  
 
    
});
  
  
</script>   
<script>
    $("#amount11").click(function(){
   var data= $(".com").val();
   if(data==0){
       alert("Please Fill Payment method");
       return false;
   }
});
</script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/js/page_js/page.js')); ?>"></script>      
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/room_food_order_final_page.blade.php ENDPATH**/ ?>