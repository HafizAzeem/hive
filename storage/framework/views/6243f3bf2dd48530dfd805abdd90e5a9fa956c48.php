<?php 
  $settings = getSettings();
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
        <style>
            .dsfht{
                position: absolute;
                right: 10%;
                top: 10%;
                z-index: 1;
            }
            .paysta1{
                background: black;
                color: white;
                padding: 6px;
                font-size: 15px;
            } 
            .paid1cls{
                background: green;
                padding: 6px;
                color: white;
                font-size: 15px;
            } 
            .paysta2{
                background: black;
                color: white;
                padding: 6px;
                font-size: 14px;
            } 
            .notpaid2cls{
                background: green;
                padding: 6px;
                color: white;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <?php             
            
            $i = 0;
            $totalOrdersAmount = 0;
            $itemsQty = [];
            $orderedItemsArr = [];
            if($data_row->orders_items){
                foreach($data_row->orders_items as $k=>$val){
                    $jsonData = json_decode($val->json_data);
                    $itemId = $jsonData->item_id;
        
                    if(isset($itemsQty[$itemId])){
                        $itemsQty[$itemId] = $itemsQty[$itemId]+$val->item_qty;
                    } else {
                        $itemsQty[$itemId] = $val->item_qty;
                    }
              
                    $orderedItemsArr[$itemId] = [
                        'item_name'=>$val->item_name,
                        'item_qty'=>$itemsQty[$itemId],
                        'item_price'=>$val->item_price,
                        'amount'=>$itemsQty[$itemId]*$val->item_price,
                        'created_at'=>dateConvert($val->created_at,'d-m-Y'),
                    ];
                }
            }
        ?>
        
        
        <button onClick="printpage()" id="printpagebutton" class="dsfht">Print this page</button>
        <!--<input id="printpagebutton" type="button" value="Print this page"  önclick="printpage()"/>-->
        <script type="text/javascript">
            function printpage() {
                //Get the print button and put it into a variable
                 var printButton = document.getElementById("printpagebutton");
                 printButton.style.visibility = 'hidden';
                //Print the page content
                window.print();
                //Set the print button to 'visible' again 
                //[Delete this line if you want it to stay hidden after printing]
                printButton.style.visibility = 'visible';
            }
        </script>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 class-inv-11">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <strong>
                            <?php echo e(lang_trans('txt_gstin')); ?>: <?php echo e($settings['gst_num']); ?>

                        </strong>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <strong>
                            <?php echo e(lang_trans('txt_ph')); ?> <?php echo e($settings['hotel_phone']); ?>

                        </strong>
                        <br/>
                        <strong>
                            (<?php echo e(lang_trans('txt_mob')); ?>) <?php echo e($settings['hotel_mobile']); ?>

                        </strong>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="class-inv-12">
                        <?php echo e($settings['hotel_name']); ?>

                    </span>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="class-inv-13">
                        <?php echo e($settings['hotel_tagline']); ?>

                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-14">
                        <?php echo e($settings['hotel_address']); ?>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-15">
                        <span>
                            <?php echo e($settings['hotel_website']); ?>

                        </span>
                        |
                        <span>
                            <?php echo e(lang_trans('txt_email')); ?>:-
                        </span>
                        <span>
                            <?php echo e($settings['hotel_email']); ?>

                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="class-inv-15" style="text-align: right;">
                        <?php
                            $isBook = json_decode($data_row);
                            $isbookStatus = $isBook->order_history[0]->is_book;
                        ?>
                        <?php if($isbookStatus == 0): ?>
                        <span class="paysta1">Status:</span>
                        <span class="paid1cls">Paid</span>
                        <?php else: ?>
                        <span class="paysta2">Status:</span>
                        <span class="notpaid2cls">Not Paid</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
           
            
            <div class="row" style="margin-top:20px;border-top:1px solid black;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="">
                    <h3 style="text-align: center;line-height: 15px;margin-bottom: 15px;">Original</h3>
                </div>
            </div>
            <div class="row" style="border-top:1px solid black;border-bottom:1px solid black;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="">
                    <h3 style="text-align: center;line-height: 15px;margin-bottom: 15px;">DUE</h3>
                </div>
            </div>

            <div class="row" style="">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="">
                    <h3>Room - <?php echo e($data_row->table_num); ?></h3>
                    <h3>ORD  #<?php echo e($data_row->id); ?></h3>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="">
                    <h3 style="text-align: right;"><?php echo e(dateConvert($data_row->invoice_date,'d-m-Y')); ?></h3>
                </div>
            </div>
        
            <div class="row" style="display:flex; justify-content: space-between;margin-bottom:-20px;">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="5" style="border-top:1px solid black;border-bottom:1px solid black;">
                                <div class="" style="justify-content: space-between;">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style=""> Item Details </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;"> Rate </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;"> Qty </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: right;"> Amount </h4>
                                    </div>
                                </div>
                            </td>
                        </tr>    
                        <?php $__empty_1 = true; $__currentLoopData = $orderedItemsArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <?php
                            $totalOrdersAmount = $totalOrdersAmount + ($val['item_qty']*$val['item_price']);
                          ?>
                        <tr>
                            <td colspan="5" style="border: none;">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <h4 style=""> <?php echo e($val['item_name']); ?> </h4>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <h4 style="text-align: center;"> <?php echo e($val['item_price']); ?> </h4>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <h4 style="text-align: center;"> <?php echo e($val['item_qty']); ?> </h4>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($val['item_qty']*$val['item_price'])); ?> </h4>
                                </div>
                            </td>
                            <!--<td class="text-center">-->
                            <!--    <?php echo e(++$i); ?>.-->
                            <!--</td>-->
                            <!--<td class="">-->
                            <!--    <?php echo e($val['item_name']); ?>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                            <!--    <?php echo e($val['item_qty']); ?>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                            <!--    <?php echo e($val['item_price']); ?>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                            <!--    <?php echo e($val['item_qty']*$val['item_price']); ?>-->
                            <!--</td>-->
                        </tr> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5">
                                <?php echo e(lang_trans('txt_no_orders')); ?>

                            </td>
                        </tr>
                        <?php endif; ?>
                        
                        <?php
                
                            $gstPerc = $cgstPerc = $discount = 0;
                            if($data_row->gst_apply==1){
                                $gstPerc = $data_row->gst_perc;
                                $cgstPerc = $data_row->cgst_perc;
                            }
                            $discount = ($data_row->discount>0) ? $data_row->discount : 0;
                            $gst = gstCalc($totalOrdersAmount,'food_amount',$gstPerc,$cgstPerc);
                            $foodAmountGst = $gst['gst'];
                            $foodAmountCGst = $gst['cgst'];
                        ?>
                        
                        <tr>
                            <td colspan="5" style="border-top: 1px solid black;">
                                <div class="" style="justify-content: space-between;">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style=""> Subtotal (2 items) </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;">  </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;"> 2 </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalOrdersAmount)); ?> </h4>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php if($foodAmountGst>0): ?>
                        <tr>
                            <td colspan="5" style="border-top: 1px solid black;">
                                <div class="" style="justify-content: space-between;">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="">  <?php echo e(lang_trans('txt_gst')); ?> </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;">  </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;"> <?php echo e($gstPerc); ?> % </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($foodAmountGst)); ?> </h4>
                                    </div>
                                </div>
                            
                        <?php endif; ?>
                        
                        <?php if($foodAmountCGst>0): ?>
                                <!--<td colspan="5" style="border: none;">-->
                                    <div class="" style="justify-content: space-between;">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style=""> <?php echo e(lang_trans('txt_cgst')); ?> </h4>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style="text-align: center;">  </h4>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style="text-align: center;"> <?php echo e($cgstPerc); ?> % </h4>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($foodAmountCGst)); ?> </h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        
                        <?php if($discount>0): ?>
                            <tr>
                                <td colspan="5" style="border: none;">
                                    <div class="" style="justify-content: space-between;">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style=""> <?php echo e(lang_trans('txt_discount')); ?> </h4>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style="text-align: center;">  </h4>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style="text-align: center;"> </h4>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($discount)); ?> </h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
            
                        <?php 
                            $finalFoodAmount = numberFormat($totalOrdersAmount+$foodAmountGst+$foodAmountCGst-$discount);
                        ?>
                        
                        <tr>
                            <td colspan="5" style="border-top: 2px solid black;">
                                <div class="" style="justify-content: space-between;">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style=""> Payble Amount </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;">  </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;"> </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($finalFoodAmount)); ?> </h4>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            
        </div>
    </body>
</html><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/food_order_final_invoice.blade.php ENDPATH**/ ?>