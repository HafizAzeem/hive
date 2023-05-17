<table class="table table-bordered">
  <thead>
    <tr>
      <th><?php echo e(lang_trans('txt_sno')); ?></th>
      <th><?php echo e(lang_trans('txt_category')); ?></th>
      <th><?php echo e(lang_trans('txt_title')); ?></th>
      <th><?php echo e(lang_trans('txt_amount')); ?></th>
      <th><?php echo e(lang_trans('txt_date')); ?></th>
      <th><?php echo e(lang_trans('txt_remark')); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php if($datalist->count()>0): ?>
    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($k+1); ?></td>
        <td><?php echo e($val->category->name); ?></td>
        <td><?php echo e($val->title); ?></td>
        <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->amount); ?></td>
        <td><?php echo e(dateConvert($val->datetime,'d-m-Y')); ?></td>
        <td><?php echo e($val->remark); ?></td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  </tbody>
</table><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/excel_view/expense_excel.blade.php ENDPATH**/ ?>