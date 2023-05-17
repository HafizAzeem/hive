
<?php $__env->startSection('content'); ?>

<div class="">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Invoice Download</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post" action="<?php echo e(route('ta_report_action')); ?>">
                        <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Type</label>
                            <select class="form-control" id="type">
                                <option>--select--</option>
                                <option value="1">Corporates</option>
                                <option value="2">TA</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="display:none;" id="tas">
                             <label>Select TA</label>
                          <select class="form-control" name="tas">
                             
                              <option value=''>--select--</option>
                              <?php 
                               $tas=DB::table('tas')->get();
                               foreach($tas as $t)
                               {
                                   echo "<option value=".$t->id.">".$t->name."</option>";
                               }
                              ?>
                          </select>
                        </div>
                        
                        <div class="col-md-3" style="display:none;" id="corporates">
                             <label>Select Corporates</label>
                          <select class="form-control" name="corporates">
                             
                              <option value=''>--select--</option>
                              <?php 
                               $co=DB::table('corporates')->get();
                               foreach($co as $t1)
                               {
                                   echo "<option value=".$t1->id.">".$t1->name."</option>";
                               }
                              ?>
                          </select>
                        </div>
                        
                         <div class="col-md-3">
                          
                              <label>Start Date</label>
                              <input type="date" class="form-control" required name="start">
                         
                        </div>
                        
                         <div class="col-md-3">
                        
                             <label>End Date</label>
                             <input type="date" class="form-control" required name="end">
                         
                        </div>
                        
                        <div class="col-md-3"><button style="margin-top:25px" class="btn btn-info">Invoice</button></div>
                    </div>
                    </form>
                    
                   
                    
                   
                
                 
</div>
</div>




</div>
</div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
<script>
    $(document).ready(function() {
   $("#type").on('click',function(){
       var type=$(this).val();
       if(type=='2')
       {
           $("#tas").css('display','');
           $("#corporates").css('display','none');
       }else if(type=='1')
       {
           $("#corporates").css('display','');
            $("#tas").css('display','none');
       }
   })
} );
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/ta_report.blade.php ENDPATH**/ ?>