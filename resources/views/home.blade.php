<!-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->
 <td><button class="btn-warning btn-sm">Check Out</button></td>
                                             <td><h4>Floor-1</h4></td>
@foreach($floor1 as $key=>$val)
                                 
                                 @if($val->count())   
                                      
                                 <td>
                                      @if(in_array($val->room_no, $checked_rooms))
                                          <button type="button" class="btn btn-warning btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $booked_rooms))
                                          <button type="button" class="btn btn-info btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $ota_rooms))
                                          <button type="button" class="btn btn-primary btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $corporate_rooms))
                                          <button type="button" class="btn btn-dark btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $management_rooms))
                                          <button type="button" class="btn btn-light btn-sm">{{$val->room_no}}</button>
                                          @else
                                          <a href="{{route('room-reservation-available',[$val->id])}}" type="button" class="btn btn-success btn-sm">{{$val->room_no}}</a>
                                          @endif
                                      </td>
                                      @else
                                      {{lang_trans('txt_no_rooms')}}
                                      <a class="btn btn-sm btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                                  @endif     
                             @endforeach
                              
                               </tr>
                               <tr class="p-5">
                                         <!-- Floor 2 -->
                                         <td><button class="btn-success btn-sm">Ready &ensp;&ensp;&ensp;&ensp;&ensp;</button></td>
                                         <td><h4>Floor-2</h4></td>
                                        
                          @foreach($floor2 as $key=>$val)
                   
                          @if($val->count())   
                                      
                                      <td>
                                      @if(in_array($val->room_no, $checked_rooms))
                                          <button type="button" class="btn btn-warning btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $booked_rooms))
                                          <button type="button" class="btn btn-info btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $ota_rooms))
                                          <button type="button" class="btn btn-primary btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $corporate_rooms))
                                          <button type="button" class="btn btn-dark btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $management_rooms))
                                          <button type="button" class="btn btn-light btn-sm">{{$val->room_no}}</button>
                                          @else
                                          <a href="{{route('room-reservation-available',[$val->id])}}" type="button" class="btn btn-success btn-sm">{{$val->room_no}}</a>
                                          @endif
                                      </td>
                                      @else
                                      {{lang_trans('txt_no_rooms')}}
                                      <a class="btn btn-sm btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                                  @endif      
                          @endforeach
                          
                               </tr>
                               <tr class="p-5">  
                               <td><button class="btn-light btn-sm">Management </button></td>
                            <td><h4>Floor-3</h4></td>  
                             <!-- Floor 2 -->
                          @foreach($floor3 as $key=>$val)
                   
                          @if($val->count())   
                                      
                          <td>
                                      @if(in_array($val->room_no, $checked_rooms))
                                          <button type="button" class="btn btn-warning btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $booked_rooms))
                                          <button type="button" class="btn btn-info btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $ota_rooms))
                                          <button type="button" class="btn btn-primary btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $corporate_rooms))
                                          <button type="button" class="btn btn-dark btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $management_rooms))
                                          <button type="button" class="btn btn-light btn-sm">{{$val->room_no}}</button>
                                          @else
                                          <a href="{{route('room-reservation-available',[$val->id])}}" type="button" class="btn btn-success btn-sm">{{$val->room_no}}</a>
                                          @endif
                                      </td>
                                      @else
                                      {{lang_trans('txt_no_rooms')}}
                                      <a class="btn btn-sm btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                                  @endif      
                          @endforeach
                          
                      </tr>
                          <tr class="p-5">
                                    <!-- Floor 2 -->
                                    <td><button class="btn-primary btn-sm">OTA &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button></td>
                                    <td><h4>Floor-4</h4></td>
                                   
                          @foreach($floor4 as $key=>$val)
                    
                                      
                             @if($val->count())   
                                      
                             <td>
                                      @if(in_array($val->room_no, $checked_rooms))
                                          <button type="button" class="btn btn-warning btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $booked_rooms))
                                          <button type="button" class="btn btn-info btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $ota_rooms))
                                          <button type="button" class="btn btn-primary btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $corporate_rooms))
                                          <button type="button" class="btn btn-dark btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $management_rooms))
                                          <button type="button" class="btn btn-light btn-sm">{{$val->room_no}}</button>
                                          @else
                                          <a href="{{route('room-reservation-available',[$val->id])}}" type="button" class="btn btn-success btn-sm">{{$val->room_no}}</a>
                                          @endif
                                      </td>
                                      @else
                                      {{lang_trans('txt_no_rooms')}}
                                      <a class="btn btn-sm btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                                  @endif      
                          @endforeach
                       
                          </tr>
                          <tr>
                                    <!-- Floor 2 -->
                                    <td><button class="btn-dark btn-sm">Corporate &ensp;&ensp;</button></td>
                                    <td><h4>Floor-5</h4></td>
                                   
                          @foreach($floor5 as $key=>$val)
                   
                          @if($val->count())   
                                      
                          <td>
                                      @if(in_array($val->room_no, $checked_rooms))
                                          <button type="button" class="btn btn-warning btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $booked_rooms))
                                          <button type="button" class="btn btn-info btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $ota_rooms))
                                          <button type="button" class="btn btn-primary btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $corporate_rooms))
                                          <button type="button" class="btn btn-dark btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $management_rooms))
                                          <button type="button" class="btn btn-light btn-sm">{{$val->room_no}}</button>
                                          @else
                                          <a href="{{route('room-reservation-available',[$val->id])}}" type="button" class="btn btn-success btn-sm">{{$val->room_no}}</a>
                                          @endif
                                      </td>
                                      @else
                                      {{lang_trans('txt_no_rooms')}}
                                      <a class="btn btn-sm btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                                  @endif     
                          @endforeach
                         
                          </tr>
                          <tr>
                                    <!-- Floor 2 -->
                                    <td><button class="btn-info btn-sm">TA &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</button></td>
                                    <td><h4>Floor-6</h4></td>
                                   
                          @foreach($floor6 as $key=>$val)
                   
                          @if($val->count())   
                                      
                          <td>
                                      @if(in_array($val->room_no, $checked_rooms))
                                          <button type="button" class="btn btn-warning btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $booked_rooms))
                                          <button type="button" class="btn btn-info btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $ota_rooms))
                                          <button type="button" class="btn btn-primary btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $corporate_rooms))
                                          <button type="button" class="btn btn-dark btn-sm">{{$val->room_no}}</button>
                                          @elseif(in_array($val->room_no, $management_rooms))
                                          <button type="button" class="btn btn-light btn-sm">{{$val->room_no}}</button>
                                          @else
                                          <a href="{{route('room-reservation-available',[$val->id])}}" type="button" class="btn btn-success btn-sm">{{$val->room_no}}</a>
                                          @endif
                                      </td>
                                      @else
                                      {{lang_trans('txt_no_rooms')}}
                                      <a class="btn btn-sm btn-success" href="{{route('add-room')}}">{{lang_trans('txt_add_new_rooms')}}</a>
                                  @endif     
                          @endforeach
                         
                          </tr>
