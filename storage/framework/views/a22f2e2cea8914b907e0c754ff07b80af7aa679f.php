
   
<?php $__env->startSection('content'); ?>
<style>
    .price {
        font-size: 20px;
        font-weight: 400;
        color: #26B99A;
        margin: 0;
    }
    .prodnamecss{
        text-transform: capitalize;
    }
    /*.mtsopt{*/
    /*    margin-top: 20%;*/
    /*}*/
    
    .radio-toolbar {
        margin: 10px;
        display: flex;
        justify-content: space-evenly;
    }
    
    .radio-toolbar input[type="radio"] {
        opacity: 0;
        position: fixed;
        width: 0;
    }
    
    .radio-toolbar label {
        display: inline-block;
        background-color: #ddd;
        padding: 5px 15px;
        font-family: sans-serif, Arial;
        font-size: 16px;
        border: 2px solid #444;
        border-radius: 4px;
    }
    
    .radio-toolbar label:hover {
        background-color: #dfd;
    }
    
    .radio-toolbar input[type="radio"]:focus + label {
        border: 2px dashed #444;
    }
    
    .radio-toolbar input[type="radio"]:checked + label {
        background-color: #bfb;
        border-color: #4c4;
    }

@media  only screen and (max-width: 600px) {
    .roomnocssdesign{
        float:right;
        margin-right: 20%;
    }
    .thumbnail{
        height:auto;
        margin-bottom: 4%;
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
    .maincatcss{
        margin-top: 15%;
        text-align: center;
        color: green;
        text-transform: capitalize;
        font-weight: 600;
        font-family: cursive;
    }
    .prodnamecss{
        text-transform: capitalize;
    }
    /*.mtsopt{*/
    /*    margin-top: 20%;*/
    /*}*/
    .radio-toolbar {
        margin-top: 10%;
        display: flex;
        justify-content: space-between;
    }
    .moddilogmt{
        margin-top: 40%;
    }
}
    
</style>
<?php 
$roomno = request()->route('id');
    session()->put('roomno', $roomno);
    //Your Order (90 plus taxes)
?>
<h4 class="roomnocssdesign">Room <?php echo e(request()->route('id')); ?></h4>
<h3 id="meassagnew1" class="meassagnew1 text-success" style="display:none;"> </h3>
<!--<div class="container">-->
   
    <!--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mtsopt">-->
    <!--    <label>Select Category</label>-->
    <!--    <select class="form-control" name="zonefilter" id="multjczone">-->
    <!--        <option value="all">All</option>-->
    <!--        <option value="green">VEG</option>-->
    <!--        <option value="red">NON-VEG</option>-->
    <!--    </select>-->
    <!--</div>-->
    
    
    
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="radio-toolbar">
            <input type="radio" id="all" name="opt" value="all" class="multjczone" checked>
            <label for="all">All</label><br>
            <input type="radio" id="green" name="opt" value="green" class="multjczone">
            <label for="green">VEG</label><br>
            <input type="radio" id="red" name="opt" value="red" class="multjczone">
            <label for="red">NON-VEG</label>
        </div>
        <p>&nbsp;</p>
        
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <div class="row">
                <h3 class="maincatcss"><?php echo e($product->name); ?></h3>
                <?php $__currentLoopData = $product['food_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                
                                <?php if($product->category == 'veg'): ?> 
                                    <?php $vegornotcls = "mygreen"; ?>
                                <?php elseif($product->category == 'nonveg'): ?>
                                    <?php $vegornotcls = "myred"; ?>
                                <?php else: ?>
                                    <?php $vegornotcls = "mywhite"; ?>
                                <?php endif; ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 <?php echo $vegornotcls ?>">
                    <div class="thumbnail">
                        <!--<img src="/storage/app/public/productjack/" alt="" class="img-fluid" width="80">-->
                        <div class="caption">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6" style="height: 60px">
                                    <img src="/storage/app/public/productjack/<?php echo e($product->food_image); ?>" alt="" class="img-fluid" width="55" height="55">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <h5 class="prodnamecss"><?php echo e($product->name); ?></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <?php if($product->strikethrough > 0): ?>
                                        <p style="text-decoration: line-through;"><strong>Before Price: </strong> <?php echo e($product->strikethrough); ?></p>
                                    <?php else: ?>
                                        <p style="text-decoration: line-through;"><strong>Before Price: </strong> <?php echo e($product->price); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <p><strong>Price: </strong> <?php echo e($product->price); ?></p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <p><?php echo e($product->description); ?></p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 officeName">
                                    <input type="hidden" id="addtocartn" class="form-control addtocartn" value="<?php echo e($product->id); ?>">
                                    <p class="btn-holder"><a class="btn btn-warning btn-block text-center addtocart" role="button" data-val="<?php echo e($product->id); ?>">Add to cart</a> </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                   <?php if($product->category == 'veg'): ?> 
                                    <img src="/storage/app/public/productjack/vegicon.png" alt="" class="img-fluid" width="20">
                                   <?php elseif($product->category == 'nonveg'): ?>
                                    <img src="/storage/app/public/productjack/nonveg.jpg" alt="" class="img-fluid" width="20">
                                   <?php else: ?>
                                    <p>egg</p>
                                    <img src="/storage/app/public/productjack/nonveg.jpg" alt="" class="img-fluid" width="20">
                                   <?php endif; ?>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <!-- Trigger the modal with a button -->
                                    <!--<button >Open Modal</button>-->
                                    <a data-toggle="modal" data-target="#myModal<?php echo e($key); ?>"><i class="fa fa-eye" style="font-size:20px"></i></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal<?php echo e($key); ?>" role="dialog">
                                        <div class="modal-dialog moddilogmt">
                                        
                                          <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Nutrition Values</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Energy  : <?php echo e($product->energy); ?></p>
                                                    <p>Protein : <?php echo e($product->protein); ?></p>
                                                    <p>Fat     : <?php echo e($product->fat); ?></p>
                                                    <p>Carbs   : <?php echo e($product->carb); ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
    </div>
<!--</div>    -->
<?php echo $__env->yieldContent('js'); ?>
<script>
    $(".addtocart").click(function (e) {
        e.preventDefault();
        var final1 = $(this).attr('data-val');
        if(final != ""){
            var final = final1;
        }else{
            var final = 0;
        }
        $.ajax({
            type:'GET',
            url:'add-to-cart'+'/'+final,
            success:function(data){
               $("#count").load(location.href + " #count");
                $('.meassagnew1').fadeIn('slow', function(){
                    $(".meassagnew1").css("display", "block");
                    $(".meassagnew1").html("Food Added Successfully");
                    $('.meassagnew1').delay(3000).fadeOut(); 
                });
            }
        });
    });
    


    $(document).on('change','input[name=opt]',function(){
       // var color1 = $(".multjczone").val();
        var color1 = $( 'input[name=opt]:checked' ).val();
        if(color1 =='red'){
            $(".mywhite").hide();
            $(".mygreen").hide();
            $(".myred").show();
        }
        // else if(color1 =='white'){
        //     $(".myred").hide();
        //     $(".mygreen").hide();
        //     $(".mywhite").show();
        // }
        else if(color1 =='green'){
            $(".myred").hide();
            $(".mywhite").hide();
            $(".mygreen").show();
        }else{
            $(".myred").show();
            $(".mywhite").show();
            $(".mygreen").show();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend_order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/products.blade.php ENDPATH**/ ?>