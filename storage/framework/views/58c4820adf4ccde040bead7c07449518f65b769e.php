<?php $__env->startSection('content'); ?>
<?php 
$i = $j = 0; 
$totalAmount = 0;
?>
<div class="">

  
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Room Inventory</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?php $dtPart2 = date('Y-m-d'); ?>
                    <!-- Sort By : <input type="text" name="sortDate" id="min" placeholder="Date"/> -->
                    <div class="col-md-3 col-xs-3">
                    <label class="control-label"> Sort Date<span class="required">*</span></label>
                     <?php echo e(Form::date('min', $dtPart2,['class'=>"datePickerDefault ", "id"=>"min", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])); ?>

                    </div>
                    
                    <br/>
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th>Room Number</th>
                        <th>Status</th>
                        <th>Referred By</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $i=0;?>
                      <?php $__currentLoopData = $booked_rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $books): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e(++$i); ?></td>
                          <td> <?php echo e($books["room_num"]); ?> </td>
                          <?php if($books["status"] == 'Booked'): ?>
                            <td><span class="btn btn-xs btn-cust"><?php echo e($books["status"]); ?></span></td>
                          <?php elseif($books["status"] == 'Available'): ?>
                            <td><span class="btn btn-xs btn-success"><?php echo e($books["status"]); ?></span></td>
                          <?php else: ?>
                          <td><span class="btn btn-xs btn-info"><?php echo e($books["status"]); ?></span></td>
                          <?php endif; ?>
                          <td><?php echo e($books["referred_by_name"]); ?></td>
                          
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
   
</div>          
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
<script>
$(document).ready(function() {
    
  // $('#min').datepicker({
  //   startDate: '-0d'
  // });
        
  $('#datatable').DataTable( {
      dom: 'Bfrtip',
      buttons: [
          'excel', 'pdf'
          
      ]
  } );

  $(document).on('change', '#min',  function (){
    var date = $("#min").val();
    $('#datatable').DataTable().destroy();
    $.ajax({
        url: "/get-filtered-room-data",
        type: "get",
        data : {"sortDate" : date},
        dataType: 'json',
        success: function(response) {
          $('#datatable').DataTable( {
            "draw": 1,
            "paging": true,
            "ordering" : true,
            buttons: [
                'excel', 'pdf'
                
            ],
            
            "data": response
            
          } );
        }
    });

    
    
  

    
    
 });
    
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/newpms/resources/views/backend/room_inventory_list.blade.php ENDPATH**/ ?>