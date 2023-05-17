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
                        <th>SRN</th>
                        <th>Name</th>
                      <th>Action</th>
                      <th>Log Date</th>
                      <th>Uri</th>
                       <th>Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <?php $user=App\User::find($val->user_id); ?> 
                        <td><?php echo e($k+1); ?></td> 
                        <th><?php echo e($user->name ?? null); ?></th>
                        <td><?php echo e($val->action_as); ?></td>
                        <td><?php echo e($val->log_date); ?></td>
                        <td><?php echo e($val->uri); ?></td>
                          <td><?php echo e($val->created_at); ?></td>
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
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/activities.blade.php ENDPATH**/ ?>