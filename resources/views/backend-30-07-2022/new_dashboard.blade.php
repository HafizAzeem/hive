@extends('layouts.master_backend')
@section('rightColContent')
@php
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
  if($val1->referred_by_name == "FIT")
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

  <h3><b>{{getSettings('hotel_name')}}</b></h3>
         <div class="row top_tiles">

                
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
                          <div class="count">{{$perc_room}} % </div>
                          @else
                          <div class="count">0 %</div>
                          @endif

                        <h3><a href="javascript:void(0);">{{lang_trans('txt_room_occupancy')}}</a>({{ $occupied_rooms}}/{{ $total_rooms}})</h3>

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
                        <h3><a href="javascript:void(0);">{{lang_trans('txt_today_expenses')}}</a></h3>
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
                        <h3><a href="javascript:void(0);">Monthly Expense</a></h3>
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
                        <h3><a href="javascript:void(0);">{{lang_trans('txt_continue_rooms')}}</a></h3>
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
                          <div class="count">{{$today_perc_room}} % </div>
                          @else
                          <div class="count">0 %</div>
                          @endif

                        <h3><a href="javascript:void(0);">Today {{lang_trans('txt_room_occupancy')}}</a>({{ $today_occupied_rooms}}/{{ $total_rooms}})</h3>

                        
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
                
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <!--<div class="icon">-->
                        <!--    <i class="fa fa-sort-amount-desc"></i>-->
                        <!--</div>-->
                        <div class="count">{{$pending_amount}} INR</div>
                        <h3><a href="{{route('pending_amount')}}">Pending Amount</a></h3>
                        <p>&nbsp;</p>
                    </div>
                </div>
                
                
            </div>
      @endsection
@section('content')
<anytag data-tippy-content="some tooltip"></anytag>




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

<a class="weatherwidget-io" href="https://forecast7.com/en/28d6677d23/delhi/" data-label_1="DELHI" data-label_2="WEATHER" data-theme="original" >DELHI WEATHER</a>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
</script>


















<div class="row-sm-12">
  <div class="col-lg-12 ">
    <!-- <h3>Rooms</h3> -->
    <div class="x_content">
      <table id="datatable_" class="table table-striped table-bordered">
        <tbody>

          <table class="table table-striped table-bordered">

            <tbody>
//   <?php
//                 echo "<pre>";
//                 print_r($inner);
//                 die();
                
//                 ?>
              @foreach($floor as $key=>$basic)
              @foreach($basic as $key=>$inner)
              <tr class="mt-5 ml-5">
                    @if($key == 0)
               <button class="btn-sm" style="background:yellow;color:black;">Check Out&ensp;&ensp;</button>
                @elseif($key == 1)
                <button class="btn-success btn-sm">Ready &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button>
                @elseif($key == 2)
                <button class="btn-light btn-sm" style="background:black;color:white;">Management </button>
                @elseif($key == 3)
                <button class="btn-sm" style="background:blue;color:white;">OTA &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button>
                @elseif($key == 4)
                <button class="btn-dark btn-sm">Corporate &ensp;&ensp;</button>
                @elseif($key == 5)
                <button class="btn-info btn-sm">TA &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button>
                @elseif($key == 6)
                <button class="btn-sm" style="background:red;color:white;" >Block or R&M issue &ensp;&ensp;</button>
                @elseif($key == 7)
                <button class="btn-sm" style="background:#7CFC00;color:white;" >Direct &ensp;&ensp;</button>
                  @elseif($key == 8)
                <button class="btn-sm" style="background:brown;color:white;" >In Cleaning &ensp;&ensp;</button>
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

                  <a class="btn btn-sm" style="background:brown;color:white;" onclick="dirty({{$reserv}});">{{$val->room_no}}</a>
                   @elseif($fit_rooms_count != 0 && in_array($val->room_no, $fit_rooms))
                     <?php $reserv=$reservation->whereIn('room_num',$val->room_no)->pluck('unique_id')->first();
                     //$reserv=getBookRoomId($val->room_no);
                    //  echo $reserv;die();
                     if(!$reserv){$reserv = 0;}
                     ?>
                      <a class="btn btn-sm" style="background:#7CFC00;color:white;" href="{{route('edit-room-reservation',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($booked_rooms_count != 0 && in_array($val->room_no, $booked_rooms))
                   <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                   if(!$reserv){$reserv = 0;}?>
                   <a class="btn btn-info btn-sm"  href="{{route('check-out-room',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($undermaintinance_count != 0 && in_array($val->room_no, $undermaintinance))
                  <?php $reason=App\Room::where('room_no',$val->room_no)->pluck('reason')->first();
                  if(!$reason){$reason = 'undefined';}?>
                  <button type="button"  style="background:red;color:white;" {{Popper::arrow()->size('large')->distance(10)->position('bottom')->pop($reason ?? "")}}
                   class="btn  btn-sm">{{$val->room_no}}</button>

                  @elseif($ota_rooms_count != 0 &&  in_array($val->room_no, $ota_rooms))
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('unique_id')->first();
                    if(!$reserv){$reserv = 0;}?>
                    <a class="btn btn-sm" style="background:blue;color:white;" href="{{route('edit-room-reservation',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($corporate_rooms_count != 0 && in_array($val->room_no, $corporate_rooms))
                    <?php $reserv=$reservation->where('room_num',$val->room_no)->pluck('id')->first();
                    if(!$reserv){$reserv = 0;} ?>
                    <a class="btn btn-dark btn-sm"  href="{{route('check-out-room',[$reserv])}}">{{$val->room_no}}</a>

                  @elseif($management_rooms_count != 0 && in_array($val->room_no, $management_rooms))
                  <button type="button" class="btn btn-sm" style="background:pink;color:white;" href="{{route('check-out-room',[$reserv])}}">{{$val->room_no}}</button>

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
<div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="col-sm-12">
                                <div class="col-sm-8 p-left-0">
                                    <h2>{{lang_trans('txt_latest_orders')}}</h2>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="{{route('food-order')}}" class="btn btn-success">{{lang_trans('txt_add_new_orders')}}</a>
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
                              <th>{{lang_trans('txt_sno')}}</th>
                              <th>{{lang_trans('txt_customer_name')}}</th>
                              <th>{{lang_trans('txt_table_num')}}</th>
                              <th>{{lang_trans('txt_order_amount')}}</th>
                              <th>{{lang_trans('txt_action')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($orders as $k=>$val)
                                <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{$val->table_num}}</td>
                                <td>{{getCurrencySymbol()}} {{@$totalAmmountsArr[$val->id]}}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="{{route('food-order-table',[$val->id])}}">{{lang_trans('btn_repeat_order')}}</i></a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view_modal_{{$k}}">{{lang_trans('btn_view_order')}}</button>
                                    <a class="btn btn-sm btn-warning" href="{{route('food-order-final',[$val->id])}}" target="_blank">{{lang_trans('btn_pay')}}</i></a>

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

 <script>
      function dirty(id)
   {
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to change status to ready",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No'
            }).then((result) => {
              if (result.isConfirmed) {

                  axios.get('delete-reservation/'+id,{
                          _method: 'DELETE',
                           headers: {
    'Content-type': 'application/json'
  },
                  })
                      .then(function (response) {
                        window.location.reload();
                      })
                      .catch(function (error) {
                        // handle error
                        console.log(error);
                      })
                      .then(function () {
                        // always executed
                      });
                Swal.fire(
                  'Status Changed!',
                  'Room switched to Ready',
                  'success'
                )
              }
            });
   }

 </script>
@endsection
