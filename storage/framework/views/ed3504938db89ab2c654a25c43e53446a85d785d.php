<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <title><?php echo e(getSettings('site_page_title')); ?></title>
        <link rel="icon" href="<?php echo e(url('public/images/hotel.png')); ?>" sizes="16x16" type="image/png">
        <link href="<?php echo e(URL::asset('public/assets/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/sweetalert2-7.0.0/sweetalert2.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/select2/dist/css/select2.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/nprogress/nprogress.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/iCheck/skins/flat/green.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/bootstrap-datetimepicker/css/datetimepicker.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/bootstrap-datepicker/css/datepicker.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/summernote-0.8.8/dist/summernote-bs4.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/assets/custom.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/css/style_backend.css')); ?>" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.14/css/bootstrap-multiselect.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet"/>
    
        <style>
            /*.nav-md .container.body .right_col{*/
                /*min-height: auto !important;*/
            /*}*/
            .bootstrap-tagsinput .tag:after {
                display: none;
            }
            .mydropmenu{
                min-width: 200px;
                padding: 10px;
            }
            .pricenewdesign{
                font-size:14px;
            }
            .row.cart-detail {
                margin-bottom: 5px;
                /*border: 1px solid;*/
                background: whitesmoke;
            }
            
        @media  only screen and (max-width: 600px) {
            .mycartposition{
                position: fixed;
                top: 2%;
                z-index: 1;
            }
            .backcolmob{
                background-color:#dbbd54 !important;
                /*linear-gradient(#99FF33,#FF9966)*/
                /*#f0ad4e*/
            }
            .w3mainnew{
                position: absolute;
                right: 0;
            }
            .vegsideselect{
                background: green;
                color: white;
                font-size: 16px;
                font-weight: 500;
            }
            .nonvegsideselect{
                background: red;
                color: white;
                font-size: 16px;
                font-weight: 500;
            }
            .w3-tealje{
                background-color: #5bc0de;
                color: white;
            }
            #w3_open{
                font-size: 16px !important;
            }
        }
            
        </style>

        <?php echo $__env->yieldContent('css'); ?>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>   -->
        <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />-->
        
        <script type="text/javascript" src="<?php echo e(URL::asset('public/assets/jquery/jquery.min.js')); ?>"></script>
        <script>
            var base_url="<?php echo e(url('/').'/'); ?>";
            var csrf_token="<?php echo e(csrf_token()); ?>";
            var currency_symbol="<?php echo e(getCurrencySymbol()); ?>";
            var current_segment = "";
        </script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script type="text/javascript" src="<?php echo e(URL::asset('public/js/init.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(URL::asset('public/js/jquery.validate.min.js')); ?>"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href=" https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo e(URL::asset('public/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')); ?>"></script>
        <!-- <script type="text/javascript" src="<?php echo e(URL::asset('public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script> -->
        <script type="text/javascript" src="<?php echo e(URL::asset('public/assets/jqueryvalidation/jqueryvalidation.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(URL::asset('public/assets/moment/min/moment.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(URL::asset('public/assets/select2/dist/js/select2.full.min.js')); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <link href="<?php echo e(URL::asset('public/assets/ekko-lightbox/ekko-lightbox.css')); ?>" rel="stylesheet">
        <script src="<?php echo e(URL::asset('public/assets/ekko-lightbox/ekko-lightbox.js')); ?>"></script>
    </head>
    
    <body class="nav-md">
        
        <div class="container body">
            <div class="main_container">
                <!--<div class="row">-->
                    <!--<div class="col-12 col-md-12 col-lg-12">-->
                        <div class="right_col backcolmob" role="main" style="margin-left:0px;">
                            <?php echo $__env->yieldContent('rightColContent'); ?>
                            <div class="clearfix">
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-10 main-section mycartposition">
                                        <div class="dropdown" id="count">
                                            <button type="button" class="btn btn-info" data-toggle="dropdown">
                                                <!--<i class="fas fa-soup"></i>-->
                                                <i class="fa fa-cutlery" aria-hidden="true"></i> Your Order <span class="badge badge-pill badge-danger"><?php echo e(count((array) session('cart'))); ?></span>
                                            </button>
                                            <div class="dropdown-menu mydropmenu">
                                                <div class="row total-header-section">
                                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger"><?php echo e(count((array) session('cart'))); ?></span>
                                                    </div>
                                                    <?php $total = 0 ?>
                                                    <?php $__currentLoopData = (array) session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $total += $details['price'] * $details['quantity'] ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-lg-6 col-sm-6 col-xs-6 total-section text-right">
                                                        <p>Total: <span class="text-info">$ <?php echo e($total); ?></span></p>
                                                    </div>
                                                </div>
                                                <?php if(session('cart')): ?>
                                                    <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="row cart-detail">
                                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 cart-detail-img">
                                                                <img src="/storage/app/public/productjack/<?php echo e($details['image']); ?>" width="50" class="img-fluid" />
                                                            </div>
                                                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 cart-detail-product">
                                                                <p><?php echo e($details['name']); ?></p>
                                                                <span class="price text-info pricenewdesign"> ₹<?php echo e($details['price']); ?></span> <span class="count"> Quantity:<?php echo e($details['quantity']); ?></span>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 text-center checkout">
                                                        <a href="<?php echo e(route('cart')); ?>" class="btn btn-success btn-block">View Your Food Items</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-right" style="width:200px;right:0;" id="mySidebar">-->
                                    <!--    <button class="w3-bar-item w3-button w3-large w3-hide-large" id="w3_close" onclick="w3_close()">Close &times;</button>-->
                                    <!--    <a class="w3-bar-item w3-button vegsideselect vegornot" data-val="veg" id="vegselect">VEG</a>-->
                                    <!--    <a class="w3-bar-item w3-button nonvegsideselect vegornot" data-val="nonveg" id="nonvegselect">NON VEG</a>-->
                                    <!--</div>-->
                                    <!--<div class="w3-main w3mainnew" style="margin-right:200px">-->
                                    <!--    <div class="w3-tealje">-->
                                    <!--        <button class="w3-button w3-xlarge w3-right w3-hide-large" id="w3_open" onclick="w3_open()">&#9776;</button>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                </div>
                            </div>
    
                            <?php echo $__env->make('layouts.flash_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->yieldContent('content'); ?>
                        </div>
                        <!--<footer style="margin-left:0px;">-->
                        <!--    <div class="pull-right">-->
                        <!--        <span>-->
                        <!--            © <?php echo e(date('Y')); ?>-->
                        <!--            <a>-->
                        <!--                <?php echo e(getSettings('hotel_name')); ?>-->
                        <!--            </a>-->
                        <!--            . <?php echo e(lang_trans('txt_rights_res')); ?>.-->
                        <!--        </span>-->
                        <!--    </div>-->
                        <!--    <div class="clearfix">-->
                        <!--    </div>-->
                        <!--</footer>-->
                    <!--</div>-->
                <!--</div>-->
                
            </div>
        </div>
        
        

        <script src="<?php echo e(URL::asset('public/assets/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/assets/fastclick/lib/fastclick.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/assets/nprogress/nprogress.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/assets/DateJS/build/date.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/assets/iCheck/icheck.min.js')); ?>"></script>

        <script src="<?php echo e(URL::asset('public/assets/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/assets/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/assets/sweetalert2-7.0.0/sweetalert2.all.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/assets/summernote-0.8.8/dist/summernote-bs4.min.js')); ?>"></script>
        <?php echo $__env->yieldContent('jquery'); ?>
        <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo e(URL::asset('public/assets/js/custom.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/js/custom.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public/js/ajax_call.js')); ?>"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.14/js/bootstrap-multiselect.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
        <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
        <script>
            $('select[multiple]').multiselect();
        </script>
        <script>
            $(document).ready(function(){
                $(".alert-success").delay(5000).slideUp(300);
            });
            
            function w3_open() {
                document.getElementById("mySidebar").style.display = "block";
            }
            function w3_close() {
                document.getElementById("mySidebar").style.display = "none";
            }
        </script>
        
        <script>
            
        </script>
        <?php echo $__env->make('popper::assets', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html>
<?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/layouts/master_backend_order.blade.php ENDPATH**/ ?>