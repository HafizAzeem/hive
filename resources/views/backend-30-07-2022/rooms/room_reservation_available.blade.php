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
<script>
    $(document).on('focus',".date", function(){ //bind to all instances of class "date".
       $(this).datepicker({
             dateFormat: 'dd-mm-yy',
             changeMonth: true,
              changeYear: true,
              yearRange: "-50:+0"
          });
       });
    $(document).on('focus',".date_adult", function(){ //bind to all instances of class "date".
       $(this).datepicker({
             dateFormat: 'dd-mm-yy',
             changeMonth: true,
              changeYear: true,
              yearRange: "-50:+0"
          });
       });
       $(function() {
          $(".datePickerDefault").datepicker({
             dateFormat: 'yy-mm-dd',
             format: 'L',
             minDate: 0

          });
          $(".datePickerDefault1").datepicker({
             dateFormat: 'dd-mm-yy',
             changeMonth: true,
              changeYear: true,
              yearRange: "-90:+0"
          });
       });
    </script>


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
                     {{ Form::text('selected_customer_id',null,['class'=>'typeahead form-control','placeholder'=>lang_trans('ph_select')]) }}
                     <!-- <input class="typeahead form-control" type="text"> -->
                  </div>
               </div>
            </div>
            <script type="text/javascript">
               var path = "{{ route('autocomplete') }}";
               $('input.typeahead').typeahead({
                   source:  function (query, process) {
                       return $.get(path, { query: query }, function (data) {
                           console.log(data);
                           return process(data);
                       });
                   }
               });
            </script>
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

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_gender')}} <span class="required">*</span></label>
                     {{ Form::select('gender',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_age')}} </label>
                     {{Form::text('age',null,['class'=>"form-control datePickerDefault1 col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}
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
                    <label class="control-label"> {{lang_trans('txt_meal_plan')}}</label>
                    {{ Form::select('meal_plan',$mealplan_list ?? '',null,['class'=>'form-control',"id"=>"meal_plan",'placeholder'=>lang_trans('ph_select')]) }}
                 </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label"> {{lang_trans('txt_referred_by_name')}}</label>
                    {{Form::select('referred_by_name',config('constants.REFERRED_BY_NAME'),$data_row->referred_by_name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name"])}}
                 </div>
                 <div id="corporate"></div>
                 </div>
                  {{-- <div class="col-md-4 col-sm-4 col-xs-12" id="booking_id">
                  </div> --}}
               </div>
               <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label"> {{lang_trans('txt_checkin')}}<span class="required">*</span></label>
                       <?php
                       $d = new DateTime($data_row->check_in ?? '');
                        $dtPart = $d->format('Y-m-d');
                        $d2 = new DateTime($data_row->check_out ?? '');
                        $dtPart2 = $d2->format('Y-m-d');
                        ?>
                    {{Form::text('check_in_date_my',$dtPart ?? '',['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_in_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required', 'disabled'])}}
                    <input type="hidden" name="check_in_date" value="<?= $dtPart; ?>">
                 </div>
                 <div class="col-md-4 col-sm-4 col-xs-12 ">
                    <label class="control-label"> {{lang_trans('txt_checkout')}} <span class="required">*</span></label>
                    {{Form::text('check_out_date',$dtPart2 ?? '',['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_out_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required'])}}
                 </div>
                 <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label"> Package</label>
                    <select class="form-control" name="package_id" id="package_id">
                       <option>--Select--</option>
                       @foreach($package_list as $pack)
                          <option value="{{$pack->id}}" data-price ="{{$pack->package_price }}" data-room-type="{{$pack->room_type_id}}">{{$pack->title}}</option>
                       @endforeach
                    </select>
                 </div>
               </div>
               <div class="row">

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
                            <input type="hidden" id="room_id" value="{{$room ?? ''}}">
                            <select name="room_type_id" id="room_type_id" class="form-control">
                                <option value="">Choose Room type</option>
                                <?php
                                         $roomtype=DB::table('room_types')->whereIsDeleted(0)->get();
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
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label"> {{lang_trans('txt_document_upload')}} </label>
                    {{Form::file('document_upload',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])}}
                 </div>
               </div>
               <div class="row">
                  <h5>Capture Image:-</h5>
                  <div class="col-md-6">
                     <a href="javascript:" id="snap" class="btn btn-success">Open WebCam</a>
                      <a href="javascript:" id="snapclose" class="btn btn-success">Close WebCam</a>
                     <div id="my_camera">
                     </div>
                     <input type=button value="Take Snapshot Front" onClick="take_snapshot()">
                     <input type=button value="Take Snapshot Back" onClick="take_snapshot_back()">
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
               <div class="persons_info_kids">
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
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label"> {{lang_trans('Booking Payment')}} <span class="required" id="booking_payment_span">*</span></label>
                     {{-- {{Form::number('booking_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('Booking Payment'),"required"=>"true","min"=>0])}} --}}
                     @if($data_row)
                        @if($data_row->package_price)
                           {{Form::text('booking_payment',$data_row->package_price ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('Booking Payment'),"required","min"=>0, 'required'])}}
                        @elseif($data_row->date_price)
                           {{Form::text('booking_payment',$data_row->date_price ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('Booking Payment'),"required","min"=>0, 'required'])}}
                        @else
                           {{Form::text('booking_payment',$data_row->final_price ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('Booking Payment'),"required","min"=>0, 'required'])}}
                        @endif
                     @else
                        {{Form::text('booking_payment','',['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('Booking Payment'),"required","min"=>0, 'required'])}}
                     @endif
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12" id="management">
                    <label class="control-label"> {{lang_trans('txt_advance_payment')}}</label>
                    {{Form::number('advance_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"advance_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_advance_payment'),"min"=>0])}}
                 </div>
                 <div class="col-md-3 col-sm-3 col-xs-12">
                    <label class="control-label"><span class="required">*</span> {{lang_trans('txt_payment_mode')}}</label>
                    {{Form::select('payment_mode',config('constants.PAYMENT_MODES'),null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select", 'required'])}}
                 </div>
                 <label class="control-label"> &nbsp;</label><br />
                  <button type="button" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>
               </div>
               <div class="row" id="second_advance">
                <div class="col-md-4 col-sm-4 col-xs-12">
                   <label class="control-label"> {{lang_trans('txt_booking_payment')}}</label>
                   {{Form::text('sec_booking_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"sec_booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_booking_payment'),"min"=>0, "disabled"])}}
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12" id="sec_management">
                   <label class="control-label"> {{lang_trans('txt_advance_payment')}}</label>
                   {{Form::number('sec_advance_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"sec_advance_payment","placeholder"=>lang_trans('ph_enter').lang_trans('txt_advance_payment'),"min"=>0])}}
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                   <label class="control-label"> {{lang_trans('txt_payment_mode')}}</label>
                   {{Form::select('sec_payment_mode',config('constants.PAYMENT_MODES'),null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])}}
                </div>
                &nbsp; <br />
                <button type="button" class="btn btn-danger remove-second-advance"><i class="fa fa-minus"></i></button>
                <button class="btn btn-success" style="display:none" id="first2" type="button" onclick="payment_link()">{{lang_trans('Verify')}}</button>
                <button class="btn btn-success" style="display:none" id="first4" type="button" onclick="paytm_Send_Link()">{{lang_trans('Verify')}}</button>

             </div>
               <div class="ln_solid"></div>
               <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                  <button class="btn btn-success" style="display:none" id="first" type="button" onclick="payment_link()">{{lang_trans('Verify')}}</button>
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
   <div class="modal-dialog modal-lg" role="document" style="max-width: 80%;">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Photos</h5>

         </div>

         <form action="{{route('save-guest-card')}}" method="post" enctype="multipart/form-data" id="image-form">
         @csrf
         <div class="row">

            <div class="col-md-4">
            <a href="javascript:" id="snapguest" class="btn btn-success">Open WebCam</a>
            <a href="javascript:" id="snapguestclose" class="btn btn-success">Close WebCam</a>
                     <div id="camera">
               </div>
<input type=button value="Take Snapshot Front" onClick="take_snapshot_guest()">
<input type=button value="Take Snapshot Back" onClick="take_snapshot_guest_back()">

<input type="hidden" name="id_cardno[]" id="id_card_guest" class="id_card_front">
<input type="hidden" name="id_cardno[]" id="id_card_guest_back" class="id_card_back">

            </div>
            <div class="col-md-4">
               <div class="results_front_guest">Your captured Front Side image will appear here...</div>
            </div>
            <div class="col-md-4">
               <div class="results_back_guest">Your captured Back Side image will appear here...</div>
            </div>
         </div>

         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btnSaveImage">
            Save Now
            </button>
            <button type="button" id="close" class="btn btn-secondary" data-mdb-dismiss="modal">
            Close
            </button>
         </div>

         </form>
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
         {{Form::text('persons_info[age][]',null,['class'=>"form-control date_adult col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12" id="new">
         <label class="control-label">{{lang_trans('Picture by Webcam')}} </label>
         <button type="button" class="btn btn-primary photo_id" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
         Upload Photo WebCam
         </button>
         <input type="hidden" name="image_guest[]" class="image-tag">
         <div class="col-md-3">
         </div>
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
<div class="colne_persons_info_kids hide_elem">
   <div class="row persons_info_elem">
   <div class="x_title">
               <h2>{{lang_trans('Kids Info')}}</h2>
               <div class="clearfix"></div>
            </div>
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
         {{Form::text('persons_info[age][]',null,['class'=>"form-control date col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"max"=>10])}}
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12" id="new">
         <label class="control-label">{{lang_trans('Picture by Webcam')}} </label>
         <button type="button" class="btn btn-primary photo_id" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
         Upload Photo WebCam
         </button>
         <input type="hidden" name="image_guest[]" class="image-tag">
         <div class="col-md-3">
         </div>
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
    $(".remove-second-advance").click(function() {

$("#second_advance").hide()})
$("#second_advance").hide();
$(".add-new-advance").click(function() {
    $("#second_advance").show();
    var booking_amount = $("#booking_payment").val();
    $("#sec_booking_payment").val(booking_amount);

})
 $('#referred_by_name').ready(function() {
                  var status = $('#referred_by_name').val();
                  if (status == 'Corporate') {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">Corporate</label>'+
                     `<select name="corporate" class="form-control col-md-6 col-xs-12">
                       @foreach($corporates as $corp)
                       <option value="{{$corp}}" @if($data_row == $corp)? selected @endif>{{$corp}}</option>
                       @endforeach
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'TA')
                  {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">TA</label>'+
                     `<select name="ta" class="form-control col-md-6 col-xs-12">
                       @foreach($tas as $corp)
                       <option value="{{$corp}}" selected>{{$corp}}</option>
                       @endforeach
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'OTA')
                  {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">OTA</label>'+
                     `<select name="ota" class="form-control col-md-6 col-xs-12">
                       @foreach($ota as $corp)
                       <option value="{{$corp}} selected">{{$corp}}</option>
                       @endforeach
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'Management')
                  {
                     $('#management').hide();
                     $('#sec_management').hide();
                  }
                  else {
                     $('#corporate').html('');
                  }
    });
     $('#referred_by_name').change(function() {
                  var status = $(this).val();
                  if (status == 'Corporate') {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">Corporate</label>'+
                     `<select name="corporate" class="form-control col-md-6 col-xs-12">
                       @foreach($corporates as $corp)
                       <option value="{{$corp}}" selected>{{$corp}}</option>
                       @endforeach
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'TA')
                  {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">TA</label>'+
                     `<select name="ta" class="form-control col-md-6 col-xs-12">
                       @foreach($tas as $corp)
                       <option value="{{$corp}}" selected>{{$corp}}</option>
                       @endforeach
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'OTA')
                  {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">OTA</label>'+
                     `<select name="ota" class="form-control col-md-6 col-xs-12">
                       @foreach($ota as $corp)
                       <option value="{{$corp}} selected">{{$corp}}</option>
                       @endforeach
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'Management')
                  {
                     $('#management').hide();
                     $('#sec_management').hide();
                  }
                  else {
                     $('#corporate').html('');
                  }
    });




   $(document).ready(function() {

       $("#check_in_date_my").datepicker({
           startDate: '-0d',


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

      $(document).on('change', '#payment', function( event ) {
            loadSelectedDeviceOptions($(this).val());
                       });
     function loadSelectedDeviceOptions(selectedOption) {

                       console.log(selectedOption);
                       if (selectedOption == 7)
                           {
                               $("#first").show();

                           }
                           else{
                               $("#first").hide();
                           }

                   }

                   $("#adult").keyup(function() {
               console.log("adult");
               var value = $("#adult").val();
               var i = 1;
               $(".persons_info_parent").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_elem").html();
                  $(".persons_info_parent").append(html);
                  $('.date_adult:last').attr('id', 'adult_'+i);
                //   .promise()
                //   .done(function() {
                //   $(".persons_info_parent").find(".datePickerDefault1").datepicker({
                //              changeMonth: true,
                //               changeYear: true,
                //               yearRange: "-50:+0"
                //           });
                //     });
               }
            });
            $("#adult").change(function() {
               console.log("adult1");
               var value = $("#adult").val();
               var i = 1;
               $(".persons_info_parent").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_elem").html();
                   $(".persons_info_parent").append(html);
                     $('.date_adult:last').attr('id', 'adult_'+i);
                //   .promise()
                //   .done(function() {
                //   $(".persons_info_parent").find(".datePickerDefault1").datepicker({
                //              changeMonth: true,
                //               changeYear: true,
                //               yearRange: "-50:+0"
                //           });
                //     });
               }
            });
            $("#kids").keyup(function() {
               console.log("kids1");
               var value = $("#kids").val();
               var i = 0;
               $(".persons_info_kids").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_kids").html();
                  $(".persons_info_kids").append(html);
                  $('.date:last').attr('id', 'kids_'+i);
               }
            });
            $("#kids").change(function() {
               console.log("kids2");
               var value = $("#kids").val();
               var i = 0;
               $(".persons_info_kids").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_kids").html();
                  $(".persons_info_kids").append(html);
                  $('.date:last').attr('id', 'kids_'+i);
               }
            });

   globalVar.page = 'room_reservation_add';





   $(document).ready(function(e) {

$('#room_num').html('');
$('#rooms_list').html('');
     var room_type = $('select[name=room_type_id]').val();
var post_data={room_type_id:room_type};
 console.log(post_data);
$( window ).on( "load", function() {
    globalFunc.ajaxCall('api/get-room-num-list', post_data, 'POST', globalFunc.before, globalFunc.listOfRooms, globalFunc.error, globalFunc.complete);
});




globalFunc.listOfRooms=function(data){
    var room_ids = [];
var bookedRooms = data.booked_rooms;
  console.log(data);

  globalVar.room_nums = [];
if(Object.keys(data.rooms).length>0){
    var k=1;
    var room_id = $('#room_id').val();
    $.each(data.rooms,function(index,val){
        if(index == room_id ){
             var statusBtn = '<span class="btn btn-xs btn-success">Available</span>';
      var checkbox = '<input name="room_num[]" type="checkbox" data-roomid="'+index+'" value="'+val+'" class="room_checkbox" checked></td>';
      globalVar.room_nums.push(room_id);

        }else
            {
                var statusBtn = '<span class="btn btn-xs btn-success">Available</span>';
      var checkbox = '<input name="room_num[]" type="checkbox" data-roomid="'+index+'" value="'+val+'" class="room_checkbox" ></td>';
      if(bookedRooms[val]!=undefined){
        statusBtn = '<span class="btn btn-xs btn-cust">Booked</span>';
        checkbox = '<input name="room_num_booked[]" type="checkbox" value="'+val+'" disabled></td>';
      }
            }

      $('#rooms_list').append('<tr>\
        <td width="5%">'+(k++)+'</td>\
        <td width="5%">'+checkbox+'</td>\
        <td>'+val+'</td>\
        <td>'+statusBtn+'</td>\
      </tr>');
    });
} else {
  addNoRoomTr();
}
}
addNoRoomTr();
function addNoRoomTr(){
$('#rooms_list').append('<tr><td colspan="4"> No Rooms Found</td></tr>');
}
var room_ids = [];


       if(room_ids.length>0){
    var post_data={room_ids:room_ids};
    globalFunc.ajaxCall('api/get-room-details', post_data, 'POST', globalFunc.before, globalFunc.roomDetails, globalFunc.error, globalFunc.complete);
  } else {
    //$("#adult,#kids,#base_price").val('');
    $("#base_price").val('100');
  }

});
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
           width: 250,
           height: 250,
           image_format: 'jpeg',
           jpeg_quality: 90
       });

       Webcam.attach('#my_camera');
   });
    $("#snapclose").click(function() {




   Webcam.reset('#my_camera');
});
$("#snapguest").click(function() {


   Webcam.set({
       width: 250,
       height: 250,
       image_format: 'jpeg',
       jpeg_quality: 90
   });

   Webcam.attach('#camera');
});
$("#snapcloseguest").click(function() {




   Webcam.reset('#camera');
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
           $(".id_card_front").val(data_uri);
           $('#id_card_guest').val(data_uri);
           var image=$('#id_card_guest').val()

           document.getElementsByClassName('results_front_guest')[0].innerHTML = '<img src="' + data_uri + '"/>';
       });
   }


   function take_snapshot_guest_back() {
       Webcam.snap(function(data_uri) {
           $(".id_card_back").val(data_uri);
           $('#id_card_guest_back').val(data_uri);
           var image=$('#id_card_guest_back').val()

           document.getElementsByClassName('results_back_guest')[0].innerHTML = '<img src="' + data_uri + '"/>';
       });
   }

   function payment_link(){
       var val=$('input[name="guest_type"]:checked').val();
       if(val=="existing"){
           var customer_id=$('input[name="selected_customer_id"]').val();
           if(customer_id==""){
               alert('please select a customer');
           }else{

               $.ajax({
                   url: "{{route('sendpaymentlink')}}?guest_type=existing&customer="+customer_id,
                   type: "get",
                   dataType: 'json',
                   success: function (response) {
                       console.log(response);
                   }
               });

           }
       }else{
           var name=$('#name').val();
           var email=$('#email').val();
           var phone=$('#phone').val();
           var payment=$('#advance_payment').val();


           if(name!="" && email!="" && phone!="" && payment!=""){
               $.ajax({
                   url: "{{route('sendpaymentlink')}}?guest_type=new&name="+name+"&email="+email+"&phone="+phone+"&payment="+payment,
                   type: "get",
                   dataType: 'json',
                   success: function (response) {
                        console.log(response);
                        alert('Payment Link Sent Sucessfully');
                   }
               });

           }else{
               alert('Enter Customer Information');
           }




       }

   }

</script>



	<script type="text/javascript">



 $(function(){


   $('#btnSaveImage').click(function(){
          var url = $('#image-form').attr('action');
          var data = $('#image-form').serialize();



        $.ajax({
                type:'POST',
                url:url,
                data:data,
                datatype:"JSON",
                success:function(responce)
                {

               $('#close').click();
               $('#image-form')[0].reset();

            var front='Your captured Front Side image will appear here..';
            var back='Your captured Back Side image will appear here...';

            $('.results_front_guest').html(front);
            $('.results_back_guest').html(back);

                },
                error:function()
                {
                    alert('error');
                }
            });


   });
});
	</script>
@endsection
