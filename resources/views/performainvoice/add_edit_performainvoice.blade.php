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
   $(function() {
      $(".datePickerDefault").datepicker({
         dateFormat: 'yy-mm-dd',
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
<div class="">

   {{ Form::open(array('url'=>route('save-performa'),'class'=>"form-horizontal form-label-left",'files'=>true)) }}

   <div class="row hide_elem" id="existing_guest_section">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
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
               <h2>Performa Invoice</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> Booking ID <span ></span></label>-->
                    <!--    {{--Form::text('Booking_id',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"Booking_id", "placeholder"=>"Booking ID"])--}}-->
                    <!--</div>-->
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> And Number </label>-->
                    <!--    {{--Form::text('and_number',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"and_number", "placeholder"=>"And Number"])--}}-->
                    <!--</div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Customer Name <span class="required">*</span></label>
                        {{Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname'), 'required'])}}
                    </div>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> {{lang_trans('txt_email')}} </label>-->
                    <!--    {{--Form::email('email',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])--}}-->
                    <!--</div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_mobile_num')}} <span class="required">*</span></label>
                        {{Form::text('mobile',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile","maxlength"=>"10", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num'), 'required'])}}
                    </div>

                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> {{lang_trans('txt_gender')}} <span class="required">*</span></label>-->
                    <!--    {{-- Form::select('gender',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), 'required']) --}}-->
                    <!--</div>-->
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> {{lang_trans('txt_age')}} </label>-->
                    <!--    {{--Form::text('age',null,['class'=>"form-control datePickerDefault1 col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off"])--}}-->
                    <!--</div>-->
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Particulars <span class="required">*</span></label>
                        {{Form::text('title',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"title", "placeholder"=>"Title", 'required'])}}
                    </div>
                </div>
                
                <div class="row ">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_checkin')}}<span class="required">*</span></label>
                        <?php
                                $dtPart2 = date('Y-m-d');
                                $dtPart3 = date('Y-m-d');
                                $dtPart4 = date('Y-m-d');
                           
                        ?>
                        {{Form::text('check_in_date', $dtPart2,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_in_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required'])}}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_checkout')}} <span class="required">*</span></label>
                        {{Form::text('check_out_date', $dtPart3,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_out_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required'])}}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Payment Mode</label>
                        <select class="form-control" name="payment_mode">
                            @foreach($payment_mode as $mode)
                            <option value="{{$mode->id}}">{{$mode->payment_mode}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_room_type')}} <span></span></label>
                        {{ Form::select('room_type_id',$roomtypes_list ?? '',null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')]) }}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('Room Qty')}} <span>*</span></label>
                        {{Form::number('no_of_rooms',null,['class'=>"form-control col-md-6 col-xs-12", "placeholder"=>lang_trans('No of Rooms'),"min"=>1])}}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Room Rent <span>*</span></label>
                        {{Form::number('payment',null,['class'=>"form-control col-md-6 col-xs-12", "placeholder"=>lang_trans('Per Room Rent'), 'required'])}}
                        <!--<input type="number" class="form-control" name="payment" placeholder="Per Room Rent" required>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Advance Payment </label>
                        {{Form::number('advance',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"advance", "placeholder"=>"Advance Payment"])}}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Advance Payment Date </label>
                        {{Form::date('advance_date',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"advance_date", "placeholder"=>"Advance Payment Date", "autocomplete"=>"off"])}}
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
                   <h2>Extra Charges</h2>
                   <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge One Title </label>
                            {{Form::text('remarkone',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkone", "placeholder"=>"Charge One Title"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge One Amount </label>
                            {{Form::number('amountone',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountone", "placeholder"=>"Charge One Amount"])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Two Title </label>
                            {{Form::text('remarktwo',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarktwo", "placeholder"=>"Charge Two Title"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Two Amount </label>
                            {{Form::number('amounttwo',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amounttwo", "placeholder"=>"Charge Two Amount"])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Three Title </label>
                            {{Form::text('remarkthree',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkthree", "placeholder"=>"Charge Three Title"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Three Amount </label>
                            {{Form::number('amountthree',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountthree", "placeholder"=>"Charge Three Amount"])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Four Title </label>
                            {{Form::text('remarkfour',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkfour", "placeholder"=>"Charge Four Title"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Four Amount </label>
                            {{Form::number('amountfour',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountfour", "placeholder"=>"Charge Four Amount"])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Five Title </label>
                            {{Form::text('remarkfive',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkfive", "placeholder"=>"Charge Five Title"])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Five Amount </label>
                            {{Form::number('amountfive',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountfive", "placeholder"=>"Charge Five Amount"])}}
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12">
                    <button class="btn btn-success btn-submit-form2" type="submit"  id="arrivals_btn" style="float:right;">{{lang_trans('btn_submit')}}</button>
                </div>
            </div>
        </div>
        
    </div>
   </div>

    {{ Form::close() }}
</div>



<script>

   $(document).ready(function() {
        $(document).on('click', '.btn-submit-form2', function(e) {
        v = $(check_in_date_my).val();
        v1 = $(check_out_date_my).val();
        var d1 = new Date(v);
        var d2 = new Date(v1);
            if (d2 < d1) {
              swal({
                 type: 'error',
                 title: 'Oops...',
                 text: 'Checkout should be greater than check in',
              })
              e.preventDefault();
            }

        });
    });

    $(document).on('change', '#payment', function(event) {
       loadSelectedDeviceOptions($(this).val());
    });

    globalVar.page = 'room_reservation_add';
</script>
<script type="text/javascript" src="{{URL::asset('public/js/page_js/page.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/js/custom.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endsection
