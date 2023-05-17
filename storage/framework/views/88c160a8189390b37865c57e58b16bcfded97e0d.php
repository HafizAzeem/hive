

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
                                <label> Range</label>
                                <select name="range" id="range" class="form-control custom-select">
                                    <option value="" selected>-- Select Range --</option>
                                    <option value="1">Yesterday</option>
                                    <option value="2">This Week</option>
                                    <option value="3">Last Month</option>
                                    <option value="4">Month Till Now</option>
                                    <option value="5">Month Till Yesterday</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                               <label> Date</label>
                               <input type="date" class="form-control" value="<?php echo e($start ?? ''); ?>" required name="start" id="start">
                            </div>
                            <div class="col-md-3">
                               <label>End Date</label>
                               <input type="date" class="form-control" value="<?php echo e($end ?? ''); ?>" required name="end" id="end">
                            </div>
                            <div class="col-md-3"><button class="btn btn-info"style="margin-top:25px;">Search</button></div>
                        </div>
                    </form>
                </div> 
                <div class="row">
                <?php if(isset($start) && isset($end))
                {
                    
                    // if(($start <= $now) && ($end == $now) ){
                    //     $arrivalcustomerids = DB::select(DB::raw("select customer_id from arrivals where referred_by_name = 'F9' and date(check_in) >= '$now' "));
                    //     //print_r($arrivalcustomerids);
                    //     foreach($arrivalcustomerids as $rci){
                    //         $reservecustomerids = DB::select(DB::raw("select customer_id from reservations where customer_id = '$rci->customer_id' and date(check_in) >= '$now'"));
                    //         if(!empty($reservecustomerids)){
                    //             foreach($reservecustomerids as $aci){
                    //               if(!empty($aci)){
                    //                     $acitp = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and customer_id != '$aci->customer_id' and date(check_in) >= '$now'"));
                    //                     //print_r($acitpif);
                    //                     //print_r('hello if');
                    //               }else{
                    //                     $acitp = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and customer_id != '$aci->customer_id' date(check_in) >= '$now'"));
                    //                     //print_r($acitpelse);
                    //                     //print_r('hello');
                    //                 }
                    //             } 
                    //         }else{
                    //             $acitpmain = DB::select(DB::raw("select sum(advance) as tp from arrivals where referred_by_name = 'F9' and date(check_in) >= '$now'"));
                    //             //print_r($acitpmain);
                    //             //print_r('main');
                    //         }
                    //     }
                    //     $acitpmain = $acitpmain[0]->tp ?? 0;
                    //     $acitp = $acitp[0]->tp ?? 0;
                    //     if($acitp == '0'){
                    //         $acitpfinal = $acitpmain;
                    //         //print_r($acitpfinal);
                    //     }else if($acitpmain == '0'){
                    //         $acitpfinal = $acitp;
                    //     }else{
                    //         $acitpfinalone = $acitpmain - $acitp;
                    //         $acitpfinal = $acitpmain - $acitpfinalone;
                    //     }
                    // }else{
                    //     $acitpfinal = 0;
                    // }    
                
                    
                // $revenue = DB::select(DB::raw("select sum(payment) as total from payment_history where reservations_id != '0' and payment != '' and date(payment_date) between '$start' and '$end'"));
                // print_r($revenue);
                $revenue=DB::select(DB::raw("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end'"));
                $data1= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'er' and date(payment_date) between '$start' and '$end' "));
                $data2= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'break' and date(payment_date) between '$start' and '$end' "));
                $advance_pay=DB::select("select sum(advance) as total_advance from arrivals where referred_by_name = 'F9' and date(created_at) between '$start' and '$end'");
                                
                //print_r($data1new[0]->total) ;
                // print_r($data1);
                $datanew = $data1[0]->total + $revenue[0]->total - $data2[0]->total + $advance_pay[0]->total_advance;
                $datanew = $datanew ?? 0;
               ?>
            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_title" style="color:Green;font-weight:bolder;">Total Revenue &nbsp;
                    <a href="<?php echo e(url('admin/exportExcel/'.$start.'/'.$end)); ?>" style="color:black;">(Download)</a>
                    </div>
                    <div class="x_content" style="padding:20px;text-align:center">
                        Rs <?php echo e($datanew); ?>

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
                    $expenses=DB::select(DB::raw("select sum(amount) as total from expenses where  DATE(datetime) between '$start' and '$end'"));
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
                    // $data=DB::select(DB::raw("select sum(payment) as total from payment_history where reservations_id != '0' and payment != '' and mode = '$p->id' and date(payment_date) between '$start' and '$end' "));
            
                    $data=DB::select(DB::raw("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end' and payment_history.mode='$p->id'"));
                    $data1new= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'er' and date(payment_date) between '$start' and '$end' and payment_history.mode='$p->id'"));
                    $data2new= DB::select(DB::raw("SELECT sum(payment) as total FROM payment_history where extra_revenue = 'break' and date(payment_date) between '$start' and '$end' and payment_history.mode='$p->id'"));
                    $advance_pay=DB::select("select sum(advance) as total_advance from arrivals where referred_by_name ='F9' and payment_mode='$p->id' and date(created_at) between '$start' and '$end'");
                                    
                    //print_r($data1new[0]->total + $data[0]->total ) ;
                    $data = $data1new[0]->total + $data[0]->total - $data2new[0]->total + $advance_pay[0]->total_advance;
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
</div>
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
<script>
$("#range option").eq(localStorage.getItem('range')).prop('selected', false);
$(document).ready(function(){
    if (localStorage.getItem('range')) {
        $("#range option").eq(localStorage.getItem('range')).prop('selected', true);
    }
    $(".custom-select").click(function(){
        var status = $(this).val();
        if(status == '1'){
            var yesterday = moment().subtract(1, 'day').format('YYYY-MM-DD');
            $('#start').val(yesterday);
            $('#end').val(yesterday);
            // var optionsText = this.options[this.selectedIndex].text;
            // alert(optionsText);
            localStorage.setItem('range', $('option:selected', this).index());
        }else if(status == '2'){
            var startOfWeek = moment().startOf('week').format('YYYY-MM-DD');
            var endOfWeek   = moment().endOf('week').format('YYYY-MM-DD');
            $('#start').val(startOfWeek);
            $('#end').val(endOfWeek);
            // alert(startOfWeek + endOfWeek);
            localStorage.setItem('range', $('option:selected', this).index());
        }else if(status == '3'){
            var laststartOfMonth = moment().subtract(1,'months').startOf('month').format('YYYY-MM-DD');
            var lastendOfMonth = moment().subtract(1,'months').endOf('month').format('YYYY-MM-DD');
            // var startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
            // var endOfMonth   = moment().endOf('month').format('YYYY-MM-DD');
            $('#start').val(laststartOfMonth);
            $('#end').val(lastendOfMonth);
            // alert(startOfMonth + endOfMonth);
            localStorage.setItem('range', $('option:selected', this).index());
        }else if(status == '4'){
            var startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
            var today = moment().format('YYYY-MM-DD');
            $('#start').val(startOfMonth);
            $('#end').val(today);
            // alert(startOfMonth + today);
            localStorage.setItem('range', $('option:selected', this).index());
        }else if(status == '5'){
            var startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
            var yesterday = moment().subtract(1, 'day').format('YYYY-MM-DD');
            $('#start').val(startOfMonth);
            $('#end').val(yesterday);
            // alert(startOfMonth + yesterday);
            localStorage.setItem('range', $('option:selected', this).index());
        }else{
            $('#start').val('');
            $('#end').val('');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/collaction_report.blade.php ENDPATH**/ ?>