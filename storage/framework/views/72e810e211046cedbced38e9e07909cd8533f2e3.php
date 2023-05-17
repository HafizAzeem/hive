
<?php $__env->startSection('content'); ?>
<div class="">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Collection Report</h2>
                    <div class="clearfix"></div>
                </div>
                   <div class="x_content">
                    <form method="post" action="<?php echo e(route('collection_report_action')); ?>">
                         <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-3">
                           
                           <label> Date</label>
                           <input type="date" class="form-control" value="<?php echo e($start ?? ''); ?>" required name="start">
                        </div>
                         <div class="col-md-3">
                           
                           <label>End Date</label>
                           <input type="date" class="form-control" value="<?php echo e($end ?? ''); ?>" required name="end">
                        </div>
                        <div class="col-md-3"><button class="btn btn-info"style="margin-top:25px;">Search</button></div>
                    </div>
                    </form>
                   </div> 
             <div class="row">
                <?php if(isset($start) && isset($end))
                {
                    // if($start > $now ){
                    //     $arrivalcustomerids = DB::select(DB::raw("select customer_id from arrivals where referred_by_name = 'F9' and date(check_in) between '$start' and '$end'"));
                    //     //print_r($arrivalcustomerids);
                    //     foreach($arrivalcustomerids as $rci){
                    //         $reservecustomerids = DB::select(DB::raw("select customer_id from reservations where customer_id = '$rci->customer_id' and date(check_in) between '$start' and '$end'"));
                    //         if(!empty($reservecustomerids)){
                    //             foreach($reservecustomerids as $aci){
                    //               if(!empty($aci)){
                    //                     $acitp = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and customer_id != '$aci->customer_id' and date(check_in) between '$start' and '$end'"));
                    //                     //print_r($acitpif);
                    //                     //print_r('hello if');
                    //               }else{
                    //                     $acitp = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and customer_id != '$aci->customer_id' date(check_in) between '$start' and '$end'"));
                    //                     //print_r($acitpelse);
                    //                     //print_r('hello');
                    //                 }
                    //             } 
                    //         }else{
                    //             $acitpmain = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and date(check_in) between '$start' and '$end'"));
                    //           // print_r($acitpmain);
                    //           // print_r('main');
                    //         }
                    //     }
                    //     $acitpmain = $acitpmain[0]->tp ?? 0;
                    //     $acitp = $acitp[0]->tp ?? 0;
                    //     if($acitp == '0'){
                    //         $acitpfinal = $acitpmain;
                    //     }else if($acitpmain == '0'){
                    //         $acitpfinal = $acitp;
                    //     }else{
                    //         $acitpfinalone = $acitpmain - $acitp;
                    //         $acitpfinal = $acitpmain - $acitpfinalone;
                    //     }
                    // }
                    
                    if(($start <= $now) && ($end == $now) ){
                        $arrivalcustomerids = DB::select(DB::raw("select customer_id from arrivals where referred_by_name = 'F9' and date(check_in) >= '$now' "));
                        //print_r($arrivalcustomerids);
                        foreach($arrivalcustomerids as $rci){
                            $reservecustomerids = DB::select(DB::raw("select customer_id from reservations where customer_id = '$rci->customer_id' and date(check_in) >= '$now'"));
                            if(!empty($reservecustomerids)){
                                foreach($reservecustomerids as $aci){
                                   if(!empty($aci)){
                                        $acitp = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and customer_id != '$aci->customer_id' and date(check_in) >= '$now'"));
                                        //print_r($acitpif);
                                        //print_r('hello if');
                                   }else{
                                        $acitp = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and customer_id != '$aci->customer_id' date(check_in) >= '$now'"));
                                        //print_r($acitpelse);
                                        //print_r('hello');
                                    }
                                } 
                            }else{
                                $acitpmain = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and date(check_in) >= '$now'"));
                                //print_r($acitpmain);
                                //print_r('main');
                            }
                        }
                        $acitpmain = $acitpmain[0]->tp ?? 0;
                        $acitp = $acitp[0]->tp ?? 0;
                        if($acitp == '0'){
                            $acitpfinal = $acitpmain;
                            //print_r($acitpfinal);
                        }else if($acitpmain == '0'){
                            $acitpfinal = $acitp;
                        }else{
                            $acitpfinalone = $acitpmain - $acitp;
                            $acitpfinal = $acitpmain - $acitpfinalone;
                        }
                    }else{
                        $acitpfinal = 0;
                    }    
                
                    
                //  $revenue=DB::select(DB::raw("select sum(payment) as total from payment_history where payment!='' and payment_date='$start'"));
                $revenue=DB::select(DB::raw("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end'"));
                $data1= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'er' and date(payment_date) between '$start' and '$end' "));
                $data2= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'break' and date(payment_date) between '$start' and '$end' "));
                //print_r($data1new[0]->total) ;
                $datanew = $data1[0]->total + $revenue[0]->total - $data2[0]->total;
                $datanew = $datanew ?? 0;
                //print_r($datanew);
               ?>
            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_title" style="color:Green;font-weight:bolder;">Total Revenue &nbsp;
                    <a href="<?php echo e(url('admin/exportExcel/'.$start.'/'.$end)); ?>" style="color:black;">(Download)</a>
                    </div>
                    <div class="x_content" style="padding:20px;text-align:center">
                        Rs <?php echo e($datanew + $acitpfinal); ?>

                    </div>
                   
                </div>
            </div>
               <?php
                }
                
             ?>
             
            <?php 
                // if(isset($start) && isset($end))
                // {
            ?>
                <!--<div class="col-md-3">-->
                <!--    <div class="x_panel">-->
                <!--        <div class="x_title" style="color:Green;font-weight:bolder;">Advance Revenue &nbsp;</div>-->
                <!--        <div class="x_content" style="padding:20px;text-align:center">-->
                <!--            Rs -->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            <?php
                // }
            ?>
             
              <?php if(isset($start))
                {
               $expenses=DB::select(DB::raw("select sum(amount) as total from expenses where  DATE(created_at) between '$start' and '$end'"));
               ?>
                <div class="col-md-3">
            <div class="x_panel">
                <div class="x_title" style="color:red;font-weight:bolder;">Total Expenses</div>
                <div class="x_content" style="padding:20px;text-align:center">
                 Rs <?php echo e($expenses[0]->total ?? 0); ?>

                </div>
                </div>
            </div>
               <?php
                }
                
             ?>
                <?php
                     $payment=$payment ?? array();
                     foreach($payment as $p)
                     {
            // $data=DB::select(DB::raw("select sum(payment) as total from payment_history where payment!='' and mode='$p->id' and payment_date='$start'"));
            
            $data=DB::select(DB::raw("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end' and payment_history.mode='$p->id'"));
            
            $data1new= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'er' and date(payment_date) between '$start' and '$end' and payment_history.mode='$p->id'"));
            $data2new= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'break' and date(payment_date) between '$start' and '$end' and payment_history.mode='$p->id'"));
            //print_r($data1new[0]->total + $data[0]->total ) ;
            $data = $data1new[0]->total + $data[0]->total - $data2new[0]->total;
            //print_r($data);
                    ?>
        <div class="col-md-3">
            <div class="x_panel">
                <div class="x_title" style="color:blue;font-weight:bolder;"> <?php echo e(ucfirst($p->payment_mode)); ?></div>
                <div class="x_content" style="padding:20px;text-align:center">
                 Rs <?php echo e($data ?? 0); ?>

                </div>
                </div>
            </div>
             <?php  } ?>
             
             
              
              <?php if(isset($start))
                {
               $checkin=DB::select(DB::raw("select count(id) as total from reservations where  DATE(check_in) between '$start' and '$end'"));
               ?>
                <div class="col-md-3">
            <div class="x_panel">
                <div class="x_title" style="color:grenn;font-weight:bolder;">Total Checkin</div>
                <div class="x_content" style="padding:20px;text-align:center;font-weight:bolder;">
                  <?php echo e($checkin[0]->total ?? 0); ?>

                </div>
                </div>
            </div>
               <?php
                }
                
             ?>
                        
                    </div>
                    
                   
                
                 
</div>
</div>





</div>
</div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
<script>
    $(document).ready(function() {
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
            
        ]
    } );
} );
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/collaction_report.blade.php ENDPATH**/ ?>