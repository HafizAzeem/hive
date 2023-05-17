@extends('install.master')
@section('content')
 <div class="panel-body ins-bg-col">
    <h4>Database Config</h4>
    {{ Form::open(array('url'=>route('save-database'),'id'=>"database-form", 'class'=>"form-horizontal")) }}
      <div class='form-group'>
        <label for="host" class="col-sm-2 control-label">
            <p>Hostname <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="host" name="host" value="{{($database_info) ? $database_info['host'] : ''}}" >
        </div>
      </div>

      <div class='form-group'>
        <label for="database" class="col-sm-2 control-label">
            <p>Database <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="database" name="database" value="{{($database_info) ? $database_info['database'] : ''}}" >
        </div>
      </div>

     <div class='form-group'>
        <label for="user" class="col-sm-2 control-label">
            <p>Username <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="user" name="username" value="{{($database_info) ? $database_info['username'] : ''}}" >
        </div>
      </div>

     <div class='form-group'>
        <label for="password" class="col-sm-2 control-label">
            <p>Password <span class="text-aqua">*</span></p>
        </label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="password" name="password" value="{{($database_info) ? $database_info['password'] : ''}}" >
        </div>
      </div>
          
      <div class="form-group">
        <div class="col-sm-4">
          <a href="{{route('checklist')}}" class="btn btn-default pull-right">Previous Step</a>
        </div>
          <div class="col-sm-4 col-sm-offset-2">
              <input type="submit" class="btn btn-success" value="Next Step" >
          </div>
      </div>
      {{ Form::close()}}
    </div>
@endsection