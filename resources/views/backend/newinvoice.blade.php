@php 
  $settings = getSettings();
  $type=1;
@endphp

<!DOCTYPE html>
<html lang="en">
     <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>{{$settings['site_page_title']}}: Invoice</title>
        <link href="{{URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('public/css/invoice_style.css')}}" rel="stylesheet">
        <style>
          .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
            {
                padding:4px;
                font-size:12px;
            }
        </style>
    </head>
    <body>
       
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
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <!--<strong class="fsize-label">-->
                        <!--    No.:-->
                        <!--    <span class="class-inv-19">-->
                        <!--       123456-->
                        <!--    </span>-->
                        <!--</strong>-->
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <br/>
                        <strong class="fsize-label">
                            Dated :
                        </strong>
                        <spa class-inv-16n="">
                            2022-32-32
                        </spa>
                    </div>
                </div>
            </div>
     
    
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Customer Name:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
    
              <?php
              $address='';
               if(isset($corporates))
               {
                   echo $corporates->name;
                   $address=$corporates->address;
                   
               }
               
               if(isset($tas))
               {
                   echo $tas->name;
                   $address=$tas->address;
               }
              ?>

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-6">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <strong class="fsize-label">
                Address:
            </strong>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 class-inv-16">
            <span>
               {{$address}}
            </span>
        </div>
    </div>
    
   
    
</div>
@if($type==1)
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="5%">
                        {{lang_trans('txt_sno')}}.
                    </th>
                    <th class="text-center" width="30%">
                        Particulars
                    </th>
                    <th class="text-center" width="10%">
                        Room Qty
                    </th>
                    
                     <th class="text-center" width="10%">
                        Room Number
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
                    <th class="text-center" width="10%">
                        Amount ({{getCurrencySymbol()}})
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $total=0; ?>
                @foreach($data_row as $key=>$d)
                 
                <tr>
                    <td class="text-center">
                        {{$key+1}}
                    </td>
                    <td class="text-center">
                    {{$d->customer->name}}
                    </td>
                    <td class="text-center">
                       {{$d->room_qty == 0 ? 1 : $d->room_qty}}
                    </td>
                    
                     <td class="text-center">
                        {{$d->room_num}}
                    </td>
                    
                    <td class="text-center">
                       {{$d->room_type->title}}
                    </td>
                    
                    <td class="text-center">
                       1200
                    </td>
                    <td class="text-center">
                         {{$d->duration_of_stay}}
                    </td>
                    <td class="text-center">
                     {{$d->booking_payment}}
                    </td>
                </tr>
                <?php $total=$total+$d->booking_payment; ?>
                @endforeach
                <tr>
                    <th class="text-right" colspan="7">
                        Total
                    </th>
                    <td class="text-right">
                       {{$total}}
                    </td>
                </tr>
                
                <?php 
                $amount=$total;
        if(($amount>=0) && ($amount<=999))
         {
              $gstPerc=$settings['gst_0'];
              $cgstPerc=$settings['cgst_0'];
         }
         else if(($amount>=1000) && ($amount<=2499))
         {
              $gstPerc=$settings['gst'];
              $cgstPerc=$settings['cgst'];
         }
            else if(($amount>2499) && ($amount<=7499))
         {
              $gstPerc=$settings['gst_1'];
              $cgstPerc=$settings['cgst_1'];
         }
         else
         {
            $gstPerc=$settings['gst_2'];
            $cgstPerc=$settings['cgst_2'];  
         }
            if($gstPerc==0)
            {
                
            }else
            {
            
            
            $sgstamount=round(($total*100)/$gstPerc);
            $cgstamount=round(($total*100)/$gstPerc);
            }
                ?>
               
                <tr>
                    <th class="text-right" colspan="7">
                        GST {{$gstPerc}} %
                    </th>
                    <td class="text-right">
                        {{$sgstamount ?? 0}}
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="7">
                        CGST {{$cgstPerc}} %
                    </th>
                    <td class="text-right">
                      {{$cgstamount ?? 0}}
                    </td>
                </tr>
                
                <tr>
                    <th class="text-right" colspan="7">
                       Total Amount
                    </th>
                    <td class="text-right">
                      {{$total}}
                    </td>
                </tr>
                
              
                
                
                
                <!--<tr>-->
                <!--    <th class="text-right" colspan="7">-->
                <!--    {{lang_trans('txt_amount_payable')}}-->
                <!--    </th>-->
                <!--    <td class="text-right">-->
                <!--  12333-->
                <!--    </td>-->
                <!--</tr>-->
                <tr>
                    <th class="text-right" colspan="5">
                        Amount in Words:-
                    </th>
                    <td class="class-inv-17" colspan="5">
                        {{ getIndianCurrency(numberFormat(12345)) }}
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



<div>
    {!!$settings['invoice_term_condition']!!}
</div>
@endif