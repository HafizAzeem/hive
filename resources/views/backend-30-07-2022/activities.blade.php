@extends('layouts.master_backend')
@section('content')
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('txt_list_customers')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                        <th>SRN</th>
                        <th>Name</th>
                      <th>Action</th>
                      <th>Log Date</th>
                      <th>Uri</th>
                       <th>Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($datalist as $k=>$val)
                      <tr>
                        <?php $user=App\User::find($val->user_id); ?> 
                        <td>{{$k+1}}</td> 
                        <th>{{$user->name ?? null}}</th>
                        <td>{{$val->action_as}}</td>
                        <td>{{$val->log_date}}</td>
                        <td>{{$val->uri}}</td>
                          <td>{{$val->created_at}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
      </div>
  </div>
</div>          
@endsection