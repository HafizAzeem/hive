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
                    <h2>Payment Mode List</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($datalist as $k=>$val)

                        <tr>
                            <td>{{++$k}}</td>
                            <td>{{$val->payment_mode}} </td>
                            @if ($val->status == 1)
                            <td><button type="button" class="btn btn-success btn-xs">Active</button></td>
                            @else
                            <button type="button" class="btn btn-danger btn-xs">InActive</button>
                            @endif
                            <td>{{ date_format($val->created_at,"d-m-Y H:i")}} </td>
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
