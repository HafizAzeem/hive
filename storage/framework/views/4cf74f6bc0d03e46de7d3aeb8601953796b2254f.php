<?php $__env->startSection('content'); ?>
<?php
    $settings = getSettings();
    $deliveryid = $settings['deliveryid'];
?>
<style>
    .btnwidth{
        width:100%;
    }
    .bgcolorbyslash{
        background-color: #e8f1ef;
    }
    .blanksection{
        min-height: 40vh;
    }
    .bgsubdivmain{
        background-color: cornsilk;
        padding: 10px;
    }
    .custbtnsb{
        margin-top:4%;
    }
</style>

<div class="deliverydiv">
    <input type="hidden" name="deliveryid" id="deliveryid" value="<?php echo e($deliveryid); ?>">
</div>

<?php
    $dataall = DB::table('deliverytables')->select('*')->where('child_id',$deliveryid)->get();
    //print_r($dataall);
?>

<div class="">
  <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
          <div class="x_panel">
              <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h2>DELIVERY</h2>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <a href="#" class="btn btn-danger btnwidth"> Pos </a>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <a href="#" class="btn btn-primary btnwidth" data-toggle="modal" data-target="#viewmodal"> Add Delivery Address </a>
                            <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModalLabel"> </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <input type="hidden" name="id" id="id" value="<?php echo e($deliveryid); ?>">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Mobile No <span>*</span></label>
                                                    <div class="moberr text-danger"></div>
                                                    <?php echo e(Form::number('mobile',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile",'required'])); ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Customer Name <span>*</span></label>
                                                    <div class="custnameerr text-danger"></div>
                                                    <?php echo e(Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name",'required'])); ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label class="control-label"> Email </label>
                                                    <?php echo e(Form::email('email',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])); ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                    <label>Gst #</label>
                                                    <?php echo e(Form::text('gstno',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"gstno"])); ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                    <label>Pan #</label>
                                                    <?php echo e(Form::text('panno',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"panno"])); ?>

                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label>Address <span>*</span></label>
                                                    <div class="addresserr text-danger"></div>
                                                    <?php echo e(Form::text('address',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address",'required'])); ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                                    <label>Building/Flat No. <span>*</span></label>
                                                    <div class="buildingflaterr text-danger"></div>
                                                    <?php echo e(Form::text('buildingflatno',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"buildingflatno",'required'])); ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                                    <label>Delivery Contact No.</label>
                                                    <?php echo e(Form::number('deliverycontact',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"deliverycontact"])); ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                                    <label>Landmark</label>
                                                    <?php echo e(Form::text('landmark',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"landmark"])); ?>

                                                </div>
                                                
                                            </div>
                                            
                                            <div class="text-right">
                                                <a class="btn btn-success custbtnsb" id="custaddressbtn"> Continue </a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <h3><a href="#"> KOT <span><?php echo e($deliveryid); ?></span> </a></h3>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                            <h3> ₹ 5.00 </h3>
                        </div>
                        
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 bgcolorbyslash">
                            <h3><a href="#"> By <span>#</span> </a></h3>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 bgcolorbyslash text-right">
                            <h3> : </h3>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="blanksection">
                                <div class="row">
                                    <?php if($dataall->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $dataall; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php //print_r($value); ?>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                            <h5 class="text-center"><?php echo e($key+1); ?></h5>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <h5 class="text-center"><?php echo e($value->foodname); ?></h5>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h5 class="text-center"><?php echo e($value->quantity); ?></h5>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h5 class="text-center"><?php echo e($value->rate); ?></h5>
                                        </div>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                            <h5 class="text-center"> X </h5>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bgsubdivmain">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                    <?php echo e(Form::text('foodname',null,['class'=>"form-control col-md-6 col-xs-12", 'placeholder'=>"custom item name", "id"=>"foodname",'required'])); ?>

                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <?php echo e(Form::number('rate',null,['class'=>"form-control col-md-6 col-xs-12", 'placeholder'=>"rate", "id"=>"rate",'required'])); ?>

                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <?php echo e(Form::number('quantity',1,['class'=>"form-control col-md-6 col-xs-12", "id"=>"quantity",'required'])); ?>

                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                    <a class="btn btn-success add-new-advance" id="plus"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button class="btn btn-success btnwidth">Place Order & Generate KOT</button>
                        </div>
                        
                    </div>
                    
              </div>
          </div>
      </div>
  </div>
</div>

<script>

    $("#plus").click(function (e) {
        e.preventDefault();
        
        var delvid = $('#deliveryid').val();
        var foodname = $('#foodname').val();
        var rate = $('#rate').val();
        var quantity = $('#quantity').val();
        
        if(foodname == '') {
            $(".meassagnew").html("Please Enter Valid Name");
            return false;
        }else if(rate == ''){
            $(".meassagnew").html("Please Enter Valid Rate");
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:"<?php echo e(route('savedeliveryorder')); ?>",
                // dataType: 'json',
                data:{"_token": "<?php echo e(csrf_token()); ?>",delvid:delvid,foodname:foodname,rate:rate,quantity:quantity},
                success:function(data){
                    console.log(data);
                    if(data.datadelivery != ''){
                        window.location.reload();
                    }
                    // if(data == 1){
                    //     $('.meassagnew').fadeIn('slow', function(){
                    //         $(".meassagnew").html("Otp Verified");
                    //         $('.meassagnew').delay(3000).fadeOut(); 
                    //     });
                    //     $("#verifyotp").prop('disabled', true);
                    //     $(".btnhide").css("display", "block");
                    // }else{
                    //     $(".meassagnew").html("Otp Not Verified");
                    // }
                }
            });
        }
        
    });
    
    $("#custaddressbtn").click(function (e) {
        e.preventDefault();
        // alert('hello');
        var mobile = $('#mobile').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var gstno = $('#gstno').val();
        var panno = $('#panno').val();
        var address = $('#address').val();
        var buildingflatno = $('#buildingflatno').val();
        var deliverycontact = $('#deliverycontact').val();
        var landmark = $('#landmark').val();
        
        if(mobile == '') {
            $('.moberr').fadeIn('slow', function(){
                $(".moberr").html("Please Enter Valid Mobile number");
                $('.moberr').delay(3000).fadeOut(); 
            });
            //$(".moberr").html("Please Enter Valid Mobile number");
            return false;
        }else if(name == ''){
            $('.custnameerr').fadeIn('slow', function(){
                $(".custnameerr").html("Please Enter Valid Name");
                $('.custnameerr').delay(3000).fadeOut(); 
            });
            //$(".custnameerr").html("Please Enter Valid Name");
            return false;
        }else if(address == ''){
            $('.addresserr').fadeIn('slow', function(){
                $(".addresserr").html("Please Enter Valid Address");
                $('.addresserr').delay(3000).fadeOut(); 
            });
            //$(".addresserr").html("Please Enter Valid Address");
            return false;
        }else if(buildingflatno == ''){
            $('.buildingflaterr').fadeIn('slow', function(){
                $(".buildingflaterr").html("Please Enter Valid Building/Flat No.");
                $('.buildingflaterr').delay(3000).fadeOut(); 
            });
            // $(".buildingflaterr").html("Please Enter Valid Building/Flat No.");
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:"<?php echo e(route('savecustomerdetails')); ?>",
                // dataType: 'json',
                data:{"_token": "<?php echo e(csrf_token()); ?>",mobile:mobile,name:name,email:email,gstno:gstno,panno:panno,address:address,buildingflatno:buildingflatno,deliverycontact:deliverycontact,landmark:landmark},
                success:function(data){
                    console.log(data);
                    // if(data.datadelivery != ''){
                    //     window.location.reload();
                    // }
                    
                }
            });
        }
        
    });
    
    // let id=1;
    // function plus()
    // {
    //   $("#remove"+id).show();
    //   id++;
    //   console.log(id)
    // }

    // function remove_addon(id)
    // {
    //     $("#remove"+id).remove();
    // }
</script>   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/delivery/deliveryorder.blade.php ENDPATH**/ ?>