@extends('layouts.master_backend')
@section('content')
<style>
    .colorstatus1{
        color:green;
        font-weight:500;
    }
    .colorstatus{
        color:blue;
        font-weight:500;
    }
</style>
<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Food Report Search</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            {{ Form::model($search_data,array('url'=>route('search-foodreport'),'id'=>"search-expense", 'class'=>"form-horizontal form-label-left")) }}
              <div class="form-group col-sm-3">
                <label class="control-label"> {{lang_trans('txt_category')}}</label>
                {{Form::select('category_id',$category_list,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])}}
              </div>
              <div class="form-group col-sm-2">
                <label class="control-label"> {{lang_trans('txt_date_from')}}</label>
                {{Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])}}
              </div>
              <div class="form-group col-sm-2">
                <label class="control-label"> {{lang_trans('txt_date_to')}}</label>
                {{Form::text('date_to',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_to')])}}
              </div>
              <div class="form-group col-sm-3">
                <br/>
                 <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit">{{lang_trans('btn_search')}}</button>
                 <a class="btn btn-danger search-btn" href="{{route('food-sales-report')}}" name="refresh" value="refresh">Refresh</a>
                 <!--<button class="btn btn-primary export-btn" name="submit_btn" value="export" type="submit">{{--lang_trans('btn_export')--}}</button>-->
              </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
  </div>
  <div class="row">
      <div class="pt-3 pb-3" id="print_area">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Food Collection Report</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  @php
                    $totalAmount = 0;
                    $totalAmount1 = 0;
                    $totalAmountn = 0;
                    $i= 1;
                  @endphp
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>{{lang_trans('txt_sno')}}</th>
                      <th>Food Name</th>
                      <!--<th>{{--lang_trans('txt_category')--}}</th>-->
                      <!--<th>{{--lang_trans('txt_title')--}}</th>-->
                      <th>{{lang_trans('txt_amount')}}</th>
                      <th>Order Type</th>
                      <th>Payment Mode</th>
                      <th>Invoice</th>
                      <th>{{lang_trans('txt_date')}}</th>
                      <!--<th>{{--lang_trans('txt_remark')--}}</th>-->
                      <!--<th>{{--lang_trans('txt_action')--}}</th>-->
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($datalist as $k=>$val)
                      @php
                        $totalAmount = $totalAmount+$val->amount;
                      @endphp
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$val->name}}</td>
                        <td>{{getCurrencySymbol()}} {{$val->amount}}</td>
                        <td class="colorstatus">{{$val->statusonoff}}</td>
                        <td>{{$val->payment_mode}}</td>
                        <td>
                          <a class="btn btn-sm btn-info" href="{{route('invoice',[$val->id])}}">Invoice</i></a>
                        </td>
                        <td>{{dateConvert($val->created_at,'d-m-Y')}}</td>
                        <!--<td>-->
                        <!--  <a class="btn btn-sm btn-info" href="{{--route('edit-expense',[$val->id])--}}"><i class="fa fa-pencil"></i></a>-->
                        <!--  <button class="btn btn-danger btn-sm delete_btn" data-url="{{--route('delete-expense',[$val->id])--}}" title="{{--lang_trans('btn_delete')--}}"><i class="fa fa-trash"></i></button>-->
                        <!--</td>-->
                      </tr>
                      <?php $i++; ?>
                    @endforeach
                    
                    @foreach($datalist2 as $k=>$val)
                        @php
                            $totalAmount1 = $totalAmount1 + $val->total_amount;
                        @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                                @if($val->order_history)
                                    @foreach($val->order_history as $key_OH=>$val_OH)
                                    @php //print_r($val_OH->is_book); @endphp
                                        @if($val_OH->orders_items)
                                            @foreach($val_OH->orders_items as $key_OI=>$val_OI)
                                                @php
                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                    $totalAmountn = $totalAmountn + $price;
                                                @endphp
                                                <span> {{$val_OI->item_name}} ({{$val_OI->item_qty}}q) </span><br>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>{{getCurrencySymbol()}} {{$val->total_amount}}</td>
                            <td class="colorstatus1">{{$val->statusonoff}}</td>
                            <td>
                                  @if($val->payment_mode==1)
                             Cash
                            @elseif($val->payment_mode==4)
                            Paytm
                             @elseif($val->payment_mode==5)
                            Phone pe
                             @elseif($val->payment_mode==6)
                            Complementary
                            
                            @endif
                            </td>
                            <td>
                          <a class="btn btn-sm btn-info" href="{{route('invoice',[$val->id])}}">Invoice</i></a>
                        </td>
                            <td>{{dateConvert($val->created_at,'d-m-Y') }}</td>
                        </tr>
                        
                        <?php $i++; ?>
                    @endforeach
                  </tbody>
                </table>
                <table class="table table-striped table-bordered">
                    <tr>
                      <th class="text-right" width="50%">{{lang_trans('txt_grand_total')}}</th>
                      <th width="50%"><b>{{getCurrencySymbol()}} {{numberFormat($totalAmount) + numberFormat($totalAmount1)}}</b></th>
                    </tr>
                </table>
              </div>
          </div>
      </div>
  </div>
  </div>
</div>  
 <div class="col-md-12 pt-3 pb-3 text-right">
                  <button onclick='downloadDiv();' class="btn btn-primary">Download PDF</button>
               
                   
                </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js" ></script>
 <script>
  
  
  function downloadDiv(){
      const element = document.getElementById("print_area");
      html2pdf()
      .from(element)
      .save();
  };

</script>