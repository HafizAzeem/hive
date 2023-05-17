<table class="table table-bordered">
  <thead>
    <tr>
      <th>{{lang_trans('txt_sno')}}</th>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Stock</th>
      <th>By</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    @if($datalist->count()>0)
    @foreach($datalist as $k=>$val)
      <tr>
        <td>{{$k+1}}</td>
        <td>{{$val->product->name}}</td>
        <td>@if($val->price>0) {{getCurrencySymbol()}} {{$val->price}} @endif</td>
        <td>{{$val->qty}}</td>
        <td>{{ucfirst($val->stock_is)}}</td>
        <td>{{ucfirst($val->user->name)}}</td>
        <td>{{dateConvert($val->created_at,'d-m-Y h:i')}}</td>
      </tr>
    @endforeach
    @endif
  </tbody>
</table>