<?php $__env->startSection('rightColContent'); ?>
<?php

    $settings = getSettings();
    $gst_0 = $settings['gst_0'];
    $cgst_0 = $settings['cgst_0'];

    $gst = $settings['gst'];
    $cgst = $settings['cgst'];

    $gst_1 = $settings['gst_1'];
    $cgst_1 = $settings['cgst_1'];

    $c=1;
    $arr = [];
    $arr1 = [];

    foreach($payment_today as $vals)
    {
        if($vals->payment_mode != "")
        {
            $arr[]= $vals->payment_mode;
        }
        if($vals->sec_payment_mode != "")
        {
            $arr[]= $vals->sec_payment_mode;
        }
        if($vals->third_payment_mode != "")
        {
            $arr[]= $vals->third_payment_mode;
        }
        if($vals->fourth_payment_mode != "")
        {
            $arr[]= $vals->fourth_payment_mode;
        }
        if($vals->fifth_payment_mode != "")
        {
            $arr[]= $vals->fifth_payment_mode;
        }
        if($vals->sixth_payment_mode != "")
        {
            $arr[]= $vals->sixth_payment_mode;
        }
        if($vals->sixth_payment_mode != "")
        {
            $arr[]= $vals->sixth_payment_mode;
        }
    }

    $count = array_count_values($arr);

    foreach($revenue_today as $val1)
    {
        if($val1->referred_by_name == "OTA")
        {
            $arr1[]= $val1->referred_by;
        }
        if($val1->referred_by_name == "TA")
        {
            $arr1[]= $val1->referred_by;
        }
        if($val1->referred_by_name == "Corporate")
        {
            $arr1[]= $val1->referred_by;
        }
        if($val1->referred_by_name == "F9")
        {
            $arr1[]= $val1->referred_by_name;
        } 
        if($val1->referred_by_name == "Management")
        {
            $arr1[]= $val1->referred_by_name;
        } 
    }
    $count1 = array_count_values($arr1);

?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .pmain{
        color: red;
        font-size: 18px;
    }
    .rforder {
        font-size: 18px;
        color: #73879C !important;
        font-weight: 500;
    }
    .roomordermsg {
        margin-left: 20px !important;
        color: #46ab4a !important;
        /*background: red;*/
        /*padding: 6px 15px;*/
        font-size: 16px;
        /*line-height: 26px;*/
    }
    .spcolnj{
        color: #73879C !important;
    }
    .btnmrodrop{
        margin-right: 0;
    }
    
    @media  screen and (max-width: 480px) {
        .jnewtab tr{
            display: grid;
            grid-template-columns: repeat(5, 1fr);
        }
        .jnewwidth{
            width: 100%;
        }
    }
