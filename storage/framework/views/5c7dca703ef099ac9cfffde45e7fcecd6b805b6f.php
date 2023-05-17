

<?php $__env->startSection('content'); ?>
<style>
    .newpadd{
        padding-left: 10%;
        padding-right: 10%;
    }
    .maintextj{
        font-size:16px;
        font-weight:bold;
        color: darkgreen;
        margin-left: 2%;
    }
    .mainhj{
        font-size:20px;
        font-weight:bold;
        color: Black;
    }
    .pricecsj{
        color: Black;
        font-weight:bold;
        margin-left: 10%;
        float:right;
    }
    .imgfood{
        border-radius: 50%;
        margin-bottom: 15px;
    }
    .rsbutton{
        position:fixed;
        bottom:10px;
    }
    .rsbutton1{
        position:fixed;
        bottom:10px;
        right:0;
    }
    .totalamh4{
        float:right;
    }
    
    
    @media  only screen and (max-width: 600px) {
        .newpadd{
            padding-left: 0%;
            padding-right: 0%;
        }
        .inputclj{
            margin-top: 10px !important;
            margin-left: 5px !important;
        }
        .maintextj{
            margin-top: 5px !important;
        }
        .bgrscol{
            background: mediumvioletred;
            color: white;
        }
        .rsbutton{
            position:fixed;
            bottom:4px;
            height: 49px;
        }
        .rsbutton1{
            position:fixed;
            bottom:4px;
            right:0;
        }
        .btnpay{
            padding: 6px 28px;
            margin-top: 10px;
        }
        .totalamh4{
            text-align: center;
            margin-top: 7%;
        }
    }

</style>

