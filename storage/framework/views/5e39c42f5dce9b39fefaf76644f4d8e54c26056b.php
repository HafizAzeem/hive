
<?php $__env->startSection('content'); ?>

<div class="">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Outlet</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post" action="<?php echo e(route('outlet_action')); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <?php echo csrf_field(); ?>
                            <input type="text" class="form-control" required name="outlet">
                        </div>
                        <div class="col-md-3"><button class="btn btn-info">Add</button></div>
                    </div>
                    </form>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>S.No</th>
                            <th>Title</th>
                            <th>Created At</th>
                           
                        </tr>
                       <?php $i=1; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i++); ?></td>
                            <td><?php echo e($value->name); ?></td>
                            <td><?php echo e($value->created_at); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                
                 
</div>
</div>


  <div class="x_panel">
                <div class="x_title">
                    <h2>Payment Remark</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post" action="<?php echo e(route('remark_action')); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <?php echo csrf_field(); ?>
                            <input type="text" class="form-control" required name="title">
                        </div>
                        <div class="col-md-3"><button class="btn btn-info">Add</button></div>
                    </div>
                    </form>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>S.No</th>
                            <th>Title</th>
                            <th>Created At</th>
                           
                        </tr>
                       <?php $i=1; ?>
                        <?php $__currentLoopData = $remark; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i++); ?></td>
                            <td><?php echo e($v->title); ?></td>
                            <td><?php echo e($v->created_at); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                
                 
</div>
</div>




</div>
</div></div>
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
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/outlet.blade.php ENDPATH**/ ?>