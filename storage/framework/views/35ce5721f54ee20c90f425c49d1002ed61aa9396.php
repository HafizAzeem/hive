<?php 
  $settings = getSettings();
  $totalOrdersAmount = 0;
 
?>
<!DOCTYPE html>
<html lang="en">
     <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title><?php echo e($settings['site_page_title']); ?>: <?php echo e(lang_trans('txt_invoice')); ?></title>
        <link href="<?php echo e(URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(URL::asset('public/css/invoice_style.css')); ?>" rel="stylesheet">
    </head>
    <body>
    <div>
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                <font size="2">
                    <?php echo e($settings['hotel_name']); ?>, <?php echo e($settings['hotel_address']); ?>

                </font>
            </label>
        </div>
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                <font size="2">
                    <?php echo e(lang_trans('txt_ph')); ?>: <?php echo e($settings['hotel_phone']); ?>

                </font>
            </label>
        </div>
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                <font size="2">
                    <?php echo e(lang_trans('txt_website')); ?>: <?php echo e($settings['hotel_website']); ?>

                </font>
            </label>
        </div>
    
        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
            <table border="0" border-style="ridge" class="class-inv-21">
                <tr>
                    <td align="left" width="100px">
                        <div>
                            <?php echo e(lang_trans('txt_gstin')); ?>

                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            <?php echo e($settings['gst_num']); ?>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="100px">
                        <div>
                            <?php echo e(lang_trans('txt_date')); ?>

                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            <?php echo e(date("d M Y h:i A")); ?>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="100px">
                        <div>
                            <?php echo e(lang_trans('txt_bill_to')); ?>

                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="100px">
                        <div>
                            
                        </div>
                    </td>
                    <td class="txt-right" width="150px">
                        <div>
                            
                        </div>
                    </td>
                </tr>
            </table>
            <h5><?php echo e(lang_trans('txt_orderd_items')); ?></h5>
            
            <table border="1" border-style="ridge" style="font-size: 80%">
                <tr>
                    <th class="txt-center" width="165px">
                        <?php echo e(lang_trans('txt_item_name')); ?>

                    </th>
                    <th class="txt-center" width="35px">
                        <?php echo e(lang_trans('txt_unit')); ?>

                    </th>
                    <th class="txt-center" width="45px">
                        <?php echo e(lang_trans('txt_amount')); ?>

                    </th>
                </tr>
              
                   <?php $__currentLoopData = $hotel13; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $totalOrdersAmount = $totalOrdersAmount + ($hotel->item_qty * $hotel->item_price);
                        ?>
                        <tr>
                            <td width="160px">
                                <?php echo e($hotel->item_name); ?>

                            </td>
                            <td class="txt-center" width="35px">
                                <?php echo e($hotel->item_qty); ?>

                            </td>
                            <td class="txt-right" width="50px">
                                <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($hotel->item_qty * $hotel->item_price)); ?>

                            </td>
                        </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th colspan="2" class="txt-right" width="195px">
                            <?php echo e(lang_trans('txt_total')); ?>&nbsp;
                        </th>
                        <th class="txt-right" width="50px">
                            <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalOrdersAmount)); ?>

                        </th>
                    </tr>
               
            </table>
            <h4> <?php echo e(lang_trans('txt_token_num')); ?> : <?php echo e($hotel13[0]->id); ?> </h4>
            <button class="btn btn-sm btn-success no-print" onclick="printSlip()">
                <?php echo e(lang_trans('btn_print')); ?>

            </button>
            <a class="btn btn-sm btn-danger no-print" href="<?php echo e(route('new-dashboard')); ?>" id="back-btn">
                <?php echo e(lang_trans('btn_go_back')); ?>

            </a>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo e(URL::asset('public/js/page_js/page.js')); ?>"></script> 
</body>
</html><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/room_kitchen_invoice.blade.php ENDPATH**/ ?>