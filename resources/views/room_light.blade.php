@extends('layouts.master_backend')
@section('content')

 <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>Room Light On Off</h3>
                <small>
                    <a href="">Home</a> /
                    <a>Manage Light</a>
                </small>
            </div>
        </div>
       
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                       
                        <div class="box-body">
                             <div class="form-group">
                             <div class="col-md-2">
                              <h5>Room No</h5>
                               <select class="form-select" id="room_no"style="height: 41px;">
                              <!--<label>Hotels</label>-->
                            <option>Select Room No</option>
                          @foreach($room_no as $room_no)
                             <option value="{{ $room_no->room_no }}"><tr>
                          <td>{{ $room_no->room_no }}</td>  
                             </tr></option>
                          @endforeach
                          </select>
                                  <!--<input type="text" class="form-control" name="room_no"id="room_no" />-->
                                  </div>
          <div class="col-md-2"> 
           <h5>Select Switch</h5>
<select style="height: 36px;"id="light1">
  <option value="">Select</option>
  <option value="1">Main Switch</option>
  <option value="2">Smart Switch</option>
</select></div>
                                  
                                  <div id="main">
                             <div class="col-md-3">
                              <h5>Event On</h5>
                              
                                  <input type="text" class="form-control" id="event_oncode" />
                                  </div>
                                  <div class="col-md-2">
                              <h5>Event Off</h5>
                              
                                  <input type="text" class="form-control" id="event_offcode" />
                                  </div>
                         </div>
                         
                          </div>
                          
                          
                          
                        </div>
                        </div>
                    </div>
                    
                    <!--AC-->
                    <div id="smart">
                    <div class="col-md-12">
                         <div class="box">
                       
                        <div class="box-body">
                             <div class="form-group">
                             <div class="col-md-2">
                              <h5>AC</h5>
                        </div>
                        <div class="col-md-2">
                              <h5> Event On</h5>
                              <input type="text" class="form-control" id="event_onac" />
                        </div> 
                        <div class="col-md-2">
                              <h5>Event Off</h5>
                              <input type="text" class="form-control" id="event_offac" />
                        </div> 
                        </div> 
                        </div>
                        </div>
                    </div>
                    <!--End AC code-->
                     <div class="col-md-12">
                         <div class="box">
                       
                        <div class="box-body">
                             <div class="form-group">
                             <div class="col-md-2">
                              <h5>Bathroom</h5>
                        </div>
                        <div class="col-md-2">
                              <h5> Event On</h5>
                              <input type="text" class="form-control" id="event_on_bathroom" />
                        </div> 
                        <div class="col-md-2">
                              <h5>Event Off</h5>
                              <input type="text" class="form-control" id="event_off_bathroom" />
                        </div> 
                        </div> 
                        </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                         <div class="box">
                       
                        <div class="box-body">
                             <div class="form-group">
                             <div class="col-md-2">
                              <h5>TV</h5>
                        </div>
                        <div class="col-md-2">
                              <h5> Event On</h5>
                              <input type="text" class="form-control" id="event_on_tv" />
                        </div> 
                        <div class="col-md-2">
                              <h5>Event Off</h5>
                              <input type="text" class="form-control" id="event_off_tv" />
                        </div> 
                        </div> 
                        </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-12">
                         <div class="box">
                       
                        <div class="box-body">
                             <div class="form-group">
                             <div class="col-md-2">
                              <h5>Site Table Lamp</h5>
                        </div>
                        <div class="col-md-2">
                              <h5> Event On</h5>
                              <input type="text" class="form-control" id="event_on_lamp" />
                        </div> 
                        <div class="col-md-2">
                              <h5>Event Off</h5>
                              <input type="text" class="form-control" id="event_off_lamp" />
                        </div> 
                        </div> 
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                 <div class="col-md-2"style="margin-top: 35px;">
                                <button class="btn btn-success" id="add"style="margin-left:950px;">Submit</button><br>
                              </div><br>
               
                
                <div class="col-md-12">
                    <div class="box-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <!--<th>Hotel Id</th>-->
                                    <th>Room No</th>
                                    <th>Room On</th>
                                    <th>Room Off</th>
                                    <th>AC On</th>
                                    <th>AC Off</th>
                                    <th>Bathroom Light On</th>
                                    <th>Bathroom Light Off</th>
                                    <th>TV On</th>
                                    <th>TV Off</th>
                                    <th>Site Lamp On</th>
                                    <th>Site Lamp Off</th>
                                </tr>
                            </thead>
                            <tbody id="show">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
               
              
            </div>
       
    </div>
@endsection
@section('jquery')
<script>
    
    function autoload()
                {
                 
                     $.ajax({
                            method : 'get',
                            url : '{{url("get_detail")}}',
                            success : function(res)
                            {
                                $("#show").html(res);
                            }
                        })
                }
                 autoload();
          function deleteCoupon(id)
          {
            
                     $.ajax({
                            method : 'get',
                            data : {id:id},
                            url : '{{url("deleteCoupon")}}',
                            success : function(res)
                            {
                               autoload();
                            }
                        })  
          }
               
                $(document).ready(function(){
                    // alert('hello');
                   
                    //   alert(hotel);
                    
                    
                    $("#add").click(function(){
                         var room_no=  $('#room_no').val();
                         
                        var oncode=$("#event_oncode").val();
                        var offcode=$("#event_offcode").val();
                        
                         var event_onac=$("#event_onac").val();
                        var event_offac=$("#event_offac").val();
                         var event_on_bathroom=$("#event_on_bathroom").val();
                        var event_off_bathroom=$("#event_off_bathroom").val();
                         var event_on_tv=$("#event_on_tv").val();
                        var event_off_tv=$("#event_off_tv").val();
                         var event_on_lamp=$("#event_on_lamp").val();
                        var event_off_lamp=$("#event_off_lamp").val();
                        
                       
                        if(room_no=='')
                        {
                            alert('All Field Required !');
                            return false;
                        }
                        // alert('hello');
                        $.ajax({
                            method : 'get',
                            // alert('hello');
                            data : {room_no:room_no,oncode:oncode,offcode:offcode,event_onac:event_onac,event_offac:event_offac,event_on_bathroom:event_on_bathroom,event_off_bathroom:event_off_bathroom,event_on_tv:event_on_tv,event_off_tv:event_off_tv,event_on_lamp:event_on_lamp,event_off_lamp:event_off_lamp},
                            url : '{{url("/roomlight_action")}}',
                            // alert(data);
                            success : function(res)
                            {
                                if(res.status=='success')
                                {
                                    
                                 autoload();
                                }else
                                {
                                    alert(res.message);
                                }
                            }
                        })
                        })
                    })
               
                
    </script>

<script>
    $(document).ready(function() {
    $('#main').hide();
            $('#smart').hide();
    $("#light1").change(function(){
        var value = $(this).val();
        if(value==1){
            $('#main').show();
             $('#smart').hide();
        }
        if(value==2){
             $('#main').hide();
            $('#smart').show();
        }
    //   alert(value);
    } );
} );
</script>
@endsection