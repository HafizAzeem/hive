@extends('layouts.master_backend')

@section('content')
<div class="qwe">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('txt_list_users')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Title</th>
                      <th>Rooms Qty</th>
                      <th>Payment</th>
                      <th>Checkin</th>
                      <th>Update</th>
                    </tr>
                  </thead>
                 

                  <tbody>
                    @foreach($invoicedata as $k=>$val)
                     
                      <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$val->name}}</td>
                        <td>{{$val->mobile}}</td>
                        <td>{{$val->title}}</td>
                        <td>{{$val->no_of_rooms}}</td>
                        <td>{{$val->payment}}</td>
                        <td>{{$val->check_in}}</td>
                            
                        <td>
                            <a class="btn btn-sm btn-info" href="{{route('edit-performa',[$val->id])}}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-performa',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
                            <a class="btn btn-sm btn-warning" href="{{route('invoice-performa',[$val->id,1])}}" target="_blank">Performa</a>
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
            
                        
<script>
    // let id=1;
    // function plus()
    // {
    //   $("#remove"+id).show();
    //   id++;
    //   console.log(id)
    // }

    // function remove_addon(id)
    // {
    //     $("#remove"+id).remove();
    // }
</script>                
                                
                                    


@endsection
