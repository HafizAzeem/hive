

<?php $__env->startSection('content'); ?>
<div class="qwe">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Budget Forecast Chart</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Property</th>
                      <th>Revenue Target</th>
                      <th>Till-Date</th>
                      <th>Actual Revenue</th>
                      <th>Average</th>
                      <th>Days Month</th>
                      <th>Forecast Month</th>
                      <th>Zone</th>
                    </tr>
                  </thead>
                 

                  <!--<tbody>-->
                    
                  <!--</tbody>-->
                  
    <tbody>
        <?php  $k = 0;     ?>
        <?php if(isset($arrReturn)): ?>
            <?php $__currentLoopData = $arrReturn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vhf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $vhf['budget']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php 
                    if(!empty($vh->budgetestimate)){
                    ?>

                    <?php if(round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate) >= 100 ): ?>
                        <tr class="mygreen">
                            <td><?php echo e($k+1); ?></td>
                            <td><?php echo e($vh->title); ?></td>
                            <td><?php echo e($vh->budgetestimate); ?></td>
                            <td><?php echo e($vhf['today']); ?></td>
                            <td><?php echo e($vhf['actualmr']); ?></td>
                            <td><?php echo e(round($vhf['actualmr']/$vhf['today'])); ?></td>
                            <td><?php echo e($vhf['DaysInCurrentMonth']); ?></td>
                            <td><?php echo e(round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']); ?></td>
                            <td style="background-color: green;color: white;"><?php echo e(round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate)); ?>%</td>
                        </tr>    
                    <?php elseif(round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate) > 80 && round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate) < 100 ): ?>
                        <tr class="myyellow">    
                            <td><?php echo e($k+1); ?></td>
                            <td><?php echo e($vh->title); ?></td>
                            <td><?php echo e($vh->budgetestimate); ?></td>
                            <td><?php echo e($vhf['today']); ?></td>
                            <td><?php echo e($vhf['actualmr']); ?></td>
                            <td><?php echo e(round($vhf['actualmr']/$vhf['today'])); ?></td>
                            <td><?php echo e($vhf['DaysInCurrentMonth']); ?></td>
                            <td><?php echo e(round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']); ?></td>
                            <td style="background-color: yellow;color: black;"><?php echo e(round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate)); ?>%</td>
                        </tr>
                    <?php else: ?>
                        <tr class="myred">    
                            <td><?php echo e($k+1); ?></td>
                            <td><?php echo e($vh->title); ?></td>
                            <td><?php echo e($vh->budgetestimate); ?></td>
                            <td><?php echo e($vhf['today']); ?></td>
                            <td><?php echo e($vhf['actualmr']); ?></td>
                            <td><?php echo e(round($vhf['actualmr']/$vhf['today'])); ?></td>
                            <td><?php echo e($vhf['DaysInCurrentMonth']); ?></td>
                            <td><?php echo e(round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']); ?></td>
                            <td style="background-color: red;color: white;"><?php echo e(round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate)); ?>%</td>
                        </tr>
                    <?php endif; ?>
                    <?php 
                    }
                    ?>
                        
                    <?php  $k++; ?>
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
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
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/budget/budget_chart.blade.php ENDPATH**/ ?>