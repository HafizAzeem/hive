@php 

    $settings = getSettings();
    $gst_0 = $settings['gst_0'];
    $cgst_0 = $settings['cgst_0'];

    $gst = $settings['gst'];
    $cgst = $settings['cgst'];

    $gst_1 = $settings['gst_1'];
    $cgst_1 = $settings['cgst_1'];
    
    date_default_timezone_set("Asia/Kolkata");
    $currentdate = date('d-m-Y h:i:A');
    
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>Invoice</title>
        <link href="{{URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('public/css/invoice_style.css')}}" rel="stylesheet">
        <style>
          .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
            {
                padding:4px;
                font-size:12px;
            }
            .dsfht{
                position: absolute;
                right: 10%;
                top: 5%;
            }
        </style>
    </head>
    <body>
      
        <button onClick="printpage()" id="printpagebutton" class="dsfht">Print this page</button>
        <script type="text/javascript">
    function printpage() {
        var printButton = document.getElementById("printpagebutton");
        printButton.style.visibility = 'hidden';
        window.print();
        printButton.style.visibility = 'visible';
    }
</script>
        <div class="container">
            <center><img src="https://f9hotels.com/web/dist/images/ezystayz-logo.png"></center>
            <h3 style="margin-top:1px;"><center>F9 GROUP OF HOTELS</center></h3>
            <h4><center>MARSROCK HOSPITALITY VENTURES PRIVATE LIMITED</center></h4>
            <h5><center>CIN: U55100UP2021PTC156143</center></h5>
            <h6><center>Reg. Office: House no. A-197, Sector-47 Noida, Noida, Gautam Buddha Nagar, U.P.-201301, IN</center></h6>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-11">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong>
                            GSTIN: {{$settings['gst_num']}}
                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <strong>
                            Ph. {{$settings['hotel_phone']}}
                        </strong>
                        
                        <strong>
                            (M) {{$settings['hotel_mobile']}}
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
                            E-mail:-
                        </span>
                        <span>
                           {{$settings['hotel_email']}}
                        </span>
                    </div>
                    <div class="class-inv-14">
                        <b>Performa Invoice</b>
                    </div>
                </div>
            </div>
            @php 
                $hello = $settings['hotel_name'];
                $acronym = "";
                $words = explode(" ", "$hello");
            @endphp

            @foreach($words as $w) 
                @php $acronym .= mb_substr($w, 0, 1); @endphp
            @endforeach
                
            <div class="row">
                <br/>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong class="fsize-label">
                            No.:
                            <span class="class-inv-19">
                                {{$acronym}}{{$data_row[0]->invoice_id}}
                            </span>
                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        
                        <strong class="fsize-label">
                            Dated : 
                        </strong>
                        <span class-inv-16n="">
                            {{$currentdate}}
                        </span>
                        <br/>
                    </div>
                    
                </div>
                <br/>
                
            </div>
            
            <br/>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <strong class="fsize-label">
                            Customer Name:
                        </strong>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
                        {{$data_row[0]->name}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <strong class="fsize-label">
                            Mobile:
                        </strong>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
                        <span>
                           {{$data_row[0]->mobile}}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="5%">
                        S.no
                    </th>
                    <th class="text-center" width="30%">
                        Particulars
                    </th>
                    <th class="text-center" width="10%">
                        Room Qty
                    </th>
                    <th class="text-center" width="10%">
                        Room Type
                    </th>
                    <th class="text-center" width="10%">
                        Room Rent ({{getCurrencySymbol()}})
                    </th>
                    <th class="text-center" width="10%">
                        Total Days
                    </th>
                    <th class="text-center" width="10%" colspan="2">
                        Amount ({{getCurrencySymbol()}})
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        1.
                    </td>
                    <td class="text-center">
                        {{$data_row[0]->title}}
                    </td>
                    <td class="text-center">
                        {{$data_row[0]->no_of_rooms}}
                    </td>
                    
                    <td class="text-center">
                        {{$roomtypes_list[0]->title}}
                    </td>
                    
                    <td class="text-center">
                        {{$data_row[0]->payment}}
                    </td>
                    <td class="text-center">
                        {{$data_row[0]->duration_of_stay}}
                    </td>
                    <td class="text-center" colspan="2">
                        {{numberFormat($data_row[0]->duration_of_stay*$data_row[0]->no_of_rooms*$data_row[0]->payment)}}
                    </td>
                </tr>
                
                <tr>
                    <th class="text-right" colspan="7">
                        Check In Date :
                    </th>
                    <td class="text-right">
                        {{dateConvert($data_row[0]->check_in,'d-m-Y')}}
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="7">
                        Check Out Date :
                    </th>
                    <td class="text-right">
                        {{dateConvert($data_row[0]->check_out,'d-m-Y')}}
                    </td>
                </tr>
               
                <tr>
                    <th class="text-right" colspan="7">
                         {{$roomtypes_list[0]->title}} ({{$data_row[0]->payment}}*{{$data_row[0]->no_of_rooms}})
                    </th>
                    <td class="text-right">
                        {{numberFormat($data_row[0]->duration_of_stay*$data_row[0]->no_of_rooms*$data_row[0]->payment)}}
                    </td>
                </tr>
                @php 
                    $total_amount = $data_row[0]->duration_of_stay*$data_row[0]->no_of_rooms*$data_row[0]->payment;
                @endphp
                <tr>
                    @if($data_row[0]->remarkone)
                    <th class="text-right" colspan="7">
                        {{$data_row[0]->remarkone}}
                    </th>
                    @endif
                    @if($data_row[0]->amountone)
                    <td class="text-right">
                        {{numberFormat($data_row[0]->amountone)}}
                    </td>
                    @endif
                </tr>
                <tr>
                    @if($data_row[0]->remarktwo)
                    <th class="text-right" colspan="7">
                        {{$data_row[0]->remarktwo}}
                    </th>
                    @endif
                    @if($data_row[0]->amounttwo)
                    <td class="text-right">
                        {{numberFormat($data_row[0]->amounttwo)}}
                    </td>
                    @endif
                </tr>
                <tr>
                    @if($data_row[0]->remarkthree)
                    <th class="text-right" colspan="7">
                        {{$data_row[0]->remarkthree}}
                    </th>
                    @endif
                    @if($data_row[0]->amountthree)
                    <td class="text-right">
                        {{numberFormat($data_row[0]->amountthree)}}
                    </td>
                    @endif
                </tr>
                <tr>
                    @if($data_row[0]->remarkfour)
                    <th class="text-right" colspan="7">
                        {{$data_row[0]->remarkfour}}
                    </th>
                    @endif
                    @if($data_row[0]->amountfour)
                    <td class="text-right">
                        {{numberFormat($data_row[0]->amountfour)}}
                    </td>
                    @endif
                </tr>
                <tr>
                    @if($data_row[0]->remarkfive)
                    <th class="text-right" colspan="7">
                        {{$data_row[0]->remarkfive}}
                    </th>
                    @endif
                    @if($data_row[0]->amountfive)
                    <td class="text-right">
                        {{numberFormat($data_row[0]->amountfive)}}
                    </td>
                    @endif
                </tr>
                @php 
                
                $total = $total_amount + $data_row[0]->amountone + $data_row[0]->amounttwo + $data_row[0]->amountthree + $data_row[0]->amountfour + $data_row[0]->amountfive;
                
                @endphp
                
                <tr>
                    <th class="text-right" colspan="7">
                       Total Amount
                    </th>
                    <td class="text-right">
                        {{numberFormat($total)}}
                    </td>
                </tr>
                @php
                  $fortypercent = $total * 40 / 100;
                @endphp
                <tr>
                    <th class="text-right" colspan="7">
                        Need 40% Advance for Booking Confirmation
                    </th>
                    <td class="text-right">
                       {{numberFormat($fortypercent)}}
                    </td>
                </tr>
                
                <tr>
                    @if($data_row[0]->advance)
                    <th class="text-right" colspan="7">
                        Advance Paid ({{dateConvert($data_row[0]->advance_date,'d-m-Y')}})
                        
                    </th>
                    <td class="text-right">
                       {{numberFormat($data_row[0]->advance)}}
                    </td>
                    @endif
                </tr>
                
                <tr>
                    @if($data_row[0]->advance)
                    <th class="text-right" colspan="7">
                        Remaining Advance
                    </th>
                    <td class="text-right">
                       {{numberFormat($fortypercent - $data_row[0]->advance)}}
                    </td>
                    @endif
                </tr>
                
                @php
                  $payble = $total - $fortypercent;
                @endphp
                <tr>
                    <th class="text-right" colspan="7">
                        (60%) Amount Payable at the time of Check In 
                    </th>
                    <td class="text-right">
                        {{numberFormat($payble)}}    
                    </td>
                </tr>
                
                <tr>
                    <th class="text-right" colspan="7">
                        Total Amount Payable 
                    </th>
                    <td class="text-right">
                        {{numberFormat($total - $data_row[0]->advance)}}    
                    </td>
                </tr>
                
                <tr>
                    <th class="text-right" colspan="4">
                        Amount in Words:-
                    </th>
                    <td class="class-inv-17" colspan="5">
                        {{ ucwords(getIndianCurrency(numberFormat($total))) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="class-inv-20" style="padding-top:5px;">
                            Customer Signature
                        </div>
                    </td>
                    <td class="text-right" colspan="5">
                        <div class="class-inv-20" style="padding-top:5px !important;">
                              <img src="{{asset('public/sign.jpeg')}}" style="width:150px;height:60px">
                              <br>
                            Manager Signature
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
