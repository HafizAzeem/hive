@extends('install.master')
@section('content')
 <div class="panel-body ins-bg-col">
    <h4>Site Config</h4>
    {{ Form::open(array('url'=>route('save-siteconfig'),'id'=>"siteconfig-form", 'class'=>"form-horizontal")) }}
    {{ Form::hidden('site_setup', 1) }}
      <div class='form-group'>
        <label for="host" class="col-sm-2 control-label">
          <p>Site Page Title <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
           {{Form::text('site_page_title',null,['class'=>"form-control", "required"=>true])}}
        </div>
      </div>

      <div class='form-group'>
        <label for="database" class="col-sm-2 control-label">
            <p>Site Language <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            {{Form::select('site_language',config('constants.LANG_LIST'),null,['class'=>"form-control", "required"=>true])}}
        </div>
      </div>

      <div class='form-group'>
        <label for="user" class="col-sm-2 control-label">
            <p>Hotel Name <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            {{Form::text('hotel_name',null,['class'=>"form-control", "required"=>true])}}
        </div>
      </div>

     <div class='form-group'>
        <label for="user" class="col-sm-2 control-label">
            <p>Name <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            {{Form::text('name',null,['class'=>"form-control", "required"=>true])}}
        </div>
      </div>

      <div class='form-group'>
        <label for="user" class="col-sm-2 control-label">
            <p>Username <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            {{Form::text('username',null,['class'=>"form-control", "required"=>true])}}
        </div>
      </div>

     <div class='form-group'>
        <label for="password" class="col-sm-2 control-label">
            <p>Password <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
      </div>
          
      <div class="form-group">
        <div class="col-sm-4">
          <a href="{{route('set-database')}}" class="btn btn-default pull-right">Previous Step</a>
        </div>
          <div class="col-sm-4 col-sm-offset-2">
              <input type="submit" class="btn btn-success" value="Next Step" >
          </div>
      </div>
      {{ Form::close()}}
    </div>
@endsection