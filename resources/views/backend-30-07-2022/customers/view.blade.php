@extends('layouts.master_backend')
@section('content')

<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{lang_trans('heading_guest_info')}}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                      <table class="table table-bordered">
                          <tr>
                            <th>{{lang_trans('txt_fullname')}}</th>
                            <td>{{$data_row->name}}</td>
                            <th>{{lang_trans('txt_email')}}</th>
                            <td>{{$data_row->email}}</td>
                          </tr>
                          <tr>

                            <th>{{lang_trans('txt_mobile_num')}}</th>
                            <td>{{$data_row->mobile}}</td>
                             <th>{{lang_trans('txt_age')}}</th>
                            <td>{{ date('d-m-Y', strtotime($data_row->dob)) }}</td>
                          </tr>
                          <tr>
                            <th>{{lang_trans('txt_gender')}}</th>
                            <td>{{$data_row->gender}}</td>

                            <th>Age</th>
                            <td>{{$data_row->age}} {{lang_trans('txt_years')}}</td>

                          </tr>


                        </tbody>
                      </table>
                    </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
