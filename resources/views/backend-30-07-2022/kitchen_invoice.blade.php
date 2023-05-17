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
    <div>
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                <font size="2">
                    {{$settings['hotel_name']}}, {{$settings['hotel_address']}}
                </font>
            </label>
        </div>
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                <font size="2">
                    {{lang_trans('txt_ph')}}: {{$settings['hotel_phone']}}
                </font>
            </label>
        </div>
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                <font size="2">
                    {{lang_trans('txt_website')}}: {{$settings['hotel_website']}}
                </font>
            </label>
        </div>
    
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <table border="0" border-style="ridge" class="class-inv-21">
                <tr>
                    <td align="left" width="100px">
                        <div>
                            {{lang_trans('txt_gstin')}}
                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            {{$settings['gst_num']}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="100px">
                        <div>
                            {{lang_trans('txt_date')}}
                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            {{ date("d M Y h:i A") }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="100px">
                        <div>
                            {{lang_trans('txt_bill_to')}}
                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            {{ ($type=='room-order') ? $data_row->reservation_data->customer->name : $data_row->order->name }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="100px">
                        <div>
                            {{ ($data_row->table_num>0) ? lang_trans('txt_table_num') : lang_trans('txt_room_num') }}
                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            {{ ($data_row->table_num>0) ? $data_row->table_num : ( ($data_row->reservation_data) ? $data_row->reservation_data->room_num : '') }}
                        </div>
                    </td>
                </tr>
            </table>
            <h5>{{lang_trans('txt_orderd_items')}}</h5>
            
            <table border="1" border-style="ridge" style="font-size: 80%">
                <tr>
                    <th class="txt-center" width="165px">
                        {{lang_trans('txt_item_name')}}
                    </th>
                    <th class="txt-center" width="35px">
                        {{lang_trans('txt_unit')}}
                    </th>
                    <th class="txt-center" width="45px">
                        {{lang_trans('txt_amount')}}
                    </th>
                </tr>
                @if($data_row->orders_items->count()>0)
                    @foreach($data_row->orders_items as $val)
                        @php
                            $totalOrdersAmount = $totalOrdersAmount + ($val->item_qty * $val->item_price);
                        @endphp
                        <tr>
                            <td width="160px">
                                {{$val->item_name}}
                            </td>
                            <td class="txt-center" width="35px">
                                {{$val->item_qty}}
                            </td>
                            <td class="txt-right" width="50px">
                                {{getCurrencySymbol()}} {{numberFormat($val->item_qty * $val->item_price)}}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2" class="txt-right" width="195px">
                            {{lang_trans('txt_total')}}&nbsp;
                        </th>
                        <th class="txt-right" width="50px">
                            {{getCurrencySymbol()}} {{numberFormat($totalOrdersAmount)}}
                        </th>
                    </tr>
                @endif
            </table>
            <h4> {{lang_trans('txt_token_num')}} : {{$data_row->id}} </h4>
            <button class="btn btn-sm btn-success no-print" onclick="printSlip()">
                {{lang_trans('btn_print')}}
            </button>
            <a class="btn btn-sm btn-danger no-print" href="{{route('dashboard')}}" id="back-btn">
                {{lang_trans('btn_go_back')}}
            </a>
        </div>
    </div>
    <script type="text/javascript" src="{{URL::asset('public/js/page_js/page.js')}}"></script> 
</body>
</html>