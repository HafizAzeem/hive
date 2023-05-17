
<table class="table table-bordered">                            
 <thead>
      <tr>
        <th>S.No</th>
        <th>Room</th>
        <th>Check In</th>
        <th>Check Out</th>
        <th>Form Fill</th>
        <th>Room Amount</th>
        <th>Order Amount</th>
        <th>Total Amount</th>
        <th>Guest Name</th>
        <th>Guest Father Name</th>
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
        <th>Invoice Applicable</th>
        <th>Company GST No.</th>
        <th>Booked By</th>
        <th>Vehicle Number</th>
        <th>Referred By</th>
        <th>Referred By Name</th>
        <th>Payment Mode</th>
        <th>Reason of Visit/Stay</th>
        <th>Remark Amount</th>
        <th>Remark</th>
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
          <td>@if($val->created_at_checkout!=null) {{dateConvert($val->created_at_checkout,'d-m-Y H:i')}}@endif</td>
          <td>{{ numberFormat($calc['finalRoomAmount']) }}</td>
          <td>{{ numberFormat($calc['finalOrderAmount']) }}</td>
          <td>{{ numberFormat($calc['finalRoomAmount']+$calc['finalOrderAmount']) }}</td>
          <td>{{$val->customer->name}}</td>
          <td>{{($val->customer) ? $val->customer->father_name : 'NA' }}</td>
          <td>{{($val->customer) ? $val->customer->mobile : 'NA'}}</td>
          <td>{{($val->customer) ? $val->customer->email : 'NA'}}</td>
          <td>{{($val->customer) ? $val->customer->gender : 'NA' }}</td>
          <td>{{($val->customer) ? $val->customer->age : 'NA' }}</td>
          <td>{{$val->customer->address}}, {{$val->customer->city}}, {{$val->customer->state}}, {{$val->customer->country}}</td>
          <td>{{$val->duration_of_stay}}</td>
          <td>{{$val->persons->count()}}</td>
          <td>{{$val->adult}}/{{$val->kids}}</td>
          <td>{{@config('constants.TYPES_OF_ID')[$val->idcard_type]}}</td>
          <td>{{$val->idcard_no}}</td>
          <td>{{($val->invoice_num!='') ? 'Yes' : 'No'}}</td>
          <td>{{$val->company_gst_num}}</td>
          <td>{{$val->booked_by}}</td>
          <td>{{$val->vehicle_number}}</td>
          <td>{{$val->referred_by}}</td>
          <td>{{$val->referred_by_name}}</td>
          <td>{{ @config('constants.PAYMENT_MODES')[$val->payment_mode]}}</td>
          <td>{{$val->reason_visit_stay}}</td>
          <td>{{$val->remark_amount}}</td>
          <td>{{$val->remark}}</td>
        </tr>
      
      @endforeach
    </tbody>
  </table>