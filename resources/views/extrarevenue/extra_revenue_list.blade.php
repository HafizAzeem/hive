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
                      <th>Title</th>
                      <th>Payment</th>
                      <th>Expenses</th>
                      <th>Revenue</th>
                      <!--<th>Mode</th>-->
                      <th>Remark</th>
                      <th>Date</th>
                      
                      <th>Update</th>
                    </tr>
                  </thead>
                 

                  <tbody>
                    @foreach($datalist as $k=>$val)
                     
                      <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$val->title}}</td>
                        <td>
                            {{$val->payment}}<br>
                            @php $suml=0; @endphp 
                            @foreach($breakerrevenue as $berr)
                                @if($val->reservations_id == $berr->reservations_id)
                                    <span>
                                    -{{$berr->payment}}({{$berr->remark}})
                                    </span><br>
                                    @php $suml += $berr->payment; @endphp
                                @endif
                            @endforeach
                        </td>
                        <td>{{$suml}}</td>
            
                        <td>{{$val->payment - $suml}}</td>
                        
                        <td>{{$val->remark}}</td>
                        <td>{{$val->payment_date}}</td>
                            
                        <td>
                            <a class="btn btn-sm btn-info" href="{{route('edit-revenue',[$val->id])}}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-extrarevenue',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
                            <!--<div class="col-md-1">-->
                                <!--<button type="button" onclick="plus()" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>-->
                            <!--</div>-->
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
