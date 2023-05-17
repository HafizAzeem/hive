@extends('layouts.master_backend')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div class="">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2>{{lang_trans('Filter')}}</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              {{ Form::model(array('url'=>route('billing'),'id'=>"search-report", 'class'=>"form-horizontal form-label-left")) }}
                <div class="form-group col-sm-3">
                  <label class="control-label">{{lang_trans('Filter')}}</label>
                    <!-- {{Form::select('check_id',$corporates,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])}} -->
                    <select name="corporate" class="form-control">
                    <option selected disabled>Select billing</option>
                       @foreach($corporates as $corp)
                       <option value="{{$corp}}">{{$corp}}</option>
                       @endforeach
                   </select>
                  </div>
                    <div class="form-group col-sm-3">
                  <label class="control-label">Timely</label>
                     <input type="text" name ="date1" class ="form-control datefilter">
                     <!--,config('constants.Time'),null-->
                     <!--{{ Form::date('first_name', '', array('class' => 'form-control datefilter')) }}-->
                  </div>
               
                <div class="form-group col-sm-3">
                  <br/>
                  <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit">{{lang_trans('btn_search')}}</button>
                </div>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{$reservationData[0]['referred_by_name'] ?? ''}} Billing List</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                        <th>SRN</th>
                        <td>Name</td>
                        <td>Type</td>
                        <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $totalAmount=0;?>
                    @foreach($reservationData as $k=>$value)
                    
                    <?php
                    $name=App\Customer::where('id',$value->customer_id)->first()->name;
                    ?>
                      <tr>
                        <td>{{$k+1}}</td>
                        <td><a href="{{route('view-reservation',[$value->id])}}">{{$name}}</a></td>
                         @if(isset($value->corporates))
                            <td width="10%">{{$value->corporates}}</td>
                            @elseif(isset($value->tas))
                            <td width="10%">{{$value->tas}}</td>
                            @elseif(isset($value->ota))
                            <td width="10%">{{$value->ota}}</td>
                            @else
                             <td></td>
                        @endif
                        @if($value->amount_json)
                        <?php
                            $data=json_decode($value->amount_json);
                         $totalAmount = $totalAmount+$data->total_room_amount;?>
                        <th>{{$data->total_room_amount ?? null}}</th>
                        @else
                         <th>$0</th>
                         @endif
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <table class="table table-striped table-bordered">
                      <tr>
                        <th class="text-right" width="70%">{{lang_trans('txt_grand_total')}}</th>
                        <th width="30%"><b>{{getCurrencySymbol()}} {{numberFormat($totalAmount)}}</b></th>
                      </tr>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>  
@endsection
@section('jquery')
    <script type="text/javascript">
    
$(function() {

  $('.datefilter').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('.datefilter').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('.datefilter').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});
</script>
@endsection