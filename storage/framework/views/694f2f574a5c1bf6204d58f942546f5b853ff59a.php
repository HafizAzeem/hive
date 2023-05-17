<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_list_permission')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <?php echo e(Form::open(array('url'=>route('save-permissions')))); ?>

              <div class="x_content">
                  <div class="col-md-12 text-right p-right-0">
                  <input type="submit" value="<?php echo e(lang_trans('btn_update')); ?>" class="btn btn-primary"/>
                </div>
                  <table id="datatable__" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center"><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th><?php echo e(lang_trans('txt_permission')); ?></th>
                        <th class="text-center"><?php echo e(lang_trans('txt_superadmin')); ?></th>
                        <th class="text-center"><?php echo e(lang_trans('txt_admin')); ?></th>
                        <th class="text-center"><?php echo e(lang_trans('txt_receptionist')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td class="text-center" width="10%"><?php echo e($k+1); ?></td>
                          <td><span class="f-15"><?php echo e($val->description); ?></span> <br/>
                              <span class="color-9e9"><?php echo e(lang_trans('txt_type')); ?>: <?php echo e(ucfirst($val->permission_type)); ?></span>
                            </td>
                          <td class="text-center" width="10%">
                            <?php echo e(Form::hidden('ids[]',$val->id)); ?>

                            <?php echo e(Form::checkbox('super_admin['.$val->id.']',null, ($val->super_admin==1) ? true: false,['class'=>"disable-checkbox"] )); ?>

                          </td>
                          <td class="text-center" width="10%"><?php echo e(Form::checkbox('admin['.$val->id.']',null, ($val->admin==1) ? true: false )); ?></td>
                          <td class="text-center" width="10%"><?php echo e(Form::checkbox('receptionist['.$val->id.']',null, ($val->receptionist==1) ? true: false )); ?></td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="col-md-12 text-right p-right-0">
                  <input type="submit" value="<?php echo e(lang_trans('btn_update')); ?>" class="btn btn-primary"/>
                </div>
              </div>
              <?php echo e(Form::close()); ?>

          </div>
      </div>
  </div>
</div>        
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/permissions/list.blade.php ENDPATH**/ ?>