<!DOCTYPE html>
<html lang="en">
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <script src="https://unpkg.com/axios/dist/axios.min.js"></script>z


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
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title">
                            <a class="site_title" href="#">
                                <i class="fa fa-paw">
                                </i>
                                <span>
                                    <?php echo e(getSettings('site_page_title')); ?>

                                </span>
                            </a>
                        </div>
                        <div class="clearfix">
                        </div>
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img alt="<?php echo e(Auth::user()->name); ?>" class="img-circle profile_img" src="<?php echo e(url('public/images/user_img.png')); ?>">
                                </img>
                            </div>
                            <div class="profile_info">
                                <span>
                                    <?php echo e(lang_trans('txt_welcome')); ?>,
                                </span>
                                <h2>
                                    <?php echo e((Auth::user()) ? Auth::user()->name : ''); ?>

                                </h2>
                            </div>
                            <div class="clearfix">
                            </div>
                        </div>
                        <br/>
                        <?php echo $__env->make('layouts.sidebar_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle">
                                    <i class="fa fa-bars">
                                    </i>
                                </a>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a aria-expanded="false" class="user-profile dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                                        <img alt="" src="<?php echo e(url('public/images/user_img.png')); ?>">
                                          <?php echo e((Auth::user()) ? Auth::user()->name : 'NA'); ?>

                                          <span class=" fa fa-angle-down"></span>
                                        </img>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li>
                                            <a href="<?php echo e(route('profile')); ?>">
                                              <?php echo e(lang_trans('txt_profile')); ?>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('logout')); ?>">
                                              <i class="fa fa-sign-out pull-right"></i>
                                              <?php echo e(lang_trans('txt_logout')); ?>

                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="right_col" role="main">
                    <?php echo $__env->yieldContent('rightColContent'); ?>
                    <div class="clearfix">
                    </div>
                    <?php echo $__env->make('layouts.flash_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php echo $__env->yieldContent('content'); ?>
                </div>
                <footer>
                    <div class="pull-right">
                        <span>
                            © <?php echo e(date('Y')); ?>

                            <a>
                                <?php echo e(getSettings('hotel_name')); ?>

                            </a>
                            . <?php echo e(lang_trans('txt_rights_res')); ?>.
                        </span>
                    </div>
                    <div class="clearfix">
                    </div>
                </footer>
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
            <script>
                $('select[multiple]').multiselect();
                </script>
          <?php echo $__env->make('popper::assets', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html>
<?php /**PATH /home/passerine/public_html/58.dsrhotelgroup.com/58/resources/views/layouts/master_backend.blade.php ENDPATH**/ ?>