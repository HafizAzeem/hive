<?php $__env->startSection('content'); ?>
<?php
$i =1; $j = 0;
$k1=1;
$totalAmount = 0;

$type =  basename(request()->path());
?>

<div class="card">
    <div class="card-header">
        <span style="float:right;"><a href="<?php echo e(route('single-list-reservation')); ?>" class="btn btn<?php echo e($type=='single-list-reservation' ? '-success':''); ?>">Single Cheking</a>
            <a href="<?php echo e(route('multi-list-reservation')); ?>" class="btn btn<?php echo e($type=='multi-list-reservation' ? '-success':''); ?>">Multi-Cheking</a>
            <a href="<?php echo e(route('list-check-outs')); ?>" class="btn btn<?php echo e($type=='list-check-outs' ? '-success':''); ?>">All Check Out's</a>
            <!--<a href="" class="btn">All Check Out's</a>-->
        </span>
    </div>
</div>
<style>
    table.dataTable td:nth-child(5) {
        width: 120px;
        max-width: 120px;
        word-break: break-all;
        white-space: pre-line;
    }
</style>

<div class="">
    
    <?php if($list=='check_outs'): ?>
        <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2><?php echo e(lang_trans('heading_filter_checkouts')); ?></h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <?php echo e(Form::model($search_data,array('url'=>route('search-checkouts'),'id'=>"search-checkouts", 'class'=>"form-horizontal form-label-left"))); ?>

                <div class="form-group col-sm-2">
                  <label class="control-label"><?php echo e(lang_trans('txt_room_type')); ?></label>
                  <?php echo e(Form::select('room_type_id',$roomtypes_list,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])); ?>

                </div>
                <div class="form-group col-sm-2">
                  <label class="control-label"><?php echo e(lang_trans('txt_date_from')); ?></label>
                  <?php echo e(Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])); ?>

                </div>
                <div class="form-group col-sm-2">
                  <label class="control-label"><?php echo e(lang_trans('txt_date_to')); ?></label>
                  <?php echo e(Form::text('date_to',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_to')])); ?>

                </div>
                <div class="form-group col-sm-3">
                  <br/>
                   <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit"><?php echo e(lang_trans('btn_search')); ?></button>
                   <button class="btn btn-primary export-btn" name="submit_btn" value="export" type="submit"><?php echo e(lang_trans('btn_export')); ?></button>
                </div>
              <?php echo e(Form::close()); ?>

            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  
    <?php if($list=='check_ins'): ?>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo e(lang_trans('heading_checkin_list')); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th><?php echo e(lang_trans('txt_guest_name')); ?></th>
                        <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th><?php echo e(lang_trans('txt_room')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkin')); ?></th>
                        <th><?php echo e(lang_trans('txt_booking_amount')); ?></th>
                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                     
                      <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($val->room_num): ?>
                        <?php if($val->check_out==null): ?>
                        
                        <?php
                        $totalAmount +=$val->booking_payment;
                        ?>
                        <tr>
                          <td><?php echo e($i); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->name : 'NA'); ?></td>
                          <td><?php echo e(($val->customer) ? $val->customer->mobile : 'NA'); ?></td>
                          
                          <?php if($val->referred_by): ?>
                            <td><?php echo e($val->referred_by ?? ''); ?></td>
                          <?php else: ?>
                            <td><?php echo e($val->referred_by_name ?? ''); ?></td>
                          <?php endif; ?>
                          
                          <?php if($val->duration_of_stay == 1): ?>
                            <td><?php echo e($val->duration_of_stay ?? ''); ?> Day</td>
                          <?php else: ?>
                            <td><?php echo e($val->duration_of_stay ?? ''); ?> Days</td>
                          <?php endif; ?>
                          
                          <td>
                            <?php if(($val->room_type)): ?>
                              <?php echo e($val->room_type->title); ?><br/>
                              ( <?php echo e(lang_trans('txt_room_num')); ?> : <?php echo e($val->room_num); ?> )
                            <?php endif; ?>
                            </td>
                          <td><?php echo e(dateConvert($val->check_in,'d-m-Y H:i')); ?></td>
                          
                          <td>
                              <?php
                                if(isset($count_room))
                                {
                                    $room = explode(',', $val->room_num);
                                    $total_room = count($room);
                                    
                                    
                                    
                                    
                                    $booking_payment = $val->per_room_price;
                                    $total_room = $count_room;
                                }
                                else
                                {
                                
                                    $booking_payment = $val->booking_payment ;
                                }

                             
                              
                              ?>
                              
                               
                              
                          <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat( $booking_payment)); ?>

                          
                            <?php $unique_id=$val->unique_id; ?>
                          </td>
                          <td>
                            <a class="btn btn-sm btn-warning" href="<?php echo e(route('food-order',[$val->id])); ?>"><?php echo e(lang_trans('btn_food_order')); ?></i></a>
                            <a class="btn btn-sm btn-success" href="<?php echo e(route('view-reservation',[$val->id])); ?>"><?php echo e(lang_trans('btn_view')); ?></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('check-out-room',[$val->unique_id])); ?>"><?php echo e(lang_trans('btn_checkout')); ?></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo e(url('admin/edit-check-in/'.$val->unique_id)); ?>"><?php echo e(lang_trans('btn_checkin_edit')); ?></i></a>
                          </td>
                        </tr>
                        <?php endif; ?>
                        <?php endif; ?>
                        
                        
                        
                        <?php $i++; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>

                </div>
            </div>
        </div>
    </div>

    <?php elseif($list=='check_outs'): ?>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo e(lang_trans('heading_checkout_list')); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <!--<div class="row">-->
                    <!--    <div class="col-md-4">-->
                    <!--        <input type="text" name="from_date" id="from_date" class="form-control input-daterange" placeholder="From Date" />-->
                    <!--    </div>-->
                    <!--    <div class="col-md-4">-->
                    <!--        <input type="text" name="to_date" id="to_date" class="form-control input-daterange" placeholder="To Date" />-->
                    <!--    </div>-->
                    <!--    <div class="col-md-4">-->
                    <!--        <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>-->
                    <!--        <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <table id="datatable" class="table table-striped table-bordered data-table">
                    <thead>
                      <tr>
                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                        <th>And S.No.</th>
                        <th><?php echo e(lang_trans('txt_guest_name')); ?></th>
                        <th><?php echo e(lang_trans('txt_mobile_num')); ?></th>
                        <th>Email Id</th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th><?php echo e(lang_trans('txt_room')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkin')); ?></th>
                        <th><?php echo e(lang_trans('txt_checkout')); ?></th>
                        <th>Booking Amount (Rs.)</th>
                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                      </tr>
                    </thead>
                    <tbody>

                

                    </tbody>
                  </table>
                    
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.input-daterange').datepicker({
        todayBtn:'linked',
        format:'yyyy-mm-dd'
        // autoclose:true
    });

    load_data();
