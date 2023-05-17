<?php $__env->startSection('content'); ?>
<div class="">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal4">
                <i class="fa fa-upload btn-icon-prepend"></i> 
                Bulk Upload Food Items
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo e(lang_trans('heading_food_item_list')); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo e(lang_trans('txt_sno')); ?></th>
                                <th><?php echo e(lang_trans('txt_item_name')); ?></th>
                                <th><?php echo e(lang_trans('txt_price')); ?></th>
                                <th><?php echo e(lang_trans('txt_desc')); ?></th>
                                <th><?php echo e(lang_trans('txt_status')); ?></th>
                                <th><?php echo e(lang_trans('txt_action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($k+1); ?></td>
                                <td><?php echo e($val->name); ?></td>
                                <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->price); ?></td>
                                <td><?php echo $val->description; ?></td>
                                <td><?php echo getStatusBtn($val->status); ?></td>
                                <td>
                                  <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-food-item',[$val->id])); ?>"><i class="fa fa-pencil"></i></a>
                                  <button class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-food-item',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
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

<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Document Upload (In CSV)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo e(route('bulk-food-upload')); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Document:</label>
                        <input class="form-control"  name="excel" type="file" id="formFile" required>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/food_item_list.blade.php ENDPATH**/ ?>