@extends('layouts.master_backend')
@section('css')
<style>
    table, th, td {
  border: 1px solid black;
}

</style>
@endsection
@section('content')
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  @if(isset($flag))
                      {{ Form::model($data_row,array('url'=>route('save-Addavailedservices'),'id'=>"amenities-form", 'class'=>"form-horizontal form-label-left")) }}
                      {{Form::hidden('id',null)}}
                  @else
                      {{ Form::open(array('url'=>route('save-Addavailedservices'),'id'=>"amenities-form", 'class'=>"form-horizontal form-label-left")) }}
                  @endif
                  
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amenities_name"> {{lang_trans('txt_name')}} <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('name',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"amenities_name", "required"=>"required"])}}
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amenities_desc"> {{lang_trans('txt_description')}}</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::textarea('description',null,['class'=>"form-control col-md-7 col-xs-12 txt-editor","id"=>"amenities_desc"])}}
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
@endsection