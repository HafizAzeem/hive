

<?php $__env->startSection('content'); ?>
<?php 
    $roomnumb = session()->get('roomno');
    $rnumber = 'menu/'.$roomnumb;
?>
<style>
    .mtnclsthank{
        margin-top: 8%;
    }
    @media  only screen and (max-width: 600px) {
        .mtnclsthank{
            margin-top: 25%;
        }
    }
    
</style>
<input type="hidden" name="roomnumberdj" id="roomnumberdj" value="<?php echo e($roomnumb); ?>">
<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12 mtnclsthank">
            <article class="bg-secondary mb-3">  
                <div class="card-body text-center">
                    <br><br>
                    <h3>Thank You for Being Our Valued Customer.</h3>
                    <h3>We Are Preparing Your Food Order Please Wait.</h3>
                    <p>
                        <a class="btn btn-warning" href="<?php echo e($rnumber); ?>"> Order Again </a>
                    </p>
                </div>
                <br><br><br>
            </article>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend_order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/ordermenu/thankyou.blade.php ENDPATH**/ ?>