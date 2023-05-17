<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('txt_list_customers')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo e(lang_trans('txt_sno')); ?></th>
                      <th><?php echo e(lang_trans('txt_fullname')); ?></th>
                      <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                      <th><?php echo e(lang_trans('txt_email')); ?></th>
                      <th><?php echo e(lang_trans('txt_gender')); ?></th>
                      <th><?php echo e(lang_trans('txt_address')); ?></th>
                      <th><?php echo e(lang_trans('txt_dob')); ?></th>
                      <th><?php echo e(lang_trans('txt_action')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($val->name); ?></td>
                        <td><?php echo e($val->mobile); ?></td>
                        <td><?php echo e($val->email); ?></td>
                        <td><?php echo e($val->gender); ?></td>
                        <td><?php echo e($val->address); ?></td>
                        <td><?php echo e(date('d-m-Y', strtotime($val->dob))); ?> </td>
                        <td>
                          <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-customer',[$val->id])); ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-success" href="<?php echo e(route('view-customer',[$val->id])); ?>"><i class="fa fa-eye"></i></a>
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

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/new/Sourcecode/9aug/newpms/resources/views/backend/customers/list.blade.php ENDPATH**/ ?>