@php 
  $settings = getSettings();
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>{{$settings['site_page_title']}}: {{lang_trans('txt_invoice')}}</title>
        <link href="{{URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('public/css/invoice_style.css')}}" rel="stylesheet">
    </head>
    <body>
        @php 
        $i = 0;
  $totalOrdersAmount = 0;
  $itemsQty = [];
  $orderedItemsArr = [];
  if($data_row->orders_items){
    foreach($data_row->orders_items as $k=>$val){
      $jsonData = json_decode($val->json_data);
      $itemId = $jsonData->item_id;

      if(isset($itemsQty[$itemId])){
        $itemsQty[$itemId] = $itemsQty[$itemId]+$val->item_qty;
      } else {
        $itemsQty[$itemId] = $val->item_qty;
      }
      
      $orderedItemsArr[$itemId] = [
          'item_name'=>$val->item_name,
          'item_qty'=>$itemsQty[$itemId],
          'item_price'=>$val->item_price,
          'amount'=>$itemsQty[$itemId]*$val->item_price,
          'created_at'=>dateConvert($val->created_at,'d-m-Y'),
      ];
    }
  }
@endphp
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-11">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong>
                            {{lang_trans('txt_gstin')}}: {{$settings['gst_num']}}
                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <strong>
                            {{lang_trans('txt_ph')}} {{$settings['hotel_phone']}}
                        </strong>
                        <br/>
                        <strong>
                            ({{lang_trans('txt_mob')}}) {{$settings['hotel_mobile']}}
                        </strong>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="class-inv-12">
                        {{$settings['hotel_name']}}
                    </span>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="class-inv-13">
                        {{$settings['hotel_tagline']}}
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-14">
                        {{$settings['hotel_address']}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-15">
                        <span>
                            {{$settings['hotel_website']}}
                        </span>
                        |
                        <span>
                            {{lang_trans('txt_email')}}:-
                        </span>
                        <span>
                            {{$settings['hotel_email']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <table class="table table-bordereda">
                        <tr>
                            <th class="text-center class-inv-18">
                                {{lang_trans('txt_num')}}
                            </th>
                            <th class="text-center class-inv-18">
                                {{lang_trans('txt_table_num')}}
                            </th>
                            <th class="text-center class-inv-18">
                                {{lang_trans('txt_dated')}}
                            </th>
                        </tr>
                        <tr>
                            <td class="text-center class-inv-18">
                                {{$data_row->invoice_num}}
                            </td>
                            <td class="text-center class-inv-18">
                                {{$data_row->table_num}}
                            </td>
                            <td class="text-center class-inv-18">
                                {{dateConvert($data_row->invoice_date,'d-m-Y')}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <strong class="fsize-label">
                            {{lang_trans('txt_cust_name')}}:
                        </strong>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
                        <span>
                            {{$data_row->name}}
                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <strong class="fsize-label">
                            {{lang_trans('txt_address')}}:
                        </strong>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
                        <span>
                            {{$data_row->address}}
                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <strong class="fsize-label">
                            {{lang_trans('txt_waiter')}}:
                        </strong>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
                        <span>
                            {{$data_row->waiter_name}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="2%">
                                    {{lang_trans('txt_sno')}}
                                </th>
                                <th class="text-center" width="20%">
                                    {{lang_trans('txt_item_details')}}
                                </th>
                                <th class="text-center" width="5%">
                                    {{lang_trans('txt_item_qty')}}
                                </th>
                                <th class="text-center" width="5%">
                                    {{lang_trans('txt_item_price')}} ({{getCurrencySymbol()}})
                                </th>
                                <th class="text-center" width="10%">
                                    {{lang_trans('txt_amount')}} ({{getCurrencySymbol()}})
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orderedItemsArr as $k=>$val)
                              @php
                                $totalOrdersAmount = $totalOrdersAmount + ($val['item_qty']*$val['item_price']);
                              @endphp
                            <tr>
                                <td class="text-center">
                                    {{++$i}}.
                                </td>
                                <td class="">
                                    {{$val['item_name']}}
                                </td>
                                <td class="text-center">
                                    {{$val['item_qty']}}
                                </td>
                                <td class="text-center">
                                    {{$val['item_price']}}
                                </td>
                                <td class="text-center">
                                    {{$val['item_qty']*$val['item_price']}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    {{lang_trans('txt_no_orders')}}
                                </td>
                            </tr>
                            @endforelse
                    @php

                      $gstPerc = $cgstPerc = $discount = 0;
                      if($data_row->gst_apply==1){
                        $gstPerc = $data_row->gst_perc;
                        $cgstPerc = $data_row->cgst_perc;
                      }
                      $discount = ($data_row->discount>0) ? $data_row->discount : 0;
                      $gst = gstCalc($totalOrdersAmount,'food_amount',$gstPerc,$cgstPerc);
                      $foodAmountGst = $gst['gst'];
                      $foodAmountCGst = $gst['cgst'];
                    @endphp
                            <tr>
                                <th class="text-right" colspan="4">
                                    {{lang_trans('txt_total')}}
                                </th>
                                <td class="text-right">
                                    {{getCurrencySymbol()}} {{ numberFormat($totalOrdersAmount) }}
                                </td>
                            </tr>
                            @if($foodAmountGst>0)
                            <tr>
                                <th class="text-right" colspan="4">
                                    {{lang_trans('txt_gst')}} ({{$gstPerc}} %)
                                </th>
                                <td class="text-right">
                                    {{getCurrencySymbol()}} {{ numberFormat($foodAmountGst) }}
                                </td>
                            </tr>
                            @endif
                    @if($foodAmountCGst>0)
                            <tr>
                                <th class="text-right" colspan="4">
                                    {{lang_trans('txt_cgst')}} ({{$cgstPerc}} %)
                                </th>
                                <td class="text-right">
                                    {{getCurrencySymbol()}} {{ numberFormat($foodAmountCGst) }}
                                </td>
                            </tr>
                            @endif
                    @if($discount>0)
                            <tr>
                                <th class="text-right" colspan="4">
                                    {{lang_trans('txt_discount')}}
                                </th>
                                <td class="text-right">
                                    {{getCurrencySymbol()}} {{ numberFormat($discount) }}
                                </td>
                            </tr>
                            @endif

                    @php 
                      $finalFoodAmount = numberFormat($totalOrdersAmount+$foodAmountGst+$foodAmountCGst-$discount);
                    @endphp
                            <tr>
                                <th class="text-right" colspan="4">
                                    {{lang_trans('txt_grand_total')}}
                                </th>
                                <td class="text-right">
                                    {{getCurrencySymbol()}} {{ numberFormat($finalFoodAmount) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="2">
                                    {{lang_trans('txt_amount_words')}}:-
                                </th>
                                <td class="class-inv-17" colspan="4">
                                    {{ getIndianCurrency(numberFormat($finalFoodAmount)) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div>
                                        {{lang_trans('txt_customer_sign')}}
                                    </div>
                                </td>
                                <td class="text-right" colspan="3">
                                    <div>
                                        {{lang_trans('txt_manager_sign')}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>