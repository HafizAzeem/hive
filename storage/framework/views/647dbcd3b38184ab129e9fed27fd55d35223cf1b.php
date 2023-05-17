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
            
            //print_r($data_row);
            
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
                        <?php if($data_row->payment_done == 1): ?>
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
                    <h3>Room - <?php echo e($data_row->roomnumber); ?></h3>
                    <h3>ORD  #<?php echo e($data_row->order_id); ?></h3>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="">
                    <h3 style="text-align: right;"><?php echo e(dateConvert($data_row->created_at,'d-m-Y')); ?></h3>
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
                        
                        <?php
                       
                            $first = $data_row->name;
                            $pehla1 = explode(",",$first);
                            $pehla = str_replace(',', '', $pehla1);
                            // print_r($pehla);die;
                            // $j1 = str_replace(',', '', $first);
                            
                            $second = $data_row->quantity;
                            $dusra1 = explode(" ",$second);
                            $dusra = str_replace(',', '', $dusra1);
                            
                            $third = $data_row->unitprice;
                            $tisra1 = explode(" ",$third);
                            $tisra = str_replace(',', '', $tisra1);
                            
                            $result = array_map(null, $pehla, $dusra, $tisra);
                        ?>
                        <?php 
                            // $pName = "";
                            $pName = "";
                            $quantity = "";
                            $unitprice = "";
                            $total = "";
                            $totalOrdersAmount = 0;
                            if(!empty($result)){
                            ?>
                                <tr>
                                    <td colspan="5" style="border: none;">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <h4 style="">
                                <?php
                                
                                    for($i=0; $i<count($result); $i++){
                                        $pName .= $result[$i][0]."<br><br>";
                                    }
                                    echo $pName;
                                ?>
                                            </h4>
                                        </div>
                            <?php
                                $itemcountall = count($result);
                                for($i=0; $i<count($result); $i++){
                                    $quantity = $result[$i][1];
                                    $unitprice = $result[$i][2];
                                    $total = ($result[$i][1] * $result[$i][2]);
                                    $totalOrdersAmount += ($result[$i][1] * $result[$i][2]);
                                    // $pName .= $result[$i][0]."(".$result[$i][1]."q * ".$result[$i][2]."p = ".$total.")<br>";
                                    
                                
                        ?>
                        
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <h4 style="text-align: center;"> <?php echo e($unitprice); ?> </h4>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <h4 style="text-align: center;"> <?php echo e($quantity); ?> </h4>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e($total); ?> </h4>
                                </div>
                            
                        <?php
                                }
                                ?> 
                                </td>
                        </tr> 
                                <?php
                                //echo $totalOrdersAmount;
                            }else{
                        ?>
                        <tr>
                            <td colspan="5">
                                <?php echo e(lang_trans('txt_no_orders')); ?>

                            </td>
                        </tr>
                        <?php
                                }
                        ?>
                        
                        
                        <?php
                            $gstPerc = $cgstPerc = $discount = 0;
                            //if($data_row->gst_apply==1){
                                $gstPerc = $settings['food_gst'];
                                $cgstPerc = $settings['food_cgst'];
                            //}
                            //$discount = ($data_row->discount>0) ? $data_row->discount : 0;
                            
                            //$foodAmountGst = numberFormat( $totalOrdersAmount - ($totalOrdersAmount*100/(100+$gstPerc)) );
                            $foodAmountGst = numberFormat($totalOrdersAmount*$gstPerc/100);
                            $foodAmountCGst = numberFormat($totalOrdersAmount*$cgstPerc/100);
                        ?>
                        
                        <tr>
                            <td colspan="5" style="border-top: 1px solid black;">
                                <div class="" style="justify-content: space-between;">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style=""> Subtotal (<?php echo e($itemcountall); ?> items) </h4>
                                        <h4 style=""> CGST (2.5%)</h4>
                                        <h4 style=""> SGST (2.5%)</h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;">  </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <h4 style="text-align: center;"> <?php echo e($itemcountall); ?> </h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                       <h4 style="text-align: right;"class="sa"> <?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalOrdersAmount/(1+(5/100)))); ?> </h4>
                                        <h4 style="text-align: right;"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat(($totalOrdersAmount/(1+(5/100)))*(2.5/100))); ?></h4>
                                        <h4 style="text-align: right;"><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat(($totalOrdersAmount/(1+(5/100)))*(2.5/100))); ?></h4>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <?php if($foodAmountGst>0): ?>
                        
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
                                        <h4 style="text-align: right;"> <?php echo e(getCurrencySymbol()); ?> <?php echo e($totalOrdersAmount); ?> </h4>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div> 
            
        </div>
    </body>
</html><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/online_food_order_final_invoice.blade.php ENDPATH**/ ?>