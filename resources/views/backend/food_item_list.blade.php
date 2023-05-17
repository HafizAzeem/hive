@extends('layouts.master_backend')
@section('content')
<div class="">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal4">
                <i class="fa fa-upload btn-icon-prepend"></i> 
                Bulk Upload Food Items
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{lang_trans('heading_food_item_list')}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{lang_trans('txt_sno')}}</th>
                                <th>{{lang_trans('txt_item_name')}}</th>
                                <th>{{lang_trans('txt_price')}}</th>
                                <th>{{lang_trans('txt_desc')}}</th>
                                <th>{{lang_trans('txt_status')}}</th>
                                <th>{{lang_trans('txt_action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datalist as $k=>$val)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{getCurrencySymbol()}} {{$val->price}}</td>
                                <td>{!!$val->description!!}</td>
                                <td>{!! getStatusBtn($val->status) !!}</td>
                                <td>
                                  <a class="btn btn-sm btn-info" href="{{route('edit-food-item',[$val->id])}}"><i class="fa fa-pencil"></i></a>
                                  <button class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-food-item',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
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

<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Document Upload (In CSV)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('bulk-food-upload')}}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Document:</label>
                        <input class="form-control"  name="excel" type="file" id="formFile" required>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection