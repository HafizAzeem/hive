@extends('layouts.master_backend')
@section('rightColContent')
@php

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

@endphp


@endsection
@section('content')
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
    
    @media screen and (max-width: 480px) {
        .jnewtab tr{
            display: grid;
            grid-template-columns: repeat(5, 1fr);
        }
        .jnewwidth{
            width: 100%;
        }
    }
</style>
    <h3><b>{{getSettings('hotel_name')}}</b></h3>
        <div class="row top_tiles"id="hide1">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-caret-square-o-right"></i>
                    </div>
                    <div class="count">{{$counts[0]->today_check_ins}}</div>
                    <h3><a href="{{route('list-reservation')}}">{{lang_trans('txt_today_checkin')}}</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-comments-o"></i>
                    </div>
                    <div class="count">{{$counts[0]->today_check_outs}}</div>
                    <h3><a href="{{route('list-check-outs')}}">{{lang_trans('txt_today_checkout')}}</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    @if(isset($perc_room))
                      <div class="count">{{$perc_room}} % <span style="font-size: 20px;color: darkgrey;">({{ $occupied_rooms}}/{{ $total_rooms}})</span></div>
                      @else
                      <div class="count">0 %</div>
                      @endif
                      
                    <h3><a href="javascript:void(0);">Today Occupancy</a></h3>

                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    @if($payment_today1)
                      <div class="count">{{$payment_today1}} </div>
                      @else
                      <div class="count">0</div>
                      @endif
                    <h3><a href="javascript:void(0);">{{lang_trans('txt_today_revenue')}}</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    @if($total_expense)
                      <div class="count">{{$total_expense}} </div>
                      @else
                      <div class="count">0</div>
                      @endif
                    <h3><a href="{{route('today-expenses')}}">{{lang_trans('txt_today_expenses')}}</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    @if($month_expense)
                      <div class="count">{{$month_expense}} </div>
                      @else
                      <div class="count">0</div>
                      @endif
                    <h3><a href="{{route('list-expense')}}">Monthly Expense</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    @if($counts[0]->continue_rooms)
                      <div class="count">{{$counts[0]->continue_rooms}} </div>
                      @else
                      <div class="count">0</div>
                      @endif
                      <h3><a href="{{route('continuerooms-list')}}">Occupied Rooms</a></h3>
                    <!--<h3><a href="javascript:void(0);">{{--lang_trans('txt_continue_rooms')--}}</a></h3>-->
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats" style="background: aqua;">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <!--@if($counts[0]->continue_rooms)-->
                      <!--<div class="count">{{--$counts[0]->continue_rooms - $counts[0]->today_check_ins--}} </div>-->
                    <!--  @else-->
                      <!--<div class="count">0</div>-->
                    <!--  @endif-->
                      @if($counts[0]->continue_rooms_new)
                      <div class="count">{{$counts[0]->continue_rooms_new}} + {{$counts[0]->continue_rooms_todaycheckout}} <span style="font-size:20px;color:red;">(tco)</span> </div>
                      @else
                      <div class="count">0</div>
                      @endif
                      <h3><a>Continue Rooms</a></h3>
                    <!--<h3><a href="javascript:void(0);">{{--lang_trans('txt_continue_rooms')--}}</a></h3>-->
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    @if($counts[0]->same_day_checkout)
                      <div class="count">{{$counts[0]->same_day_checkout}} </div>
                      @else
                      <div class="count">0</div>
                      @endif
                    <h3><a href="javascript:void(0);">Same Day Checkout</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                 
                    @if(isset($today_perc_room))
                      <div class="count">{{$today_perc_room}} % <span style="font-size: 20px;color: darkgrey;">({{ $today_occupied_rooms}}/{{ $total_rooms}})</span></div>
                      @else
                      <div class="count">0 %</div>
                      @endif

                    <h3><a href="javascript:void(0);">Today Check In  {{lang_trans('txt_room_occupancy')}}</a></h3>

                    
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    @if(isset($monthly_perc_room))
                      <div class="count">{{$monthly_perc_room}} % </div>
                      @else
                      <div class="count">0 %</div>
                      @endif

                    <h3><a href="javascript:void(0);">Monthly {{lang_trans('txt_room_occupancy')}}</a></h3>

                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <div class="count">{{$counts[0]->only_today_arrivals}}</div>
                    <h3><a href="{{route('todays-upcoming')}}">Today's Upcoming</a></h3>
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
                    <div class="count">{{$counts[0]->today_arrivals}}</div>
                    <h3><a href="{{route('list-arrival-reservation')}}">Reservation</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-caret-square-o-right"></i>
                    </div>
                    <div class="count">{{$counts[0]->noShow_arrivals}}</div>
                    <h3><a href="{{route('list-arrival-reservation')}}">NoShow</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <div class="count">{{$counts[0]->today_orders}}</div>
                    <h3><a href="{{route('orders-list')}}">{{lang_trans('txt_today_orders')}}</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <!--<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">-->
            <!--    <div class="tile-stats">-->
            <!--        <div class="count">{{--$pending_amount--}} INR</div>-->
            <!--        <h3><a href="{{--route('pending_amount')--}}">Pending Amount</a></h3>-->
            <!--        <p>&nbsp;</p>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <!--<div class="icon">-->
                    <!--    <i class="fa fa-sort-amount-desc"></i>-->
                    <!--</div>-->
                    <div class="count">{{abs(round($cashinhand))}} INR</div>
                    <h3><a href="#">Cash In Hand</a></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
      


            <div class="row justify-content-center">
                <br>
                <div class="col-md-12 jnewwidth">
                    <form method="post" action="{{route('new-dashboard')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label>From Date</label>
                                    <input type="date" class="form-control" name="start" required value="{{$start}}">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" name="end" required value="{{$end}}">
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
    @foreach($graphTotalCheckin as $checkin)
    ['{{$checkin->checkinDate}}',  {{$checkin->totalCheckin}}],
    @endforeach
  ]);

  var options = {
    chart: {
      title: '{{$currentMonthName}} Month Total Checkin',
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
    @foreach($graphTotalRevenue as $checkin)
    ['{{$checkin->checkinDate}}',  {{$checkin->totalRevenue}}],
    @endforeach
  ]);

  var options = {
    chart: {
      title: '{{$currentMonthName}} Month Total Revenue',
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
    @foreach($aRR as $checkin)
    ['{{$checkin->checkinDate}}',  {{$checkin->sumARR}}],
    @endforeach
  ]);

  var options = {
    chart: {
      title: '{{$currentMonthName}} Month Total ARR',
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
  @foreach($graphTotalReferredBy as $item)
  ['{{$item->rby}}',     {{$item->totalRevenue}}],
  @endforeach
]);

