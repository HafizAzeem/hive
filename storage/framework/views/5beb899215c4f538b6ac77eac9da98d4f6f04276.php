<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2><?php echo e(lang_trans('heading_filter_orders')); ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo e(Form::model($search_data,array('url'=>route('search-orders'),'id'=>"search-orders", 'class'=>"form-horizontal form-label-left"))); ?>

              <div class="form-group col-sm-3">
                <label class="control-label"><?php echo e(lang_trans('txt_type')); ?></label>
                <?php echo e(Form::select('order_type',config('constants.LIST_ORDER_TYPES'),null,['class'=>"form-control"])); ?>

              </div>
              <div class="form-group col-sm-3">
                <label class="control-label"><?php echo e(lang_trans('txt_date_from')); ?></label>
                <?php echo e(Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])); ?>

              </div>
              <div class="form-group col-sm-3">
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
                  <h2><?php echo e(lang_trans('heading_all_orders')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo e(lang_trans('txt_sno')); ?></th>
                      <th><?php echo e(lang_trans('txt_order_by')); ?></th>
                      <th><?php echo e(lang_trans('txt_inv_num')); ?></th>
                      <th><?php echo e(lang_trans('txt_tbl_room_num')); ?></th>
                      <th><?php echo e(lang_trans('txt_customer_name')); ?></th>
                      <th><?php echo e(lang_trans('txt_customer_email')); ?></th>
                      <th><?php echo e(lang_trans('txt_customer_mobile')); ?></th>
                      <th><?php echo e(lang_trans('txt_order_date')); ?></th>
                      <th><?php echo e(lang_trans('txt_pay_date')); ?></th>
                      <th><?php echo e(lang_trans('txt_order_list')); ?></th>
                      <th><?php echo e(lang_trans('txt_total_amount')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php 
                      $totalOrdersAmount = $finalOrderAmount = 0; 
                      $totalOrderAmountGst = $totalOrderAmountCGst = $totalOrderAmountDiscount = $orderGst = $orderCGst = 0;
                      $orderInfo = $value;
                      if($orderInfo){
                        $orderGst = $orderInfo->gst_perc;
                        $orderCGst = $orderInfo->cgst_perc;

                        $totalOrderAmountGst = $orderInfo->gst_amount;
                        $totalOrderAmountCGst = $orderInfo->cgst_amount;
                        $totalOrderAmountDiscount = $orderInfo->discount;
                      }
                                   
                      $countOrderHistory = ($value->order_history) ? $value->order_history->count() : 0;
                      $reservationId = $value->reservation_id;

                      $name = $value->name;
                      $email = $value->email;
                      $mobile = $value->mobile;
                      $checkOutDate = '';
                      if($reservationId>0){
                        if($value->reservation_data){
                          if($value->reservation_data->customer){
                            $name = $value->reservation_data->customer->name;
                            $email = $value->reservation_data->customer->email;
                            $mobile = $value->reservation_data->customer->mobile;
                            $checkOutDate = $value->reservation_data->check_out;
                          }
                        }
                        $type = lang_trans('txt_room_order');
                      } else {
                        $type = lang_trans('txt_tbl_order');
                      }
                      ?>
                      <tr>
                        <td><?php echo e($key+1); ?></td>
                        <td><?php echo e($type); ?></td>
                        <td><?php echo e($value->invoice_num); ?></td>
                        <td><?php echo e(($value->reservation_data!=null) ? $value->reservation_data->room_num : $value->table_num); ?></td>
                        <td><?php echo e($name); ?></td>
                        <td><?php echo e($email); ?></td>
                        <td><?php echo e($mobile); ?></td>
                        <td><?php echo e(dateConvert($value->created_at,'d-m-Y H:i')); ?></td>
                        <td><?php echo e(($value->original_date!=null) ? dateConvert($value->original_date,'d-m-Y H:i') : 'NA'); ?></td>
                        <td width="40%">
                          <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#tbl-<?php echo e($key); ?>"><?php echo e(lang_trans('btn_view_item')); ?></button>
                          <?php if($value->reservation_data==null): ?>
                          <a href="<?php echo e(route('order-invoice-final',[$orderInfo->id])); ?>" class="btn btn-sm btn-warning" target="_blank"><?php echo e(lang_trans('txt_invoice')); ?></a>
                          <?php endif; ?>
                          <div id="tbl-<?php echo e($key); ?>" class="collapse">
                            <table class="table table-bordered items-tbl">
                              <thead>
                                <tr>
                                  <th width="2%"><?php echo e(lang_trans('txt_sno')); ?></th>
                                  <th width="20%"><?php echo e(lang_trans('txt_item_details')); ?></th>
                                  <th width="5%"><?php echo e(lang_trans('txt_item_qty')); ?></th>
                                  <th width="5%"><?php echo e(lang_trans('txt_item_price')); ?></th>
                                  <th width="10%"><?php echo e(lang_trans('txt_subtotal')); ?></th>
                                  <th width="10%"><?php echo e(lang_trans('txt_date')); ?></th>
                                  <th width="5%"><?php echo e(lang_trans('txt_action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $value->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <?php
                                    $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
                                    $finalOrderAmount = ($totalOrdersAmount+$totalOrderAmountGst+$totalOrderAmountCGst-$totalOrderAmountDiscount);

                                    $flag = false;

                                    if(Auth::user()->role_id==1){
                                      if($reservationId>0){
                                          if($checkOutDate=='' & $checkOutDate==null){
                                            $flag = true;
                                          }
                                      } else if($countOrderHistory>0){
                                        $flag = true;
                                      }
                                    }
                                  ?>
                                  <tr>
                                    <td><?php echo e($k+1); ?></td>
                                    <td><?php echo e($val->item_name); ?></td>
                                    <td><?php echo e($val->item_qty); ?></td>
                                    <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->item_price); ?></td>
                                    <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->item_qty*$val->item_price); ?></td>
                                     <td><?php echo e(dateConvert($val->created_at,'d-m-Y H:i')); ?></td>
                                    <td> 
                                      <?php if($flag): ?>
                                        <button class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-order-item',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
                                      <?php else: ?>
                                        <button class="btn btn-default btn-sm bgcolor-eee" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash color-cbc"></i></button>
                                      <?php endif; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <tr>
                                    <td colspan="6"><?php echo e(lang_trans('txt_no_orders')); ?></td>
                                  </tr>
                                <?php endif; ?>
                                <tr>
                                    <th colspan="5" class="text-right"><?php echo e(lang_trans('txt_total_amount')); ?></td>
                                    <td><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($finalOrderAmount)); ?></td>
                                    <td></td>
                                </tr>
                              </tbody>
                            </table>
                          </th>
                        </td>
                       <td><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($finalOrderAmount)); ?></td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
               
              </div>
          </div>
      </div>
  </div>
</div>  
     
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/orders_list.blade.php ENDPATH**/ ?>