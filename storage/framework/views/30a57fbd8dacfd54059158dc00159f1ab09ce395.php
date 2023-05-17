<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_list_roomtypes')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo e(lang_trans('txt_sno')); ?></th>
                      <th><?php echo e(lang_trans('txt_title')); ?></th>
                      <th><?php echo e(lang_trans('txt_short_code')); ?></th>
                      <th><?php echo e(lang_trans('txt_capacity')); ?></th>
                      <th><?php echo e(lang_trans('txt_base_price')); ?></th>
                      <th><?php echo e(lang_trans('txt_base_price_weekends')); ?></th>
                      <th><?php echo e(lang_trans('txt_status')); ?></th>
                      <th><?php echo e(lang_trans('txt_action')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($val->title); ?></td>
                        <td><?php echo e($val->short_code); ?></td>
                        <td><?php echo e(lang_trans('txt_adults')); ?>: <?php echo e($val->adult_capacity); ?> &nbsp; <?php echo e(lang_trans('txt_kids')); ?>: <?php echo e($val->kids_capacity); ?> </td>
                        <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->base_price); ?></td>
                        <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->base_price_weekends); ?></td>
                        <td><?php echo getStatusBtn($val->status); ?></td>
                        <td>
                          <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-room-types',[$val->id])); ?>"><i class="fa fa-pencil"></i></a>
                          <button class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-room-types',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/rooms/room_types_list.blade.php ENDPATH**/ ?>