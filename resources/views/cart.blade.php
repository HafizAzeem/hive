@extends('layouts.master_backend_order')
  
@section('content')
@php

    $settings = getSettings();
    $gstPercFood = $settings['food_gst'];
    $cgstPercFood = $settings['food_cgst'];
    $discountFood = $settings['discountfood'];
    

@endphp
<style>
    .carddesign{
        width: 70%;
        margin: auto;
        background-color: antiquewhite !important;
    }
    .subheadtotnew{
        position: absolute;
        margin-left: 5%;
    }
    .dicount{
        width: 40%;
        float: right;
    }
    
@media only screen and (max-width: 600px) {
    tbody#cartdiv tr td {
        vertical-align: middle;
    }
    .carddesign{
        width: 100%;
        margin-top:20%;
    }
    #meassagnew1 {
        position: fixed;
        top: 3%;
        left: 5%;
        z-index: 1;
        background: #5bc0de;
        color: white;
        font-size: 18px;
        padding: 9px;
    }
    .nofonts{
        font-size: 14px;
    }
    .subheadtot{
        font-size: 16px;
        margin-right: 10%;
    }
    .subheadtotnew{
        position: absolute;
        margin-left: -25%;
        line-height: 2;
    }
    .dicount{
        width: 80%;
        float: right;
    }
}
</style>
<?php 
$roomnumb = session()->get('roomno');
?>

<input type="hidden" name="gst" id="gst" value="{{$gstPercFood}}">
<input type="hidden" name="cgst" id="cgst" value="{{$cgstPercFood}}">

<input type="hidden" name="roomnumberdj" id="roomnumberdj" value="{{$roomnumb}}">
<div id="meassagnew1" class="meassagnew1" style="display:none;"></div>
<!--<div id="cartdiv">-->
    <table id="cart" class="table table-hover table-condensed carddesign">
        <thead>
            <tr>
                <th style="width:40%;padding: 10px;">Food</th>
                <th style="width:20%;padding: 10px;">Price</th>
                <th style="width:10%;padding: 10px;">Quantity</th>
                <th style="width:20%;padding: 10px;" class="text-center">Subtotal</th>
                <th style="width:10%;padding: 10px;"></th>
            </tr>
        </thead>
        <tbody id="cartdiv">
            @php $total = 0 @endphp
            @if(session('cart'))
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr data-id="{{ $id }}" id="trid{{ $id }}" class="tridnew">
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs"><img src="/storage/app/public/productjack/{{ $details['image'] }}" width="70" height="100" class="img-responsive"/></div>
                                <div class="col-sm-9">
                                    <h4 class="nomargin nofonts">{{ $details['name'] }}</h4>
                                    <input type="hidden" id="allfoodname" name="allfoodname" class="allfoodname" value="{{ $details['name'] }}">
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">₹{{ $details['price'] }}</td>
                        <input type="hidden" id="unitprice" name="unitprice" class="unitprice" value="{{ $details['price'] }}">
                        <td data-th="Quantity">
                            <input type="number" id="foodquantity" name="foodquantity" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
                        </td>
                        <td data-th="Subtotal" class="text-center Subtotal">₹{{ $details['price'] * $details['quantity'] }}</td>
                        <input type="hidden" class="form-control Subtotalnew" id="Subtotalnew" name="Subtotalnew" value="{{ $details['price'] * $details['quantity'] }}"  />
                        <td class="actions" data-th="">
                            <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <?php
                    $total = number_format((float)$total, 2, '.', '');
                    $totalnew = number_format((float)$total*$gstPercFood/100, 2, '.', '');
                    $totalnewc = number_format((float)$total*$cgstPercFood/100, 2, '.', '');
                    $final = $total + $totalnew +$totalnewc;
                    $jatdis = number_format($final*$discountFood/100);
                    $jatdisnew = $final - $jatdis;
                    $final = number_format(round($jatdisnew),2, '.', '');
                    
                    //$jatdis = number_format((float)$final*$discountFood/100, 2, '.', '');
            ?>
            <tr>
                <td colspan="5" class="text-right"> <h4><span class="subheadtot">Total</span> <strong class="totalnew">  {{ $total }}</strong></h4></td>
                <input type="number" id="finalamount" class="form-control" value="{{$final}}" style="display:none;">
                <input type="hidden" id="hiddenfinaldis" class="form-control" value="{{$final}}" style="display:none;">
                <input type="hidden" name="discfood" id="discfood" value="{{$jatdis}}">
            </tr>
            <tr>
                <td colspan="5" class="text-right"><h4><span class="subheadtot">GST ({{$gstPercFood}} %)</span> <strong class="gstf" id="gstf"> {{$totalnew}} </strong></h4></td>
            </tr>
            <tr> 
                <td colspan="5" class="text-right"><h4><span class="subheadtot">CGST ({{$cgstPercFood}} %)</span> <strong class="cgstf" id="cgstf"> {{$totalnewc}} </strong></h4></td>
            </tr>
            <tr> 
                <td> </td>
                <td> </td>
                <td> </td>
                <td colspan="5"> 
                    <h4> 
                        <span class="subheadtotnew">Discount %</span> 
                        <span><input type="number" name="discount" id="discount" class="form-control dicount" value="{{$discountFood}}" disabled> </span>
                    </h4>  
                </td>
            </tr>
            <tr> 
                <td colspan="5" class="text-right"><h4><span class="subheadtot">Grand Total</span> <strong class="finalnew"> ₹ {{$final}} </strong></h4></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                    <!--<a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>-->
                     <a class="btn btn-warning" href="{{ url()->previous() }}"> Back </a>
                    <button class="btn btn-success" id="myModalnew">Continue</button>
                </td>
            </tr>
        </tfoot>
    </table>
