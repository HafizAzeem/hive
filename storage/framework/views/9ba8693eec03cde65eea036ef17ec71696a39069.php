<?php $__env->startSection('content'); ?>
<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2><?php echo e(lang_trans('heading_filter_expense')); ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo e(Form::model($search_data,array('url'=>route('search-expenses'),'id'=>"search-expense", 'class'=>"form-horizontal form-label-left"))); ?>

              <div class="form-group col-sm-3">
                <label class="control-label"> <?php echo e(lang_trans('txt_category')); ?></label>
                <?php echo e(Form::select('category_id',$category_list,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])); ?>

              </div>
              <div class="form-group col-sm-2">
                <label class="control-label"> <?php echo e(lang_trans('txt_date_from')); ?></label>
                <?php echo e(Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])); ?>

              </div>
              <div class="form-group col-sm-2">
                <label class="control-label"> <?php echo e(lang_trans('txt_date_to')); ?></label>
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
                  <h2><?php echo e(lang_trans('heading_expense_list')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php
                    $totalAmount = 0;
                  ?>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo e(lang_trans('txt_sno')); ?></th>
                      <th><?php echo e(lang_trans('txt_category')); ?></th>
                      <th><?php echo e(lang_trans('txt_title')); ?></th>
                      <th><?php echo e(lang_trans('txt_amount')); ?></th>
                      <th><?php echo e(lang_trans('txt_date')); ?></th>
                      <th><?php echo e(lang_trans('txt_remark')); ?></th>
                      <th><?php echo e(lang_trans('txt_action')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                        $totalAmount = $totalAmount+$val->amount;
                      ?>
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($val->category->name); ?></td>
                        <td><?php echo e($val->title); ?></td>
                        <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->amount); ?></td>
                        <td><?php echo e(dateConvert($val->datetime,'d-m-Y')); ?></td>
                        <td><?php echo e($val->remark); ?></td>
                        <td>
                          <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-expense',[$val->id])); ?>"><i class="fa fa-pencil"></i></a>
                          <button class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-expense',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
                <table class="table table-striped table-bordered">
                    <tr>
                      <th class="text-right" width="50%"><?php echo e(lang_trans('txt_grand_total')); ?></th>
                      <th width="50%"><b><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalAmount)); ?></b></th>
                    </tr>
                </table>
              </div>
          </div>
      </div>
  </div>
</div>          
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/expenses/list.blade.php ENDPATH**/ ?>