<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_list_datepricerange')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo e(lang_trans('txt_sno')); ?></th>
                      <th><?php echo e(lang_trans('txt_room')); ?></th>
                      <th><?php echo e(lang_trans('txt_start_date')); ?></th>
                      <th><?php echo e(lang_trans('txt_end_date')); ?></th>
                      <th><?php echo e(lang_trans('txt_date_price')); ?></th>
                      <th><?php echo e(lang_trans('txt_status')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td>
                            <?php if(($val->room_type)): ?>
                              <?php echo e($val->room_type->title); ?><br/>
                              ( <?php echo e(lang_trans('txt_room_num')); ?> : <?php echo e($val->room_num); ?> )
                            <?php endif; ?>
                            </td>
                        <td><?php echo e($val->start_date); ?></td>
                        <td><?php echo e($val->end_date); ?></td>
                        <td><?php echo e($val->date_price); ?></td>
                        <?php if($val->status == 1): ?>
                            <td><button type="button" class="btn btn-success btn-xs">Active</button></td>
                        <?php else: ?>
                        <td><button type="button" class="btn btn-delete btn-xs">InActive</button></td>
                        <?php endif; ?>
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

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/rooms/date_price_range_list.blade.php ENDPATH**/ ?>