<?php $__env->startSection('css'); ?>
<style>
    table, th, td {
  border: 1px solid black;
}

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php

$i = $j = 0;
$totalAmount = 0;
?>
<div class="">


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 dl_rp_div">
            <div class="x_panel x_panel_dailyreport">
                <div class="x_title">
                    <h2>Daily Report</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content ">
                <?php $dtPart2 = date('Y-m-d'); ?>
                <div class="col-md-2 col-xs-2">
                    <label class="control-label"> Start Date<span class=""></span></label>
                     <?php echo e(Form::date('min', $dtPart2,['class'=>"datePickerDefault ", "id"=>"min", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])); ?>

                </div>
                <div class="col-md-2 col-xs-2">
                    <label class="control-label"> End Date<span class=""></span></label>
                     <?php echo e(Form::date('max', $dtPart2,['class'=>"datePickerDefault ", "id"=>"max", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])); ?>

                </div>
                <div class="col-md-2 col-xs-2">
                <label class="control-label"> Range Filter<span class=""></span></label>
                <select id="week_filter">
                    <option Value="">Select Option</option>
                    <option Value="this_week">This week</option>
                    <option Value="previous_week">Previous Week</option>
                    <option Value="this_month">This Month</option>
                    <option Value="previous_month">Previous Month</option>
                </select>
                </div>
                    <br/>
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <th>Date  </th>
                            <!-- <th>Total Corporates </th> -->
                            <th>No Show </th>
                            <th>Management</th>
                            <!-- <th>Total Tas </th>
                            <th>Total Otas</th>-->
                            <th>Total Fit </th> 
                            <th>Total Checkouts </th>
                            <th>Total Check In`s</th>
                            <th>Total Rooms </th>
                            <th>Occuppied Rooms</th>
                            <th>Total Users </th>
                            <th>Continue Rooms </th>
                            <!--<th>Upcomming </th>-->
                            <th>Total Payments </th>
                            <th>Daily Expenses</th>
                            <?php $__currentLoopData = $paymentmode_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($pay_list->payment_mode); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $corporate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corporate_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($corporate_list->name); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            <?php $__currentLoopData = $ta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($ta_list->name); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $ota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ota_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($ota_list->name); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(date('y-m-d')); ?> </td>
                                <!-- <td><?php echo e($val->corporate_count); ?></td> -->
                                <td><?php echo e($val->noShow); ?></td>
                                <td><?php echo e($val->police); ?></td>
                                <!-- <td><?php echo e($val->ta_count); ?></td>
                                <td><?php echo e($val->ota_count); ?></td>-->
                                <td><?php echo e($val->fit_count); ?></td> 
                                <td><?php echo e($val->total_check_outs); ?></td>
                                <td><?php echo e($val->total_check_ins); ?></td>
                                <td><?php echo e($val->room_count); ?></td>
                                <td><?php echo e($val->occupied_rooms); ?></td>
                                <td><?php echo e($val->user_count); ?></td>
                                <td><?php echo e($val->Continue1); ?></td>
                                <!--<td><?php echo e($val->comming); ?></td>-->
                                <td><?php echo e($val->total_payment); ?></td>
                                <td><?php echo e($val->total_expense); ?></td>
                                <?php $__currentLoopData = $paymentmode_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $data = get_payment_mode_data($pay_list->payment_mode) ?>
                                    <td><?php echo e($data); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                 <?php $__currentLoopData = $corporate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corporate_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 
                                    <td></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $ta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 
                                 <td></td>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php $__currentLoopData = $ota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ota_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 
                                 <td></td>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


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
    var start_date;var end_date;
    $(document).ready(function() {
    $('#datatable').DataTable( {
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
                'excel',
                'print'
        ]
    } );
    $(document).on('change', '#min',  function (){
        start_date = $("#min").val();
        $('#datatable').DataTable().destroy();
        $.ajax({
            url: "/get-filtered-report-data",
            type: "get",
            data : {"sortDate" : start_date, "source" : "date"},
            dataType: 'json',
            success: function(response) {
            $('#datatable').DataTable( {
                "draw": 1,
                "paging": false,
                "ordering" : true,
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'

                ],

                "data": response

            } );
            }
        });
    });
    $(document).on('change', '#max',  function (){
        start_date = $("#min").val();
        end_date = $("#max").val();
        $('#datatable').DataTable().destroy();
        $.ajax({
            url: "/get-filtered-report-data",
            type: "get",
            data : {"start_date" : start_date, "end_date" : end_date, "source" : "dateRange"},
            dataType: 'json',
            success: function(response) {
            $('#datatable').DataTable( {
                "draw": 1,
                "paging": false,
                "ordering" : true,
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'

                ],

                "data": response

            } );
            }
        });
    });
    $(document).on('change', '#week_filter',  function (){
        var week = $("#week_filter").val();
        $('#datatable').DataTable().destroy();
        $.ajax({
            url: "/get-filtered-report-data",
            type: "get",
            data : {"sortDate" : week, "source" : "weekly"},
            dataType: 'json',
            success: function(response) {
            $('#datatable').DataTable( {
                "draw": 1,
                "paging": false,
                "ordering" : true,
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'

                ],

                "data": response

            } );
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/demo.collabr8.in/newpms/resources/views/backend/dailyReport.blade.php ENDPATH**/ ?>