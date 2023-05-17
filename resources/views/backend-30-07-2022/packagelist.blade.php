@extends('layouts.master_backend')
@section('content')
@php
$i = $j = 0;
$totalAmount = 0;
@endphp
<div class="">


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Package List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>Title</th>
                        <th>Room Type</th>
                        <th>Meal Plan</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>{{lang_trans('txt_action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($datalist as $k=>$val)

                        <tr>
                            <td>{{++$k}}</td>
                            <td> {{$val->title}} </td>
                            <td> {{$val->room_type->title}} </td>
                            <td> {{$val->meal_type->name}} </td>
                            <td> {{$val->start_date}} </td>
                            <td> {{$val->end_date}} </td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{route('edit-package',[$val->id])}}"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-package',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
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
@section('jquery')
<script>
    $(document).ready(function() {
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'

        ]
    } );
} );
</script>
@endsection