</style>
    <h3><b><?php echo e(getSettings('hotel_name')); ?></b></h3>
        <div class="row top_tiles"id="hide1">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-caret-square-o-right"></i>
                    </div>
                    <div class="count"><?php echo e($counts[0]->today_check_ins); ?></div>
                    <h3><a href="<?php echo e(route('list-reservation')); ?>"><?php echo e(lang_trans('txt_today_checkin')); ?></a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-comments-o"></i>
                    </div>
                    <div class="count"><?php echo e($counts[0]->today_check_outs); ?></div>
                    <h3><a href="<?php echo e(route('list-check-outs')); ?>"><?php echo e(lang_trans('txt_today_checkout')); ?></a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <?php if(isset($perc_room)): ?>
                      <div class="count"><?php echo e($perc_room); ?> % <span style="font-size: 20px;color: darkgrey;">(<?php echo e($occupied_rooms); ?>/<?php echo e($total_rooms); ?>)</span></div>
                      <?php else: ?>
                      <div class="count">0 %</div>
                      <?php endif; ?>
                      
                    <h3><a href="javascript:void(0);">Today Occupancy</a></h3>

                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <?php if($payment_today1): ?>
                      <div class="count"><?php echo e($payment_today1); ?> </div>
                      <?php else: ?>
                      <div class="count">0</div>
                      <?php endif; ?>
                    <h3><a href="javascript:void(0);"><?php echo e(lang_trans('txt_today_revenue')); ?></a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <?php if($total_expense): ?>
                      <div class="count"><?php echo e($total_expense); ?> </div>
                      <?php else: ?>
                      <div class="count">0</div>
                      <?php endif; ?>
                    <h3><a href="<?php echo e(route('today-expenses')); ?>"><?php echo e(lang_trans('txt_today_expenses')); ?></a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <?php if($month_expense): ?>
                      <div class="count"><?php echo e($month_expense); ?> </div>
                      <?php else: ?>
                      <div class="count">0</div>
                      <?php endif; ?>
                    <h3><a href="<?php echo e(route('list-expense')); ?>">Monthly Expense</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <?php if($counts[0]->continue_rooms): ?>
                      <div class="count"><?php echo e($counts[0]->continue_rooms); ?> </div>
                      <?php else: ?>
                      <div class="count">0</div>
                      <?php endif; ?>
                      <h3><a href="<?php echo e(route('continuerooms-list')); ?>">Occupied Rooms</a></h3>
                    <!--<h3><a href="javascript:void(0);"></a></h3>-->
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats" style="background: aqua;">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <!--<?php if($counts[0]->continue_rooms): ?>-->
                      <!--<div class="count"> </div>-->
                    <!--  <?php else: ?>-->
                      <!--<div class="count">0</div>-->
                    <!--  <?php endif; ?>-->
                      <?php if($counts[0]->continue_rooms_new): ?>
                      <div class="count"><?php echo e($counts[0]->continue_rooms_new); ?> + <?php echo e($counts[0]->continue_rooms_todaycheckout); ?> <span style="font-size:20px;color:red;">(tco)</span> </div>
                      <?php else: ?>
                      <div class="count">0</div>
                      <?php endif; ?>
                      <h3><a>Continue Rooms</a></h3>
                    <!--<h3><a href="javascript:void(0);"></a></h3>-->
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <?php if($counts[0]->same_day_checkout): ?>
                      <div class="count"><?php echo e($counts[0]->same_day_checkout); ?> </div>
                      <?php else: ?>
                      <div class="count">0</div>
                      <?php endif; ?>
                    <h3><a href="javascript:void(0);">Same Day Checkout</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                 
                    <?php if(isset($today_perc_room)): ?>
                      <div class="count"><?php echo e($today_perc_room); ?> % <span style="font-size: 20px;color: darkgrey;">(<?php echo e($today_occupied_rooms); ?>/<?php echo e($total_rooms); ?>)</span></div>
                      <?php else: ?>
                      <div class="count">0 %</div>
                      <?php endif; ?>

                    <h3><a href="javascript:void(0);">Today Check In  <?php echo e(lang_trans('txt_room_occupancy')); ?></a></h3>

                    
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <?php if(isset($monthly_perc_room)): ?>
                      <div class="count"><?php echo e($monthly_perc_room); ?> % </div>
                      <?php else: ?>
                      <div class="count">0 %</div>
                      <?php endif; ?>

                    <h3><a href="javascript:void(0);">Monthly <?php echo e(lang_trans('txt_room_occupancy')); ?></a></h3>

                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <div class="count"><?php echo e($counts[0]->only_today_arrivals); ?></div>
                    <h3><a href="<?php echo e(route('todays-upcoming')); ?>">Today's Upcoming</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            
        </div>    
        <div class="row top_tiles"id="hide2">   
        
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-caret-square-o-right"></i>
                    </div>
                    <div class="count"><?php echo e($counts[0]->today_arrivals); ?></div>
                    <h3><a href="<?php echo e(route('list-arrival-reservation')); ?>">Reservation</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-caret-square-o-right"></i>
                    </div>
                    <div class="count"><?php echo e($counts[0]->noShow_arrivals); ?></div>
                    <h3><a href="<?php echo e(route('list-arrival-reservation')); ?>">NoShow</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <div class="count"><?php echo e($counts[0]->today_orders); ?></div>
                    <h3><a href="<?php echo e(route('orders-list')); ?>"><?php echo e(lang_trans('txt_today_orders')); ?></a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <!--<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">-->
            <!--    <div class="tile-stats">-->
            <!--        <div class="count"> INR</div>-->
            <!--        <h3><a href="">Pending Amount</a></h3>-->
            <!--        <p>&nbsp;</p>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <div class="count"><?php echo e(abs(round($cashinhand))); ?> INR</div>
                    <h3><a href="#">Cash In Hand</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
      


            <div class="row justify-content-center">
                <br>
                <div class="col-md-12 jnewwidth">
                    <form method="post" action="<?php echo e(route('new-dashboard')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>From Date</label>
                                    <input type="date" class="form-control" name="start" required value="<?php echo e($start); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" name="end" required value="<?php echo e($end); ?>">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-info" style="margin-top:25px;">Search</button>
                                </div>
                            </div>    
                        </form>
        
                    <div class="card">
                        <div class="card-header">Collection Break-up Table</div>
                        <div class="card-body">
                            <br/>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <!--<th>Hotel</th>-->
                                        <!--<th>Location</th>-->
                                        <th>Total</th>
                                        <?php
                                            $payment= DB::select("select*from payment_mode");
                                            foreach($payment as $p1)
                                            {
                                                echo "<th>".$p1->payment_mode."</th>";
                                            }
                                        ?>
                                        <th>Total OTA</th>
                                    </tr>
                                <?php
                                echo "<tr>";
                                
                                $t= DB::select("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end'");
                                $ter= DB::select("select sum(payment) as totaler from payment_history where extra_revenue = 'er' and date(payment_date) between '$start' and '$end'");
                                
                                $tbreak= DB::select("select sum(payment) as totalbreak from payment_history where extra_revenue = 'break' and date(payment_date) between '$start' and '$end'");
                                // print_r($tbreak);
                                $advance_pay=DB::select("select sum(advance) as total_advance from arrivals where referred_by_name = 'F9' and date(created_at) between '$start' and '$end'");
                                echo "<td>";
                                //   $tot = $ter[0]->totaler + $tbreak[0]->totalbreak;
                                  $tot2 = $ter[0]->totaler - $tbreak[0]->totalbreak;
                                //   echo $t[0]->total - $tot + $tot2;
                                   echo $t[0]->total + $tot2 + $advance_pay[0]->total_advance;
                                "</td>";
                                // print_r($tot2);
                                foreach($payment as $p)
                                {
                                    $data = DB::select("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end' and payment_history.mode='$p->id'");
                                    // $data= DB::select("select sum(payment) as total from payment_history where payment!='' and mode='$p->id' and payment_date between '$start' and '$end'");
                                    $advance_pay=DB::select("select sum(advance) as total_advance from arrivals where referred_by_name ='F9' and payment_mode='$p->id' and date(created_at) between '$start' and '$end'");
                                    $dataerer= DB::select("select sum(payment) as totaler from payment_history where extra_revenue = 'er' and mode='$p->id' and date(payment_date) between '$start' and '$end'");
                                    $databreak= DB::select("select sum(payment) as totalbreak from payment_history where extra_revenue = 'break' and mode='$p->id' and date(payment_date) between '$start' and '$end'");
                                    
                
                                    echo "<td>";
                                    if(!empty($data[0]->total)){
                                        // $tot = $dataerer[0]->totaler + $databreak[0]->totalbreak;
                                        $tot2 = $dataerer[0]->totaler - $databreak[0]->totalbreak;
                                        // echo $data[0]->total - $tot + $tot2;
                                        echo $data[0]->total + $advance_pay[0]->total_advance + $tot2;
                                    }else
                                    {
                                        echo $advance_pay[0]->total_advance + $tot2;
                                    }
                                      
                                    "</td>";
                                    
                                }
                                 
                                $d= DB::select("select sum(payment) as total from payment_history where reservations_id!='0' and payment!='' and mode!='1' and mode!='2' and mode!='6' and date(payment_date) between '$start' and '$end'");
                                $advance_pay=DB::select("select sum(advance) as total_advance from arrivals where referred_by_name = 'F9' and payment_mode!='1' and payment_mode!='2' and payment_mode!='6' and date(created_at) between '$start' and '$end'");
                                $otatotal = $d[0]->total + $advance_pay[0]->total_advance;
                                echo "<td>".$otatotal."</td>";
                                
                                echo "</tr>";
                            ?>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
<anytag data-tippy-content="some tooltip"></anytag>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {'packages':['line']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = new google.visualization.DataTable();
  data.addColumn('string', '');
  data.addColumn('number', '');
  
  data.addRows([
    <?php $__currentLoopData = $graphTotalCheckin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    ['<?php echo e($checkin->checkinDate); ?>',  <?php echo e($checkin->totalCheckin); ?>],
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  ]);

  var options = {
    chart: {
      title: '<?php echo e($currentMonthName); ?> Month Total Checkin',
    },
    // width: 1000,
    height: 300,
    axes: {
      x: {
        0: {side: 'top'}
      }
    }
  };

  var chart = new google.charts.Line(document.getElementById('order_graph_checkin'));
  chart.draw(data, google.charts.Line.convertOptions(options));
}

google.charts.setOnLoadCallback(drawRevenueChart);
function drawRevenueChart() {
  var data = new google.visualization.DataTable();
  data.addColumn('string', '');
  data.addColumn('number', '');
  
  data.addRows([
    <?php $__currentLoopData = $graphTotalRevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    ['<?php echo e($checkin->checkinDate); ?>',  <?php echo e($checkin->totalRevenue); ?>],
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  ]);

  var options = {
    chart: {
      title: '<?php echo e($currentMonthName); ?> Month Total Revenue',
    },
    // width: 1000,
    height: 300,
    axes: {
      x: {
        0: {side: 'top'}
      }
    }
  };

  var chart = new google.charts.Line(document.getElementById('order_graph_revenue'));
  chart.draw(data, google.charts.Line.convertOptions(options));
}

google.charts.setOnLoadCallback(drawChartaRR);
function drawChartaRR() {
  var data = new google.visualization.DataTable();
  data.addColumn('string', '');
  data.addColumn('number', '');
  
  data.addRows([
    <?php $__currentLoopData = $aRR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    ['<?php echo e($checkin->checkinDate); ?>',  <?php echo e($checkin->sumARR); ?>],
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  ]);

  var options = {
    chart: {
      title: '<?php echo e($currentMonthName); ?> Month Total ARR',
    },
    // width: 1000,
    height: 300,
    axes: {
      x: {
        0: {side: 'top'}
      }
    }
  };

  var chart = new google.charts.Line(document.getElementById('order_aRR'));
  chart.draw(data, google.charts.Line.convertOptions(options));
}

google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawReferredByChart);
function drawReferredByChart() {
var data = google.visualization.arrayToDataTable([
  ['Payment Mode', 'Revenue'],
  <?php $__currentLoopData = $graphTotalReferredBy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  ['<?php echo e($item->rby); ?>',     <?php echo e($item->totalRevenue); ?>],
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
]);

var options = {
  title: '<?php echo e($currentMonthName); ?> Month Booking Source',
  is3D: true,
  height: 400,
};

var chart = new google.visualization.PieChart(document.getElementById('referred_by_3d'));
chart.draw(data, options);
}


google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawPaymentModeChart);
function drawPaymentModeChart() {
    var data = google.visualization.arrayToDataTable([
      ['Payment Mode', 'Revenue'],
      <?php $__currentLoopData = $graphTotalPaymentMode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      ['<?php echo e($item->paymentMode); ?>', <?php echo e($item->totalRevenue); ?>],
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]);
    
    var options = {
      title: '<?php echo e($currentMonthName); ?> Month Payment Mode',
      is3D: true,
      height: 400,
    };
    
    var chart = new google.visualization.PieChart(document.getElementById('payment_mode_3d'));
    chart.draw(data, options);
}
</script>

<!-- Modal Today Check In -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Today Revenue </h4>
      </div>
      <div class="modal-body">
        
    <?php $__currentLoopData = $count; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php echo e($key); ?> : <?php echo e($vals); ?> <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="ex1" class="modal">
  <a href="#" rel="modal:close">Close</a>
