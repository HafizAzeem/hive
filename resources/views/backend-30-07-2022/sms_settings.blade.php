@extends('layouts.master_backend')
@section('content')
<div class="">
    {{ Form::open(array('url'=>route('save-settings'),'id'=>"update-setting-form", 'class'=>"form-horizontal form-label-left")) }}
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_smsapi_settings')}}</h2>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="x_content">
                    <br/>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_api_url')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('sms_api_url',@$data_row['sms_api_url'],['class'=>"form-control col-md-7 col-xs-12"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_api_username')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('sms_api_username',@$data_row['sms_api_username'],['class'=>"form-control col-md-7 col-xs-12"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_api_senderid')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('sms_api_senderid',@$data_row['sms_api_senderid'],['class'=>"form-control col-md-7 col-xs-12"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_api_key')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('sms_api_key',@$data_row['sms_api_key'],['class'=>"form-control col-md-7 col-xs-12"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 p-top-1">{{lang_trans('txt_api_active')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          {{ Form::checkbox('sms_api_active',null,(@$data_row['sms_api_active'] && $data_row['sms_api_active']==1) ? true : false ,['id'=>'sms_active']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
            <div class="x_panel">
                <div class="x_content">
                    <br/>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-success" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{Form::close()}}
</div>
@endsection
