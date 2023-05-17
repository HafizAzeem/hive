@extends('layouts.master_backend')

@section('content')

@php
    $settings = getSettings();
    $gst_0 = $settings['gst_0'];
    $cgst_0 = $settings['cgst_0'];

    $gst = $settings['gst'];
    $cgst = $settings['cgst'];

    $gst_1 = $settings['gst_1'];
    $cgst_1 = $settings['cgst_1'];
@endphp    
<style>
    .roomordermsg {
        margin-left: 20px !important;
        color: #46ab4a !important;
        font-size: 16px;
    }
    .colorstatus {
        color: blue;
        font-weight: 500;
    }
    .colorstatus1 {
        color: green;
        font-weight: 500;
    }
    .caproomtable{
        text-transform: capitalize;
        color: red;
        font-weight: 600;
    }
</style>

                <div id="userInfo" style="display: none;">
                    <center><img src="https://f9hotels.com/web/dist/images/ezystayz-logo.png" width="150"></center>
                    <h3 style="margin-top:1px;"><center>F9 GROUP OF HOTELS</center></h3>
                    <h4><center>MARSROCK HOSPITALITY VENTURES PRIVATE LIMITED</center></h4>
                    <h5><center>PHONE: {{$settings['hotel_phone']}}</center></h5>
                    <h5 style="margin-top:1px;"><center>GSTIN: {{$settings['gst_num']}}</center></h5>
                    <h5 style="margin-top:1px;"><center>FSSAI: 345678457890</center></h5>
                    <h6><center>Reg. Office: House no. A-197, Sector-47 Noida, Noida, Gautam Buddha Nagar, U.P.-201301, IN</center></h6>
                    <h3 style="border-top:1px solid black;"><center>Original</center></h3>
                    <h3 style="margin-top:1px;border-top:1px solid black;"><center>DUE</center></h3><br>
                    
                    <div id="maindatabill">
                        
                    </div>
                </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel"id="reloaddiv">
                <div class="x_title">
                    <div class="col-sm-12">
                        <div class="col-sm-8 p-left-0">
                            <h2>{{lang_trans('txt_latest_orders')}} <span class="roomordermsg"></span></h2>
                        </div>
                        <div class="col-sm-4 text-right">
                            <a href="{{route('room-order')}}" class="btn btn-success">{{lang_trans('txt_add_new_orders')}}</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
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
                      <th>Order ID</th>
                      <th>Food Name</th>
                      <th>Room No/Table No</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Order Type</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $k=>$val)
                        <tr>
                        <td>
                            {{$val->id}}
                            
                            {{--@if($val->order_history)
                                @foreach($val->order_history as $key_OH=>$val_OH)
                                    {{$val_OH->order_id}} 
                                @endforeach
                            @endif --}}
                        </td>
                        <td>
                            
                        @if($val->order_history)
                            @foreach($val->order_history as $key_OH=>$val_OH)
                            @php //print_r($val_OH->is_book); @endphp
                                @if($val_OH->orders_items)
                                    @foreach($val_OH->orders_items as $key_OI=>$val_OI)
                                        @php
                                            $price = $val_OI->item_price*$val_OI->item_qty;
                                            $totalAmount = $totalAmount+$price;
                                        @endphp
                                        <span> {{$val_OI->item_name}} ({{$val_OI->item_qty}}q) </span><br>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                        </td>
                        
                        <td>
                            {{$val->table_num}}
                            @if($val->ordertype)
                                <span class="caproomtable">({{$val->ordertype}})</span>
                            @else
                                <span>(Room)</span>
                            @endif
                        </td>
                        
                        <td>{{getCurrencySymbol()}} {{$val->total_amount}}</td>
                        
                        <td>{{$val->created_at}}</td>
                        
                        <td class="colorstatus1">{{$val->statusonoff}}</td>
                        <td>
                            <?php
                            if ($val->markpreparing == "Ordered") {
                                echo '<select class="form-control" name="zonefilter" id="multjczonelocal"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val->id.'" selected>Ordered</option><option data-value="Preparing" data-id="'.$val->id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val->id.'">Food Ready</option><option data-value="Served" data-id="'.$val->id.'">Served</option></select>';  
                            }else if($val->markpreparing == "Preparing") {
                                echo '<select class="form-control" name="zonefilter" id="multjczonelocal"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val->id.'">Ordered</option><option data-value="Preparing" data-id="'.$val->id.'" selected>Preparing</option><option data-value="FoodReady" data-id="'.$val->id.'">Food Ready</option><option data-value="Served" data-id="'.$val->id.'">Served</option></select>';
                            }else if($val->markpreparing == "FoodReady"){
                                echo '<select class="form-control" name="zonefilter" id="multjczonelocal"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val->id.'">Ordered</option><option data-value="Preparing" data-id="'.$val->id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val->id.'" selected>Food Ready</option><option data-value="Served" data-id="'.$val->id.'">Served</option></select>';
                            }else if($val->markpreparing == "Served"){
                                echo '<select class="form-control" name="zonefilter" id="multjczonelocal"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val->id.'">Ordered</option><option data-value="Preparing" data-id="'.$val->id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val->id.'">Food Ready</option><option data-value="Served" data-id="'.$val->id.'" selected>Served</option></select>';
                            }else{
                                echo '<select class="form-control" name="zonefilter" id="multjczonelocal"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val->id.'">Ordered</option><option data-value="Preparing" data-id="'.$val->id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val->id.'">Food Ready</option><option data-value="Served" data-id="'.$val->id.'">Served</option></select>';
                            }
                            ?>
                            <br><a class="btn btn-sm btn-success" data-closeid="{{$val->id}}" id="closeorderidlocal">Close Order</a>
                            <!--@if($val->order_history)-->
                            <!--    @foreach($val->order_history as $key_OH=>$val_OH)-->
                            <!--        @if($val_OH->is_book == 1)-->
                            <!--            <a class="btn btn-sm btn-warning" href="{{route('room-order-final',[$val->id])}}" target="_blank">{{lang_trans('btn_pay')}}</a>-->
                            <!--        @else-->
                                        <!--<a class="btn btn-sm btn-primary" href="{{route('roomorder-invoice-final',[$val->id])}}" target="_blank">View Bill</a>-->
                            <!--        @endif-->
                            <!--    @endforeach-->
                            <!--@endif-->
                            
                            <a class="btn btn-sm btn-warning" href="{{route('room-order-final',[$val->id])}}" target="_blank">{{lang_trans('btn_pay')}}</a>
                            
                            <a class="btn btn-sm btn-primary" href="{{route('roomorder-invoice-final',[$val->id])}}" target="_blank">View Bill</a>
                            
                            <!--<a class="btn btn-sm btn-success" href="{{--route('food-order-table',[$val->id])--}}">{{lang_trans('btn_repeat_order')}}</i></a>-->
                            <!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view_modal_{{$k}}">{{lang_trans('btn_view_order')}}</button>-->
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
                    
                   {{-- @foreach($datalist4 as $k=>$val1) --}}
                    <?php
                    
                        // $first = $val1->name;
                        // $pehla1 = explode(" ",$first);
                        // $pehla = str_replace(',', '', $pehla1);
                        
                        // $second = $val1->quantity;
                        // $dusra1 = explode(" ",$second);
                        // $dusra = str_replace(',', '', $dusra1);
                        
                        // $third = $val1->unitprice;
                        // $tisra1 = explode(" ",$third);
                        // $tisra = str_replace(',', '', $tisra1);
                        
                        // $result = array_map(null, $pehla, $dusra, $tisra);
                        
                        // if ($val1->markpreparing == "Ordered") {
                        //     $select = '<select class="form-control" name="zonefilter" id="multjczone" style="width: 50%;"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val1->order_id.'" selected>Ordered</option><option data-value="Preparing" data-id="'.$val1->order_id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val1->order_id.'">Food Ready</option><option data-value="Served" data-id="'.$val1->order_id.'">Served</option></select>';  
                        // }else if($val1->markpreparing == "Preparing") {
                        //     $select = '<select class="form-control" name="zonefilter" id="multjczone" style="width: 50%;"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val1->order_id.'">Ordered</option><option data-value="Preparing" data-id="'.$val1->order_id.'" selected>Preparing</option><option data-value="FoodReady" data-id="'.$val1->order_id.'">Food Ready</option><option data-value="Served" data-id="'.$val1->order_id.'">Served</option></select>';
                        // }else if($val1->markpreparing == "FoodReady"){
                        //     $select = '<select class="form-control" name="zonefilter" id="multjczone" style="width: 50%;"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val1->order_id.'">Ordered</option><option data-value="Preparing" data-id="'.$val1->order_id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val1->order_id.'" selected>Food Ready</option><option data-value="Served" data-id="'.$val1->order_id.'">Served</option></select>';
                        // }else if($val1->markpreparing == "Served"){
                        //     $select = '<select class="form-control" name="zonefilter" id="multjczone" style="width: 50%;"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val1->order_id.'">Ordered</option><option data-value="Preparing" data-id="'.$val1->order_id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val1->order_id.'">Food Ready</option><option data-value="Served" data-id="'.$val1->order_id.'" selected>Served</option></select>';
                        // }else{
                        //     $select = '<select class="form-control" name="zonefilter" id="multjczone" style="width: 50%;"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'.$val1->order_id.'">Ordered</option><option data-value="Preparing" data-id="'.$val1->order_id.'">Preparing</option><option data-value="FoodReady" data-id="'.$val1->order_id.'">Food Ready</option><option data-value="Served" data-id="'.$val1->order_id.'">Served</option></select>';
                        // }
                        
                    ?>
                   
                      <!--  <tr>-->
                      <!--  <td>{{--$val1->order_id--}}</td>    -->
                      <!--  <td>-->
                            <?php 
                                // $pName = "";
                                // for($i=0; $i<count($result); $i++){
                                //     $total = ($result[$i][1] * $result[$i][2]);
                                //     $pName .= $result[$i][0]."(".$result[$i][1]."q * ".$result[$i][2]."p = ".$total.")<br>";
                                // }
                                // echo $pName;
                            ?>
                      <!--  </td>-->
                      <!--  <td>{{--$val1->roomnumber--}}</td>-->
                      <!--  <td>{{--getCurrencySymbol()--}} {{--$val1->amount--}}</td>-->
                      <!--  <td>{{--$val1->created_at--}}</td>-->
                      <!--  <td>-->
                            <?php //echo $select; ?>
                            <!--<br>-->
                      <!--      <a class="btn btn-primary btn-sm" data-closeid="{{--$val1->order_id--}}" id="closeorderid"  href="{{--route('closeroomorder')--}}">Close Order</a>-->
                      <!--      <a class="btn btn-sm btn-primary" id="getUser" data-userSelect="{{--$val1->order_id--}}">Bill Details</a>-->
                      <!--  </td>-->
                      <!--</tr>-->
                    {{-- @endforeach --}}
                    
                  </tbody>
                    <tbody id="mytable7">
                      
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        demo();
        function demo(){
            $.ajax({
                url:'{{ route("foodorderlistnew") }}',
                type: "GET",
                // data: ""
                dataType: 'json',
                success: function(data){
                    $('#mytable7').html("");
                    var ij = 1;
                    $.each(data.studata, function(key, value){

                        var first = value.name;
                        const pehla = first.split(",");
                        var second = value.quantity;
                        const dusra = second.split(",");
                        var third = value.unitprice;
                        const tisra = third.split(",");
                        
                        var newArray = pehla.map((e, i) => e+'('+dusra[i]+'q *'+tisra[i]+'p = ' +dusra[i]*tisra[i]+')'+'<br>');
                        var formatted_date = $.datepicker.formatDate('dd M yy', new Date(value.updated_at));
                        var d = moment(value.updated_at).format('D-MM-YYYY, h:mm:ss a');
                        
                        if (value.markpreparing == "Ordered") {
                            var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'" selected>Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';  
                        }else if(value.markpreparing == "Preparing") {
                            var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'" selected>Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';
                        }else if(value.markpreparing == "FoodReady"){
                            var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'" selected>Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';
                        }else if(value.markpreparing == "Served"){
                            var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'" selected>Served</option></select>';
                        }else{
                            var select = '<select class="form-control" name="zonefilter" id="multjczone"><option value="">Mark Preparing</option><option data-value="Ordered" data-id="'+value.order_id+'">Ordered</option><option data-value="Preparing" data-id="'+value.order_id+'">Preparing</option><option data-value="FoodReady" data-id="'+value.order_id+'">Food Ready</option><option data-value="Served" data-id="'+value.order_id+'">Served</option></select>';
                        }
                        
                        $('#mytable7').append('<tr>\
                        <td>'+value.order_id+'</td>\
                        <td>'+newArray+'</td>\
                        <td>'+value.roomnumber+'</td>\
                        <td>₹ '+value.amount+'</td>\
                        <td>'+d+'</td>\
                        <td class="colorstatus">'+value.statusonoff+'</td>\
                        <td>'+select+'\
                        <br><a class="btn btn-sm btn-success" data-closeid="'+value.order_id+'" id="closeorderid"  href="{{route("closeroomorder")}}">Close Order</i></a>\
                        <a class="btn btn-sm btn-primary" href="{{url("admin/onlineorder-invoice-final")}}/'+value.order_id+' " target="_blank">View Bill</a>\
                        </tr>');
                        ij++;
                    });
                    
                    // <a class="btn btn-sm btn-primary" id="getUser" data-userSelect="'+value.order_id+'">View Bill</a></td>\
                }
            });
        } 
        
        setInterval(demo, 30000);
        
        $(document).on('change','#multjczone',function(e){
            e.preventDefault();
            var orderid = $(this).find(':selected').attr('data-id');
            var color1 = $(this).find(':selected').attr('data-value');
            $.ajax({
                type:'POST',
                url:"{{ route('markpreparing') }}",
                data:{"_token": "{{ csrf_token() }}",orderid:orderid,type:color1},
                success:function(data){
                    // console.log(data);
                    if(data.updatemark == 1){
                        $('.roomordermsg').fadeIn('slow', function(){
                            $(".roomordermsg").css("display", "block");
                            $(".roomordermsg").html("Food Status Updated Successfully...");
                            $('.roomordermsg').delay(5000).fadeOut(); 
                        });
                    }else{
                        // $('.roomordermsg').fadeIn('slow', function(){
                        //     $(".roomordermsg").css("display", "block");
                        //     $(".roomordermsg").html("Food Status Not Updated. System Error...");
                        //     $('.roomordermsg').delay(3000).fadeOut(); 
                        // });
                    }
                }
            });
        });
        
        $(document).on('click','#closeorderid',function(e){
            e.preventDefault();
            var orderidclose = $(this).attr('data-closeid');
            $.ajax({
                type:'POST',
                url:"{{ route('closeroomorder') }}",
                data:{"_token": "{{ csrf_token() }}",orderid:orderidclose},
                success:function(data){
                    console.log(data);
                    if(data.closeord == 1){
                        $('.roomordermsg').fadeIn('slow', function(){
                            $(".roomordermsg").css("display", "block");
                            $(".roomordermsg").html("Order Close Successfully...");
                            $('.roomordermsg').delay(5000).fadeOut(); 
                        });
                    }else{
                        // $('.roomordermsg').fadeIn('slow', function(){
                        //     $(".roomordermsg").css("display", "block");
                        //     $(".roomordermsg").html("Order Not Close. System Error...");
                        //     $('.roomordermsg').delay(3000).fadeOut(); 
                        // });
                    }
                }
            });
        });
        
        $(document).on('click','#getUser',function(e){
            var billid = $(this).attr('data-userSelect');
            // alert(billid);
            
            // var newWin = window.open();
            $.ajax({
                type: "POST", 
                url:"{{ route('printbill') }}",
                data:{"_token": "{{ csrf_token() }}",billid:billid},
                success: function(data){
                    console.log(data.detailsiddata);
                        
                        var roomjc = data.detailsiddata.roomnumber;
                        var ordidjc = data.detailsiddata.order_id;
                        var first = data.detailsiddata.name;
                        const pehla = first.split(",");
                        var newArrayname = pehla.map(a => a).join("<br>");
                        var countitems = pehla.length;
                        
                        var third = data.detailsiddata.unitprice;
                        const tisra = third.split(",");
                        var newArrayunitprice = tisra.map(b => b).join("<br>");
                        
                        var second = data.detailsiddata.quantity;
                        const dusra = second.split(",");
                        var newArrayquantity = dusra.map(c => c).join("<br>");
                        
                        var newArrayamount = pehla.map((e, i) => dusra[i]*tisra[i]);
                        var newArrayamount1 = newArrayamount.map(d => d).join("<br>");
                        
                        var scgst = parseFloat(data.detailsiddata.amount * 2.5/100);
                        var scgst1 = scgst.toFixed(2);
                        
                        var paybelamount = Math.round(data.detailsiddata.amount + scgst + scgst);
                        var bhasad = parseFloat(data.detailsiddata.amount + scgst + scgst ).toFixed(2);
                        var roundoff1 = parseFloat(paybelamount - bhasad);
                        var roundoff = parseFloat(roundoff1).toFixed(2);
                        
                        var formatted_date = $.datepicker.formatDate('dd M yy', new Date(data.detailsiddata.updated_at));
                        var d = moment(data.detailsiddata.updated_at).format('D-MM-YYYY, h:mm:ss a');
                        // var newArray = pehla.map((e, i) => e+'<br>');
                        
                    // newWin.document.write(data.billid);
                    // newWin.document.close();
                    // newWin.focus();
                    // newWin.print();
                    // newWin.close();
                    
                    $('#maindatabill').html('<div class="row" style="display:flex;justify-content:space-between;border-top:1px solid black;margin-bottom:-30px;">\
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:left;">\
                            <h3></h3>\
                        </div>\
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:right;">\
                            <h3></h3>\
                        </div>\
                    </div><br>\
                    <div class="row" style="display:flex;justify-content: space-between;margin-top:1px;">\
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:left;">\
                            <h3>Room '+roomjc+'</h3>\
                            <h3>ORD #'+ordidjc+'</h3>\
                        </div>\
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="float:right;">\
                            <h3>'+d+'</h3>\
                        </div>\
                    </div><br>\
                    <div class="row" style="display:flex;justify-content: space-between;border-top:1px solid black;">\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> Item </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> Rate </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> Qty </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> Amount </h3>\
                        </div>\
                    </div><br>\
                    <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;margin-bottom:-20px;">\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+newArrayname+' </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+newArrayunitprice+' </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+newArrayquantity+' </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+newArrayamount1+' </h3>\
                        </div>\
                    </div><br>\
                    <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;">\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> Subtotal ('+countitems+' items) </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style="">  </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+countitems+' </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+data.detailsiddata.amount+' </h3>\
                        </div>\
                    </div><br>\
                    <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;margin-bottom:-30px;">\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> SGST </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style="">  </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> 2.5% </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+scgst1+' </h3>\
                        </div>\
                    </div>\
                    <div class="row" style="display:flex; justify-content: space-between;margin-bottom:-30px;">\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> CGST </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style="">  </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> 2.5% </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+scgst1+' </h3>\
                        </div>\
                    </div>\
                    <div class="row" style="display:flex; justify-content: space-between;margin-bottom:-30px;">\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> Round Off </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style="">  </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+roundoff+' </h3>\
                        </div>\
                    </div><br>\
                    <div class="row" style="display:flex; justify-content: space-between;border-top:1px solid black;">\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> Payble Amount </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style="">  </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> </h3>\
                        </div>\
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">\
                            <h3 style=""> '+paybelamount+' </h3>\
                        </div>\
                    </div>');
                    
                    var printContent = document.getElementById('userInfo');
                    var WinPrint = window.open('', '', 'width=800,height=650');
                    WinPrint.document.write(printContent.innerHTML);
                    WinPrint.document.close();
                    WinPrint.focus();
                    WinPrint.print();
                    WinPrint.close();
                    
                    // demoFromHTML();
                    
                    
                    // const data = res;
                    // const link = document.createElement('a');
                    // link.setAttribute('href', printContent);
                    // link.setAttribute('download', 'bill.pdf'); // Need to modify filename ...
                    // link.click();
                    
                    console.log(data);
                }
                ,error: function() {
                }
            });
        });
        
        function demoFromHTML() {
            var pdf = new jsPDF('p', 'pt', 'letter');
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('#userInfo')[0];
            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#bypassme': function (element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
                source, // HTML string or DOM elem ref.
                margins.left, // x coord
                margins.top, { // y coord
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': specialElementHandlers
                },
    
                function (dispose) {
                    // dispose: object with X, Y of the last line add to the PDF 
                    //          this allow the insertion of new lines after html
                    pdf.save('Test.pdf');
                }, margins
            );
        }
        
        $(document).on('change','#multjczonelocal',function(e){
            e.preventDefault();
            var orderid = $(this).find(':selected').attr('data-id');
            var color1 = $(this).find(':selected').attr('data-value');
            $.ajax({
                type:'POST',
                url:"{{ route('markpreparinglocal') }}",
                data:{"_token": "{{ csrf_token() }}",orderid:orderid,type:color1},
                success:function(data){
                    // console.log(data);
                    if(data.updatemark == 1){
                        $('.roomordermsg').fadeIn('slow', function(){
                            $(".roomordermsg").css("display", "block");
                            $(".roomordermsg").html("Food Status Updated Successfully...");
                            $('.roomordermsg').delay(5000).fadeOut(); 
                        });
                    }else{
                        // $('.roomordermsg').fadeIn('slow', function(){
                        //     $(".roomordermsg").css("display", "block");
                        //     $(".roomordermsg").html("Food Status Not Updated. System Error...");
                        //     $('.roomordermsg').delay(3000).fadeOut(); 
                        // });
                    }
                }
            });
        });
        
        $(document).on('click','#closeorderidlocal',function(e){
            e.preventDefault();
            var orderidclose = $(this).attr('data-closeid');
            $.ajax({
                type:'POST',
                url:"{{ route('closeroomorderlocal') }}",
                data:{"_token": "{{ csrf_token() }}",orderid:orderidclose},
                success:function(data){
                    console.log(data);
                    if(data.closeord == 1){
                        $('.roomordermsg').fadeIn('slow', function(){
                            $(".roomordermsg").css("display", "block");
                            $(".roomordermsg").html("Order Close Successfully...");
                            $('.roomordermsg').delay(5000).fadeOut(); 
                            
                        });
                           $("#reloaddiv").load(location.href + " #reloaddiv");
                            $("#mytable7").load(location.href + " #mytable7");
                    }else{
                        // $('.roomordermsg').fadeIn('slow', function(){
                        //     $(".roomordermsg").css("display", "block");
                        //     $(".roomordermsg").html("Order Not Close. System Error...");
                        //     $('.roomordermsg').delay(3000).fadeOut(); 
                        // });
                    }
                }
               
            });
        });
    </script>
        
@endsection