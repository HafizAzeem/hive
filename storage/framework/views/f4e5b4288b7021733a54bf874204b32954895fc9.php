<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php echo e(session('success')); ?>

    </div>
<?php elseif(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php echo e(session('error')); ?>

    </div>
<?php elseif(session('info')): ?>
    <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php echo e(session('info')); ?>

    </div>
<?php endif; ?>
<?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/layouts/flash_msg.blade.php ENDPATH**/ ?>