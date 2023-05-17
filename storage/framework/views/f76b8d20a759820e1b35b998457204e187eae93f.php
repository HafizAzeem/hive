<!DOCTYPE html>
<html lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo e(getSettings('site_page_title')); ?></title>
      <link rel="icon" href="<?php echo e(url('public/images/hotel.png')); ?>" sizes="16x16" type="image/png">
      <link href="<?php echo e(URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(URL::asset('public/assets/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(URL::asset('public/assets/custom.min.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(URL::asset('public/css/style_backend.css')); ?>" rel="stylesheet">
    </head>
    <body class="login">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php echo e(Form::open(array('url'=>route('do-login'),'id'=>"login-form"))); ?>

                        <h1>
                            <?php echo e(lang_trans('heading_login')); ?>

                        </h1>
                        <div>
                            <input class="form-control" name="username" placeholder="Username" required="required" type="text" value=""/>
                        </div>
                        <div>
                            <input class="form-control" name="password" placeholder="Password" required="required" type="password" value=""/>

                        </div>
                        <div>
                            <button class="btn btn-default submit" type="submit">
                                <?php echo e(lang_trans('btn_login')); ?>

                            </button>
                        </div>
                        <div class="clearfix">
                        </div>
                        <div class="separator">
                            <div class="clearfix">
                            </div>
                            <br/>
                            <div>
                                <h1>
                                    <i class="fa fa-paw">
                                    </i>
                                    <?php echo e(getSettings('hotel_name')); ?>

                                </h1>
                                <p>
                                    ©<?php echo e(date('Y')); ?> <?php echo e(lang_trans('txt_rights_res')); ?>.
                                </p>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </section>
                </div>
            </div>
        </div>
        
    </body>
</html>
<?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/login.blade.php ENDPATH**/ ?>