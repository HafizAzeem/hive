@extends('layouts.master_backend')
@section('content')
<script>
    $(document).on('focus',".date", function(){ //bind to all instances of class "date".
       $(this).datepicker({
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
             changeMonth: true,
              changeYear: true,
              yearRange: "-90:+0"
          });
       });
    </script>

@php
$flag=0;
$heading=lang_trans('btn_add');
$expAmenities = [];
if(isset($data_row) && !empty($data_row)){
$flag=1;
$heading=lang_trans('btn_update');
$expAmenities = explode(',', $data_row->amenities);
}
@endphp
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{$heading}} {{lang_trans('txt_room_type')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    @if($flag==1)
                    {{ Form::model($data_row,array('url'=>route('save-room-types'),'id'=>"room-type-form", 'class'=>"form-horizontal  form-label-left")) }}
                    {{Form::hidden('id',null)}}
                    @else
                    {{ Form::open(array('url'=>route('save-room-types'),'id'=>"room-type-form", 'class'=>"form-horizontal  form-label-left")) }}
                    @endif

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_title"> {{lang_trans('txt_title')}} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('title',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"type_title", "required"=>"required"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_short_code"> {{lang_trans('txt_short_code')}} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('short_code',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"type_short_code", "required"=>"required"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="adult_capacity"> {{lang_trans('txt_adult_capacity')}} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::number('adult_capacity',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"adult_capacity", "required"=>"required"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kids_capacity"> {{lang_trans('txt_kids_capacity')}} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::number('kids_capacity',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"kids_capacity", "required"=>"required"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kids_capacity"> {{lang_trans('Enter Room Price')}} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <fieldset data-role="controlgroup">
                                <label for="male">Yes</label>
                                <input type="radio" name="is_base_price" class="rbutton" id="yesCheck" value="1">
                                <label for="female">No</label>
                                <input type="radio" name="is_base_price"  class="rbutton" id="noCheck" value="0">
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group base_price_weekdays">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="base_price"> {{lang_trans('txt_base_price_weekdays')}} </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('base_price',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"base_price",])}}
                        </div>
                    </div>
                    <div class="form-group base_price_weekends">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="base_price_weekends"> {{lang_trans('txt_base_price_weekends')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('base_price_weekends',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"base_price_weekends", ])}}
                        </div>
                    </div>
                    <?php
                            $dtPart2 = date('Y-m-d');
                    ?>
                    <div class="col-md-offset-2 col-md-4 col-sm-2 col-xs-12 date_range_cls" >
                        <div class="date-field row" style="display: flex;">
                            <div class="col-md-4">
                                <label class="control-label"> {{lang_trans('txt_start_date')}}</label>
                            </div>

                          <div class="col-md-7 mln-8">
                            {{Form::text('start_date', $dtPart2,['class'=>"form-control datePickerDefault col-md-7 col-xs-12", "id"=>"start_date", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                          </div>
                        </div>
                    </div>
                    <div class="form-group date_range_cls">
                        <div class="col-md-4 col-sm-2 col-xs-12 mln-3">
                          <div class="date-field row" style="display: flex;">
                            <div class="col-md-3">
                                <label class="control-label"> {{lang_trans('txt_end_date')}} </label>
                            </div>
                            <div class="col-md-7">
                                {{Form::text('end_date', $dtPart2,['class'=>"form-control datePickerDefault col-md-7 col-xs-12", "id"=>"end_date", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="form-group  date_range_cls">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_price"> {{lang_trans('txt_date_price')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          {{Form::number('date_price',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"date_price",])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="base_price"> {{lang_trans('txt_amenities')}} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            @if($amenities_list)
                            @foreach($amenities_list as $k=>$val)
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="checkbox">
                                    <label>{{Form::checkbox('amenities_ids[]', $val->id, (in_array($val->id, $expAmenities)) ? true : false )}}{{$val->name}}</label>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_status')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{ Form::select('status',config('constants.LIST_STATUS'),1,['class'=>'form-control']) }}
                        </div>
                    </div>

                    <div class="ln_solid">
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">{{lang_trans('btn_reset')}}</button>
                            <button class="btn btn-success" type="submit">{{lang_trans('btn_submit')}}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
     $('.base_price_weekdays').hide();
     $(".base_price_weekends").hide();
     $(".date_range_cls").hide();

  $("input[name='is_base_price']").change(function(){
      if($(this).val() == '1')
          {
            $('.base_price_weekdays').show();
            $('.base_price_weekends').show();
            $(".date_range_cls").show();

          }else{
               $('.base_price_weekdays').hide();
               $('.base_price_weekends').hide();
               $(".date_range_cls").show();

          }
});
</script>
@endsection
