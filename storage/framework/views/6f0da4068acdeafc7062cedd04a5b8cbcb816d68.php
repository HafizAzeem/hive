

<?php $__env->startSection('content'); ?>
<div class="qwe">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('txt_list_users')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Property</th>
                      <th>Budget-Month</th>
                      <th>Till-Date</th>
                      <th>Actual Revenue</th>
                      <th>Average</th>
                      <th>Days Month</th>
                      <th>Forecast Month</th>
                      <th>Zone</th>
                    </tr>
                  </thead>
                 

                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($k+1); ?></td>
                            <td><?php echo e($val->title); ?></td>
                            <td><?php echo e($val->budgetestimate); ?></td>
                            <td><?php echo e($today); ?></td>
                            <td><?php echo e($actualmr); ?></td>
                            <td><?php echo e($average); ?></td>
                            <td><?php echo e($DaysInCurrentMonth); ?></td>
                            <td><?php echo e($forecast); ?></td>
                            
                            <?php if(round($forecast *100 / $val->budgetestimate) >= 100 ): ?>
                                <td style="background-color: green;color: white;"><?php echo e(round($forecast *100 / $val->budgetestimate)); ?>%</td>
                            <?php elseif(round($forecast *100 / $val->budgetestimate) > 80 && round($forecast *100 / $val->budgetestimate) < 100 ): ?>
                                <td style="background-color: yellow;color: black;"><?php echo e(round($forecast *100 / $val->budgetestimate)); ?>%</td>
                            <?php else: ?>
                                <td style="background-color: red;color: white;"><?php echo e(round($forecast *100 / $val->budgetestimate)); ?>%</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                  </tbody>
                  
                  
                 
                </table>
                
              </div>
                                
          </div>
      </div>
  </div>
</div>     
            
                        
<script>
    // let id=1;
    // function plus()
    // {
    //   $("#remove"+id).show();
    //   id++;
    //   console.log(id)
    // }

    // function remove_addon(id)
    // {
    //     $("#remove"+id).remove();
    // }
</script>                
                                
                                    


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/budget/budget_chart.blade.php ENDPATH**/ ?>