<table class="table table-bordered">
  <thead>
    <tr>
      <th>{{lang_trans('txt_sno')}}</th>
      <th>{{lang_trans('txt_category')}}</th>
      <th>{{lang_trans('txt_title')}}</th>
      <th>{{lang_trans('txt_amount')}}</th>
      <th>{{lang_trans('txt_date')}}</th>
      <th>{{lang_trans('txt_remark')}}</th>
    </tr>
  </thead>
  <tbody>
    @if($datalist->count()>0)
    @foreach($datalist as $k=>$val)
      <tr>
        <td>{{$k+1}}</td>
        <td>{{$val->category->name}}</td>
        <td>{{$val->title}}</td>
        <td>{{getCurrencySymbol()}} {{$val->amount}}</td>
        <td>{{dateConvert($val->datetime,'d-m-Y')}}</td>
        <td>{{$val->remark}}</td>
      </tr>
    @endforeach
    @endif
  </tbody>
</table>