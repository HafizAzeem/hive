<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Budget Estimation Table</div>
                <div class="card-body">
                    <br/>
                    <form method="post" action="<?php echo e(route('save-budget')); ?>">
                    <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" class="form-control" name="idall">
                                <label>Budget Amount</label>
                                <input type="number" class="form-control" name="estimation">
                            </div>
                        </div>
                        <br/>
                        <button class="btn btn-info">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/budget/budgetforecast.blade.php ENDPATH**/ ?>