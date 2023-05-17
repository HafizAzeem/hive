
<?php $__env->startSection('css'); ?>
<style>
    table, th, td {
  border: 1px solid black;
}

</style>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                 <div class="col-md-2 col-xs-2">
                    <label class="control-label"> <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Upload Excel Sheet (In CSV)</button></span></label>
                     <!--<input type="file" class="" accept=".csv">-->
                </div>
                    <table id="example" class="display nowrap table table-striped table-bordered" width="100%">
                        <thead>
                            <th>Booking ID </th>
                            <th>Guest Name </th>
                            <th>Reconciliation status</th>
                            <th>Booking Status</th> 
                            <th>Booking Type(Reason)</th>
                            <th>Recon Month</th>
                            <th>Checkin</th>
                            <th>Checkout</th>
                            <th>No of Nights</th>
                            <th>No of Rooms</th>
                            <th>Per Room Price</th>
                            <th>Booking Amount (Cost price)</th>
                            <th>Booking Amount (Booking Source Cost)</th>
                            <th>Booking Amount (On check out basis)</th>
                            <th>Revenue from  Bills (ECI/LCO)</th>
                            <th>Revenue from  Meals</th>
                            <th>Net share</th>
                            <th>Tax on  commissions</th>
                            <th>Net Hotel share payable post tax</th>
                            <th>TDS amount u/s 194-O</th>
                            <th>TDS Deducted on Buy-Sell Booking</th>
                            <th>TCS (CGST + SGST)</th>
                            <th>Guest  Mobile</th>
                            <th>Guest Email</th>
                            <th>Guest Gender</th>
                            <th>Guest DOB</th>
                            <th>Guest Address </th>
                            <th> hotel </th>
                            <th> Hotel Location </th>
                            <th> Hotel Star Category </th>
                            <th> Booking Date </th>
                            <th> Booking Time </th>
                            <th> Check in Date Time </th>
                            <th> Check Out Date Time </th>
                            <th> adults </th>
                            <th> children </th>
                            <th> chlid age </th>
                            <th> infant </th>
                            <th> meal </th>
                            <th> Hotel City </th>
                            <th> Market_segment </th>
                            <th> Source_Details </th>
                            <th> Repeated Booking </th>
                            <th> previous_cancellations </th>
                            <th> previous_bookings_not_canceled </th>
                            <th> reserved_room_type </th>
                            <th> actual_assigned_room_type </th>
                            <th> booking_changes_count </th>
                            <th> Booking_Type </th>
                            <th> Payment Mode </th>
                            <th> Payment_status </th>
                            <th> total_of_special_requests </th>
                            <th> Special_Requests_if_any </th>
                            <th> Actual_Reservation_status </th>
                            <th> reservation_status_date  </th>
                            <th> Average Duration Spend in Room(In a Day) </th>
                            <th> Discount </th>
                            <th> Promocode </th>
                            <th> Promocode_Details </th>
                            <th> Is_Package_Deal </th>
                            <th> Availed Services </th>
                            <th> Availed Services Details </th>
                            <th> Guest Feedback </th>
                            <th> Hotel Facilities </th>
                            <th> Room Amenties </th>
                            <th> Hotel reviews </th>
                            <th> car_parking_spaces </th>
                            <th> Booking Device </th>
                            <th> Employee Check In name </th>
                            <th> Employee Check out name </th>
                        </thead>
                        <tbody id="bod">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Excel Sheet (In CSV)</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo e(url('/UploadFile')); ?>" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            
            <input id="fileupload" type="file" name="csv" accept=".csv">
            
            <button type="submit" class="btn btn-warning">Upload</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
<script>
    var start_date;var end_date;
    
    function check()
    {
        console.log(document.getElementById("fileupload").value);
    }
    
    
    
    
$(document).ready(function() {
  


$(document).on('change', '#min',  function (){
    start_date = $("#min").val();
    $('#example').DataTable().destroy();
    $.ajax({
        url: "/get-report-data",
        type: "get",
        data : {"sortDate" : start_date, "source" : "date"},
        success: function(response) {
            document.getElementById("bod").innerHTML= response;
            $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: 'Customized PDF Title',
                filename: 'customized_print_file_name'
                }, {
                extend: 'excel',
                title: 'Customized EXCEL Title',
                filename: 'customized_excel_file_name'
                }]
            });
        }
    });
         
});



 $(document).on('change', '#max',  function (){
        start_date = $("#min").val();
        end_date = $("#max").val();
        $('#datatable').DataTable().destroy();
        $.ajax({
            url: "/get-report-data",
            type: "get",
            data : {"start_date" : start_date, "end_date" : end_date, "source" : "dateRange"},
            success: function(response) {
            document.getElementById("bod").innerHTML= response;
            $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                title: 'Customized PDF Title',
                filename: 'customized_print_file_name'
                }, {
                extend: 'excel',
                title: 'Customized EXCEL Title',
                filename: 'customized_excel_file_name'
                }]
            });
            }
        });
    });
    $(document).on('change', '#week_filter',  function (){
        var week = $("#week_filter").val();
        $('#datatable').DataTable().destroy();
        $.ajax({
            url: "/get-report-data",
            type: "get",
            data : {"sortDate" : week, "source" : "weekly"},
            success: function(response) {
           document.getElementById("bod").innerHTML= response;
            $('#example').DataTable({
             buttons: [{
                extend: 'print',
                title: 'Customized PDF Title',
                filename: 'customized_print_file_name'
                }, {
                extend: 'excel',
                title: 'Customized EXCEL Title',
                filename: 'customized_excel_file_name'
                }]
            });
            }
        });
    });




























});













</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/reportExcel.blade.php ENDPATH**/ ?>