
<?php $__env->startSection('content'); ?>
<?php 
$i = $j = 0; 
$totalAmount = 0;
?>
<div class="">

  <?php if($list=='check_ins'): ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Meal Plan List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th>Name</th>
                        <th>Included Meals</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                        <tr>
                            <td><?php echo e(++$k); ?></td>
                         <td> 
                            <?php echo e($val->name); ?> 
                            </td>
                            <td> 
                            <?php echo e($val->included_meal); ?> 
                            </td>
                            
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>          
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
<script>
    $(document).ready(function() {
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
            
        ]
    } );
} );
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp-7-4\htdocs\hive\resources\views/backend/rooms/mealpackage.blade.php ENDPATH**/ ?>