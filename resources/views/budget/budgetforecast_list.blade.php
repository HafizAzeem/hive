@extends('layouts.master_backend')

<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>-->
<!--<link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet"/>-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

<!--<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>-->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Budget</div>
                <div class="card-body">
                    <br/>
                    <form method="post" action="{{route('save-budget')}}">
                    @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" class="form-control" name="idall">
                                <label>Budget Amount</label>
                                <input type="number" class="form-control" name="estimation">
                            </div>
                            <div class="col-md-3">
                                <label>Date</label>
                                <input type="month" class="form-control" name="tilldate">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info" style="margin-top:9%;">Submit</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Tags</div>
                <div class="card-body">
                    <br/>
                    <form method="GET" action="{{route('save-tags')}}">
                    @csrf
                        <div class="row">
                            <div class="col-md-11">
                                <?php 
                                    $tg = $tags[0]->tags ?? '';
                                ?>
                                <input id="input" type="text" name="tagsnew" value="{{$tg}}" data-role="tagsinput" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-info" style="margin-top:1%;">Submit</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="qwe">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>List All Budgets</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Title</th>
                      <th>Location</th>
                      <th>Revenue Target</th>
                      <th>Date</th>
                      <th>Update</th>
                    </tr>
                  </thead>
                 

                  <tbody>
                    @foreach($datalist as $k=>$val)
                     
                      <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$val->title}}</td>
                        <td>{{$val->location}}</td>
                        <td>{{$val->budgetestimate}}</td>
                        <td>{{date('M-Y', strtotime($val->tilldate))}}</td>
                            
                        <td>
                            <a class="btn btn-sm btn-info" href="{{route('edit-budget',[$val->id])}}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-budget',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
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
            
@yield('js')
<script>
    $(document).ready(function(){  
        var x = "<?php echo "$tg" ?>";
        //   $('#input').tagsinput('x');
        $('#input').tagsinput('add', x );
        $('#input').tagsinput({
          typeahead: {
            source: function(query) {
              return $.getJSON('x.json');
            }
          }
        });
    });
</script>                
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