var options = {
  title: '{{$currentMonthName}} Month Booking Source',
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
      @foreach($graphTotalPaymentMode as $item)
      ['{{$item->paymentMode}}', {{$item->totalRevenue}}],
      @endforeach
    ]);
    
    var options = {
      title: '{{$currentMonthName}} Month Payment Mode',
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
        
    @foreach($count as $key => $vals)
      {{$key}} : {{$vals}} <br>
    @endforeach
    
   
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
        
      @foreach($count1 as $key => $vals1)
      {{$key}} : {{$vals1}} <br>
    @endforeach
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
              @foreach($floor as $key=>$basic)
              @foreach($basic as $key=>$inner)
              <tr class="mt-5 ml-5">
                    @if($key == 0)
               <button class="btn-sm" style="background:yellow;color:black;">Check Out&ensp;&ensp;({{$checked_rooms_count}})</button>
                @elseif($key == 1)
                <button class="btn-success btn-sm">Ready &ensp;&ensp;({{$totrooms - $checked_rooms_count - $management_rooms_count - $ota_rooms_count - $corporate_rooms_count -$booked_rooms_count - $undermaintinance_count - $fit_rooms_count - $dirty_rooms_count }}) </button>
                @elseif($key == 2)
                <button class="btn-light btn-sm" style="background:black;color:white;">Management&ensp;({{$management_rooms_count}}) </button>
                @elseif($key == 3)
                <button class="btn-sm" style="background:blue;color:white;">OTA &ensp;&ensp;({{($ota_rooms_count - $fab_rooms_count)-$oyo_rooms_count}})</button>
                @elseif($key == 4)
                <button class="btn-dark btn-sm">Corporate &ensp;&ensp;({{$corporate_rooms_count}})</button>
                @elseif($key == 5)
                <button class="btn-info btn-sm">TA &ensp;&ensp;({{$booked_rooms_count}})</button>
                @elseif($key == 6)
                <button class="btn-sm" style="background:red;color:white;" >Block/R&M issue &ensp;&ensp;({{$undermaintinance_count}})</button>
                @elseif($key == 7)
                <button class="btn-sm" style="background:#7CFC00;color:black;" >F9 &ensp;&ensp;({{$fit_rooms_count}})</button>
                  @elseif($key == 8)
                <button class="btn-sm" style="background:brown;color:white;" >In Cleaning &ensp;&ensp;({{$dirty_rooms_count}})</button>
                 @elseif($key == 9)
                <button class="btn-sm" style="background:#bf951eeb;color:white;" > Fab&ensp;&ensp;({{$fab_rooms_count}})</button>
                 @elseif($key == 10)
                <button class="btn-sm" style="background:#ed1967eb;color:white;" > Oyo&ensp;&ensp;({{$oyo_rooms_count}})</button>
                @endif
                
              
                
                @foreach($inner as $key=>$val)

                         @if($loop->first)
                            <td>Floor-{{$inner[$key]->floor-1}}</td>
                            @endif
                @if($val->count())
                <td>
                   <!--href="{{route('delete-reservation',[$reserv ?? '']-->
                 @if( $checked_rooms_count != 0 && in_array($val->room_no, $checked_rooms))
                  <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                  if(!$reserv){$reserv = 0;}
                  ?>
                  <a class="btn btn-sm" style="background:yellow;color:black;" href="{{route('edit-room-reservation',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($dirty_rooms_count != 0 && in_array($val->room_no, $dirty_rooms))
                  <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                  if(!$reserv){$reserv = 0;}
                  ?>

                  <a class="btn btn-sm" style="background:brown;color:white;" data-toggle="modal" data-target="#exampleModal{{$reserv}}">{{$val->room_no}}</a>
                  <div class="modal fade" id="exampleModal{{$reserv}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"> X </button>-->
                            <form action="{{route('delete-reservation',[$reserv])}}" method="GET">
                                <div class="modal-body">
                                    <div class="container text-center">
                                        <div>
                                            <img src="{{url('public/images/mark.png')}}" class="img-fluid" width="30%">
                                        </div>
                                        <h1>Are you sure?</h1>
                                        <p class="pmain">You want to change status to ready</p><br>
                                        <input type="hidden" id="idstatusroom" name="id" value="{{$reserv}}">
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
                   @elseif($fit_rooms_count != 0 && in_array($val->room_no, $fit_rooms))
                     <?php $reserv=$reservation->whereIn('room_num',$val->room_no)->pluck('unique_id')->first();
                     //$reserv=getBookRoomId($val->room_no);
                    //  echo $reserv;die();
                     if(!$reserv){$reserv = 0;}
                     ?>
                      <a class="btn btn-sm" style="background:#7CFC00;color:black;" href="{{route('edit-room-reservation',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($booked_rooms_count != 0 && in_array($val->room_no, $booked_rooms))
                   <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                   if(!$reserv){$reserv = 0;}?>
                   <a class="btn btn-info btn-sm"  href="{{route('check-out-room',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($undermaintinance_count != 0 && in_array($val->room_no, $undermaintinance))
                  <?php $reason=App\Room::where('room_no',$val->room_no)->pluck('reason')->first();
                  if(!$reason){$reason = 'undefined';}?>
                  <button type="button"  style="background:red;color:white;" {{Popper::arrow()->size('large')->distance(10)->position('bottom')->pop($reason ?? "")}}
                   class="btn  btn-sm">{{$val->room_no}}</button>
                   
                   @elseif($fab_rooms_count != 0 &&  in_array($val->room_no, $fab_rooms))
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:#bf951eeb;color:white;" href="{{route('edit-room-reservation',[$reserv])}}">{{$val->room_no}}</a>
                   
                    @elseif($oyo_rooms_count != 0 &&  in_array($val->room_no, $oyo_rooms))
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:#ed1967eb;color:white;" href="{{route('edit-room-reservation',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif(($ota_rooms_count-$fab_rooms_count)-$oyo_rooms_count != 0 &&  in_array($val->room_no, $ota_rooms))
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:blue;color:white;" href="{{route('edit-room-reservation',[$reserv])}}">{{$val->room_no}}</a>

                 

                  @elseif($corporate_rooms_count != 0 && in_array($val->room_no, $corporate_rooms))
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                    if(!$reserv){$reserv = 0;} ?>
                    <a class="btn btn-dark btn-sm"  href="{{route('check-out-room',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($management_rooms_count != 0 && in_array($val->room_no, $management_rooms))
                  <button type="button" class="btn btn-sm" style="background:black;color:white;" href="{{--route('check-out-room',[$reserv])--}}">{{$val->room_no}}</button>

                  @else
                  <a href="{{route('room-reservation-available',[$val->id])}}" type="button" class="btn btn-success btn-sm">{{$val->room_no}}</a>
                  @endif
                </td>
                @else
                {{lang_trans('txt_no_rooms')}}
                <a class="btn btn-sm btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                @endif
                @endforeach
              </tr>
              @endforeach
              @endforeach

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
                                                <a href="{{route('delivery')}}" class="btn btnmrodrop">DELIVERY</a>
                                            </li>
                                            <li>
                                                <a href="{{route('room-order')}}" class="btn btnmrodrop">Room</a>
                                            </li>
                                        </ul>
                                        
                                    </nav>
                                </div>
                    
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4 text-right">
                                <a href="{{route('latest-orders')}}" class="btn btn-primary">Latest Orders</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="x_content">
                            @foreach($orders as $k=>$val)
                                @php
                                     $totalAmount = 0.00;
                                @endphp
                                @if($val->order_history)
                                    @foreach($val->order_history as $key_OH=>$val_OH)
                                        @if($val_OH->orders_items)
                                            @foreach($val_OH->orders_items as $key_OI=>$val_OI)
                                                @php
                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                    $totalAmount = $totalAmount+$price;
                                                    $totalAmmountsArr[$val->id] = $totalAmount;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <table  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{lang_trans('txt_sno')}}</th>
                                        <th>Name</th>
                                        <th>Room No.</th>
                                        <th>{{lang_trans('txt_order_amount')}}</th>
                                        <th>{{lang_trans('txt_action')}}</th>
                                    </tr>
                                </thead>
                                 
                                
                                <tbody>
                                    @foreach($orders as $k=>$val)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>
                                            @if($val->order_history)
                                                @foreach($val->order_history as $key_OH=>$val_OH)
                                                    @if($val_OH->orders_items)
                                                        @foreach($val_OH->orders_items as $key_OI=>$val_OI)
                                                            @php
                                                                $price = $val_OI->item_price*$val_OI->item_qty;
                                                                $totalAmount = $totalAmount+$price;
                                                            @endphp
                                                            
                                                            
                                                            <span class="spcolnj"> {{$val_OI['item_name']}} ({{$val_OI['item_qty']}}q) </span><br>
                                                           
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{$val->table_num}}</td>
                                        <td>{{getCurrencySymbol()}} {{@$totalAmmountsArr[$val->id]}}</td>
                                        <td>
                                            <!--<a class="btn btn-sm btn-success" href="{{--route('food-order-table',[$val->id])--}}">{{--lang_trans('btn_repeat_order')--}}</i></a>-->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view_modal_{{$k}}">{{lang_trans('btn_view_order')}}</button>
                                            <a class="btn btn-sm btn-warning" href="{{route('room-order-final',[$val->id])}}" target="_blank">{{lang_trans('btn_pay')}}</i></a>
            
                                            <div class="modal fade view_modal_{{$k}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">{{lang_trans('txt_order_details')}}: ({{lang_trans('txt_table_num')}}- #{{$val->table_num}})</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                           <table  class="table table-striped table-bordered">
                                                                <tr>
                                                                    <th>{{lang_trans('txt_sno')}}</th>
                                                                    <th>{{lang_trans('txt_datetime')}}</th>
                                                                    <th>{{lang_trans('txt_orderitem_qty')}}</th>
                                                                </tr>
                                                                @if($val->order_history)
                                                                    @foreach($val->order_history as $key_OH=>$val_OH)
                                                                        <tr>
                                                                          <td>{{$key_OH+1}}</td>
                                                                          <td>{{$val_OH->created_at}}</td>
                                                                          <td>
                                                                            @if($val_OH->orders_items)
                                                                                <table class="table table-bordered">
                                                                                    @foreach($val_OH->orders_items as $key_OI=>$val_OI)
                                                                                        @php
                                                                                            $price = $val_OI->item_price*$val_OI->item_qty;
                                                                                            $totalAmount = $totalAmount+$price;
                                                                                        @endphp
                                                                                        <tr>
                                                                                            <td>{{$val_OI->item_name}}</td>
                                                                                            <td>{{$val_OI->item_qty}}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </table>
                                                                            @endif
                                                                          </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                              </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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
                        <h2>{{lang_trans('txt_product_stocks')}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable_" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>{{lang_trans('txt_sno')}}</th>
                          <th>{{lang_trans('txt_product')}}</th>
                          <th>{{lang_trans('txt_current_stocks')}}</th>
                          <th>{{lang_trans('txt_unit')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $k=>$val)
                          <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->stock_qty}}</td>
                            <td>{{($val->unit) ? $val->unit->name : ''}}</td>
                          </tr>
                        @endforeach
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
<!--                        <h5><center>PHONE: {{$settings['hotel_phone']}}</center></h5>-->
<!--                        <h5 style="margin-top:1px;"><center>GSTIN: {{$settings['gst_num']}}</center></h5>-->
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
            @if(count($graphTotalCheckin) > 0)
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="order_graph_checkin"></div>
                </div>
            </div>
            @endif
            
            @if(count($graphTotalRevenue) > 0)
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="order_graph_revenue"></div>
                </div>
            </div>
            @endif
            
            @if(count($graphTotalRevenue) > 0)
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="order_aRR"></div>
                </div>
            </div>
            @endif
            
            @if(count($graphTotalReferredBy) > 0)
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="referred_by_3d"></div>
                </div>
            </div>
            @endif
            
            @if(count($graphTotalPaymentMode) > 0)
            <div class="card">
                <div class="card-body">
                    <br/>
                    <div class="container" id="payment_mode_3d"></div>
                </div>
            </div>
            @endif
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
        //         url:'{{ route("foodorderlistnew") }}',
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
        //                 <td><a class="btn btn-sm btn-success" data-closeid="'+value.order_id+'" id="closeorderid"  href="{{route("closeroomorder")}}">Close Order</i></a></td>\
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
        //         url:"{{ route('markpreparing') }}",
        //         data:{"_token": "{{ csrf_token() }}",orderid:orderid,type:color1},
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
        //         url:"{{ route('closeroomorder') }}",
        //         data:{"_token": "{{ csrf_token() }}",orderid:orderidclose},
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
        //         url:"{{ route('printbill') }}",
        //         data:{"_token": "{{ csrf_token() }}",billid:billid},
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
        //         url:'{{ route("foodorderlistnew") }}',
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

@endsection
