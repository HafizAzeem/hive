@extends('layouts.master_backend')
@section('content')
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('heading_list_datepricerange')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>{{lang_trans('txt_sno')}}</th>
                      <th>{{lang_trans('txt_room')}}</th>
                      <th>{{lang_trans('txt_start_date')}}</th>
                      <th>{{lang_trans('txt_end_date')}}</th>
                      <th>{{lang_trans('txt_date_price')}}</th>
                      <th>{{lang_trans('txt_status')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($datalist as $k=>$val)
                      <tr>
                        <td>{{$k+1}}</td>
                        <td>
                            @if(($val->room_type))
                              {{$val->room_type->title}}<br/>
                              ( {{lang_trans('txt_room_num')}} : {{$val->room_num}} )
                            @endif
                            </td>
                        <td>{{$val->start_date}}</td>
                        <td>{{$val->end_date}}</td>
                        <td>{{$val->date_price}}</td>
                        @if ($val->status == 1)
                            <td><button type="button" class="btn btn-success btn-xs">Active</button></td>
                        @else
                        <td><button type="button" class="btn btn-delete btn-xs">InActive</button></td>
                        @endif
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
