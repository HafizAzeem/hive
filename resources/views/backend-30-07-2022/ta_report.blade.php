@extends('layouts.master_backend')
@section('content')

<div class="">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Invoice Download</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post" action="{{route('ta_report_action')}}">
                        @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label>Type</label>
                            <select class="form-control" id="type">
                                <option>--select--</option>
                                <option value="1">Corporates</option>
                                <option value="2">TA</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="display:none;" id="tas">
                             <label>Select TA</label>
                          <select class="form-control" name="tas">
                             
                              <option value=''>--select--</option>
                              <?php 
                               $tas=DB::table('tas')->get();
                               foreach($tas as $t)
                               {
                                   echo "<option value=".$t->id.">".$t->name."</option>";
                               }
                              ?>
                          </select>
                        </div>
                        
                        <div class="col-md-3" style="display:none;" id="corporates">
                             <label>Select Corporates</label>
                          <select class="form-control" name="corporates">
                             
                              <option value=''>--select--</option>
                              <?php 
                               $co=DB::table('corporates')->get();
                               foreach($co as $t1)
                               {
                                   echo "<option value=".$t1->id.">".$t1->name."</option>";
                               }
                              ?>
                          </select>
                        </div>
                        
                         <div class="col-md-3">
                          
                              <label>Start Date</label>
                              <input type="date" class="form-control" required name="start">
                         
                        </div>
                        
                         <div class="col-md-3">
                        
                             <label>End Date</label>
                             <input type="date" class="form-control" required name="end">
                         
                        </div>
                        
                        <div class="col-md-3"><button style="margin-top:25px" class="btn btn-info">Invoice</button></div>
                    </div>
                    </form>
                    
                   
                    
                   
                
                 
</div>
</div>




</div>
</div></div>
@endsection
@section('jquery')
<script>
    $(document).ready(function() {
   $("#type").on('click',function(){
       var type=$(this).val();
       if(type=='2')
       {
           $("#tas").css('display','');
           $("#corporates").css('display','none');
       }else if(type=='1')
       {
           $("#corporates").css('display','');
            $("#tas").css('display','none');
       }
   })
} );
</script>
@endsection