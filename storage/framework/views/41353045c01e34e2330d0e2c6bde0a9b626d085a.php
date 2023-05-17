<table class="table table-bordered">                            
 <thead>
      <tr>
        <th>S.No</th>
        <th>Room</th>
        <th>Check In</th>
        <th>Check Out</th>
        
       
        
        <th>Total Amount</th>
        <th>Guest Name</th>
       
        <th>Guest Mobile</th>
        <th>Guest Email</th>
        <th>Guest Gender</th>
        <th>Guest Age</th>
        <th>Guest Address</th>
        <th>Duration of Stay</th>
        <th>Total Persons</th>
        <th>Adult/Kids</th>
        <th>ID Card Type</th>
        <th>ID Card Number</th>
        
        
        <th>Payment Mode</th>
        
        
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
            $calc = calcFinalAmount($val);
        ?>
        <tr>
          <td><?php echo e($key+1); ?></td>
          <td>
            <?php if(($val->room_type)): ?> 
              <?php echo e($val->room_type->title); ?><br/>
              ( Room No. : <?php echo e($val->room_num); ?> )
            <?php endif; ?>
            </td>
          <td><?php echo e(dateConvert($val->check_in,'d-m-Y H:i')); ?></td>
          <td><?php echo e(dateConvert($val->check_out,'d-m-Y H:i')); ?></td>
        <td><?php echo e(numberFormat($calc['finalRoomAmount']+$calc['finalOrderAmount'])); ?></td>
          <td><?php echo e($val->customer->name); ?></td>
         
          <td><?php echo e(($val->customer) ? $val->customer->mobile : 'NA'); ?></td>
          <td><?php echo e(($val->customer) ? $val->customer->email : 'NA'); ?></td>
          <td><?php echo e(($val->customer) ? $val->customer->gender : 'NA'); ?></td>
          <td><?php echo e(($val->customer) ? $val->customer->age : 'NA'); ?></td>
          <td><?php echo e($val->customer->address); ?>, <?php echo e($val->customer->city); ?>, <?php echo e($val->customer->state); ?>, <?php echo e($val->customer->country); ?></td>
          <td><?php echo e($val->duration_of_stay); ?></td>
          <td><?php echo e($val->persons->count()); ?></td>
          <td><?php echo e($val->adult); ?>/<?php echo e($val->kids); ?></td>
          <td><?php echo e($val->idcard_type); ?></td>
          <td><?php echo e($val->idcard_no); ?></td>
         
          
          
          <td><?php echo e(@config('constants.PAYMENT_MODES')[$val->payment_mode]); ?></td>
          
        </tr>
      
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/excel_view/reports_excel.blade.php ENDPATH**/ ?>