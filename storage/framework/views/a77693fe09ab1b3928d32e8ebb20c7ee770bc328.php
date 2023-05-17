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
                      <th>Title</th>
                      <th>Payment</th>
                      <th>Expenses</th>
                      <th>Revenue</th>
                      <!--<th>Mode</th>-->
                      <th>Remark</th>
                      <th>Date</th>
                      
                      <th>Update</th>
                    </tr>
                  </thead>
                 

                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($val->title); ?></td>
                        <td>
                            <?php echo e($val->payment); ?><br>
                            <?php $suml=0; ?> 
                            <?php $__currentLoopData = $breakerrevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($val->reservations_id == $berr->reservations_id): ?>
                                    <span>
                                    -<?php echo e($berr->payment); ?>(<?php echo e($berr->remark); ?>)
                                    </span><br>
                                    <?php $suml += $berr->payment; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td><?php echo e($suml); ?></td>
            
                        <td><?php echo e($val->payment - $suml); ?></td>
                        
                        <td><?php echo e($val->remark); ?></td>
                        <td><?php echo e($val->payment_date); ?></td>
                            
                        <td>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-revenue',[$val->id])); ?>"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-extrarevenue',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
                            <!--<div class="col-md-1">-->
                                <!--<button type="button" onclick="plus()" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>-->
                            <!--</div>-->
                        </td>
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

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/extrarevenue/extra_revenue_list.blade.php ENDPATH**/ ?>