<!--</div>-->
<div id="myModal" class="modal fade" role="dialog" style="top: 25%;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="meassagnew" class="meassagnew text-danger"></div>
        <p>Enter Mobile Number</p>
        <input type="number" name="mobileno" id="mobileno" class="form-control mobileno" placeholder="Enter Mobile Number" maxlength="10">
        <button class="btn btn-success sendotp" id="sendotp">SEND OTP</button>
        <a class="btn btn-success resendotp" id="resendotp" style="display:none;">RESEND OTP</a>
        <input type="number" name="enterotp" id="enterotp" class="form-control enterotp" placeholder="Enter Otp" disabled>
        <button class="btn btn-success verifyotp" id="verifyotp">VERIFY OTP</button>
      </div>
      <div class="modal-footer">
        <button id="rzp-button1" class="btn btn-success btnpay btnhide" style="display:none;">Pay</button>
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>
  </div>
</div>
  
@yield('js')

<script type="text/javascript">
  
    // $(".update-cart").change(function (e) {
    //     e.preventDefault();
    //     var ele = $(this);
        
    //     $.ajax({
    //         url: '{{ route('update.cart') }}',
    //         method: "patch",
    //         data: {
    //             _token: '{{ csrf_token() }}', 
    //             id: ele.parents("tr").attr("data-id"), 
    //             quantity: ele.parents("tr").find(".quantity").val()
    //         },
    //         success: function (response) {
    //             // console.log(response);
    //             var quat = ele.parents("tr").find(".quantity").val();
    //             var pricen = ele.parents("tr").find("#unitprice").val();
    //             var third = quat*pricen;
    //             // alert(third);
    //             var valnew = ele.parents("tr").find(".Subtotal").html("₹"+third);
    //             var jat = ele.parents("tr").find(".Subtotalnew").val(third);
    //             var arr = [];
    //             $.each($("input[name='Subtotalnew']"), function(){
    //                 arr.push($(this).val());
    //             });
                
    //             sum = 0;
    //             $.each(arr,function(){sum+=parseFloat(this) || 0;});
    //             // alert(sum);
    //             $(".totalnew").html("₹"+sum);
    //             $('#finalamount').val(sum);
                
    //             $('.meassagnew1').fadeIn('slow', function(){
    //                 $(".meassagnew1").css("display", "block");
    //                 $(".meassagnew1").html("Food updated successfully");
    //                 $('.meassagnew1').delay(3000).fadeOut(); 
    //             });
    //         }
    //     });
    // });
    
    $(".update-cart").keyup(function (e) {
        e.preventDefault();
        var ele = $(this);
        var quatnew = ele.parents("tr").find(".quantity").val();
        
        if(quatnew == 0){
            
            $('.meassagnew1').fadeIn('slow', function(){
                $(".meassagnew1").css("display", "block");
                $(".meassagnew1").html("Please Fill atleast 1 Quantity");
                $('.meassagnew1').delay(3000).fadeOut(); 
            });
            ele.parents("tr").find("#foodquantity").val("");
            ele.parents("tr").find(".Subtotal").html("₹"+0);
            ele.parents("tr").find(".Subtotalnew").val("");
            // ele.('#foodquantity').val("");
        }else{
            $.ajax({
                url: '{{ route('update.cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id"), 
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function (response) {
                    
                    var quat = ele.parents("tr").find(".quantity").val();
                    var pricen = ele.parents("tr").find("#unitprice").val();
                    var third = quat*pricen;
                    
                    var valnew = ele.parents("tr").find(".Subtotal").html("₹"+third);
                    var jat = ele.parents("tr").find(".Subtotalnew").val(third);
                    var arr = [];
                    $.each($("input[name='Subtotalnew']"), function(){
                        arr.push($(this).val());
                    });
                    
                    sum = 0;
                    $.each(arr,function(){sum+=parseFloat(this) || 0;});
                    // alert(sum);
                    // $(".totalnew").html("₹"+sum);
                    var sum = parseFloat(sum).toFixed(2);
                    $(".totalnew").html(sum);
                    
                    var gst = $("#gst").val();
                    var cgst = $("#cgst").val();
                    var discount = $("#discount").val();
                    var totalgst = parseFloat(sum*gst/100).toFixed(2);
                    $('#gstf').html(totalgst);
                    var totalcgst = parseFloat(sum*cgst/100).toFixed(2);
                    $('#cgstf').html(totalcgst);
                    var final = parseFloat(sum) + parseFloat(totalgst) + parseFloat(totalcgst);
                    var finalnewj = parseFloat(final).toFixed(2);
                    
                    var jatdis = parseFloat(finalnewj*discount/100);
                    var jatdis1 = Math.round(jatdis);
                    $('#discfood').val(jatdis1);
                    var jatdisn = parseFloat(jatdis).toFixed(2);
                    //alert(jatdisn);
                    var newfinalnewj = Math.round(finalnewj-jatdisn);
                    var newfinalnewj1 = parseFloat(newfinalnewj).toFixed(2);
                    $('#finalamount').val(newfinalnewj1);
                    $('.finalnew').html("₹" +newfinalnewj1);
                    
                
                    $('.meassagnew1').fadeIn('slow', function(){
                        $(".meassagnew1").css("display", "block");
                        $(".meassagnew1").html("Food updated successfully");
                        $('.meassagnew1').delay(3000).fadeOut(); 
                    });
                }
            });
        }

        
    });
    
    $("#discount").keyup(function (e) {
        e.preventDefault();
        var finalamount = $('#finalamount').val();
        var disfinal = $('#hiddenfinaldis').val();
        var discount = $("#discount").val();
        if(parseFloat(discount) > parseFloat(finalamount)){
            var final = parseFloat(disfinal).toFixed(2);
            $("#discount").val('');
            $('#finalamount').val(final);
            $('.finalnew').html("₹" +final);
            
            $('.meassagnew1').fadeIn('slow', function(){
                $(".meassagnew1").html("Disount amount is greter than total amount");
                $('.meassagnew1').delay(3000).fadeOut(); 
            });
        }else if(discount == ""){
            var disfn = parseFloat(disfinal).toFixed(2);
            $('.finalnew').html("₹" +disfn);
        }else{
            var final = parseFloat(disfinal) - parseFloat(discount);
            var finalnewj = parseFloat(final).toFixed(2);
            var newfinalnewj = Math.round(finalnewj);
            var newfinalnewj1 = parseFloat(newfinalnewj).toFixed(2);
            $('#finalamount').val(newfinalnewj1);
            $('.finalnew').html("₹" +newfinalnewj1);
        }
        
    });
  
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        // alert("call");
        var ele = $(this);
  
        if(confirm("Are you sure want to remove?")) {
            
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
    
    // $("verifyotp").prop('disabled', false);
    // $("enterotp").prop('disabled', false);
    $("#verifyotp").attr('disabled','disabled');
    $("#enterotp").attr('disabled','disabled');
    // $("#resendotp").attr('disabled','disabled');
    
    $("#myModalnew").click(function (e) {
        var finalamount = $('#finalamount').val();
        var roomvalue = $('#roomnumberdj').val();
        // alert(finalamount);
        if(finalamount > 0){
            
            //get mobile number using room number
                $.ajax({
                    type:'POST',
                    url:"{{ route('getmobnumb') }}",
                    data:{"_token": "{{ csrf_token() }}",roomvalue:roomvalue},
                    success:function(data){
                        console.log(data);
                        var mobile = data.userdatafood.customer.mobile;
                        $("#mobileno").val(mobile);
                    }
                });
                
                $("#myModal").modal("show");
                
        }else{
            $('.meassagnew1').fadeIn('slow', function(){
                $(".meassagnew1").html("Please Select Food And Come Back");
                $('.meassagnew1').delay(3000).fadeOut(); 
            });
        }
        
    });
    
    $("#sendotp").click(function (e) {
        e.preventDefault();
        var mobileno = $('#mobileno').val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        var otp = Math.floor(1000 + Math.random() * 9000);
        if (filter.test(mobileno)) {
            if(mobileno.length!=10){
                $('.meassagnew').fadeIn('slow', function(){
                    $(".meassagnew").html("Please Enter Valid Mobile Number");
                    $('.meassagnew').delay(3000).fadeOut(); 
                });
                
            }else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('mobotp') }}",
                    data:{"_token": "{{ csrf_token() }}",mobile:mobileno,otp:otp},
                    success:function(data){
                        console.log(data);
                        if(data != 406){
                            
                            // $("#sendotp").attr('disabled','disabled');
                            $("#sendotp").prop('disabled', true);
                            
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Send Successfully");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                           
                            $("#enterotp").removeAttr('disabled');
                            $("#verifyotp").removeAttr('disabled');
                            // $("#resendotp").removeAttr('disabled');
                            $( "#resendotp" ).show();
                            
                        }else{
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Not Send");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                        }
                        
                    }
                });
            }
        }
        else{
            $(".meassagnew").html("Server Error");
        }
        // if(mobileno == '') {
        //     $(".meassagnew").html("Please Enter Valid Mobile Number");
        //     return false;
        // }else{
        //     $.ajax({
        //             type:'POST',
        //             url:"{{ route('mobotp') }}",
        //             data:{"_token": "{{ csrf_token() }}",mobile:mobileno,otp:otp},
        //             success:function(data){
        //                 console.log(data);
        //                 if(data == 406){
                            
        //                     // $("#sendotp").attr('disabled','disabled');
        //                     $("#sendotp").prop('disabled', true);
                            
        //                     $('.meassagnew').fadeIn('slow', function(){
        //                         $(".meassagnew").html("Otp Send Successfully");
        //                         $('.meassagnew').delay(5000).fadeOut(); 
        //                     });
                           
        //                     $("#enterotp").removeAttr('disabled');
        //                     $("#verifyotp").removeAttr('disabled');
                            
        //                 }else{
                            
        //                 }
                        
        //             }
        //         });
        // }
        
        // var ele = $(this);
        
    });
    
    $("#resendotp").click(function (e) {
        e.preventDefault();
        var mobileno = $('#mobileno').val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        var otp = Math.floor(1000 + Math.random() * 9000);
        if (filter.test(mobileno)) {
            if(mobileno.length!=10){
                $('.meassagnew').fadeIn('slow', function(){
                    $(".meassagnew").html("Please Enter Valid Mobile Number");
                    $('.meassagnew').delay(3000).fadeOut(); 
                });
                
            }else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('mobotp') }}",
                    data:{"_token": "{{ csrf_token() }}",mobile:mobileno,otp:otp},
                    success:function(data){
                        console.log(data);
                        if(data != 406){
                            
                            // $("#sendotp").attr('disabled','disabled');
                            $("#sendotp").prop('disabled', true);
                            
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Send Successfully");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                           
                            $("#enterotp").removeAttr('disabled');
                            $("#verifyotp").removeAttr('disabled');
                            
                        }else{
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Not Send");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                        }
                        
                    }
                });
            }
        }
        else{
            $(".meassagnew").html("Server Error");
        }
        // if(mobileno == '') {
        //     $(".meassagnew").html("Please Enter Valid Mobile Number");
        //     return false;
        // }else{
        //     $.ajax({
        //             type:'POST',
        //             url:"{{ route('mobotp') }}",
        //             data:{"_token": "{{ csrf_token() }}",mobile:mobileno,otp:otp},
        //             success:function(data){
        //                 console.log(data);
        //                 if(data == 406){
                            
        //                     // $("#sendotp").attr('disabled','disabled');
        //                     $("#sendotp").prop('disabled', true);
                            
        //                     $('.meassagnew').fadeIn('slow', function(){
        //                         $(".meassagnew").html("Otp Send Successfully");
        //                         $('.meassagnew').delay(5000).fadeOut(); 
        //                     });
                           
        //                     $("#enterotp").removeAttr('disabled');
        //                     $("#verifyotp").removeAttr('disabled');
                            
        //                 }else{
                            
        //                 }
                        
        //             }
        //         });
        // }
        
        // var ele = $(this);
        
    });
    
    $("#verifyotp").click(function (e) {
        e.preventDefault();
        var mobileno = $('#mobileno').val();
        var enterotp = $('#enterotp').val();
        if(enterotp == '') {
            $(".meassagnew").html("Please Enter Valid Otp");
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:"{{ route('verifyotp') }}",
                // dataType: 'json',
                data:{"_token": "{{ csrf_token() }}",mobileno:mobileno,enterotp:enterotp},
                success:function(data){
                    console.log(data);
                    if(data == 1){
                        $('.meassagnew').fadeIn('slow', function(){
                            $(".meassagnew").html("Otp Verified");
                            $('.meassagnew').delay(3000).fadeOut(); 
                        });
                        $("#verifyotp").prop('disabled', true);
                        $(".btnhide").css("display", "block");
                    }else{
                        $(".meassagnew").html("Otp Not Verified");
                    }
                }
            });
        }
        
    });
    