</div>
<!-- End Modal Today Check In -->


<!-- Modal Today Revenue -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Today Check In </h4>
      </div>
      <div class="modal-body">
        
      <?php $__currentLoopData = $count1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vals1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php echo e($key); ?> : <?php echo e($vals1); ?> <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="ex1" class="modal">
  <a href="#" rel="modal:close">Close</a>
</div>
<!-- End Modal Today Revenue -->

<div class="row-sm-12 top_tiles">
  <div class="col-lg-12 ">
    <!-- <h3>Rooms</h3> -->
    <div class="x_content">
      <table id="datatable_" class="table table-striped table-bordered ss">
        <tbody>

          <table class="table table-striped table-bordered jnewtab">

            <tbody>
   <?php
//                 echo "<pre>";
//                 print_r($inner);
//                 die();
                
//                 ?>
              <?php $__currentLoopData = $floor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$basic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php $__currentLoopData = $basic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="mt-5 ml-5">
                    <?php if($key == 0): ?>
               <button class="btn-sm" style="background:yellow;color:black;">Check Out&ensp;&ensp;(<?php echo e($checked_rooms_count); ?>)</button>
                <?php elseif($key == 1): ?>
                <button class="btn-success btn-sm">Ready &ensp;&ensp;(<?php echo e($totrooms - $checked_rooms_count - $management_rooms_count - $ota_rooms_count - $corporate_rooms_count -$booked_rooms_count - $undermaintinance_count - $fit_rooms_count - $dirty_rooms_count); ?>) </button>
                <?php elseif($key == 2): ?>
                <button class="btn-light btn-sm" style="background:black;color:white;">Management&ensp;(<?php echo e($management_rooms_count); ?>) </button>
                <?php elseif($key == 3): ?>
                <button class="btn-sm" style="background:blue;color:white;">OTA &ensp;&ensp;(<?php echo e(($ota_rooms_count - $fab_rooms_count)-$oyo_rooms_count); ?>)</button>
                <?php elseif($key == 4): ?>
                <button class="btn-dark btn-sm">Corporate &ensp;&ensp;(<?php echo e($corporate_rooms_count); ?>)</button>
                <?php elseif($key == 5): ?>
                <button class="btn-info btn-sm">TA &ensp;&ensp;(<?php echo e($booked_rooms_count); ?>)</button>
                <?php elseif($key == 6): ?>
                <button class="btn-sm" style="background:red;color:white;" >Block/R&M issue &ensp;&ensp;(<?php echo e($undermaintinance_count); ?>)</button>
                <?php elseif($key == 7): ?>
                <button class="btn-sm" style="background:#7CFC00;color:black;" >F9 &ensp;&ensp;(<?php echo e($fit_rooms_count); ?>)</button>
                  <?php elseif($key == 8): ?>
                <button class="btn-sm" style="background:brown;color:white;" >In Cleaning &ensp;&ensp;(<?php echo e($dirty_rooms_count); ?>)</button>
                 <?php elseif($key == 9): ?>
                <button class="btn-sm" style="background:#bf951eeb;color:white;" > Fab&ensp;&ensp;(<?php echo e($fab_rooms_count); ?>)</button>
                 <?php elseif($key == 10): ?>
                <button class="btn-sm" style="background:#ed1967eb;color:white;" > Oyo&ensp;&ensp;(<?php echo e($oyo_rooms_count); ?>)</button>
                <?php endif; ?>
                
              
                
                <?php $__currentLoopData = $inner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                         <?php if($loop->first): ?>
                            <td>Floor-<?php echo e($inner[$key]->floor-1); ?></td>
                            <?php endif; ?>
                <?php if($val->count()): ?>
                <td>
                   <!--href="{{route('delete-reservation',[$reserv ?? '']-->
                 <?php if( $checked_rooms_count != 0 && in_array($val->room_no, $checked_rooms)): ?>
                  <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                  if(!$reserv){$reserv = 0;}
                  ?>
                  <a class="btn btn-sm" style="background:yellow;color:black;" href="<?php echo e(route('edit-room-reservation',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($dirty_rooms_count != 0 && in_array($val->room_no, $dirty_rooms)): ?>
                  <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                  if(!$reserv){$reserv = 0;}
                  ?>

                  <a class="btn btn-sm" style="background:brown;color:white;" data-toggle="modal" data-target="#exampleModal<?php echo e($reserv); ?>"><?php echo e($val->room_no); ?></a>
                  <div class="modal fade" id="exampleModal<?php echo e($reserv); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"> X </button>-->
                            <form action="<?php echo e(route('delete-reservation',[$reserv])); ?>" method="GET">
                                <div class="modal-body">
                                    <div class="container text-center">
                                        <div>
                                            <img src="<?php echo e(url('public/images/mark.png')); ?>" class="img-fluid" width="30%">
                                        </div>
                                        <h1>Are you sure?</h1>
                                        <p class="pmain">You want to change status to ready</p><br>
                                        <input type="hidden" id="idstatusroom" name="id" value="<?php echo e($reserv); ?>">
                                        <div>
                                            <button type="submit" class="btn btn-primary" style="width:15%">Yes</button>
                                            <button type="button" class="btn btn-danger" style="width:15%" data-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                   <?php elseif($fit_rooms_count != 0 && in_array($val->room_no, $fit_rooms)): ?>
                     <?php $reserv=$reservation->whereIn('room_num',$val->room_no)->pluck('unique_id')->first();
                     //$reserv=getBookRoomId($val->room_no);
                    //  echo $reserv;die();
                     if(!$reserv){$reserv = 0;}
                     ?>
                      <a class="btn btn-sm" style="background:#7CFC00;color:black;" href="<?php echo e(route('edit-room-reservation',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($booked_rooms_count != 0 && in_array($val->room_no, $booked_rooms)): ?>
                   <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                   if(!$reserv){$reserv = 0;}?>
                   <a class="btn btn-info btn-sm"  href="<?php echo e(route('check-out-room',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($undermaintinance_count != 0 && in_array($val->room_no, $undermaintinance)): ?>
                  <?php $reason=App\Room::where('room_no',$val->room_no)->pluck('reason')->first();
                  if(!$reason){$reason = 'undefined';}?>
                  <button type="button"  style="background:red;color:white;" <?php echo e(Popper::arrow()->size('large')->distance(10)->position('bottom')->pop($reason ?? "")); ?>

                   class="btn  btn-sm"><?php echo e($val->room_no); ?></button>
                   
                   <?php elseif($fab_rooms_count != 0 &&  in_array($val->room_no, $fab_rooms)): ?>
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:#bf951eeb;color:white;" href="<?php echo e(route('edit-room-reservation',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>
                   
                    <?php elseif($oyo_rooms_count != 0 &&  in_array($val->room_no, $oyo_rooms)): ?>
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:#ed1967eb;color:white;" href="<?php echo e(route('edit-room-reservation',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif(($ota_rooms_count-$fab_rooms_count)-$oyo_rooms_count != 0 &&  in_array($val->room_no, $ota_rooms)): ?>
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:blue;color:white;" href="<?php echo e(route('edit-room-reservation',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                 

                  <?php elseif($corporate_rooms_count != 0 && in_array($val->room_no, $corporate_rooms)): ?>
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                    if(!$reserv){$reserv = 0;} ?>
                    <a class="btn btn-dark btn-sm"  href="<?php echo e(route('check-out-room',[$reserv])); ?>"><?php echo e($val->room_no); ?></a>

                  <?php elseif($management_rooms_count != 0 && in_array($val->room_no, $management_rooms)): ?>
                  <button type="button" class="btn btn-sm" style="background:black;color:white;" href=""><?php echo e($val->room_no); ?></button>

                  <?php else: ?>
                  <a href="<?php echo e(route('room-reservation-available',[$val->id])); ?>" type="button" class="btn btn-success btn-sm"><?php echo e($val->room_no); ?></a>
                  <?php endif; ?>
                </td>
                <?php else: ?>
                <?php echo e(lang_trans('txt_no_rooms')); ?>

                <a class="btn btn-sm btn-success" href="<?php echo e(route('add-room')); ?>"><?php echo e(lang_trans('txt_add_new_rooms')); ?></a>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
          </table>
        </tbody>
      </table>
    </div>

  </div>
</div>

<div class="row" id="gotoorders">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-sm-12">
                            <div class="col-sm-4 col-md-4 col-lg-4 p-left-0">
                                <h2>Orders</h2>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4 text-right">
                                <div class="">
                                    <nav>
                                        
                                        <a aria-expanded="false" class="dropdown-toggle btn btn-info" data-toggle="dropdown" href="javascript:;">
                                              New Order
                                              <!--<span class=" fa fa-angle-down"></span>-->
                                        </a>
                                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                                            <li>
                                                <a href="#" class="btn btnmrodrop">DINEIN</a>
                                            </li>
                                            <li>
                                                <a href="#" class="btn btnmrodrop">TAKEAWAY</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('delivery')); ?>" class="btn btnmrodrop">DELIVERY</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('room-order')); ?>" class="btn btnmrodrop">Room</a>
                                            </li>
                                        </ul>
                                        
                                    </nav>
                                </div>
                    
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4 text-right">
                                <a href="<?php echo e(route('latest-orders')); ?>" class="btn btn-primary">Latest Orders</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="x_content">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                     $totalAmount = 0.00;
                                ?>
                                <?php if($val->order_history): ?>
                                    <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($val_OH->orders_items): ?>
                                            <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                    $totalAmount = $totalAmount+$price;
                                                    $totalAmmountsArr[$val->id] = $totalAmount;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <table  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo e(lang_trans('txt_sno')); ?></th>
                                        <th>Name</th>
                                        <th>Room No.</th>
                                        <th><?php echo e(lang_trans('txt_order_amount')); ?></th>
                                        <th><?php echo e(lang_trans('txt_action')); ?></th>
                                    </tr>
                                </thead>
                                 
                                
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($k+1); ?></td>
                                        <td>
                                            <?php if($val->order_history): ?>
                                                <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($val_OH->orders_items): ?>
                                                        <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $price = $val_OI->item_price*$val_OI->item_qty;
                                                                $totalAmount = $totalAmount+$price;
                                                            ?>
                                                            
                                                            
                                                            <span class="spcolnj"> <?php echo e($val_OI['item_name']); ?> (<?php echo e($val_OI['item_qty']); ?>q) </span><br>
                                                           
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($val->table_num); ?></td>
                                        <td><?php echo e(getCurrencySymbol()); ?> <?php echo e(@$totalAmmountsArr[$val->id]); ?></td>
                                        <td>
                                            <!--<a class="btn btn-sm btn-success" href=""></i></a>-->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view_modal_<?php echo e($k); ?>"><?php echo e(lang_trans('btn_view_order')); ?></button>
                                            <a class="btn btn-sm btn-warning" href="<?php echo e(route('room-order-final',[$val->id])); ?>" target="_blank"><?php echo e(lang_trans('btn_pay')); ?></i></a>
            
                                            <div class="modal fade view_modal_<?php echo e($k); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title" id="myModalLabel"><?php echo e(lang_trans('txt_order_details')); ?>: (<?php echo e(lang_trans('txt_table_num')); ?>- #<?php echo e($val->table_num); ?>)</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                           <table  class="table table-striped table-bordered">
                                                                <tr>
                                                                    <th><?php echo e(lang_trans('txt_sno')); ?></th>
                                                                    <th><?php echo e(lang_trans('txt_datetime')); ?></th>
                                                                    <th><?php echo e(lang_trans('txt_orderitem_qty')); ?></th>
                                                                </tr>
                                                                <?php if($val->order_history): ?>
                                                                    <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                          <td><?php echo e($key_OH+1); ?></td>
                                                                          <td><?php echo e($val_OH->created_at); ?></td>
                                                                          <td>
                                                                            <?php if($val_OH->orders_items): ?>
                                                                                <table class="table table-bordered">
                                                                                    <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                        <?php
                                                                                            $price = $val_OI->item_price*$val_OI->item_qty;
                                                                                            $totalAmount = $totalAmount+$price;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td><?php echo e($val_OI->item_name); ?></td>
                                                                                            <td><?php echo e($val_OI->item_qty); ?></td>
                                                                                        </tr>
                                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                </table>
                                                                            <?php endif; ?>
                                                                          </td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>
                                                              </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo e(lang_trans('txt_product_stocks')); ?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable_" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><?php echo e(lang_trans('txt_sno')); ?></th>
                          <th><?php echo e(lang_trans('txt_product')); ?></th>
                          <th><?php echo e(lang_trans('txt_current_stocks')); ?></th>
                          <th><?php echo e(lang_trans('txt_unit')); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td><?php echo e($k+1); ?></td>
                            <td><?php echo e($val->name); ?></td>
                            <td><?php echo e($val->stock_qty); ?></td>
                            <td><?php echo e(($val->unit) ? $val->unit->name : ''); ?></td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div class="row">-->
<!--    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">-->
<!--        <div class="row">-->
<!--            <div class="col-md-12 col-sm-12 col-xs-12">-->
<!--                <div class="x_panel">-->
<!--                    <div class="x_title">-->
<!--                        <div class="col-sm-12">-->
<!--                            <div class="col-sm-8 p-left-0">-->
<!--                                <h2 class="rforder">Room Food Orders</h2> &nbsp;&nbsp;&nbsp;<span class="roomordermsg"></span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4 text-right">-->
                                
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="clearfix"></div>-->
<!--                    </div>-->
                    
<!--                    <div id="userInfo" style="display: none;">-->
<!--                        <center><img src="https://f9hotels.com/web/dist/images/ezystayz-logo.png" width="150"></center>-->
<!--                        <h3 style="margin-top:1px;"><center>F9 GROUP OF HOTELS</center></h3>-->
<!--                        <h4><center>MARSROCK HOSPITALITY VENTURES PRIVATE LIMITED</center></h4>-->
<!--                        <h5><center>PHONE: <?php echo e($settings['hotel_phone']); ?></center></h5>-->
<!--                        <h5 style="margin-top:1px;"><center>GSTIN: <?php echo e($settings['gst_num']); ?></center></h5>-->
<!--                        <h5 style="margin-top:1px;"><center>FSSAI: 345678457890</center></h5>-->
<!--                        <h6><center>Reg. Office: House no. A-197, Sector-47 Noida, Noida, Gautam Buddha Nagar, U.P.-201301, IN</center></h6>-->
<!--                        <h3 style="border-top:1px solid black;"><center>Original</center></h3>-->
<!--                        <h3 style="margin-top:1px;border-top:1px solid black;"><center>DUE</center></h3><br>-->
                        
<!--                        <div id="maindatabill">-->
                            
<!--                        </div>-->
<!--                    </div>-->
                    
<!--                    <div class="x_content" id="refresh">-->
<!--                        <table class="table table-striped table-bordered">-->
<!--                            <thead>-->
<!--                                <tr>-->
<!--                                  <th>S.No</th>-->
<!--                                  <th>Order ID</th>-->
<!--                                  <th>Name</th>-->
<!--                                  <th>Room No</th>-->
<!--                                  <th>Amount</th>-->
<!--                                  <th>Payment status</th>-->
<!--                                  <th>Date</th>-->
<!--                                  <th>Actions</th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody id="mytable7">-->
                      
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->



<a class="weatherwidget-io" href="https://forecast7.com/en/28d6677d23/delhi/" data-label_1="DELHI" data-label_2="WEATHER" data-theme="original" >DELHI WEATHER</a>

<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
</script>

<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12 jnewwidth">
            <?php if(count($graphTotalCheckin) > 0): ?>
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="order_graph_checkin"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(count($graphTotalRevenue) > 0): ?>
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="order_graph_revenue"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(count($graphTotalRevenue) > 0): ?>
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="order_aRR"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(count($graphTotalReferredBy) > 0): ?>
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="referred_by_3d"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(count($graphTotalPaymentMode) > 0): ?>
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="payment_mode_3d"></div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
                    $userid = Auth::user()->role_id;
                   
                    ?>
                    
<?php  if($userid!=5) { ?>
<input type="hidden" id="role"value="0">

<?php } else { ?>

<input type="hidden" id="role"value="5">
 <?php } ?>
<script type="text/javascript">

    $(document).ready(function(){
        var role4= $('#role').val();
        if(role4==5){
            // alert(role4);
            
            $('.top_tiles').hide();
              $('.justify-content-center').hide();
                 $('.weatherwidget-io').hide();
            
        //      $(".navbar-brand").attr("onclick", "history.back()");
        //   $(".navbar-brand").attr("href", "#");
        
        }

        // alert('hello');die;
        
        // demo();
        // function demo(){
        //     $.ajax({
        //         url:'<?php echo e(route("foodorderlistnew")); ?>',
        //         type: "GET",
        //         // data: ""
        //         dataType: 'json',
        //         success: function(data){
        //             $('#mytable7').html("");
        //             var ij = 1;
        //             $.each(data.studata, function(key, value){

        //                 var first = value.name;
        //                 const pehla = first.split(",");
        //                 var second = value.quantity;
        //                 const dusra = second.split(",");
        //                 var third = value.unitprice;
        //                 const tisra = third.split(",");
                        
        //                 var newArray = pehla.map((e, i) => e+'('+dusra[i]+'q *'+tisra[i]+'p = ' +dusra[i]*tisra[i]+')'+'<br>');
        //                 var formatted_date = $.datepicker.formatDate('dd M yy', new Date(value.updated_at));
        //                 var d = moment(value.updated_at).format('D-MM-YYYY, h:mm:ss a');
                        
        //                 if (value.markpreparing == "Ordered") {
        //                     var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'" selected>Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';  
        //                 }else if(value.markpreparing == "Preparing") {
        //                     var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'" selected>Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';
        //                 }else if(value.markpreparing == "FoodReady"){
        //                     var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'" selected>Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';
        //                 }else if(value.markpreparing == "Served"){
        //                     var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'" selected>Served</option></select>';
        //                 }else{
        //                     var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';
        //                 }
                        
        //                 $('#mytable7').append('<tr>\
        //                 <td>'+ij+'</td>\
        //                 <td>'+value.order_id+'</td>\
        //                 <td>'+newArray+'</td>\
        //                 <td>'+value.roomnumber+'</td>\
        //                 <td>'+value.amount+'</td>\
        //                 <td>'+value.payment_done+'</td>\
        //                 <td>'+d+'</td>\
        //                 <td>'+select+'</td>\
        //                 <td><a class="btn btn-sm btn-success" data-closeid="'+value.order_id+'" id="closeorderid"  href="<?php echo e(route("closeroomorder")); ?>">Close Order</i></a></td>\
        //                 <td><a class="btn btn-sm btn-primary" id="getUser" data-userSelect="'+value.order_id+'">Print Details</a></td>\
        //                 </tr>');
        //                 ij++;
        //             });
        //         }
        //     });
        // } 
        
        // setInterval(demo, 30000);
        
        
        // $(document).on('change','#multjczone',function(e){
        //     e.preventDefault();
        //     var orderid = $(this).find(':selected').attr('data-id');
        //     var color1 = $(this).find(':selected').attr('data-value');
        //     $.ajax({
        //         type:'POST',
        //         url:"<?php echo e(route('markpreparing')); ?>",
        //         data:{"_token": "<?php echo e(csrf_token()); ?>",orderid:orderid,type:color1},
        //         success:function(data){
        //             // console.log(data);
        //             if(data.updatemark == 1){
        //                 $('.roomordermsg').fadeIn('slow', function(){
        //                     $(".roomordermsg").css("display", "block");
        //                     $(".roomordermsg").html("Food Status Updated Successfully...");
        //                     $('.roomordermsg').delay(5000).fadeOut(); 
        //                 });
        //             }else{
        //                 // $('.roomordermsg').fadeIn('slow', function(){
        //                 //     $(".roomordermsg").css("display", "block");
        //                 //     $(".roomordermsg").html("Food Status Not Updated. System Error...");
        //                 //     $('.roomordermsg').delay(3000).fadeOut(); 
        //                 // });
        //             }
        //         }
        //     });
        // });
        
        // $(document).on('click','#closeorderid',function(e){
        //     e.preventDefault();
        //     var orderidclose = $(this).attr('data-closeid');
        //     $.ajax({
        //         type:'POST',
        //         url:"<?php echo e(route('closeroomorder')); ?>",
        //         data:{"_token": "<?php echo e(csrf_token()); ?>",orderid:orderidclose},
        //         success:function(data){
        //             console.log(data);
        //             if(data.closeord == 1){
        //                 $('.roomordermsg').fadeIn('slow', function(){
        //                     $(".roomordermsg").css("display", "block");
        //                     $(".roomordermsg").html("Order Close Successfully...");
        //                     $('.roomordermsg').delay(5000).fadeOut(); 
        //                 });
        //             }else{
        //                 // $('.roomordermsg').fadeIn('slow', function(){
        //                 //     $(".roomordermsg").css("display", "block");
        //                 //     $(".roomordermsg").html("Order Not Close. System Error...");
        //                 //     $('.roomordermsg').delay(3000).fadeOut(); 
        //                 // });
        //             }
        //         }
        //     });
        // });
        
        // $(document).on('click','#getUser',function(e){
        //     var billid = $(this).attr('data-userSelect');
        //     alert(billid);
            
        //     // var newWin = window.open();
        //     $.ajax({
        //         type: "POST", 
        //         url:"<?php echo e(route('printbill')); ?>",
        //         data:{"_token": "<?php echo e(csrf_token()); ?>",billid:billid},
        //         success: function(data){
        //             console.log(data.detailsiddata);
                    
        //                 var first = data.detailsiddata.name;
        //                 const pehla = first.split(",");
        //                 var newArrayname = pehla.map(a => a).join("<br>");
        //                 var countitems = pehla.length;
                        
        //                 var third = data.detailsiddata.unitprice;
        //                 const tisra = third.split(",");
        //                 var newArrayunitprice = tisra.map(b => b).join("<br>");
                        
        //                 var second = data.detailsiddata.quantity;
        //                 const dusra = second.split(",");
        //                 var newArrayquantity = dusra.map(c => c).join("<br>");
                        
        //                 var newArrayamount = pehla.map((e, i) => dusra[i]*tisra[i]);
        //                 var newArrayamount1 = newArrayamount.map(d => d).join("<br>");
                        
        //                 var scgst = parseFloat(data.detailsiddata.amount * 2.5/100);
        //                 var scgst1 = scgst.toFixed(2);
                        
        //                 var paybelamount = Math.round(data.detailsiddata.amount + scgst + scgst);
        //                 var bhasad = parseFloat(data.detailsiddata.amount + scgst + scgst ).toFixed(2);
        //                 var roundoff1 = parseFloat(paybelamount - bhasad);
        //                 var roundoff = parseFloat(roundoff1).toFixed(2);
        //                 // var newArray = pehla.map((e, i) => e+'<br>');
                        
        //             // newWin.document.write(data.billid);
        //             // newWin.document.close();
        //             // newWin.focus();
        //             // newWin.print();
        //             // newWin.close();
                    
        //             $('#maindatabill').html('<div class="row" style="display:flex;justify-content:space-between;border-top:1px solid black;margin-bottom:-30px;">\
        //                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:left;">\
        //                     <h3>Performa Invoice</h3>\
        //                 </div>\
        //                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:right;">\
        //                     <h3>0471</h3>\
        //                 </div>\
        //             </div><br>\
        //             <div class="row" style="display:flex;justify-content: space-between;margin-top:1px;">\
        //                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:left;">\
        //                     <h3>Room 108</h3>\
        //                     <h3>ORD #10</h3>\
        //                 </div>\
        //                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:right;">\
        //                     <h3>16-12-2022 1:47 PM</h3>\
        //                 </div>\
        //             </div><br>\
        //             <div class="row" style="display:flex;justify-content: space-between;border-top:1px solid black;">\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> Item </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> Rate </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> Qty </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> Amount </h3>\
        //                 </div>\
        //             </div><br>\
        //             <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;margin-bottom:-20px;">\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+newArrayname+' </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+newArrayunitprice+' </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+newArrayquantity+' </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+newArrayamount1+' </h3>\
        //                 </div>\
        //             </div><br>\
        //             <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;">\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> Subtotal ('+countitems+' items) </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style="">  </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+countitems+' </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+data.detailsiddata.amount+' </h3>\
        //                 </div>\
        //             </div><br>\
        //             <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;margin-bottom:-30px;">\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> SGST </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style="">  </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> 2.5% </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+scgst1+' </h3>\
        //                 </div>\
        //             </div>\
        //             <div class="row" style="display:flex; justify-content: space-between;margin-bottom:-30px;">\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> CGST </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style="">  </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> 2.5% </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+scgst1+' </h3>\
        //                 </div>\
        //             </div>\
        //             <div class="row" style="display:flex; justify-content: space-between;margin-bottom:-30px;">\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> Round Off </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style="">  </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+roundoff+' </h3>\
        //                 </div>\
        //             </div><br>\
        //             <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;">\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> Payble Amount </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style="">  </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> </h3>\
        //                 </div>\
        //                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
        //                     <h3 style=""> '+paybelamount+' </h3>\
        //                 </div>\
        //             </div>');
                    
        //             var printContent = document.getElementById('userInfo');
        //             var WinPrint = window.open('', '', 'width=800,height=650');
        //             WinPrint.document.write(printContent.innerHTML);
        //             WinPrint.document.close();
        //             WinPrint.focus();
        //             WinPrint.print();
        //             WinPrint.close();
                    
        //             console.log(data);
        //         }
        //         ,error: function() {
        //         }
        //     });
        // });
        
        
        // var tablenewj = $('#datatablenew7').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: {
        //         url:'<?php echo e(route("foodorderlistnew")); ?>',
        //     },
        //     columns: [
        //         {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        //         {data: 'order_id', name: 'order_id'},
        //         {data: 'name', name: 'name'},
        //         {data: 'quantity', name: 'quantity'},
        //         {data: 'unitprice', name: 'unitprice'},
        //         {data: 'roomnumber', name: 'roomnumber'},
        //         {data: 'amount', name: 'amount'},
        //         {data: 'payment_done', name: 'payment_done'},
        //         {data: 'updated_at', name: 'updated_at'}
                
        //     ]
        // });
    
        // setInterval( function () {
        //     tablenewj.ajax.reload();
        // }, 10000 );
    
    });

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/new_dashboard.blade.php ENDPATH**/ ?>