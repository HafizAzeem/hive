@extends('layouts.master_backend')
@section('content')
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('heading_list_roomtypes')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>{{lang_trans('txt_sno')}}</th>
                      <th>{{lang_trans('txt_title')}}</th>
                      <th>{{lang_trans('txt_short_code')}}</th>
                      <th>{{lang_trans('txt_capacity')}}</th>
                      <th>{{lang_trans('txt_base_price')}}</th>
                      <th>{{lang_trans('txt_base_price_weekends')}}</th>
                      <th>{{lang_trans('txt_status')}}</th>
                      <th>{{lang_trans('txt_action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($datalist as $k=>$val)
                      <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$val->title}}</td>
                        <td>{{$val->short_code}}</td>
                        <td>{{lang_trans('txt_adults')}}: {{$val->adult_capacity}} &nbsp; {{lang_trans('txt_kids')}}: {{$val->kids_capacity}} </td>
                        <td>{{getCurrencySymbol()}} {{$val->base_price}}</td>
                        <td>{{getCurrencySymbol()}} {{$val->base_price_weekends}}</td>
                        <td>{!! getStatusBtn($val->status) !!}</td>
                        <td>
                          <a class="btn btn-sm btn-info" href="{{route('edit-room-types',[$val->id])}}"><i class="fa fa-pencil"></i></a>
                          <button class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-room-types',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
                        </td>
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
