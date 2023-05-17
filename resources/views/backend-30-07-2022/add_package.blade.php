@extends('layouts.master_backend')
@section('content')
@php
      $flag=0;
      $heading=lang_trans('btn_add');
      if(isset($data_row) && !empty($data_row)){
          $flag=1;
          $heading=lang_trans('btn_update');
      }
  @endphp
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Add Package</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                @if($flag==1)
                    {{ Form::model($data_row,array('url'=>route('update-package'),'id'=>"room-form", 'class'=>"form-horizontal form-label-left")) }}
                    {{Form::hidden('id',null)}}
                @else
                    {{ Form::open(array('url'=>route('save-package'),'id'=>"meal-plan-form", 'class'=>"form-horizontal form-label-left")) }}
                @endif
                    <div class="row">
                        <br/>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label">Package Title <span class="required">*</span></label>
                            {{Form::text('title',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"title", "placeholder"=>"Enter package name", 'required'])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> {{lang_trans('txt_room_type')}} <span class="required">*</span></label>
                            {{ Form::select('room_type_id',$roomtypes_list ?? '',null,['class'=>'form-control',"id"=>"room_type_id",'placeholder'=>lang_trans('ph_select'), 'required']) }}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label">Meal Type<span class="required">*</span></label>
                            {{ Form::select('meal_plan_id',$mealplan_list ?? '',null,['class'=>'form-control',"id"=>"meal_plan_id",'placeholder'=>lang_trans('ph_select')]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label">Package Price <span class="required">*</span></label>
                            {{Form::text('package_price',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"package_price", "placeholder"=>"Enter package price", 'required'])}}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 ">
                            <label class="control-label"> Number of days<span class="required">*</span></label>
                            {{Form::text('no_of_days',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"no_of_days", "placeholder"=>"Enter Number Of Days"])}}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Package Discription</label>
                            {{Form::textarea('package_description',null,['class'=>"form-control col-md-12 col-xs-12", "id"=>"package_description", "placeholder"=>"Enter package description"])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_content">

                                <div class="ln_solid"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button class="btn btn-success btn-submit-form2" type="submit">{{lang_trans('btn_submit')}}</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::close() }}
              </div>
          </div>
      </div>
  </div>
</div>


<script>
    $(document).ready(function() {

        $(document).on('click', '.btn-submit-form2', function(e) {
            v = $(start_date_my).val();
            v1 = $(end_date_my).val();
            var d1 = new Date(v);
            var d2 = new Date(v1);
            if (d2 < d1) {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Checkout should be greater than check in',
                })
                e.preventDefault();
                alert("End Date should be greater than Start Date");
            }

        });





    });

</script>
@endsection
