<?php $__env->startSection('content'); ?>

<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo e(lang_trans('heading_guest_info')); ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                      <table class="table table-bordered">
                          <tr>
                            <th><?php echo e(lang_trans('txt_fullname')); ?></th>
                            <td><?php echo e($data_row->name); ?></td>
                            <th><?php echo e(lang_trans('txt_email')); ?></th>
                            <td><?php echo e($data_row->email); ?></td>
                          </tr>
                          <tr>

                            <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                            <td><?php echo e($data_row->mobile); ?></td>
                             <th><?php echo e(lang_trans('txt_age')); ?></th>
                            <td><?php echo e(date('d-m-Y', strtotime($data_row->dob))); ?></td>
                          </tr>
                          <tr>
                            <th><?php echo e(lang_trans('txt_gender')); ?></th>
                            <td><?php echo e($data_row->gender); ?></td>

                            <th>Age</th>
                            <td><?php echo e($data_row->age); ?> <?php echo e(lang_trans('txt_years')); ?></td>

                          </tr>


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

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/customers/view.blade.php ENDPATH**/ ?>