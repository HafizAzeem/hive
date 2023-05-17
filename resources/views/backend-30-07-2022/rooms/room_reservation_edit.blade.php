@extends('layouts.master_backend')
@section('content')
<style type="text/css">
    #results {
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
$multi_room = '';//$data_row->room_num;
$multi_room_id = '';//$data_row->id;
$c=1;
$remark=DB::table('payment_remark')->get();
if($customer_room_data != "empty")
{
    
    foreach($customer_room_data as $key => $room_dt)
    {
    
        $multi_room .=  ','.$room_dt->room_num;
        $multi_room_id.= ','.$room_dt->id;
        $c++;
    
    }
}

@endphp
<div class="">
    @if($flag==1)
    {{ Form::model($data_row,array('url'=>route('update-room-reservation'),'id'=>"update-reservation-form", 'class'=>"form-horizontal form-label-left",'files'=>true)) }}
    {{Form::hidden('id',null)}}
    @else
    {{ Form::open(array('url'=>route('update-room-reservation'),'id'=>"add-reservation-form", 'class'=>"form-horizontal form-label-left",'files'=>true)) }}
    @endif
   
    {{Form::hidden('room_qty',null,['id'=>'room_qty'])}}
    {{Form::hidden('room_no_switch',$data_row->room_num,['id'=>'room_no_switch'])}}
    {{Form::hidden('resId',$data_row->id,['id'=>'resId'])}}

    {{Form::hidden('customerId',$data_row->customer->id,['id'=>'customerId'])}}
    {{Form::hidden('default_room_type_id',$data_row->room_type_id,['id'=>'default_room_type_id'])}}
    {{Form::hidden('default_meal_plan',$data_row->meal_plan,['id'=>'default_meal_plan'])}}
    {{Form::hidden('checkin_type',$data_row->checkin_type,['id'=>'checkin_type'])}}
    {{Form::hidden('total_room_id',$multi_room_id,['id'=>'total_room_id'])}}
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
                            <input class="typeahead form-control" type="text">
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
                        @if($data_row->customer->Booking_id !="")
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label"> Booking ID <span class="required"></span></label>
                                <input class="form-control col-md-6 col-xs-12" id="name" value="{{$data_row->customer->Booking_id}}" name="Booking_id" type="text">
                            </div>
                        @else
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label"> Booking ID <span class="required"></span></label>
                                <input class="form-control col-md-6 col-xs-12" id="Booking_id" placeholder="Booking ID"  name="Booking_id" type="text" >
                            </div>
                        @endif



                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_fullname')}} <span class="required">*</span></label>
                            {{Form::text('name',$data_row->customer->name,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname'),"value"=>$data_row->customer->name])}}
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_email')}} </label>
                            {{Form::email('email',$data_row->customer->email,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_mobile_num')}} <span class="required">*</span></label>
                            <input class="form-control col-md-6 col-xs-12" id="mobile" placeholder="Enter Mobile No." length="10" maxlength="10" onkeyup="mobile1()" name="mobile" type="text" value="{{$data_row->customer->mobile}}" aria-invalid="true">
                            <label id="mobile-error"mobile style="display:none" class="error" for="mobile">Please enter at least 10 characters.</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_age')}} </label>
                            <!--{{Form::number('age',$data_row->customer->age,['class'=>"form-control col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}-->
                             {{Form::text('age',date('d-m-Y', strtotime($data_row->customer->dob)),['class'=>"form-control datePickerDefault1 col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Address </label>
                            <!--{{Form::number('age',$data_row->customer->age,['class'=>"form-control col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}-->
                             {{Form::text('address',$data_row->customer->address,['class'=>"form-control col-md-6 col-xs-12", "id"=>"age",  "autocomplete"=>"off"])}}
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
                  <div class="row">
                       <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x:auto;">

                     <table class="table table-bordered">
                        <tr>
                           <th>{{lang_trans('txt_name')}}</th>
                           <th>{{lang_trans('txt_gender')}}</th>
                           <th>{{lang_trans('txt_dob')}}</th>
                           <th>{{lang_trans('txt_idcard_type')}}</th>
                           <th>ID No</th>
                           <th>{{lang_trans('document')}}</th>
                           <!--<th> Id Cards</th>-->
                        </tr>

                        <tr>

                           <td>
                                <input type="text" value="{{$data_row->customer->name}}" class="form-control">
                           </td>

                           <td>
                                {{ Form::select('gender',config('constants.GENDER'),$data_row->customer->gender ?? '',['class'=>'form-control','placeholder'=>lang_trans('ph_select') ]) }}
                           </td>

                           <td>
                                <input type="text" value="{{$data_row->customer->dob}}"  class="form-control datePickerDefault1 ">
                           </td>

                            <td>
                                <select class="form-control col-md-6 col-xs-12" name="idcard_type">
                                    <option @if($data_row->customer->idcard_type == 1) selected="selected" @endif  value="1">Aadhar Card</option>
                                    <option @if($data_row->customer->idcard_type == 2) selected="selected" @endif value="2"> License</option>
                                    <option @if($data_row->customer->idcard_type == 3) selected="selected" @endif value="3">Passport</option>
                                    <option @if($data_row->customer->idcard_type == 4) selected="selected" @endif value="4">Voter Id</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control col-md-6 col-xs-12" id="idcard_no" value="{{$data_row->idcard_no}}" name="idcard_no" type="text">
                            </td>
                            <td>
                                <input type="hidden" name="document_upload_id" value="{{$data_row->customer->id}}">
                                {{Form::file('document_upload',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])}}
                                @php $documentsDetails =explode("/",$data_row->customer->document);
                                    $documentName = end($documentsDetails);
                                @endphp
                                <label>
                                    <a href="{{asset('storage/app/public/files/'.$documentName)}}" download>{{$documentName}}</a>
                                </label>
                            </td>

                            <td></td>
                        </tr>



                               <!-- Other Persons Data -->
                      
                        @if($data_row->persons)
                        @foreach($data_row->persons as $k=>$val)
                        <tr>
                           {{-- <td>{{$k+1}}</td> --}}
                           <input type="hidden" value="{{$val->id}}" name="persons_info[id][]" class="form-control">
                           <input type="hidden" value="{{$k}}" name="persons_info[count]" class="form-control">
                          
                           <td>
                           <input type="text" value="{{$val->name}}" name="persons_info[name][]" class="form-control">
                           </td>
                           <td>
                            <input type="text" value="{{$val->gender}}" name="persons_info[gender][]" class="form-control">
                          </td>
                          <td>
                            <input type="text" value="{{$val->dob}}" name="persons_info[age][]" class="form-control ">
                          </td>

                          <td>
                                <select class="form-control col-md-6 col-xs-12" name="persons_info[idcard_type][]">
                                    <option @if($val->idcard_type == 1) selected="selected" @endif  value="1">Aadhar Card</option>
                                    <option @if($val->idcard_type == 2) selected="selected" @endif value="2"> License</option>
                                    <option @if($val->idcard_type == 3) selected="selected" @endif value="3">Passport</option>
                                    <option @if($val->idcard_type == 4) selected="selected" @endif value="4">Voter Id</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control col-md-6 col-xs-12" id="idcard_no" value="{{$val->idcard_no}}" name="persons_info[idcard_no][]" type="text">
                            </td>
                        
                        <td>
                                <input type="hidden" name="persons_info[document_upload_id]" value="{{$val->id}}">
                                {{Form::file('persons_info[document_upload][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload1", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])}}
                                </a>
                                @php $documentsDetails =explode("/",$val->document);
                                  $documentName = end($documentsDetails);
                                  @endphp
                                   <label>
                                <a href="{{asset('storage/app/public/files/'.$documentName)}}" download>{{$documentName}}</a>
                             </label>
                            </td>

                           <td>
                              <div class="row">
                                 <div class="col-sm-6 col-xs-12">
                                    <input type="hidden" name="file1[]" value="{{$val->id}}">
                                    <img src="{{asset($val->cnic_front)}}" height="120px" width="120px" style="margin-left:10px"><br><br>
                                    <a href="{{asset($val->cnic_front)}}"  class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>
                                    <button type="button" class="btn btn-sm btn-success" title="Print" onclick="PrintImage('https://58.dsrhotelgroup.com/{{$val->cnic_front}}')">
                                        <i class="fa fa-print" ></i>
                                    </button>
                                 </div>
                                 <div class="col-sm-6 col-xs-12">
                                     {{$documentName}}
                                    <input type="hidden" name="cnic_back1[]" value="{{$val->id}}">
                                    <img src="{{asset($val->cnic_back)}}"  height="120px" width="120px"><br><br>
                                    <a href="{{asset($val->cnic_back)}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>
                                    <button type="button" class="btn btn-sm btn-success" title="Print" onclick="PrintImage('https://58.dsrhotelgroup.com/{{$val->cnic_back}}')">
                                        <i class="fa fa-print" ></i>
                                    </button>
                                 </div>
                                 <div class="col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn-primary photo_id" data-step="1" data-oldid="{{$val->id}}" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                                    Upload Photo
                                    </button>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                           <td colspan="7">{{lang_trans('txt_no_record')}}</td>
                        </tr>
                        @endif

                         <!-- End Other Persons Data -->
                     </table>
                        </div>

                  </div>
              </div>
          </div>
      </div>
  </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label"> {{lang_trans('txt_reserved_rooms')}}<span class="required">*</span></label>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>{{lang_trans('txt_room')}}</th>
                        <th>{{lang_trans('txt_room_num')}}</th>
                        <th>{{lang_trans('txt_action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            @if($data_row->room_type)
                            {{$data_row->room_type->title}}<br />
                            ( {{lang_trans('txt_room_num')}} : {{$multi_room}} )
                            @endif
                        </td>
                        <td>
                            {{$multi_room}}
                        </td>
                        <td>
                            <a href="javascript:" id="btn-switch" class="btn btn-success">{{lang_trans('txt_switch')}}</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_checkin_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">


                        <div class="col-md-12 col-sm-12 col-xs-12 " id="change_room">
                            @if($customer_room_data != 'empty')
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Choose Room</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control col-md-12 col-xs-12" id='listed_rooms' name="listed_rooms[]" multiple>
                                
                                <!--<option value=''>Choose Switch Room</option>-->
                                <!--<option id="{{ $data_row->id }}" value="{{ $data_row->id }}" data-room="{{$data_row->room_num}}">{{ $data_row->room_num}}</option>-->
                               
                                @foreach($customer_room_data as $room_dt)
                                <option class="room_options" id="{{ $room_dt->id }}" value='{{ $room_dt->id}}' data-room='{{ $room_dt->room_num }}' data-per-room-price = "{{ $room_dt->per_room_price }}" data-booking-payment="{{ $room_dt->booking_payment }}" data-advance-payment="{{ $room_dt->advance_payment }}" data-sec-advance-payment="{{ $room_dt->sec_advance_payment }}">{{ $room_dt->room_num }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        @endif
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label"> {{lang_trans('txt_room_type')}}<span class="required">*</span></label>
                                {{ Form::select('room_type_id',$roomtypes_list,$roomtypes_list[1],['class'=>'form-control',"id"=>"room_type_id",'placeholder'=>lang_trans('ph_select')]) }}
                                <label class="control-label"> {{lang_trans('txt_select_rooms')}}<span class="required">*</span></label>
                            </div>
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
                        <div class="col-md-4 col-sm-4 col-xs-12">

                            <label class="control-label"> {{lang_trans('txt_checkin')}}<span class="required">*</span></label>
                            {{Form::text('check_in_date',$data_row->check_in,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_in", "placeholder"=>lang_trans('ph_date'),'readonly'=>true,'disabled'=>true, "autocomplete"=>"off"])}}
                            <input type="hidden" id="check_in_date_my" value="{{date('Y-m-d',strtotime($data_row->check_in))}}">
                        </div>
                        {{-- <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_checkout')}} <span class="required">*</span></label>
                            {{Form::text('check_out_date',$data_row->user_checkout,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_out", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                        </div> --}}
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_duration_of_stay')}} <span class="required">*</span></label>
                            {{Form::number('duration_of_stay',$data_row->duration_of_stay,['class'=>"form-control col-md-6 col-xs-12", "id"=>"duration_of_stay", "placeholder"=>lang_trans('txt_duration_of_stay'),"min"=>1, 'required'])}}
                         </div>

                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_adults')}} <span class="required">*</span></label>
                            {{Form::number('adult',$data_row->adult,['class'=>"form-control col-md-7 col-xs-12", "id"=>"adult", "required"=>"required","placeholder"=>lang_trans('ph_enter').lang_trans('txt_adults'),"min"=>1])}}
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_kids')}} </label>
                            {{Form::number('kids',$data_row->kids,['class'=>"form-control col-md-7 col-xs-12", "id"=>"kids","placeholder"=>lang_trans('ph_enter').lang_trans('txt_kids'),"min"=>0])}}
                        </div>

                        <div class="col-md-4 col-sm-2 col-xs-12">
                            <label class="control-label"> Infant (below 5) </label>
                            {{Form::number('infant',$data_row->infant  ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"infant","placeholder"=>" Infant (below 5) ","min"=>0])}}
                        </div>


                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_meal_plan')}}</label>
                            {{ Form::select('meal_plan',$mealplan_list ?? '',null,['class'=>'form-control',"id"=>"meal_plan",'placeholder'=>lang_trans('ph_select')]) }}
                         </div>

                         <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Booking Reason </label>
                            <select class="form-control" name="Booking_Reason" id="package_id">
                                <option value='' @if($data_row->Booking_Reason == "") selected    @endif >--Select--</option>
                                <option value='Personal' @if($data_row->Booking_Reason == "Personal") selected    @endif >Personal</option>
                                <option value='Business' @if($data_row->Booking_Reason == "Business") selected    @endif >Business</option>
                                <option value='Leisure' @if($data_row->Booking_Reason == "Leisure") selected    @endif >Leisure</option>
                            </select>



                        </div>


                        <div class="col-md-4 col-sm-4 col-xs-12">
                             <label class="control-label"> {{lang_trans('txt_referred_by_name')}}</label>
                             {{Form::select('referred_by_name',config('constants.REFERRED_BY_NAME'),$data_row->referred_by_name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name"])}}
                        </div>
                        <div id="corporate"></div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                             <label class="control-label"> Special Requests </label>
                             <input class="form-control col-md-6 col-xs-12" id="Special_Requests" placeholder="Special Requests" value="" name="Special_Requests" type="text">
                        </div>




                        @if(isset($ota_check[0]->reconciliation))
                            @if($ota_check[0]->reconciliation == 1)
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label"> Reconciliation status </label>
                                    <select class="form-control col-md-6 col-xs-12" name="persons_info[Reconciliation]">
                                        <option @if($data_row->Reconciliation == "") selected="selected" @endif value=""> Select </option>
                                        <option @if($data_row->Reconciliation == "Completed") selected="selected" @endif value="Completed">Completed</option>
                                        <option @if($data_row->Reconciliation == "Pending") selected="selected" @endif value="Pending">Pending</option>
                                        
                                    </select>
                                </div>  
                            @endif
                            
                        @endif
                        @if($data_row->referred_by_name == "OTA")
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label"> Reserved Room</label>
                                <select class="form-control" name="room_types" id="package_id">
                                    <option value='' @if($data_row->room_type == "") selected    @endif >--Select--</option>
                                    @foreach($roomtypes_list as $key=>$val)
                                        <option value='{{$val}}' @if($data_row->room_types == $val) selected    @endif >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label">OTA Booking Date</label>
                                <input class="form-control datePickerDefault1 col-md-6 col-xs-12 hasDatepicker" id="ota_booking_date" placeholder="OTA Booking Date" autocomplete="off" name="ota_booking_date" type="date" value="{{$data_row->ota_booking_date}}">
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label">OTA Discount</label>
                                <input class="form-control col-md-6 col-xs-12" id="ota_discount" placeholder="OTA Discount" autocomplete="off" name="ota_discount" type="text" value="{{$data_row->ota_discount}}">
                            </div>
                            
                            
                              <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Revenue from Bills (ECI/LCO)</label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="LCO" @if(isset($data_row->LCO)) value="{{$data_row->LCO}}"  @else   placeholder="Revenue from Bills (ECI/LCO)" @endif name="LCO" type="number">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="LCO_type" name="LCO_type" aria-invalid="false">
                            @if(isset($data_row->LCO_type))
                              <option value="" @if($data_row->LCO_type == "") selected   @endif> Select </option>
                              <option value="precentage" @if($data_row->LCO_type == "precentage")  selected   @endif>In %</option>
                              <option value="Amount" @if($data_row->LCO_type == "Amount") selected   @endif>In Amount</option>
                            @else
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            @endif
                            </select>
                            </div>
                        </div>
                      </div>
                            
                        <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Revenue from Meals <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="Meals" @if(isset($data_row->Meals)) value="{{$data_row->Meals}}"  @else   placeholder="Revenue from Meals" @endif  name="Meals" type="number">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="Meals_type" name="Meals_type" aria-invalid="false">
                            @if(isset($data_row->Meals_type))
                              <option value="" @if($data_row->Meals_type == "") selected   @endif> Select </option>
                              <option value="precentage" @if($data_row->Meals_type == "precentage") selected   @endif>In %</option>
                              <option value="Amount" @if($data_row->Meals_type == "Amount") selected   @endif>In Amount</option>
                            @else
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            @endif
                            </select>
                            </div>
                        </div>
                      </div>
                            
                            
                            
                            
                            
                            
                            

                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('txt_idcard_uploaded')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <table class="table table-bordered">
                                <tr>
                                    <th>{{lang_trans('txt_sno')}}.</th>
                                    <th>{{lang_trans('txt_action')}}</th>
                                </tr>
                                @if($data_row->id_cards)
                                @foreach($data_row->id_cards as $k=>$val)
                                @if($val->file!='')
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>
        <a href="{{checkFile($val->file,'uploads/id_cards/','blank_id.jpg')}}" data-toggle="lightbox" data-title="{{lang_trans('txt_idcard')}}" data-footer="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> </a>
            <a href="{{checkFile($val->file,'uploads/id_cards/','blank_id.jpg')}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="2">{{lang_trans('txt_no_file')}}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
-->


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_person_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="persons_info_parent">
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
                                {{Form::text('persons_info[age][]',null,['class'=>"form-control col-md-6 col-xs-12 datePickerDefault1", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label"> Address</label>
                                <textarea class="form-control col-md-6 col-xs-12" id="address" placeholder="Enter Address" rows="1" name="persons_info[address][]" cols="50"></textarea>
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
                                <button type="button" class="btn btn-success add-new-row"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


<!-- 
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
         <input type="file" name="persons_info[document_upload][]" id="form-file" class="persons_document_upload" form="add-reservation-form" />
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
</div> -->






















   <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_payment_info')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
<div class="col-md-2">
                       <label>Total Amount</label>
                       <input type="text" value="{{$data_row->total_amount ?? 0}}" class="form-control">
                       </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class="control-label"> Price per room</label>
                            <input class="form-control col-md-7 col-xs-12" id="booking_payment"  min="0" name="booking_payment" type="text" value="{{$data_row->per_room_price}}" disabled>
                        </div>

                        
                        <div class="col-md-3">
                            <label class="control-label"> Advance Payment</label>
                            <input class="form-control col-md-7 col-xs-12" id="advance_payment" placeholder="Enter Advance Payment" min="0" disabled type="text" value="{{$data_row->advance_payment}}">
                        </div>
                        
                        
                        
                        
                        

                       
                        <div class="col-md-3">
                            <label class="control-label"> {{lang_trans('txt_payment_mode')}}</label>
                            {{Form::select('payment_mode',$payment_mode_list,$data_row->payment_mode,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment1", "placeholder"=>"--Select"])}}
                        </div>
                        <div class="col-md-1">
                        <button type="button" onclick="plus()" style="margin-top:25px" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>
                           </div>
                    
                   
                        
                </div>
                       
                       <?php 
                        $t_amount=0;
                        $re=DB::table('reservations')->where('unique_id',$unique_id)->get();
                        foreach($re as $r)
                        {
                            $r_id=$r->id;
                            $pay=DB::table('payment_history')->where('reservations_id',$r_id)->where('payment','!=','')->get();
                            
                            foreach($pay as $pp)
                            {
                                $t_amount += $pp->payment;
                                ?>
                                <div class="row">  
                    <div class="col-md-3">                            
                    <label class="control-label">Payment</label>        
                    <input class="form-control col-md-4 col-xs-4" placeholder="Enter Advance Payment" disabled value="{{$pp->payment}}" type="number">                        
                    </div>                         
                    <div class="col-md-3">                             
                    <label>Remark</label>                                
                    <select class="form-control" name="payment_remark[]" disabled>
                         @foreach($remark as $r)
                          @if($pp->remark==$r->title)
                                <option value='{{$r->title}}' selected>{{$r->title}}</option>
                                @else
                                <option value='{{$r->title}}'>{{$r->title}}</option>
                                @endif
                                @endforeach                                                               </select>  
                        </div>                        
                        <div class="col-md-3">                            
                        <label class="control-label"> Payment Mode</label>                            
                         {{Form::select('payment_mode[]',$payment_mode_list,$pp->mode,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])}}
                        
                    </select>  
                    <input type="hidden" name="payment_history_ids[]" value="{{$pp->id}}">
                    </div>
                    <div class="col-md-2">
                        <label class="control-label">Payment Date</label> 
                        <input type="date" value="{{$pp->payment_date}}" class="form-control">
                    </div>
                    </div>
                                
                                <?php
                                
                            }
                            
                        }
                       
                       ?>
                
                
                
                 <?php 
                 $a=1;
                 for($p=0;$p<20;$p++)
                 {
                     
                 ?>
                    <div class="row" id="remove<?= $a ;?>" style="display:none">  
                    <div class="col-md-4">                            
                    <label class="control-label">Payment</label>        
                    <input class="form-control col-md-4 col-xs-4" placeholder="Enter Advance Payment" name="payment[]" min="0" type="number">                        
                    </div>                         
                    <div class="col-md-3">                             
                    <label>Remark</label>                                
                    <select class="form-control" name="payment_remark[]">
                         @foreach($remark as $r)
                                <option value='{{$r->title}}'>{{$r->title}}</option>
                                @endforeach                                                               </select>  
                        </div>                        
                        <div class="col-md-3">                            
                        <label class="control-label"> Payment Mode</label>                            
                         {{Form::select('mode[]',$payment_mode_list,'',['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])}}
                        
                    </select>                       
                    </div>
                     <div class="col-md-2">                       
                   
                    <button type="button" onclick="remove_addon(<?= $a; ?>)" style="margin-top:25px" class="btn btn-danger add-new-advance"><i class="fa fa-minus"></i></button>     
                    </div>
                    
                    </div>
                    
                    <?php $a++; } ?>
                     
                     
                
                <div class="ln_solid">
                    
                  
                </div>
               <div class="col-md-6" style="font-size:18px;">
                   <?php  if($t_amount > $data_row->total_amount){ ?>
                       Total Pending Amount : 0
                   <?php }else{ ?>
                       Total Pending Amount : <?php echo $data_row->total_amount-$t_amount; ?>
                   <?php } ?>
                     
               </div>
                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                    <button class="btn btn-success btn-update-form" type="submit"  name="update_btn" value="update">{{lang_trans('btn_update')}}</button>
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
            <input type="hidden" name="step" id="step">
            <input type="hidden" name="oldId" id="oldId">
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
            {{Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name')])}}
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            {{ Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            {{Form::number('persons_info[age][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])}}
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            {{Form::textarea('persons_info[address][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_address'),"rows"=>1])}}
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            {{ Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')]) }}
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            {{Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number')])}}
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
        </div>
    </div>
</div>
{{-- require set var in js var --}}
<script>
    globalVar.page = 'room_reservation_add';

</script>
<script type="text/javascript" src="{{URL::asset('public/js/page_js/page.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
   $(function() {

      $(".datePickerDefault1").datepicker({
        dateFormat: 'dd-mm-yy',
         changeMonth: true,
          changeYear: true,
          yearRange: "-50:+0"
      });
   });
</script>
<script language="JavaScript">
$(document).on('click', 'button[name=update_btn]', function() {
    
    if($("#change_room").attr("style") == "display: none;"){
        //return true;
    }else{
        if($('#listed_rooms').val() == 'null'){
            alert("Please atleast choose 1 room");
            return false;
        }else if($('.room_checkbox:checked').length == 0){
            alert("Please choose room type with room number");
            return false;
        }else if($('#listed_rooms').val().length != $('.room_checkbox:checked').length){
            alert("Switch room, no of selected room should be equal to choose new room");
            return false;
        } 
        
    }
    
});
$(document).on('click', '.room_checkbox', function() {
    
    if($('#listed_rooms').val().length < $('.room_checkbox:checked').length){
        alert("Switch room, no of selected room should be equal to choose new room");
        $(this).prop("checked", false);
        return false;
    }
});
 $(document).on('click', '.photo_id', function() {
     var step =  $(this).data("step");
     var oldId =  $(this).data("oldid");
    $("#exampleModal").modal('show');
    $("#step").val(step);
    $("#oldId").val(oldId);
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
$("#snapguestclose").click(function() {
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

       $(".id_cardno_back").val(data_uri);

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
    $("#change_room").hide();
    $("#second_advance").hide();
    $("#third_advance").hide();
    $("#fourth_advance").hide();
    $("#fifth_advance").hide();
    $("#sixth_advance").hide();
    $("#snap").click(function() {


        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');
    });

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

$(".remove-third-advance").click(function() {

$("#second_advance").hide()})
$(".remove-fourth-advance").click(function() {

$("#third_advance").hide()})
$(".remove-fifth-advance").click(function() {

$("#fourth_advance").hide()})
$(".remove-fifth-advance").click(function() {

$("#fourth_advance").hide()})
$(".remove-sixth-advance").click(function() {

$("#fifth_advance").hide()})
    $("#btn-switch").click(function() {
        $("#change_room").toggle();

    })
     $(".add-fourth-advance").click(function() {

        $("#fourth_advance").show()})

        $(".add-fifth-advance").click(function() {

$("#fifth_advance").show()})
$(".add-sixth-advance").click(function() {

$("#sixth_advance").show()})
    $(".add-third-advance").click(function() {

        $("#third_advance").show()})

    $(".add-new-advance").click(function() {

        $("#second_advance").show();

    })
    //verify
        $(document).on('change', '#payment1', function( event ) {
            loadSelectedDeviceOptions1($(this).val());
        });
        function loadSelectedDeviceOptions1(selectedOption) {
            console.log(selectedOption);
            if (selectedOption == 7 )
            {
                $("#first1").show();
                $("#first1").attr("onclick","payment_link()");
            }else if( selectedOption == 4){
                $("#first1").show();
                $("#first1").attr("onclick","paytm_Send_Link()");
            }else{
                $("#first1").hide();
            }
        }
        $(document).on('change', '#payment2', function( event ) {
            loadSelectedDeviceOptions2($(this).val());
        });
        function loadSelectedDeviceOptions2(selectedOption) {
            console.log(selectedOption);
            if (selectedOption == 7 )
            {
                $("#first2").show();
                $("#first2").attr("onclick","payment_link()");
            }else if( selectedOption == 4){
                $("#first2").show();
                $("#first2").attr("onclick","paytm_Send_Link()");
            }else{
                $("#first2").hide();
            }

        }
        $(document).on('change', '#payment3', function( event ) {
            loadSelectedDeviceOptions3($(this).val());
        });
        function loadSelectedDeviceOptions3(selectedOption) {
            console.log(selectedOption);
            if (selectedOption == 7 )
            {
                $("#first3").show();
                $("#first3").attr("onclick","payment_link()");
            }else if( selectedOption == 4){
                $("#first3").show();
                $("#first3").attr("onclick","paytm_Send_Link()");
            }else{
                $("#first3").hide();
            }
        }
        $(document).on('change', '#payment4', function( event ) {
            loadSelectedDeviceOptions4($(this).val());
        });
        function loadSelectedDeviceOptions4(selectedOption) {
            console.log(selectedOption);
            if (selectedOption == 7 )
            {
                $("#first4").show();
                $("#first4").attr("onclick","payment_link()");
            }else if( selectedOption == 4){
                $("#first4").show();
                $("#first4").attr("onclick","paytm_Send_Link()");
            }else{
                $("#first4").hide();
            }
        }
        $(document).on('change', '#payment5', function( event ) {
            loadSelectedDeviceOptions5($(this).val());
        });
        function loadSelectedDeviceOptions5(selectedOption) {
            console.log(selectedOption);
            if (selectedOption == 7 )
            {
                $("#first5").show();
                $("#first5").attr("onclick","payment_link()");
            }else if( selectedOption == 4){
                $("#first5").show();
                $("#first5").attr("onclick","paytm_Send_Link()");
            }else{
                $("#first5").hide();
            }
        }
        $(document).on('change', '#payment6', function( event ) {
            loadSelectedDeviceOptions6($(this).val());
        });
        function loadSelectedDeviceOptions6(selectedOption) {
            console.log(selectedOption);
             if (selectedOption == 7 )
            {
                $("#first6").show();
                $("#first6").attr("onclick","payment_link()");
            }else if( selectedOption == 4){
                $("#first6").show();
                $("#first6").attr("onclick","paytm_Send_Link()");
            }else{
                $("#first6").hide();
            }
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
            console.log(phone);
            console.log()
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
 function paytm_Send_Link(){
        var val=$('input[name="guest_type"]:checked').val();
        if(val=="existing"){
            var customer_id=$('input[name="selected_customer_id"]').val();
            if(customer_id==""){
                alert('please select a customer');
            }else{

                $.ajax({
                    url: "{{route('paytmSendLink')}}?guest_type=existing&customer="+customer_id,
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
            console.log(phone);
            console.log()
            if(name!="" && email!="" && phone!="" && payment!=""){
                $.ajax({
                    url: "{{route('paytmSendLink')}}?guest_type=new&name="+name+"&email="+email+"&phone="+phone+"&payment="+payment,
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


	<script>
function ImagetoPrint(source) {

    return "<html><head><script>function step1(){\n" +
            "setTimeout('step2()', 10);}\n" +
            "function step2(){window.print();window.close()}\n" +
            "</scri" + "pt></head><body onload='step1()'>\n" +
            "<img src='" + source + "' /></body></html>";
            }
        function PrintImage(source) {
        Pagelink = "about:blank";
        var pwa = window.open(Pagelink, "_new");
        pwa.document.open();
        pwa.document.write(ImagetoPrint(source));
        pwa.document.close();
}
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
                       <option value="{{$corp}}"  @if($data_row->referred_by == $corp)? selected @endif>{{$corp}}</option>
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
                       <option value="{{$corp}}"  @if($data_row->referred_by == $corp)? selected @endif>{{$corp}}</option>
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


    $("#advance_payment").keyup(function() {
              var advanced_payment = document.getElementById("advance_payment").value;
               var duration_of_stay = document.getElementById("duration_of_stay").value;
               var booking_payment = document.getElementById("booking_payment").value;
               if((booking_payment * duration_of_stay * {{$c}} )<advanced_payment)
               {
                  swal({
                           type: 'error',
                           title: 'Oops...',
                           text: 'Invalid Amount',
                        })
               }
            });




    $(document).on('change', "#listed_rooms", function(){
        var checked_room_id = $(this).val();
        var checked_room = $("#"+checked_room_id).attr('data-room'); // Checked Room
        $("#room_no_switch").val(checked_room);
        $("#resId").val(checked_room_id);
    });

   


    function mobile1()
    {
        mobile = document.getElementById('mobile').value;
        if(mobile.length != 10)
        {
            document.getElementById('mobile-error').style.display="block";
        }
        else{
            document.getElementById('mobile-error').style.display="none";
        }
    }


    mobile1()



    














    // $("#adult").keyup(function() {
    //            console.log("adult");
    //            var value = $("#adult").val();
    //            var i = 1;
    //            $(".persons_info_parent").empty();
    //            for (i; i <= value - 1; i++) {
    //               var html = $(".colne_persons_info_elem").html();
    //               $(".persons_info_parent").append(html);
    //               $('.date_adult:last').attr('id', 'adult_'+i);
    //             //   .promise()
    //             //   .done(function() {
    //             //   $(".persons_info_parent").find(".datePickerDefault1").datepicker({
    //             //              changeMonth: true,
    //             //               changeYear: true,
    //             //               yearRange: "-50:+0"
    //             //           });
    //             //     });
    //            }
    //         });
    //         $("#adult").change(function() {
    //            console.log("adult1");
    //            var value = $("#adult").val();
    //            var i = 1;
    //            $(".persons_info_parent").empty();
    //            for (i; i <= value - 1; i++) {
    //               var html = $(".colne_persons_info_elem").html();
    //                $(".persons_info_parent").append(html);
    //                  $('.date_adult:last').attr('id', 'adult_'+i);
    //             //   .promise()
    //             //   .done(function() {
    //             //   $(".persons_info_parent").find(".datePickerDefault1").datepicker({
    //             //              changeMonth: true,
    //             //               changeYear: true,
    //             //               yearRange: "-50:+0"
    //             //           });
    //             //     });
    //            }
    //         });
    //         $("#kids").keyup(function() {
    //            console.log("kids1");
    //            var value = $("#kids").val();
    //            var i = 0;
    //            $(".persons_info_kids").empty();
    //            for (i; i <= value - 1; i++) {
    //               var html = $(".colne_persons_info_kids").html();
    //               $(".persons_info_kids").append(html);
    //               $('.date:last').attr('id', 'kids_'+i);
    //            }
    //         });
    //         $("#kids").change(function() {
    //            console.log("kids2");
    //            var value = $("#kids").val();
    //            var i = 0;
    //            $(".persons_info_kids").empty();
    //            for (i; i <= value - 1; i++) {
    //               var html = $(".colne_persons_info_kids").html();
    //               $(".persons_info_kids").append(html);
    //               $('.date:last').attr('id', 'kids_'+i);
    //            }
    //         });


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
