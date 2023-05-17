@extends('install.master')
@section('content')
  <div class="panel-body ins-bg-col">
    <h4>Pre-Install Checklist</h4>
    @foreach($success as $succ)
      <div class="alert alert-success"><span class="fa fa-check-circle"></span>&nbsp;{{$succ}}</div>
    @endforeach
    @foreach($errors as $err)
      <div class="alert alert-danger"><span class="fa fa-check-circle"></span>&nbsp;{{$err}}</div>
    @endforeach
    <div class="col-sm-12"><a href="{{route('set-database')}}" class="btn btn-success pull-right">Next Step</a></div>
  </div>
@endsection