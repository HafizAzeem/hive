

                  <table class="table table-bordered">
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        
                      Total Checkouts ...................<?php echo e($val->total_check_outs); ?></tr><br>
                        <tr>Total Check In`s ..............<?php echo e($val->total_check_ins); ?></tr><br>
                        <tr>Total Rooms ...................<?php echo e($val->room_count); ?></tr><br>
                        <tr>Occuppied Rooms.................<?php echo e($val->occupied_rooms); ?></tr><br>
                        <tr>Total Users ....................<?php echo e($val->user_count); ?></tr><br>
                        <tr>Total Payments ....................<?php echo e($val->total_payment); ?></tr><br>
                        <tr>Total Corporates ....................<?php echo e($val->corporate_count); ?></tr><br>
                        <tr>Total Tas ....................<?php echo e($val->ta_count); ?></tr><br>
                        <tr>Total Otas ....................<?php echo e($val->ota_count); ?></tr><br>
                        <tr>Total Fit ....................<?php echo e($val->fit_count); ?></tr><br>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
<?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/new_report.blade.php ENDPATH**/ ?>