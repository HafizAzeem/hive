  @php 
    $i=0;
  @endphp                           
<table class="table table-bordered">
  <thead>
    <tr>
      <th>S.No.</th>
      <th>Order Type</th>
      <th>Invoice No.</th>
      <th>Table No.</th>
      <th>Customer Name</th>
      <th>Customer Email</th>
      <th>Customer Mobile</th>
      <th>Date</th>
      <th>Pay Date</th>
      <th>Order Items</th>
      <th>Order Amount</th>
    </tr>
  </thead>
  <tbody>
    @foreach($datalist as $key=>$value)
      @php 
        $totalOrdersAmount = $finalOrderAmount = 0; 
        $totalOrderAmountGst = $totalOrderAmountCGst = $totalOrderAmountDiscount = $orderGst = $orderCGst = 0;
        $orderInfo = $value;
        if($orderInfo){
          $orderGst = $orderInfo->gst_perc;
          $orderCGst = $orderInfo->cgst_perc;

          $totalOrderAmountGst = $orderInfo->gst_amount;
          $totalOrderAmountCGst = $orderInfo->cgst_amount;
          $totalOrderAmountDiscount = $orderInfo->discount;
        }

        if($value->orders_items->count()>0){
          foreach($value->orders_items as $k=>$val){
              $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
              $finalOrderAmount = ($totalOrdersAmount+$totalOrderAmountGst+$totalOrderAmountCGst-$totalOrderAmountDiscount);
          }    
        }
        $name = $value->name;
        $email = $value->email;
        $mobile = $value->mobile;
        if($value->reservation_id>0){
          if($value->reservation_data){
            if($value->reservation_data->customer){
              $name = $value->reservation_data->customer->name;
              $email = $value->reservation_data->customer->email;
              $mobile = $value->reservation_data->customer->mobile;
            }
          }
          $type = 'Room Order';
        } else {
          $type = 'Table Order';
        }
        
        if($search_data['order_type']=='roomOrder'){
            $type = 'Room Order';
        } else if($search_data['order_type']=='tableOrder'){
          $type = 'Table Order';
        }
      @endphp
      <tr>
        <td>{{$key+1}}</td>
        <td>{{$type}}</td>
        <td>{{$value->invoice_num}}</td>
        <td>{{($value->reservation_data!=null) ? $value->reservation_data->room_num : $value->table_num }}</td>
        <td>{{$name}}</td>
        <td>{{$email}}</td>
        <td>{{$mobile}}</td>
        <td>{{dateConvert($value->created_at,'d-m-Y H:i')}}</td>
        <td>{{ ($value->original_date!=null) ? dateConvert($value->original_date,'d-m-Y H:i') : 'NA'}}</td>
        <td>{{$value->orders_items->count()}}</td>
        <td>{{numberFormat($finalOrderAmount)}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
                    