<div class="container-fluid newpadd">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <h2 class="text-center text-danger"><b> Feeling Hungry Just Select Your Favourite Food And Enjoy </b></h2>
            <br/>
            <!--<form method="post" action="#">-->
            <!--<form action="<?php echo e(route('payment')); ?>" method="POST" >-->
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label class="hotelstitle">Room Number <?php echo e(request()->route('id')); ?></label>
                        <input type="hidden" name="roomnumberdj" id="roomnumberdj" value="<?php echo e(request()->route('id')); ?>">
                        <!--<select class="form-control" name="room_number" id="roomnumber" required>-->
                            <?php
                                // $hotel_id = $hotel_id ?? '';
                                // foreach($datalist as $v)
                                // {
                                //     // print_r($v);
                                //     if($hotel_id==$v->room_no)
                                //     {
                                //         echo '<option selected value='.$v->room_no.'>'.$v->room_no.'</option>';
                                //     }else
                                //     {
                                //         echo '<option value='.$v->room_no.'>'.$v->room_no.'</option>';  
                                //     }
                                // } 
                            ?>
                        <!--</select>-->
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-xs-12 col-md-3 col-lg-3"></div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <!--<label class="hotelstitle">Select Food Items <span style="color:red;">*</span></label>-->
                        
                        <!--<label for="vehicle1"> I have a bike</label><br>-->
                            <?php
                                $hotel_id = $hotel_id ?? '';
                                foreach($category_list as $v)
                                {
                                    
                                    echo '<h4 class="mainhj">'.$v->name.'</h4>';
                                    foreach($v['food_items'] as $newv){
                                        // print_r($newv);
                                        if($hotel_id==$v->room_no)
                                        {
                                            echo '<div class="row" id="cart">
                                                <div class="col-xs-2 col-md-2 col-lg-2"> 
                                                    <img src="/storage/app/public/productjack/'.$newv->food_image.'" class="img-fluid imgfood" width="50" />
                                                </div>
                                                <div class="col-xs-1 col-md-1 col-lg-1"> 
                                                    <input type="checkbox" id="allfoodname'.$newv->id.'" name="allfoodname" class="inputclj" data-price="'.$newv->price.'" value="'.$newv->name.'">
                                                </div> 
                                                <div class="col-xs-4 col-md-4 col-lg-4"> 
                                                    <label class="maintextj" for="allfoodname'.$newv->id.'"> '.$newv->name.' </label> 
                                                </div>
                                                <div class="col-xs-1 col-md-1 col-lg-1"> 
                                                    <span class="pricecsj">₹'.$newv->price.'</span>
                                                </div>
                                                <div class="col-xs-3 col-md-3 col-lg-3"> 
                                                    <div id="field1">
                                                        <button type="button" id="sub" data-addid="'.$newv->id.'" data-price="'.$newv->price.'" class="sub">-</button>
                                                        <input type="number" name="countfood" id="countfood'.$newv->id.'" data-price="'.$newv->price.'" value="0" min="0" max="10" />
                                                        <button type="button" id="add" data-addid="'.$newv->id.'" data-price="'.$newv->price.'" class="add quantity-plus">+</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-1 col-md-1 col-lg-1"> 
                                                    <span class="finalprice"> </span>
                                                </div>
                                                
                                            </div><br>';
                                        }else
                                        {
                                            echo '<div class="row" id="cart">
                                                <div class="col-xs-2 col-md-2 col-lg-2"> 
                                                    <img src="{{ url("storage/productjack/"'.$newv->food_image.') }}" class="img-fluid imgfood" width="50" />
                                                </div>
                                                <div class="col-xs-1 col-md-1 col-lg-1">
                                                    <input type="checkbox" id="allfoodname'.$newv->id.'" name="allfoodname" class="inputclj" data-price="'.$newv->price.'" value="'.$newv->name.'">
                                                </div> 
                                                <div class="col-xs-4 col-md-4 col-lg-4">
                                                    <label class="maintextj" for="allfoodname'.$newv->id.'"> '.$newv->name.' </label> 
                                                </div>
                                                <div class="col-xs-1 col-md-1 col-lg-1"> 
                                                    <span class="pricecsj">₹'.$newv->price.'</span>
                                                </div>
                                                <div class="col-xs-3 col-md-3 col-lg-3"> 
                                                    <div id="field1">
                                                        <button type="button" id="sub" data-addid="'.$newv->id.'" data-price="'.$newv->price.'" class="sub">-</button>
                                                        <input type="number" name="countfood" id="countfood'.$newv->id.'" data-price="'.$newv->price.'" value="0" min="0" max="10" />
                                                        <button type="button" id="add" data-addid="'.$newv->id.'" data-price="'.$newv->price.'" class="add quantity-plus">+</button>
                                                    </div>
                                                </div>
                                            </div><br>';  
                                        }
                                    }
                                    
                                } 
                            ?>
                    </div>
                    <div class="col-xs-12 col-md-3 col-lg-3"></div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-3 col-lg-3"></div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <input type="number" name="mobileno" id="mobileno" class="form-control mobileno" placeholder="Enter Mobile Number" maxlength="10" disabled="disabled">
                    </div>
                    <div class="col-xs-12 col-md-3 col-lg-3">
                        <!--<button id="rzp-button1" class="btn btn-success">Get OTP</button>-->
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-2 col-md-2 col-lg-2 rsbutton">
                    </div>
                    <div class="col-xs-8 col-md-6 col-lg-6 rsbutton bgrscol">
                        <h4 class="totalamh4"> <b>Total Amount is <span id="amounttotalfinal">0 </span></b> </h4>
                        <input type="text" name="amount" id="totalprice" class="form-control amount" placeholder="Enter Amount" style="display:none;">
                    </div>
                    <div class="col-xs-4 col-md-4 col-lg-4 rsbutton1 bgrscol">
                       <button id="rzp-button1" class="btn btn-success btnpay">Pay</button>
                    </div>
                </div>
                
                <br/>
            <!--</form>-->
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Please Enter Valid Mobile Number</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php echo $__env->yieldContent('js'); ?>