//   $(function () {

    function load_data(from_date = '', to_date = '')
    {
    
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'<?php echo e(route("list-check-outs")); ?>',
            data:{from_date:from_date, to_date:to_date}
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'and_number', name: 'and_number'},
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
            {data: "source",
                    "render": function (data, type, row) {
                    if ( row.refby === '') {
                        return row.source;
                    }
                    else {
                        return row.refby;
                    }
                }
            },
            {data: "duration",
                    "render": function (data, type, row) {
                    if ( row.duration == '1') {
                        
                        return row.duration +' Day';
                    }
                    else {
                        return row.duration +' Days';
                    }
                }
            },
            {data: "room_type_id",
                    "render": function (data, type, row) {
                    if ( row.room_type_id == '1') {
                        return 'DELUXE ROOM (Room No: ' + row.room_num +')';
                    }
                    else if(row.room_type_id == '2') {
                        return 'PREMIUM ROOM (Room No: ' + row.room_num +')';
                    }else{
                        return 'EXECUTIVE ROOM (Room No: ' + row.room_num +')';
                    }
                }
            },
            {data: 'check_in', name: 'check_in'},
            {data: 'check_out', name: 'check_out'},
            {data: 'booking_payment', name: 'booking_payment'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            
        ]
    });
    
    }
    
    $('#filter').click(function(){
          var from_date = $('#from_date').val();
          var to_date = $('#to_date').val();
          if(from_date != '' &&  to_date != '')
          {
           $('.data-table').DataTable().destroy();
           load_data(from_date, to_date);
          }
          else
          {
           alert('Both Date is required');
          }
    });

    $('#refresh').click(function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('.data-table').DataTable().destroy();
        load_data();
    });
    
//   });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/rooms/room_reservation_list.blade.php ENDPATH**/ ?>