</script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $('body').on('click','#rzp-button1',function(e){
        e.preventDefault();
        
        var mobileno = $('#mobileno').val();
        var enterotp = $('#enterotp').val();
        
        var roomnumber = $('#roomnumberdj').val();
        var discount = $('#discfood').val();
        var amount = $('#finalamount').val();
        // var arr = [];
        // $.each($("input[name='allfoodname']"), function(){
        //     arr.push($(this).val());
        // });
        // var allfoodname =  arr.join(", ");
        // alert(allfoodname);
        // if(allfoodname == '') {
        //     alert('Please Choose Atleast One Food');
        //     return false;
        // }else{
            
        // }
        
        var arr = [];
        var arr1 = [];
        var arr2 = [];
        
        $.each($("input[name='allfoodname']"), function(){
            arr.push($(this).val());
        });
        var allfoodname =  arr.join(", ");
        
        $.each($("input[name='foodquantity']"), function(){
            arr1.push($(this).val());
        });
        var foodquantity =  arr1.join(", ");
        
        $.each($("input[name='unitprice']"), function(){
            arr2.push($(this).val());
        });
        var unitprice =  arr2.join(", ");
        
        // alert(unitprice);
        
        // var mobileno = $('#mobileno').val();
        // if(mobileno == '') {
        //     $("#myModal").modal("show");
        //     // alert('Please Enter Valid Mobile Number');
        //     return false;
        // }else{
            
        // }
        
        // var amount = $('.amount').val();
        // alert(allfoodname);
        var total_amount = amount * 100;
        // var total_amount = amount;
        var options = {
            "key": "{{ env('RAZOR_KEY') }}", // Enter the Key ID generated from the Dashboard
            "amount": total_amount,// Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
            "currency": "INR",
            "name": "NiceSnippets",
            "description": "Test Transaction",
            "image": "https://www.nicesnippets.com/image/imgpsh_fullsize.png",
            "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "handler": function (response){
                // console.log(response);
                if (typeof response.razorpay_payment_id == 'undefined' || response.razorpay_payment_id < 1) {
                    redirect_url = '{{ route("payment-failed") }}';
                } else {
                    redirect_url = '{{ route("thank-you") }}';
                }
                location.href = redirect_url;
                
                $.ajax({
                    type:'POST',
                    url:"{{ route('payment') }}",
                    data:{"_token": "{{ csrf_token() }}",razorpay_payment_id:response.razorpay_payment_id,mobileno:mobileno,enterotp:enterotp,roomnumber:roomnumber,allfoodname:allfoodname,foodquantity:foodquantity,unitprice:unitprice,discount:discount,amount:amount},
                    success:function(data){
                        // console.log(data);
                        $('.success-message').text(data.success);
                        $('.success-alert').fadeIn('slow', function(){
                           $('.success-alert').delay(3000).fadeOut(); 
                        });
                        $('.amount').val('');
                    }
                });
            },
            "prefill": {
                "name": "Mehul Bagda",
                "email": "mehul.bagda@example.com",
                "contact": "818********6"
            },
            "notes": {
                "address": "test test"
            },
            "theme": {
                "color": "#F37254"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    });
</script>
@endsection