@extends('layouts.master_backend')
@section('content')

<div class="">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Outlet</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post" action="{{route('outlet_action')}}">
                    <div class="row">
                        <div class="col-md-3">
                            @csrf
                            <input type="text" class="form-control" required name="outlet">
                        </div>
                        <div class="col-md-3"><button class="btn btn-info">Add</button></div>
                    </div>
                    </form>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>S.No</th>
                            <th>Title</th>
                            <th>Created At</th>
                           
                        </tr>
                       <?php $i=1; ?>
                        @foreach($data as $value)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->created_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                
                 
</div>
</div>


  <div class="x_panel">
                <div class="x_title">
                    <h2>Payment Remark</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post" action="{{route('remark_action')}}">
                    <div class="row">
                        <div class="col-md-3">
                            @csrf
                            <input type="text" class="form-control" required name="title">
                        </div>
                        <div class="col-md-3"><button class="btn btn-info">Add</button></div>
                    </div>
                    </form>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>S.No</th>
                            <th>Title</th>
                            <th>Created At</th>
                           
                        </tr>
                       <?php $i=1; ?>
                        @foreach($remark as $v)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$v->title}}</td>
                            <td>{{$v->created_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                
                 
</div>
</div>




</div>
</div></div>
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