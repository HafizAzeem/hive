@extends('install.master')
@section('content')

    <div class="panel-body ins-bg-col">
      <h4><span class="fa fa-check"></span> Installation completed!</h4>

      <div class="alert alert-info">
        <h5><span class="fa fa-info-circle"></span> You can login now using the following credential:</h5>

        <p style="margin-top:25px;">
          <h5>Username: <b>{{$username}}</b></h5>
          <h5>Password: <b>{{$password}}</b></h5>
        </p>
      </div>

      <div class="alert alert-warning">
        <h5><span class="fa fa-exclamation-triangle"></span> Please click go to login then finish your job.</h5>
      </div>

      <form class="form-horizontal" role="form" method="post">
        <input type="text" name="text" value="1" style="display:none;" />
      <div class="form-group">
        <div class="row">
           <div class="col-sm-4 col-sm-offset-1">
                </div>
                <div class="col-sm-4 col-sm-offset-3">
                    <a href="{{url('admin/')}}" class="btn btn-success">Go to Login</a>
                </div>
        </div>
          </div>
    </form>
    </div>
@endsection