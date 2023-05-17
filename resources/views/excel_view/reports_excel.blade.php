<table class="table table-bordered">                            
 <thead>
      <tr>
        <th>S.No</th>
        <th>Room</th>
        <th>Check In</th>
        <th>Check Out</th>
        
       
        
        <th>Total Amount</th>
        <th>Guest Name</th>
       
        <th>Guest Mobile</th>
        <th>Guest Email</th>
        <th>Guest Gender</th>
        <th>Guest Age</th>
        <th>Guest Address</th>
        <th>Duration of Stay</th>
        <th>Total Persons</th>
        <th>Adult/Kids</th>
        <th>ID Card Type</th>
        <th>ID Card Number</th>
        
        
        <th>Payment Mode</th>
        
        
      </tr>
    </thead>
    <tbody>
      @foreach($datalist as $key=>$val)
        @php 
            $calc = calcFinalAmount($val);
        @endphp
        <tr>
          <td>{{$key+1}}</td>
          <td>
            @if(($val->room_type)) 
              {{$val->room_type->title}}<br/>
              ( Room No. : {{$val->room_num}} )
            @endif
            </td>
          <td>{{dateConvert($val->check_in,'d-m-Y H:i')}}</td>
          <td>{{dateConvert($val->check_out,'d-m-Y H:i')}}</td>
        <td>{{ numberFormat($calc['finalRoomAmount']+$calc['finalOrderAmount']) }}</td>
          <td>{{$val->customer->name}}</td>
         
          <td>{{($val->customer) ? $val->customer->mobile : 'NA'}}</td>
          <td>{{($val->customer) ? $val->customer->email : 'NA'}}</td>
          <td>{{($val->customer) ? $val->customer->gender : 'NA' }}</td>
          <td>{{($val->customer) ? $val->customer->age : 'NA' }}</td>
          <td>{{$val->customer->address}}, {{$val->customer->city}}, {{$val->customer->state}}, {{$val->customer->country}}</td>
          <td>{{$val->duration_of_stay}}</td>
          <td>{{$val->persons->count()}}</td>
          <td>{{$val->adult}}/{{$val->kids}}</td>
          <td>{{$val->idcard_type}}</td>
          <td>{{$val->idcard_no}}</td>
         
          
          
          <td>{{ @config('constants.PAYMENT_MODES')[$val->payment_mode]}}</td>
          
        </tr>
      
      @endforeach
    </tbody>
  </table>