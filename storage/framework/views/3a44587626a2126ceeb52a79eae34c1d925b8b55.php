<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('txt_list_ota')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo e(lang_trans('txt_sno')); ?></th>
                      <th><?php echo e(lang_trans('txt_name')); ?></th>
                      <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                      <th><?php echo e(lang_trans('txt_gst_num')); ?></th>
                      <th><?php echo e(lang_trans('txt_concern_person')); ?></th>
                      <th><?php echo e(lang_trans('txt_address')); ?></th>
                      <th><?php echo e(lang_trans('txt_action')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($val->name); ?></td>
                        <td><?php echo e($val->mobile_no); ?></td>
                        <td><?php echo e($val->gst_no); ?></td>
                        <td><?php echo e($val->conc_person); ?></td>
                        <td><?php echo e($val->address); ?></td>
                        <td>
                          <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-ota',[$val->id])); ?>"><i class="fa fa-pencil"></i></a>
                          <button class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-ota',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
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
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/ota/ota_list.blade.php ENDPATH**/ ?>