<script>
    var finalamount = 0;
    $(document).on("click","#add",function() {
       
        var currentVal = 0;
        $(this).prev().val(+$(this).prev().val() + 1);
        $("input[name=countfood]").each(function(){
            if ($(this).val() < 10 && $(this).val() > 0) {
        	    currentVal += parseFloat($(this).attr('data-price') * $(this).val());
    	    }
        });
         alert(currentVal);
        
         $("#totalprice").val(finalamount + currentVal);
         $("#amounttotalfinal").html(finalamount + currentVal);
        

    //     if ($(this).prev().val() < 10) {
    // 	    $totalfood = $(this).prev().val(+$(this).prev().val() + 1);
    // 	    $totalfood1 = $(this).parent().children("input[name=countfood]").val();
    	   
    // 	    var cuurentVal = parseFloat($(this).attr('data-price') * $totalfood1 );
    // 	    $finalamount = $finalamount + cuurentVal;
    	    
    // 	    $("#totalprice").val($finalamount);
    //         $("#amounttotalfinal").html($finalamount);
	   // }
    });
    
    $('.sub').click(function () {
		if ($(this).next().val() > 0) {
    	    if ($(this).next().val() > 0){
    	        $(this).next().val(+$(this).next().val() - 1);
    	        $totalfood1 = $("input[name='countfood']").val();
    	        
        	    $finalamount = parseFloat($(this).attr('data-price') * $totalfood1 );
        	    alert($finalamount);
        	    $("#totalprice").val($finalamount);
                $("#amounttotalfinal").html($finalamount);
    	    } 
    	    
		}
    });
    
</script>
<script>
    $('input[type="checkbox"]').on('change', function(){
        var $total = 0;
        $('input[type="checkbox"]:checked').each(function(){
            var $new = $(this).attr('data-pricen');
            // var $tbv = $("input[name='countfood']").val();
            //  alert($new * $tbv );
            // $total += parseFloat($(this).data('price')).toFixed(2);
            $total += parseFloat($(this).attr('data-price'));
        });
        
        
        $('#mobileno').prop("disabled", false);
        var $finalamount = $total.toFixed(2);
        $("#totalprice").val($finalamount);
        $("#amounttotalfinal").html($finalamount);
    });
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('body').on('click','#rzp-button1',function(e){
            e.preventDefault();
            
            // beforeSend: function() {                    
                // var empty = $('#mobileno').val();
                // if(empty == '') {
                //     alert('Please Enter Valid Mobile Number');
                //     return false;
                // }else{
                //     return true;
                // };
            // },
            var roomnumber = $('#roomnumberdj').val();
            var arr = [];
            $.each($("input[name='allfoodname']:checked"), function(){
                arr.push($(this).val());
            });
            var allfoodname =  arr.join(", ");
            if(allfoodname == '') {
                alert('Please Choose Atleast One Food');
                return false;
            }else{
                
            }
            
            var mobileno = $('#mobileno').val();
            if(mobileno == '') {
                $("#myModal").modal("show");
                // alert('Please Enter Valid Mobile Number');
                return false;
            }else{
                
            }
            
            var amount = $('.amount').val();
            // alert(allfoodname);
            var total_amount = amount * 100;
            // var total_amount = amount;
            var options = {
                "key": "<?php echo e(env('RAZOR_KEY')); ?>", // Enter the Key ID generated from the Dashboard
                "amount": total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
                "currency": "INR",
                "name": "NiceSnippets",
                "description": "Test Transaction",
                "image": "https://www.nicesnippets.com/image/imgpsh_fullsize.png",
                "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response){
                    
                    if (typeof response.razorpay_payment_id == 'undefined' || response.razorpay_payment_id < 1) {
                        redirect_url = '<?php echo e(route("payment-failed")); ?>';
                    } else {
                        redirect_url = '<?php echo e(route("thank-you")); ?>';
                    }
                    location.href = redirect_url;
                    // $.ajaxSetup({
                    //     headers: {
                    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //     }
                    // });
                    $.ajax({
                        type:'POST',
                        url:"<?php echo e(route('payment')); ?>",
                        data:{"_token": "<?php echo e(csrf_token()); ?>",razorpay_payment_id:response.razorpay_payment_id,roomnumber:roomnumber,allfoodname:allfoodname,amount:amount},
                        success:function(data){
                            // console.log(data);
                            $('.success-message').text(data.success);
                            $('.success-alert').fadeIn('slow', function(){
                               $('.success-alert').delay(5000).fadeOut(); 
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend_order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/ordermenu/menu.blade.php ENDPATH**/ ?>