@extends('layouts.master_backend')
@section('css')
<style>
    table, th, td {
  border: 1px solid black;
}

</style>
@endsection
@section('content')
@php

$i = $j = 0;
$totalAmount = 0;
@endphp
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
                     {{Form::date('min', $dtPart2,['class'=>"datePickerDefault ", "id"=>"min", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                </div>
                <div class="col-md-2 col-xs-2">
                    <label class="control-label"> End Date<span class=""></span></label>
                     {{Form::date('max', $dtPart2,['class'=>"datePickerDefault ", "id"=>"max", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
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
                            @foreach ( $paymentmode_list as $pay_list )
                            <th>{{ $pay_list->payment_mode }}</th>
                            @endforeach

                            @foreach ( $corporate as $corporate_list )
                            <th>{{ $corporate_list->name }}</th>
                            @endforeach


                            @foreach ( $ta as $ta_list )
                            <th>{{ $ta_list->name }}</th>
                            @endforeach

                            @foreach ( $ota as $ota_list )
                            <th>{{ $ota_list->name }}</th>
                            @endforeach

                        </thead>
                        <tbody>
                            @foreach($datalist as $k=>$val)
                            <tr>
                                <td>{{date('y-m-d')}} </td>
                                <!-- <td>{{$val->corporate_count}}</td> -->
                                <td>{{$val->noShow}}</td>
                                <td>{{$val->police}}</td>
                                <!-- <td>{{$val->ta_count}}</td>
                                <td>{{$val->ota_count}}</td>-->
                                <td>{{$val->fit_count}}</td> 
                                <td>{{$val->total_check_outs}}</td>
                                <td>{{$val->total_check_ins}}</td>
                                <td>{{$val->room_count}}</td>
                                <td>{{$val->occupied_rooms}}</td>
                                <td>{{$val->user_count}}</td>
                                <td>{{$val->Continue1}}</td>
                                <!--<td>{{$val->comming}}</td>-->
                                <td>{{$val->total_payment}}</td>
                                <td>{{$val->total_expense}}</td>
                                @foreach ( $paymentmode_list as $pay_list )
                                    <?php $data = 0;//get_payment_mode_data($pay_list->payment_mode) ?>
                                    <td>{{ $data }}</td>
                                @endforeach


                                 @foreach ( $corporate as $corporate_list )
                                 
                                    <td></td>
                                @endforeach

                                @foreach ( $ta as $ta_list )
                                 
                                 <td></td>
                             @endforeach
                             @foreach ( $ota as $ota_list )
                                 
                                 <td></td>
                             @endforeach


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('jquery')
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
@endsection
