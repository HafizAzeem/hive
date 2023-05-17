@php 
  $settings = getSettings();
  $totalOrdersAmount = 0;
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
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-1">
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
                    <span class="class-inv-2">
                        {{$settings['hotel_name']}}
                    </span>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="class-inv-3">
                        {{$settings['hotel_tagline']}}
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-4">
                        {{$settings['hotel_address']}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-5">
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
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong class="fsize-label">
                            {{lang_trans('txt_num')}}.:
                            <span class="class-inv-7">
                                {{$data_row->invoice_num}}
                            </span>
                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <br/>
                        <strong class="fsize-label">
                            {{lang_trans('txt_dated')}} :
                        </strong>
                        <span class="class-inv-8">
                            {{dateConvert($data_row->invoice_date,'d-m-Y')}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <strong class="fsize-label">
                            {{lang_trans('txt_cust_name')}}:
                        </strong>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-8">
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
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-8">
                        <span>
                            {{$data_row->address}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="2%">{{lang_trans('txt_sno')}}</th>
                                <th class="text-center" width="20%">{{lang_trans('txt_item_details')}}</th>
                                <th class="text-center" width="5%">{{lang_trans('txt_date')}}</th>
                                <th class="text-center" width="5%">{{lang_trans('txt_item_qty')}}</th>
                                <th class="text-center" width="5%">{{lang_trans('txt_item_price')}} ({{getCurrencySymbol()}})</th>
                                <th class="text-center" width="10%">{{lang_trans('txt_amount')}} ({{getCurrencySymbol()}})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_row->orders_items as $k=>$val)
                      @php
                        $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty*$val->item_price);
                      @endphp
                            <tr>
                                <td class="text-center">
                                    {{$k+1}}
                                </td>
                                <td class="">
                                    {{$val->item_name}}
                                </td>
                                <td class="text-center">
                                    {{dateConvert($val->created_at,'d-m-Y')}}
                                </td>
                                <td class="text-center">
                                    {{$val->item_qty}}
                                </td>
                                <td class="text-center">
                                    {{$val->item_price}}
                                </td>
                                <td class="text-center">
                                    {{$val->item_qty*$val->item_price}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    No Orders
                                </td>
                            </tr>
                            @endforelse
                    @php

                      $gstPerc = $cgstPerc = $discount = 0;
                      if($data_row->gst_apply==1){
                        $gstPerc = $data_row->gst_perc;
                        $cgstPerc = $data_row->cgst_perc;
                        $discount = ($data_row->discount>0) ? $data_row->discount : 0;
                      }
                      $gst = gstCalc($totalOrdersAmount,'food_amount',$gstPerc,$cgstPerc);
                      $foodAmountGst = $gst['gst'];
                      $foodAmountCGst = $gst['cgst'];
                    @endphp
                            <tr>
                                <th class="text-right" colspan="5">{{lang_trans('txt_total')}}</th>
                                <td class="text-right">{{ numberFormat($totalOrdersAmount) }}</td>
                            </tr>
                            @if($foodAmountGst>0)
                            <tr>
                                <th class="text-right" colspan="5">
                                    {{lang_trans('txt_gst')}} ({{$gstPerc}} %)
                                </th>
                                <td class="text-right">
                                    {{ numberFormat($foodAmountGst) }}
                                </td>
                            </tr>
                            @endif
                    @if($foodAmountCGst>0)
                            <tr>
                                <th class="text-right" colspan="5">
                                    {{lang_trans('txt_cgst')}} ({{$cgstPerc}} %)
                                </th>
                                <td class="text-right">
                                    {{ numberFormat($foodAmountCGst) }}
                                </td>
                            </tr>
                            @endif
                    @if($discount>0)
                            <tr>
                                <th class="text-right" colspan="5">
                                    {{lang_trans('txt_discount')}}
                                </th>
                                <td class="text-right">
                                    {{ numberFormat($discount) }}
                                </td>
                            </tr>
                            @endif

                    @php 
                      $finalFoodAmount = numberFormat($totalOrdersAmount+$foodAmountGst+$foodAmountCGst-$discount);
                    @endphp
                            <tr>
                                <th class="text-right" colspan="5">
                                    {{lang_trans('txt_grand_total')}}
                                </th>
                                <td class="text-right">
                                    {{ numberFormat($finalFoodAmount) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="2">
                                    {{lang_trans('txt_amount_words')}}:-
                                </th>
                                <td class="class-inv-9" colspan="4">
                                    {{ getIndianCurrency(numberFormat($finalFoodAmount)) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="class-inv-10">
                                        {{lang_trans('txt_customer_sign')}}
                                    </div>
                                </td>
                                <td class="text-right" colspan="3">
                                    <div class="class-inv-10">
                                        {{lang_trans('txt_manager_sign')}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            {!!$settings['invoice_term_condition']!!}
        </div>
    </body>
</html>