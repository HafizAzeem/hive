@extends('layouts.master_backend')
@section('content')
<style type="text/css">
    #results {
        border: 1px solid;
        background: #ccc;
    }

    .results_guest {
        border: 1px solid;
        background: #ccc;
    }

</style>
@php
$flag=0;
$heading=lang_trans('btn_add');
if(isset($data_row) && !empty($data_row)){
$flag=1;
$heading=lang_trans('btn_update');
}
@endphp
<div class="">
    @if($flag==1)
    {{ Form::model($data_row,array('url'=>route('save-reservation'),'id'=>"update-reservation-form", 'class'=>"form-horizontal form-label-left",'files'=>true)) }}
    {{Form::hidden('id',null)}}
    @else
    {{ Form::open(array('url'=>route('save-reservation'),'id'=>"add-reservation-form", 'class'=>"form-horizontal form-label-left",'files'=>true)) }}
    @endif
    {{Form::hidden('per_room_price',null,['id'=>'base_price'])}}
    {{Form::hidden('room_qty',null,['id'=>'room_qty'])}}
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_guest_type')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                {{Form::radio('guest_type','new',true,['class'=>"flat guest_type", 'id'=>'new_guest'])}} <label for="new_guest">{{lang_trans('txt_new_guest')}}</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                {{Form::radio('guest_type','existing',false,['class'=>"flat guest_type", 'id'=>'existing_guest'])}} <label for="existing_guest">{{lang_trans('txt_existing_guest')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row hide_elem" id="existing_guest_section">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_existing_guest_list')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label">{{lang_trans('txt_guest')}}</label>
                            {{ Form::select('selected_customer_id',$customer_list,null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="new_guest_section">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_guest_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_fullname')}} <span class="required">*</span></label>
                            {{Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname')])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_email')}} </label>
                            {{Form::email('email',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_mobile_num')}} <span class="required">*</span></label>
                            {{Form::text('mobile',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num')])}}
                        </div>
                        <!--
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_address')}} <span class="required">*</span></label>
                            {{Form::textarea('address',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_address'),"rows"=>1])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label">{{lang_trans('txt_nationality')}}</label>
                            {{ Form::select('nationality',config('constants.NATIONALITY_LIST'),getSettings('default_nationality'),['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_country')}} <span class="required">*</span></label>
                            {{Form::text('country',getSettings('default_country'),['class'=>"form-control col-md-6 col-xs-12", "id"=>"country", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_country')])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_state')}} <span class="required">*</span></label>
                            {{Form::text('state',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"state", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_state')])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_city')}} <span class="required">*</span></label>
                            {{Form::text('city',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"city", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_city')])}}
                        </div>
-->
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_gender')}} <span class="required">*</span></label>
                            {{ Form::select('gender',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_age')}} </label>
                            {{Form::number('age',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_checkin_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_adults')}} <span class="required">*</span></label>
                            {{Form::number('adult',1,['class'=>"form-control col-md-7 col-xs-12", "id"=>"adult", "required"=>"required","placeholder"=>lang_trans('ph_enter').lang_trans('txt_adults'),"min"=>1])}}
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_kids')}} </label>
                            {{Form::number('kids',0,['class'=>"form-control col-md-7 col-xs-12", "id"=>"kids", "required"=>"required","placeholder"=>lang_trans('ph_enter').lang_trans('txt_kids'),"min"=>0])}}
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_vehicle_number')}}</label>
                            {{Form::text('vehicle_number',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"vehicle_number", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_vehicle_number')])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">
                            <label class="control-label"> {{lang_trans('txt_reason_of_visit')}}</label>
                            {{Form::textarea('reason_visit_stay',null,['class'=>"form-control h34 col-md-6 col-xs-12", "id"=>"reason_visit_stay", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_reason_of_visit'),"rows"=>1])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_referred_by')}}<span class="required">*</span></label>
                            {{ Form::select('referred_by',config('constants.REFERRED_BY'),null,['class'=>'form-control',"id"=>"referred_by"]) }}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_referred_by_name')}}</label>
                            {{Form::text('referred_by_name','WALK-IN',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_referred_by_name')])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12" id="booking_id">


                        </div>
                    </div>
                    <div class="row">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_checkin')}}<span class="required">*</span></label>

                            {{Form::text('check_in_date',null,['class'=>"form-control datepicker col-md-6 col-xs-12", "id"=>"check_in_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 ">
                            <label class="control-label"> {{lang_trans('txt_checkout')}} <span class="required">*</span></label>
                            {{Form::text('check_out_date',null,['class'=>"form-control datepicker col-md-6 col-xs-12", "id"=>"check_out_date", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                        </div>
<!--
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_duration_of_stay')}} <span class="required">*</span></label>
                            {{Form::number('duration_of_stay',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"duration_of_stay", "placeholder"=>lang_trans('ph_day_night'),"min"=>1])}}
                        </div>
-->
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('No of Rooms')}} <span class="required">*</span></label>
                            {{Form::number('no_of_rooms',1,['class'=>"form-control col-md-6 col-xs-12", "id"=>"no_of_rooms", "placeholder"=>lang_trans('No of Rooms'),"min"=>1])}}
                        </div>
                        
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_room_type')}}<span class="required">*</span></label>
                            <?php
                            $type= 0;
                            foreach($data['available-room'] as $room)
                            {
                                $type = $room->room_type_id;
                                $room = $room->id;
                                
                            }
                            ?>
                            <input type="hidden" id="room_id" value="{{$room}}">
                            <select name="room_type_id" id="room_type_id" class="form-control">
                                <option value="">Choose Room type</option>
                                <?php
                                         $roomtype=DB::table('room_types')->get();      
                                        ?>
                                @foreach($roomtype as $roomtype)
                                <option value="{{$roomtype->id}}" <?php 
                                            if($roomtype->id == $type){
                                            ?> selected <?php
                                            
                                            }?>>{{$roomtype->title}}</option>
                                @endforeach
                            </select>




                            <!--                            {{ Form::select('room_type_id',$roomtypes_list,null,['class'=>'form-control',"id"=>"room_type_id",'placeholder'=>lang_trans('ph_select')]) }}-->
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_select_rooms')}}<span class="required">*</span></label>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{lang_trans('txt_sno')}}</th>
                                        <th>{{lang_trans('txt_select')}}</th>
                                        <th>{{lang_trans('txt_room_num')}}</th>
                                        <th>{{lang_trans('txt_status')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="rooms_list">

                                </tbody>
                            </table>
                        </div>
                        
                        

                        <!--
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_remark_amount')}} </label>
                            {{Form::number('remark_amount',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"Remark Amount","placeholder"=>lang_trans('ph_enter').lang_trans('txt_remark_amount'),"min"=>0])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_remark')}}</label>
                            {{Form::textarea('remark',null,['class'=>"form-control h34 col-md-6 col-xs-12", "id"=>"remark", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_remark'),"rows"=>1])}}
                        </div>
-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_idcard_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content id_info">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label">{{lang_trans('txt_type_id')}} <span class="required">*</span></label>
                            {{ Form::select('idcard_type',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_id_number')}} <span class="required">*</span></label>
                            {{Form::text('idcard_no',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number')])}}
                        </div>
<!--
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_upload_idcard')}} <sup class="color-ff4">{{lang_trans('txt_multiple')}}</sup> </label>
                            {{Form::file('id_image[]',['class'=>"form-control",'id'=>'idcard_image','multiple'=>true])}}
                        </div>
-->
                    </div>
                     <div class="row">
                        <h5>Capture Image:-</h5>

                        <div class="col-md-6">
                            <a href="javascript:" id="snap" class="btn btn-success">Upload Photo By WebCam</a>
                            <div id="my_camera">
                            </div>
                            <input type=button value="Take Snapshot Front" onClick="take_snapshot()">
                            <input type=button value="Take Snapshot Back" onClick="take_snapshot_back()">
                              <input type="button" value="Close Webcam" onClick="closewebcam()">
                           <input type="hidden" name="id_cardno[]" id="id_card" class="images">
                           <input type="hidden" name="id_cardno[]" id="id_card_back" class="images">
                            
                           
                        </div>
                        <div class="col-md-3">
                            <div id="resultss">Your captured Front Side image will appear here...</div>
                            
                        </div>

                        <div class="col-md-3">
                            <div id="results-back">Your captured Back Side image will appear here...</div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_person_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="persons_info_parent">

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_payment_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12" id="bookingAmount">
                           
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_advance_payment')}}</label>
                            {{Form::number('advance_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"advance_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_advance_payment'),"min"=>0])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_payment_mode')}}</label>
                            {{Form::select('payment_mode',config('constants.PAYMENT_MODES'),null,['class'=>"form-control col-md-6 col-xs-12", "placeholder"=>"--Select"])}}
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-success btn-submit-form" type="submit">{{lang_trans('btn_submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{ Form::close() }}
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Photo</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="row">
                        <h5>Capture Image:-</h5>

                        <div class="col-md-6">
                            <a href="javascript:" class="snap_guest" class="btn btn-success">Upload Photo By WebCam</a>
                            <div class="my_camera">
                            </div>
                            <input type=button value="Take Snapshot Front" onClick="take_snapshot_guest()">
                            <input type=button value="Take Snapshot Back" onClick="take_snapshot_guest_back()">
                            <input type="hidden" name="id_card[]" id="id_card" class="images">
                        </div>
                        <div class="col-md-3">
                            <div class="resultss">Your captured Front Side image will appear here...</div>
                            
                        </div>

                        <div class="col-md-3">
                            <div class="results-back">Your captured Back Side image will appear here...</div>
                        </div>


                    </div>

            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-mdb-dismiss="modal">
                    Close
                </button>
               
            </div>
        </div>
    </div>
</div>

<div class="colne_persons_info_elem hide_elem">
    <div class="row persons_info_elem">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label"> {{lang_trans('txt_name')}} </label>
            {{Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name')])}}
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label"> {{lang_trans('txt_gender')}} </label>
            {{ Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label"> {{lang_trans('txt_age')}} </label>
            {{Form::number('persons_info[age][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">

            <label class="control-label">{{lang_trans('Picture by Webcam')}} </label>
            <button type="button" class="btn btn-primary photo_id" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
               Upload Photo WebCam
            </button>
            <input type="hidden" name="image_guest[]" class="image-tag">
            <!--
            <div class="col-md-6">
                <a href="javascript:" class="btn btn-success snap_guest">WebCam</a>
                <div class="my_camera">
                </div>
                <div class="col-md-3">
                    <div class="results_guest">Your captured image.</div>
                </div>
                <input type=button value="Take Snapshot" onClick="take_snapshot_guest()">
                
            </div>
-->


            <div class="col-md-3">

            </div>



            <!--            {{Form::textarea('persons_info[address][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_address'),"rows"=>1])}}-->
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label">{{lang_trans('txt_type_id')}} </label>
            {{ Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label">{{lang_trans('txt_id_number')}} </label>
            {{Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number')])}}
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
               <label class="control-label"> &nbsp;</label><br />
            <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
        </div>
    </div>
</div>
{{-- require set var in js var --}}
<script>

     $(document).ready(function(e) {

    $('#room_num').html('');
    $('#rooms_list').html('');
         var room_type = $('select[name=room_type_id]').val();
    var post_data={room_type_id:room_type};
     console.log(post_data);
    $( window ).on( "load", function() {
        globalFunc.ajaxCall('api/get-room-num-list', post_data, 'POST', globalFunc.before, globalFunc.listOfRooms, globalFunc.error, globalFunc.complete);
    });
   
  
   
  
//   globalFunc.listOfRooms=function(data){
//     var bookedRooms = data.booked_rooms;
//       console.log(data);
//     if(Object.keys(data.rooms).length>0){
//         var k=1;
//         var room_id = $('#room_id').val();
//         $.each(data.rooms,function(index,val){
//             if(index == room_id ){
//                  var statusBtn = '<span class="btn btn-xs btn-success">Available</span>';
//           var checkbox = '<input name="room_num[]" type="checkbox" data-roomid="'+index+'" value="'+val+'" class="room_checkbox" checked></td>';
                
//             }else
//                 {
//                     var statusBtn = '<span class="btn btn-xs btn-success">Available</span>';
//           var checkbox = '<input name="room_num[]" type="checkbox" data-roomid="'+index+'" value="'+val+'" class="room_checkbox" ></td>';
//           if(bookedRooms[val]!=undefined){
//             statusBtn = '<span class="btn btn-xs btn-cust">Booked</span>';
//             checkbox = '<input name="room_num_booked[]" type="checkbox" value="'+val+'" disabled></td>';
//           } 
//                 }
          
//           $('#rooms_list').append('<tr>\
//             <td width="5%">'+(k++)+'</td>\
//             <td width="5%">'+checkbox+'</td>\
//             <td>'+val+'</td>\
//             <td>'+statusBtn+'</td>\
//           </tr>');          
//         });
//     } else {
//       addNoRoomTr();
//     }
//   }
//   addNoRoomTr();
//   function addNoRoomTr(){
//     $('#rooms_list').append('<tr><td colspan="4"> No Rooms Found</td></tr>');
//   }
//           var room_ids = [];
//       globalVar.room_nums = [];
//       $.each($(".room_checkbox:checked"), function(){
//           Console.log("Hello");
//           globalVar.room_nums.push(room,$(this).val());
//           Console.log("Hello");
//           room_ids.push($(this).data('roomid'));
//       });
         
//            if(room_ids.length>0){
//         var post_data={room_ids:room_ids};
//         globalFunc.ajaxCall('api/get-room-details', post_data, 'POST', globalFunc.before, globalFunc.roomDetails, globalFunc.error, globalFunc.complete);
//       } else {
//         //$("#adult,#kids,#base_price").val('');
//         $("#base_price").val('100');
//       }
    
//   });
    
    
    
    $(document).ready(function() {
     

        $("#check_in_date_my").datepicker({
            minDate: 0
        });
        $('#referred_by').change(function() {
            var status = $(this).val();
            if (status == 'ThirdParty') {
                var html = '';
                html +=
                    '<label for="validationServerUsername">Booking ID</label>' +
                    '<input type="text" class="form-control" name="booking_id" id="" >';
                $('#booking_id').html(html);
            } else {
                $('#booking_id').remove();
            }

        });
    });

    $("#adult").keyup(function() {
        var value = $("#adult").val();
        var i = 1;
        //        if (value == 0) {
        //            $(".persons_info_parent").remove();
        //        }
        for (i; i <= value - 1; i++) {
            var html = $(".colne_persons_info_elem").html();
            $(".persons_info_parent").append(html);
        }

    });
    $("#kids").keyup(function() {
        var value = $("#kids").val();
        var i = 1;
        for (i; i <= value - 1; i++) {
            var html = $(".colne_persons_info_elem").html();
            $(".persons_info_parent").append(html);
        }

    });

    globalVar.page = 'room_reservation_add';

</script>
<script type="text/javascript" src="{{URL::asset('public/js/page_js/page.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script language="JavaScript">
   $(document).on('click', '.photo_id', function() {
        
    
       $("#exampleModal").modal('show');
    
    });  
    $(document).on('click', '#close', function() {
        
    
       $("#exampleModal").modal('hide');
    
    }); 
    $("#snap").click(function() {


        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');
    });
    $(document).on('click', '.snap_guest', function() {
        Webcam.set({
            width: 100,
            height: 100,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('.my_camera');



    });


   function take_snapshot() {
        Webcam.snap(function(data_uri) {
            $(".images").val(data_uri);
             $('#id_card').val(data_uri);
             var image=$('#id_card').val();
        
            document.getElementById('resultss').innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

    function take_snapshot_back() {
        Webcam.snap(function(data_uri) {
            $(".images").val(data_uri);
             $('#id_card_back').val(data_uri);
             var image=$('#id_card_back').val();
       
            document.getElementById('results-back').innerHTML = '<img src="' + data_uri + '"/>';
        });
    } 

    function take_snapshot_guest() {

        Webcam.snap(function(data_uri) {
            $(".images").val(data_uri);
            document.getElementsByClassName('resultss')[0].innerHTML = '<img src="' + data_uri + '"/>';
        });
    }
    function take_snapshot_guest_back() {
        Webcam.snap(function(data_uri) {
            $(".images").val(data_uri);
            document.getElementsByClassName('results-back')[0].innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

         $("#room_type_id").change(function() {
                var id = $(this).val();
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{route("room-types")}}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                  
                         var html = '';

                        var i;
                        for (i = 0; i < data.length; i++) {
                            if(data[i].is_base_price == 0 )
                                {
                                   html +=
                                '<label class="control-label"> Booking Payment </label>'+
                            '{{Form::number("booking_payment",null,["class"=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment","min"=>0])}}';
                                    }
                           
                        }

                        $('#bookingAmount').html(html);

                    },
                    error: function() {
                        alert('Could not get Data from Database');
                    }
                });
            });
     function closewebcam()
    {
        Webcam.reset('.my_camera');
    }

    

</script>
@endsection
