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
          yearRange: "-150:+0"
      });
   });
$(document).on('focus',".date_adult", function(){ //bind to all instances of class "date".
   $(this).datepicker({
         dateFormat: 'dd-mm-yy',
         changeMonth: true,
          changeYear: true,
          yearRange: "-150:+0"
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
           yearRange: "-40:-17"
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
$remark=DB::table('payment_remark')->get();
@endphp
<div class="">
   @if($flag==1)
   {{ Form::model($data_row,array('url'=>route('save-reservation'),'id'=>"update-reservation-form", 'class'=>"form-horizontal form-label-left",'files'=>true)) }}
   {{Form::hidden('id',null)}}
   @else
   {{ Form::open(array('url'=>route('save-reservation'),'id'=>"add-reservation-form", 'class'=>"form-horizontal form-label-left",'files'=>true)) }}
   @endif
   {{Form::hidden('per_room_price',null,['id'=>'base_price'])}}
   {{Form::hidden('per_room_price_new',null,['id'=>'base_priceprp'])}}
   {{Form::hidden('room_qty',null,['id'=>'room_qty'])}}
   <input type="hidden" id="flag_num" value="<?= $flag; ?>">
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
                  source: function(query, process) {
                     return $.get(path, {
                        query: query
                     }, function(data) {
                        console.log(data);
                        console.log(process.id);
                        console.log(data.name);
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
                        <label class="control-label"> Booking ID <span ></span></label>
                        <!--<input class="form-control col-md-6 col-xs-12" id="Booking_id" placeholder="Booking ID"  name="Booking_id" type="text" >-->
                        {{Form::text('Booking_id',$data_row->Booking_id ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"Booking_id", "placeholder"=>"Booking ID"])}}
                    </div>
                    <?php $getmid = ($getmid->value + 1) ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> And Serial No. <span class="required">*</span></label>
                        {{Form::text('and_number',$getmid ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"and_number", "placeholder"=>"And Number", 'required', 'disabled'])}}
                        <!--<input class="form-control col-md-6 col-xs-12" id="and_number" placeholder="And Number"  name="and_number" type="text" required>-->
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_fullname')}} <span class="required">*</span></label>
                        {{Form::text('name',$data_row->name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname'), 'required'])}}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_email')}} </label>
                        {{Form::email('email',$data_row->email ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])}}
                    </div>
                    <?php 
                    $country_code = '+91';
                    $result = preg_replace("/^\+?{$country_code}/", '',$data_row->mobile ?? '');
                    $result = $result ?? '';
                    $mobile = str_replace(" ", "", $result);
                    $mobile = $mobile ?? '';
                    //print_r($mobile);
                    ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Mobile No. <span class="required">*</span></label>
                        <!--{{--Form::text('mobile',$data_row->mobile ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile", "placeholder"=>"Enter Mobile No.", 'required'])--}}-->
                        <input class="form-control col-md-6 col-xs-12" autocomplete="off" onkeyup="moblie(this.value)" id="mobile" placeholder="Enter Mobile No." required="" name="mobile" type="number" value="{{$mobile}}">
                        <!--<select class="form-control col-md-6 col-xs-12" onkeyup="moblie(this.value)" length="10" id="mobile" placeholder="Enter Mobile No." required="" name="mobile">-->
                        <div id="find_numbuer">
                  
                        </div>
                        <!--</select>-->
                    </div>
                  
                  <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                  <!--   <label class="control-label"> {{lang_trans('txt_mobile_num')}} <span class="required">*</span></label>-->
                  <!--   {{Form::number('mobile',$data_row->mobile ?? '',['class'=>"form-control col-md-6 col-xs-12","length"=>"10" ,"id"=>"mobile", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num'), 'required'])}}-->
                  <!--</div>-->

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_gender')}} <span class="required">*</span></label>
                     {{ Form::select('gender',config('constants.GENDER'),$data_row->gender ?? '',['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), 'required']) }}
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_age')}} </label>
                     {{Form::text('age',$data_row->age ?? '',['class'=>"form-control datePickerDefault1 col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off"])}}
                     <!-- {{Form::number('age',$data_row->customer->age ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}} -->
                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> Address </label>
                     <input class="form-control col-md-6 col-xs-12" id="Address" placeholder="Enter Address" autocomplete="off" name="Address" type="text" value="{{$data_row->address ?? ''}}">
                  </div>
                  
                  <div class="col-md-4 col-sm-2 col-xs-12">
                     <label class="control-label"> Original Referred By </label>
                     {{Form::text('originally_referred_by',$data_row->referred_by_name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"originally_referred_by", 'disabled', 'style'=>"background: mediumspringgreen"])}}
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
                  <div class="col-md-4 col-sm-2 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_adults')}} <span class="required">*</span></label>
                     {{Form::number('adult',$data_row->adult ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"adult", "required"=>"required","placeholder"=>lang_trans('ph_enter').lang_trans('txt_adults'),"min"=>1, 'required'])}}
                  </div>
                  <div class="col-md-4 col-sm-2 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_kids')}} </label>
                     {{Form::number('kids',$data_row->kids ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"kids","placeholder"=>lang_trans('ph_enter').lang_trans('txt_kids'),"min"=>0])}}
                  </div>
                  <div class="col-md-4 col-sm-2 col-xs-12">
                     <label class="control-label"> Infant (below 5) </label>
                     {{Form::number('infant',$data_row->infant  ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"infant", "placeholder"=>" Infant (below 5) ","min"=>0])}}
                  </div>
               </div>
               <div class="row ">
                  <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                  <!--   <label class="control-label"> {{lang_trans('txt_vehicle_number')}}</label>-->
                  <!--   {{Form::text('vehicle_number',$data_row->vehicle_number ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"vehicle_number", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_vehicle_number')])}}-->
                  <!--</div>-->
                  <!--<div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">-->
                  <!--   <label class="control-label"> {{lang_trans('txt_reason_of_visit')}}</label>-->
                  <!--   {{Form::select('reason_visit_stay',config('constants.REASON'),$data_row->reason_visit_stay ?? '',['class'=>"form-control h34 col-md-6 col-xs-12", "id"=>"reason_visit_stay","rows"=>1])}}-->
                  <!--</div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_meal_plan')}}</label>
                     {{ Form::select('meal_plan',$mealplan_list ?? '',null,['class'=>'form-control',"id"=>"meal_plan",'placeholder'=>lang_trans('ph_select')]) }}
                  </div>
                  
                   <?php
                        $refby = $data_row->referred_by_name ?? '';
                        if($refby == 'F9'){
                    ?> 
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_referred_by_name')}}</label>
                     {{Form::select('referred_by_name',config('constants.REFERRED_BY_NAME'),$data_row->referred_by_name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name"])}}
                  </div>
                  
                  <?php }else if($refby != 'F9hotels'){ ?>
                  
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_referred_by_name')}}</label>
                     {{Form::select('referred_by_name',config('constants.REFERRED_BY_NAME'),'OTA',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name"])}}
                  </div>
                  
                  <?php }else{ ?>
                  
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_referred_by_name')}}</label>
                     {{Form::select('referred_by_name',config('constants.REFERRED_BY_NAME'),$data_row->referred_by_name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name"])}}
                  </div>
                  
                  <?php } ?>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> {{lang_trans('txt_referred_by_name')}}</label>-->
                    <!--    <select class="form-control col-md-6 col-xs-12" id="referred_by_name" name="referred_by_name">-->
                    <!--        <option value="F9">F9</option>-->
                    <!--    </select>-->
                    <!--</div>-->
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> </label>-->
                    <!--</div>-->

                    <div id="corporate"></div>
                </div>
               <div class="row ">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_checkin')}}<span class="required">*</span></label>
                        <?php
                         $d = new DateTime($data_row->check_in ?? '');
                         $dtPart = $d->format('Y-m-d');
                         $d2 = new DateTime($data_row->check_out ?? '');
                         $dtPart2 = $d2->format('Y-m-d');
                         $number_of_days=date_diff(date_create($dtPart2),date_create($dtPart));
                         $total_number_of_days=$number_of_days->format("%a");
                         ?>
                     {{Form::text('check_in_date_my',$dtPart ?? '',['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_in_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required', 'disabled'])}}
                     <input type="hidden" name="check_in_date" value="<?= $dtPart; ?>">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label"> {{lang_trans('txt_duration_of_stay')}} <span class="required">*</span></label>
                    {{Form::number('duration_of_stay',$total_number_of_days ?? 1,['class'=>"form-control col-md-6 col-xs-12", "id"=>"duration_of_stay", "placeholder"=>lang_trans('txt_duration_of_stay'),"min"=>1, 'required'])}}
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
                     <label class="control-label"> {{lang_trans('txt_room_type')}}<span class="required">*</span></label>
                     {{ Form::select('room_type_id',$roomtypes_list ?? '',null,['class'=>'form-control',"id"=>"checkin_room_type_id",'placeholder'=>lang_trans('ph_select'), 'required']) }}
                  </div>
                  <?php
                         
                         if($data_row->room_qty == 0){
                             $d = 1;
                         }else{
                             $d = $data_row->room_qty ?? '';
                         }
                         ?>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('No of Rooms')}} <span class="required">*</span></label>
                     {{Form::number('no_of_rooms',$d ?? 1,['class'=>"form-control col-md-6 col-xs-12", "id"=>"no_of_rooms", "placeholder"=>lang_trans('No of Rooms'),"min"=>1, 'required'])}}
                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> Booking Reason <!-- <span class="required">*</span>--></label> 
                        <select class="form-control" name="Booking_Reason"> <!-- id="package_id" -->
                           <option value=''>--Select--</option>
                           <option value='Personal'>Personal</option>
                           <option value='Business'>Business</option>
                           <option value='Leisure'>Leisure</option>
                        </select>
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
                     <label class="control-label">{{lang_trans('txt_type_id')}} </label>
                     {{ Form::select('idcard_type',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_id_number')}} </label>
                     {{Form::text('idcard_no',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no","placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number')])}}
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> {{lang_trans('txt_document_upload')}} </label>
                     {{Form::file('document_upload',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload","required"=>"required", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])}}
                  </div>
                  <sapn id="img"></sapn>
                  <sapn id="img1"></sapn>
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
                     <input type="hidden" name="id_cardno[]" id="id_card" class="id_cardno_front">
                     <input type="hidden" name="id_cardno[]" id="id_card_back" class="id_cardno_back">
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
    <div class="colne_persons_info_elem hide_elem">
       <div class="row persons_info_elem">
          <div class="col-md-2 col-sm-2 col-xs-12">
             <label class="control-label"> {{lang_trans('txt_name')}} </label>
             {{Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name'), "form"=> "add-reservation-form"])}}
          </div>
          <div class="col-md-2 col-sm-2 col-xs-12">
             <label class="control-label"> {{lang_trans('txt_gender')}} </label>
             {{ Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"]) }}
          </div>
          <div class="col-md-1 col-sm-1 col-xs-12">
             <label class="control-label"> {{lang_trans('txt_age')}} </label>
             {{Form::text('persons_info[age][]',null,['class'=>"form-control date_adult col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off", "form"=> "add-reservation-form"])}}
          </div>
          <div class="col-md-2 col-sm-1 col-xs-12">
             <label class="control-label"> {{lang_trans('txt_document_upload')}} <span class="required">*</span></label>
             <input type="file" name="persons_info[document_upload1][]" id="form-file" class="persons_document_upload" form="add-reservation-form" />
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
             {{ Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"]) }}
          </div>
          <div class="col-md-2 col-sm-2 col-xs-12">
             <label class="control-label">{{lang_trans('txt_id_number')}} </label>
             {{Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number'), "form"=> "add-reservation-form"])}}
          </div>
          <div class="col-md-1 col-sm-1 col-xs-12">
             <label class="control-label"> &nbsp;</label><br />
             <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
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
                <?php
                    $refby = $data_row->referred_by_name ?? '';
                    if($refby == 'F9'){
                ?> 
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"> Total Price</label>
                        {{Form::text('total_amount',$data_row->payment ?? '',['class'=>"form-control col-md-6 col-xs-12","id"=>"total_amount"])}}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"> {{lang_trans('Price per Room')}} <span class="required" id="booking_payment_span">*</span></label>
                        {{Form::text('booking_payment',$data_row->payment ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment_new", "required", 'disabled'])}}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12"> <!--id="management" -->
                        <label class="control-label"> {{lang_trans('txt_advance_payment')}}</label>
                        {{Form::number('advance_payment',0,['class'=>"form-control col-md-7 col-xs-12", "id"=>"advance_payment", "placeholder"=>"Advance Payment","required"])}}
                    </div>
                    
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"><span class="required">*</span> {{lang_trans('txt_payment_mode')}}</label>
                        <select name="payment_mode" class="form-control col-md-6 col-xs-12 select_id" id="payment" required>
                            
                        </select>
                    </div>
                    
                    <label class="control-label"> &nbsp;</label><br />
                <?php
                    }else if($refby == 'Booking.com'){
                        $totamnt = $data_row->payment ?? '';
                        // $amntnew = numberFormat($totamnt/1.12);
                        $gstamounttotal= $totamnt- ($totamnt/1.12);
                        $totgstnew = numberFormat($totamnt + $gstamounttotal);
                ?> 
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"> Total Price</label>
                        {{Form::text('total_amount',$totgstnew ?? 0,['class'=>"form-control col-md-6 col-xs-12","id"=>"total_amount"])}}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"> {{lang_trans('Price per Room')}} <span class="required" id="booking_payment_span">*</span></label>
                        {{Form::text('booking_payment',$data_row->payment ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment_new", "required", 'disabled'])}}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12"> 
                        <label class="control-label"> {{lang_trans('txt_advance_payment')}}</label>
                        {{Form::number('advance_payment',$data_row->advance ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"advance_payment", "placeholder"=>"Advance Payment","required"])}}
                    </div>
                    <!--<div class="col-md-3 col-sm-3 col-xs-12">-->
                        <!--<label class="control-label"><span class="required">*</span> {{--lang_trans('txt_payment_mode')--}}</label>-->
                        <!--{{--Form::select('payment_mode',$payment_mode_list ?? '',null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select", 'required'])--}}-->
                    <!--</div>-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"><span class="required">*</span> {{lang_trans('txt_payment_mode')}}</label>
                        <select name="payment_mode" class="form-control col-md-6 col-xs-12 select_id" id="payment" required>
                            
                        </select>
                    </div>
                    
                    <label class="control-label"> &nbsp;</label><br />
                    <input type="hidden" id="mainadvancenew" value="0">
                <?php
                    }else{
                ?> 
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"> Total Price</label>
                        {{Form::text('total_amount',$data_row->payment ?? '',['class'=>"form-control col-md-6 col-xs-12","id"=>"total_amount"])}}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"> {{lang_trans('Price per Room')}} <span class="required" id="booking_payment_span">*</span></label>
                        {{Form::text('booking_payment',$data_row->payment ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"booking_payment_new", "required", 'disabled'])}}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12"> 
                        <label class="control-label"> {{lang_trans('txt_advance_payment')}}</label>
                        {{Form::number('advance_payment',$data_row->advance ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"advance_payment", "placeholder"=>"Advance Payment","required"])}}
                    </div>
                    <!--<div class="col-md-3 col-sm-3 col-xs-12">-->
                        <!--<label class="control-label"><span class="required">*</span> {{--lang_trans('txt_payment_mode')--}}</label>-->
                        <!--{{--Form::select('payment_mode',$payment_mode_list ?? '',null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select", 'required'])--}}-->
                    <!--</div>-->
                    
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"><span class="required">*</span> {{lang_trans('txt_payment_mode')}}</label>
                        <select name="payment_mode" class="form-control col-md-6 col-xs-12 select_id" id="payment" required>
                            
                        </select>
                    </div>
                    
                    <label class="control-label"> &nbsp;</label><br />
                    <input type="hidden" id="mainadvancenew" value="0">
                
                <?php
                    }
                ?> 
               </div>
               <?php 
               if($data_row->advance){
                // $a=1;
                // for($p=0;$p<20;$p++)
                // {
                $date = date('Y-m-d',strtotime($data_row->created_at));
                     
                ?>
                <div class="row" id="remove" style="display:block">  
                    <div class="col-md-3">                            
                        <label class="control-label">Advance Payment</label>        
                        <input class="form-control col-md-4 col-xs-4" placeholder="Enter Advance Payment" id='mainadvancenew' name="payment[]" min="0" type="number" value="{{$data_row->advance}}">                        
                    </div>                         
                    <div class="col-md-3">                            
                        <label class="control-label"> Payment Mode</label>                            
                         {{Form::select('mode[]',$payment_mode_list ?? '',$data_row->payment_mode,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])}}
                        </select>                       
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Advance Payment Date</label> 
                        {{Form::text('pdateupdate[]',$date ?? '',['class'=>"form-control datepickerjc col-md-6 col-xs-12"])}}
                        <!--<input type="date" value="{{--$pp->payment_date--}}" class="form-control">-->
                    </div>
                    <!--<div class="col-md-2"> -->
                        <!--<button type="button" onclick="remove_addon" style="margin-top:25px" class="btn btn-danger add-new-advance"><i class="fa fa-minus"></i></button>     -->
                    <!--</div>-->
                </div>
                <?php } //$a++; }  ?>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <p style="font-size:18px;" id="pending_amount"></p>
                    </div>
                </div>
               <!--<div class="row" id="second_advance">-->
               <!--   <div class="col-md-3 col-sm-3 col-xs-12">-->
               <!--      <label class="control-label"> {{--lang_trans('txt_booking_payment')--}}</label>-->
               <!--      {{--Form::text('sec_booking_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"sec_booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_booking_payment'),"min"=>0, "disabled"])--}}-->
               <!--   </div>-->
               <!--   <div class="col-md-3 col-sm-3 col-xs-12" id="sec_management">-->
               <!--      <label class="control-label"> {{--lang_trans('txt_advance_payment')--}}</label>-->
               <!--      {{--Form::number('sec_advance_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"sec_advance_payment","placeholder"=>lang_trans('ph_enter').lang_trans('txt_advance_payment'),"min"=>0])--}}-->
               <!--   </div>-->
               <!--   <div class="col-md-3 col-sm-3 col-xs-12">-->
               <!--      <label class="control-label"> {{--lang_trans('txt_payment_mode')--}}</label>-->
               <!--      {{--Form::select('sec_payment_mode',config('constants.PAYMENT_MODES'),null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])--}}-->
               <!--   </div>-->
               <!--   &nbsp; <br />-->
               <!--   <button type="button" class="btn btn-danger remove-second-advance"><i class="fa fa-minus"></i></button>-->
               <!--   <button class="btn btn-success" style="display:none" id="first2" type="button" onclick="payment_link()">{{--lang_trans('Verify')--}}</button>-->
               <!--   <button class="btn btn-success" style="display:none" id="first4" type="button" onclick="paytm_Send_Link()">{{--lang_trans('Verify')--}}</button>-->

               <!--</div>-->
               <div class="ln_solid"></div>
               <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                  <button class="btn btn-success" style="display:none" id="first" type="button" onclick="payment_link()">{{lang_trans('Verify')}}</button>
                  <button class="btn btn-success btn-submit-form" type="button" id="arrivals_btn">{{lang_trans('btn_submit')}}</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" id="arrivals_id" name="arrivals_id" value="<?= $arrivals_id; ?>">
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

<div class="colne_persons_info_kids hide_elem">
   <div class="row persons_info_elem">
      <div class="x_title">
         <h2>{{lang_trans('Kids Info')}}</h2>
         <div class="clearfix"></div>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> {{lang_trans('txt_name')}} </label>
         {{Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name'), "form"=> "add-reservation-form"])}}
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> {{lang_trans('txt_gender')}} </label>
         {{ Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"]) }}
      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> {{lang_trans('txt_age')}} </label>
         {{Form::text('persons_info[age][]',null,['class'=>"form-control date col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off", "form"=> "add-reservation-form"])}}
      </div>
      <div class="col-md-2 col-sm-1 col-xs-12">
         <label class="control-label"> {{lang_trans('txt_document_upload')}} <span class="required">*</span></label>
         <input type="file" name="persons_info[document_upload1][]" id="form-file" class="persons_document_upload" form="add-reservation-form" />
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
         {{ Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"]) }}
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label">{{lang_trans('txt_id_number')}} </label>
         {{Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number'), "form"=> "add-reservation-form"])}}
      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> &nbsp;</label><br />
         <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
      </div>
   </div>
</div>
{{-- require set var in js var --}}
<script>

    $(".datepickerjc").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        maxDate: "d",
        minDate: "-30Y",
        yearRange: "-30:+0"
    });

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
                '<label class="control-label">OTA <span class="required">*</span></label>'+
                `<select name="ota" id="check" class="form-control col-md-6 col-xs-12 myotaall" required>
                    <option value='0'> Select -- </option>
                    @foreach($ota as $corp)
                        <option value="{{$corp->name}}" data-ota="{{$corp->id}}">{{$corp->name}}</option>
                    @endforeach
                </select>`+
                '@if($errors->has("ota"))<div class="error">{{ $errors->first("ota") }}</div>@endif';
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
            $("#ota_new").empty();
            var html = '';
            html +=
                ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                '<label class="control-label">OTA <span class="required">*</span></label>'+
                `<select name="ota" class="form-control col-md-6 col-xs-12 myotaall" id="ota_new" required>
                    <option value=""> Select -- </option>
                    @foreach($ota as $corp)
                        <option value="{{$corp->name}}" data-ota="{{$corp->id}}">{{$corp->name}}</option>
                    @endforeach
                </select>`+
                '@if($errors->has("ota"))<div class="error">{{ $errors->first("ota") }}</div>@endif';
            $('#corporate').html(html);
        }
        else if(status == 'Management')
        {
            $('#management').hide();
            $('#sec_management').hide();
            $('#corporate').html('');
        }
        else {
            $('#corporate').html('');
        }
    });
    
    $(".myotaall").ready(function() {
        var id = 1;
        // alert(id);
        $.ajax({
            type:'POST',
            url:"{{ route('myotaalldata3') }}",
            data:{"_token": "{{ csrf_token() }}",id:id},
            success:function(data){
                var isDefault = id;
                //console.log(isDefault);
                var selectj = '';
                var defaultset = "";
                $.each(data,function(key, value){
                    
                    if (value.otarelation == isDefault)  {
                        console.log(value.otarelation);
                        defaultset =  'selected';
                        selectj += '<option value=' + value.id +' class="test" '+ defaultset +'>' + value.payment_mode + '</option>';
                    }else{
                        selectj += '<option value=' + value.id + '>' + value.payment_mode + '</option>';
                    }
                    
                });
                $(".select_id").html(selectj);
                
            }
        });
        
    });
    
    $(document).ready(function() {
        $("#check_in_date_my").datepicker({
          startDate: '-0d',
        });
        $(document).on('click', '.btn-submit-form', function(e) {
            v = $(check_in_date_my).val();
            var d1 = new Date(v);
        });

        $(".myotaall").on('change', function() {
            var id = $(this).find(':selected').attr('data-ota');
            alert(id);
            
            $.ajax({
                type:'POST',
                url:"{{ route('myotaalldata') }}",
                data:{"_token": "{{ csrf_token() }}",id:id},
                success:function(data){
                    var isDefault = id;
                    //console.log(isDefault);
                    var selectj = '';
                    var defaultset = "";
                    $.each(data,function(key, value){
                        
                        if (value.otarelation == isDefault)  {
                            console.log(value.otarelation);
                            defaultset =  'selected';
                            selectj += '<option value=' + value.id +' class="test" '+ defaultset +'>' + value.payment_mode + '</option>';
                        }else{
                            selectj += '<option value=' + value.id + '>' + value.payment_mode + '</option>';
                        }
                        
                    });
                    $(".select_id").html(selectj);
                    
                }
            });
            
        });
        
        $(document).on('change',"#ota_new", function() {
            var id = $(this).find(':selected').attr('data-ota');
            alert(id);
            
            $.ajax({
                type:'POST',
                url:"{{ route('myotaalldata') }}",
                data:{"_token": "{{ csrf_token() }}",id:id},
                success:function(data){
                    var isDefault = id;
                    //console.log(isDefault);
                    var selectj = '';
                    var defaultset = "";
                    $.each(data,function(key, value){
                        
                        if (value.otarelation == isDefault)  {
                            console.log(value.otarelation);
                            defaultset =  'selected';
                            selectj += '<option value=' + value.id +' class="test" '+ defaultset +'>' + value.payment_mode + '</option>';
                        }else{
                            selectj += '<option value=' + value.id + '>' + value.payment_mode + '</option>';
                        }
                        
                    });
                    $(".select_id").html(selectj);
                    
                }
            });
            
        });       
        
    });
        
    $(document).on('change', '#payment', function(event) {
       loadSelectedDeviceOptions($(this).val());
    });

    function loadSelectedDeviceOptions(selectedOption) {
        console.log(selectedOption);
        if (selectedOption == 7) {
            $("#first").show();
            $("#first").attr("onclick", "payment_link()");
        } else if (selectedOption == 4) {
            $("#first").show();
            $("#first").attr("onclick", "paytm_Send_Link()");
        } else {
            $("#first").hide();
        }
    }
    
    $("#advance_payment").keyup(function() {
        var advanced_payment = document.getElementById("advance_payment").value;
        //   alert(advanced_payment);
        var duration_of_stay = document.getElementById("duration_of_stay").value;
        //   alert(duration_of_stay);
        var booking_payment = document.getElementById("booking_payment_new").value;
        //   alert(booking_payment);
        var no_of_rooms = document.getElementById("no_of_rooms").value;
        //   alert(no_of_rooms);
        var total_amount = document.getElementById("total_amount").value;
        var mainadnew = document.getElementById("mainadvancenew").value;
        //   alert();
        if(mainadnew){
            var pending_amount = total_amount-advanced_payment-mainadnew;
            $("#pending_amount").html("Pending Amount "+pending_amount);  
        }
       
        if((booking_payment * duration_of_stay * no_of_rooms) < advanced_payment)
        {
            swal({
               type: 'error',
               title: 'Oops...',
               text: 'Invalid Amount',
            })
            $("#advance_payment").val('');
        }
    });

</script>
<script>

    $("#adult").keyup(function() {
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
           
        var customer_id = $('input[name="selected_customer_id"]').val();
        $.ajax({
            url : '{{route("getDocument")}}?customer_id='+customer_id,
            type : 'GET',
            dataType: 'json',
            success : function(res)
            {
               
                $("[name=idcard_type]").val(res.idcard_type);
                $("[name=idcard_no]").val(res.idcard_no);
                var img="{{asset('storage/app')}}"+'/'+res.document;
                $("#img").html("<img src='"+img+"' height='50' width='70'>")
                $("#img1").html("<input type='hidden' name='document_id' value='"+res.document+"'>")
            }
        })
           
    });
    
    $("#adult").change(function() {
        var value = $("#adult").val();
        var i = 1;
        $(".persons_info_parent").empty();
        for (i; i <= value - 1; i++) {
            var html = $(".colne_persons_info_elem").html();
            $(".persons_info_parent").append(html);
            $('.date_adult:last').attr('id', 'adult_'+i);
        }
    });
    
    $("#kids").keyup(function() {
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
</script>
<script type="text/javascript" src="{{asset('public/js/page_js/page.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/js/custom.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


<script language="JavaScript">
    $(document).on('click', '.photo_id', function() {
        $("#exampleModal").modal('show');
    });

    $(document).on('click', '#close', function() {
        $("#exampleModal").modal('hide');
    });

    $(".remove-second-advance").click(function() {
        $("#second_advance").hide();
    })
    
    $("#snap").click(function() {
        Webcam.set({
            width: 250,
            height: 250,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');
    });
    $("#second_advance").hide();
    $(".add-new-advance").click(function() {
        $("#second_advance").show();
        var booking_amount = $("#booking_payment_new").val();
        $("#sec_booking_payment").val(booking_amount);
    })
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
            var image = $('#id_card').val();
            document.getElementById('resultss').innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

    function take_snapshot_back() {
        Webcam.snap(function(data_uri) {
            $(".id_cardno_back").val(data_uri);
            var image = $('#id_card_back').val();
            document.getElementById('results-back').innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

    function take_snapshot_guest() {
        Webcam.snap(function(data_uri) {
            $(".id_card_front").val(data_uri);
            $('#id_card_guest').val(data_uri);
            var image = $('#id_card_guest').val();
            document.getElementsByClassName('results_front_guest')[0].innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

    function take_snapshot_guest_back() {
        Webcam.snap(function(data_uri) {
            $(".id_card_back").val(data_uri);
            $('#id_card_guest_back').val(data_uri);
            var image = $('#id_card_guest_back').val()
            document.getElementsByClassName('results_back_guest')[0].innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

    function payment_link() {
        var val = $('input[name="guest_type"]:checked').val();
        if (val == "existing") {
            var customer_id = $('input[name="selected_customer_id"]').val();
            var advanced_payment = $('#advance_payment').val();
            var duration_of_stay = $('#duration_of_stay').val();
            var booking_payment = $('#booking_payment_new').val();
            // var payable= booking_payment - advanced_payment ;
            // alert(payable);
            if (customer_id == "") {
                alert('please select a customer');
            } 
            else {

                $.ajax({
                    url: "{{route('sendpaymentlink')}}?guest_type=existing&customer=" + customer_id + "&advanced_payment=" + advanced_payment + "&booking_payment=" + booking_payment,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                      console.log(response);
                    }
                 });
            }
        } else {
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var advanced_payment = $('#advance_payment').val();
            var booking_payment = $('#booking_payment_new').val();

            if (name != "" && email != "" && phone != "" && payment != "") {
                $.ajax({
                    url: "{{route('sendpaymentlink')}}?guest_type=new&name=" + name + "&email=" + email + "&phone=" + phone + "&advanced_payment=" + advanced_payment + "&booking_payment=" + booking_payment,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        alert('Payment Link Sent Sucessfully');
                    }
                });

            } else {
                alert('Enter Customer Information');
            }

        }
    }

    function paytm_Send_Link() {
        var val = $('input[name="guest_type"]:checked').val();
        if (val == "existing") {
            var customer_id = $('input[name="selected_customer_id"]').val();
            if (customer_id == "") {
                alert('please select a customer');
            } else {
    
                $.ajax({
                    url: "{{route('paytmSendLink')}}?guest_type=existing&customer=" + customer_id,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                    }
                });
    
            }
        } else {
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var payment = $('#advance_payment').val();


            if (name != "" && email != "" && phone != "" && payment != "") {
                $.ajax({
                    url: "{{route('paytmSendLink')}}?guest_type=new&name=" + name + "&email=" + email + "&phone=" + phone + "&payment=" + payment,
                    type: "get",
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        alert('Payment Link Sent Sucessfully');
                    }
                });

            } else {
                alert('Enter Customer Information');
            }
        }
    }
</script>

<script type="text/javascript">
    $(function() {
        $('#btnSaveImage').click(function() {
            var url = $('#image-form').attr('action');
            var data = $('#image-form').serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                datatype: "JSON",
                success: function(responce) {
    
                   $('#close').click();
                   $('#image-form')[0].reset();
    
                   var front = 'Your captured Front Side image will appear here..';
                   var back = 'Your captured Back Side image will appear here...';
    
                   $('.results_front_guest').html(front);
                   $('.results_back_guest').html(back);
    
                },
                error: function() {
                   alert('error');
                }
            });
        });
    });
</script>
<script>
    $(function() {
        $('#package_id').change(function() {
            var package_price = $(this).find(':selected').attr('data-price');
            var room_type = $(this).find(':selected').attr('data-room-type');
            if(package_price)
            {
               $("#booking_payment").val(package_price);
               $('#room_type_id > option ' ).each(function(index) {
                  if($(this).val() == room_type)
                  {
                     $('#room_type_id option').eq(index).prop('selected', true);
                  }
               });

            }
            else{
               $("#booking_payment").val();
            }
    
        });
    });
    
    $("#arrivals_btn").click(function(){
         //   alert('hello');
  var check1 =  $("#check").val();
//   alert(check1);
//   return false;
    if(check1=="0"){
        alert("Please select OTA");
        return false;
    }else{
        
    }
        var flag_num = $("#flag_num").val();
        var booking_payment = $("#booking_payment_new").val();
        if(booking_payment == 0)
        {
            $("#booking_payment_span").html("* Booking amount should be more than 0");
        }
        else{
            if(flag_num == 1)
            {
                $("#update-reservation-form").submit();
            }
            else
            {
                $("#add-reservation-form").submit();
            }
        }
    });

    function moblie(w)
    {
        console.log(w);
        if(w == "" || w == null )
        {
            document.getElementById("find_numbuer").innerHTML = "";
        }
        else
        {
            $.get("{{url('/mob')}}",
            {
                mob: w
            },
            function(data, status){
                document.getElementById("find_numbuer").innerHTML = data
                // alert("Data: " + data + "\nStatus: " + status);
            });
        }
    
    }

</script>
<script>

// $(function () {
//     yourFunction(); //this calls it on load
//         yourFunction2();
//         yourFunction3();
//     $("select#marca").change(yourFunction);
// });

    $(document).ready(function(){
        yourFunction();// onload it will call the function
        yourFunction2();
        yourFunction3();
        // adultchangenew();// onload it will call the function
    });

    function yourFunction(){
        var total_amount= $("#total_amount").val();
        //print_r(total_amount);
        var duration_of_stay= $("#duration_of_stay").val();
        var no_of_rooms = $("#no_of_rooms").val();
        var duration_roooms = duration_of_stay*no_of_rooms;
        var price_per_room= total_amount/duration_roooms;
        //var price_per_room = Math.round(price_per_room);
        var price_per_room = (price_per_room).toFixed(2);
        $("#booking_payment_new").val(price_per_room);
        $("#base_priceprp").val(price_per_room);
        
    }
    function yourFunction2(){
        var total_amount= $("#total_amount").val();
        //print_r(total_amount);
        var duration_of_stay= $("#duration_of_stay").val();
        var no_of_rooms = $("#no_of_rooms").val();
        var duration_roooms = duration_of_stay*no_of_rooms;
        var price_per_room= total_amount/duration_roooms;
        //var price_per_room = Math.round(price_per_room);
        var price_per_room = (price_per_room).toFixed(2);
        $("#booking_payment_new").val(price_per_room);
        $("#base_priceprp").val(price_per_room);
        
    }
    function yourFunction3(){
        var total_amount= $("#total_amount").val();
        //print_r(total_amount);
        var duration_of_stay= $("#duration_of_stay").val();
        var no_of_rooms = $("#no_of_rooms").val();
        var duration_roooms = duration_of_stay*no_of_rooms;
        var price_per_room= total_amount/duration_roooms;
        //var price_per_room = Math.round(price_per_room);
        var price_per_room = (price_per_room).toFixed(2);
        $("#booking_payment_new").val(price_per_room);
        $("#base_priceprp").val(price_per_room);
        
    }
    $("[name=total_amount]").keyup(function(){
        var total_amount= $("#total_amount").val();
        //print_r(total_amount);
        var duration_of_stay= $("#duration_of_stay").val();
        var no_of_rooms = $("#no_of_rooms").val();
        var duration_roooms = duration_of_stay*no_of_rooms;
        var price_per_room= total_amount/duration_roooms;
        //var price_per_room = Math.round(price_per_room);
        var price_per_room = (price_per_room).toFixed(2);
        $("#booking_payment_new").val(price_per_room);
        $("#base_priceprp").val(total_amount);
    })
    $("#duration_of_stay").keyup(function(){
        var duration_of_stay=$("#duration_of_stay").val();
        var total_amount = $("#total_amount").val();
        var no_of_rooms = $("#no_of_rooms").val();
        //var totalroom = $("#totalroom").val();
        var duration_roooms = duration_of_stay*no_of_rooms;
        var total_amount = total_amount/duration_roooms;
        //var total_amount = Math.round(total_amount);
        var total_amount = (total_amount).toFixed(2);
        $("#booking_payment_new").val(total_amount);
        $("#base_priceprp").val(total_amount);
    })
    $("#no_of_rooms").keyup(function(){
        var duration_of_stay=$("#duration_of_stay").val();
        var no_of_rooms = $("#no_of_rooms").val();
        var total_amount = $("#total_amount").val();
        //var totalroom = $("#totalroom").val();
        var duration_roooms = duration_of_stay*no_of_rooms;
        var total_amount = total_amount/duration_roooms;
        //var total_amount = total_amount/duration_of_stay*no_of_rooms;
        //var total_amount = Math.round(total_amount);
        var total_amount = (total_amount).toFixed(2);
        $("#booking_payment_new").val(total_amount);
        $("#base_priceprp").val(total_amount);
    })
</script>
<script>
    let id=1;
    function plus()
    {
       $("#remove"+id).show();
       id++;
       console.log(id)
    }

    function remove_addon(id)
    {
        $("#remove"+id).remove();
    }
</script>
@endsection
