<?php $__env->startSection('content'); ?>
  <div class="">
     <?php $__env->startSection('rightColContent'); ?>
         <div class="row top_tiles">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-caret-square-o-right"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->today_check_ins); ?></div>
                        <h3><a href="<?php echo e(route('list-reservation')); ?>"><?php echo e(lang_trans('txt_today_checkin')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-comments-o"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->today_check_outs); ?></div>
                        <h3><a href="<?php echo e(route('list-check-outs')); ?>"><?php echo e(lang_trans('txt_today_checkout')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon">
                            <i class="fa fa-sort-amount-desc"></i>
                        </div>
                        <div class="count"><?php echo e($counts[0]->today_orders); ?></div>
                        <h3><a href="<?php echo e(route('orders-list')); ?>"><?php echo e(lang_trans('txt_today_orders')); ?></a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
      <?php $__env->stopSection(); ?>
    
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="col-sm-12">
                                <div class="col-sm-8 p-left-0">
                                    <h2><?php echo e(lang_trans('txt_latest_orders')); ?></h2>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="<?php echo e(route('food-order')); ?>" class="btn btn-success"><?php echo e(lang_trans('txt_add_new_orders')); ?></a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                     $totalAmount = 0.00;
                                ?>
                                <?php if($val->order_history): ?>
                                    <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($val_OH->orders_items): ?>
                                            <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                    $totalAmount = $totalAmount+$price;
                                                    $totalAmmountsArr[$val->id] = $totalAmount;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <table  class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th><?php echo e(lang_trans('txt_sno')); ?></th>
                              <th><?php echo e(lang_trans('txt_customer_name')); ?></th>
                              <th><?php echo e(lang_trans('txt_table_num')); ?></th>
                              <th><?php echo e(lang_trans('txt_order_amount')); ?></th>
                              <th><?php echo e(lang_trans('txt_action')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <td><?php echo e($k+1); ?></td>
                                <td><?php echo e($val->name); ?></td>
                                <td><?php echo e($val->table_num); ?></td>
                                <td><?php echo e(getCurrencySymbol()); ?> <?php echo e(@$totalAmmountsArr[$val->id]); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?php echo e(route('food-order-table',[$val->id])); ?>"><?php echo e(lang_trans('btn_repeat_order')); ?></i></a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view_modal_<?php echo e($k); ?>"><?php echo e(lang_trans('btn_view_order')); ?></button>
                                    <a class="btn btn-sm btn-warning" href="<?php echo e(route('food-order-final',[$val->id])); ?>" target="_blank"><?php echo e(lang_trans('btn_pay')); ?></i></a>

                                    <div class="modal fade view_modal_<?php echo e($k); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title" id="myModalLabel"><?php echo e(lang_trans('txt_order_details')); ?>: (<?php echo e(lang_trans('txt_table_num')); ?>- #<?php echo e($val->table_num); ?>)</h4>
                                                </div>
                                                <div class="modal-body">
                                                   <table  class="table table-striped table-bordered">
                                                        <tr>
                                                            <th><?php echo e(lang_trans('txt_sno')); ?></th>
                                                            <th><?php echo e(lang_trans('txt_datetime')); ?></th>
                                                            <th><?php echo e(lang_trans('txt_orderitem_qty')); ?></th>
                                                        </tr>
                                                        <?php if($val->order_history): ?>
                                                            <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                  <td><?php echo e($key_OH+1); ?></td>
                                                                  <td><?php echo e($val_OH->created_at); ?></td>
                                                                  <td>
                                                                    <?php if($val_OH->orders_items): ?>
                                                                        <table class="table table-bordered">
                                                                            <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php
                                                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                                                    $totalAmount = $totalAmount+$price;
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo e($val_OI->item_name); ?></td>
                                                                                    <td><?php echo e($val_OI->item_qty); ?></td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </table>
                                                                    <?php endif; ?>
                                                                  </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                      </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                              </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo e(lang_trans('txt_room')); ?></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable_" class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo e(lang_trans('txt_sno')); ?></th>
                                  <th><?php echo e(lang_trans('txt_title')); ?></th>
                                  <th><?php echo e(lang_trans('txt_capacity')); ?></th>
                                  <th><?php echo e(lang_trans('txt_base_price')); ?></th>
                                  <th><?php echo e(lang_trans('txt_room')); ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td><?php echo e($val->title); ?></td>
                                    <td><?php echo e(lang_trans('txt_adults')); ?>: <?php echo e($val->adult_capacity); ?> &nbsp; <?php echo e(lang_trans('txt_kids')); ?>: <?php echo e($val->kids_capacity); ?> </td>
                                    <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->base_price); ?></td>
                                    <td>
                                        <?php if($val->rooms->count()): ?>
                                            <table class="table table-striped table-bordered">
                                              <thead>
                                                <tr>
                                                    <th><?php echo e(lang_trans('txt_sno')); ?></th>
                                                    <th><?php echo e(lang_trans('txt_room_num')); ?></th>
                                                    <th><?php echo e(lang_trans('txt_floor')); ?></th>
                                                    <th><?php echo e(lang_trans('txt_status')); ?></th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php $__currentLoopData = $val->rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <tr>
                                                    <td><?php echo e($k+1); ?></td>
                                                    <td><?php echo e($v->room_no); ?></td>
                                                    <td><?php echo e(config('constants.ROOM_FLOOR')[$v->floor]); ?></td>
                                                    <td>
                                                        <?php if(in_array($v->room_no, $booked_rooms)): ?>
                                                            <button type="button" class="btn btn-danger btn-xs"><?php echo e(lang_trans('txt_booked')); ?></button>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(route('room-reservation-available',[$v->id])); ?>" type="button" class="btn btn-success btn-xs"><?php echo e(lang_trans('txt_available')); ?></a>
                                                        <?php endif; ?>
                                                    </td>
                                                  </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              </tbody>
                                            </table>
                                        <?php else: ?>
                                           <?php echo e(lang_trans('txt_no_rooms')); ?>

                                           <a class="btn btn-xs btn-success" href="<?php echo e(route('add-room')); ?>"><?php echo e(lang_trans('txt_add_new_rooms')); ?></a>
                                        <?php endif; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo e(lang_trans('txt_product_stocks')); ?></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable_" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th><?php echo e(lang_trans('txt_sno')); ?></th>
                              <th><?php echo e(lang_trans('txt_product')); ?></th>
                              <th><?php echo e(lang_trans('txt_current_stocks')); ?></th>
                              <th><?php echo e(lang_trans('txt_unit')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td><?php echo e($k+1); ?></td>
                                <td><?php echo e($val->name); ?></td>
                                <td><?php echo e($val->stock_qty); ?></td>
                                <td><?php echo e(($val->unit) ? $val->unit->name : ''); ?></td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/dashboard.blade.php ENDPATH**/ ?>