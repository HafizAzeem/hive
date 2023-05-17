<table>
   <tr>
       <th>Invoice Number</th>
       <th>Room</th>
       <th>Name</th>
       <th>Checkin</th>
       <th>Checkout</th>
       <th>Booking ID</th>
       <th>OTA Booking id</th>
       <th>Booking Type</th>
       <th>OTA Type</th>
       <th>Serial No</th>
       <th>Mobile</th>
       <th>Adult</th>
       <th>Hotel Name</th>
       <th>Room Price</th>
       <th>Nights</th>
       <th>CGST</th>
        <th>SGST</th>
        <th>Total</th>
        
        <?php 
        $th=DB::select(DB::raw("select*from payment_mode"));
        foreach($th as $v)
        {
            echo "<th>".$v->payment_mode."</th>";
        }
        ?>
        <th>Remark</th>
        <th>Company Gst No.</th>
       
      
   </tr>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     
     <tr>
         <td><?php echo e($v->invoice_num); ?></td>
         <td><?php echo e($v->room_num); ?></td>
         <td><?php echo e($v->name); ?></td>
         <td><?php echo e($v->check_in); ?></td>
         <td><?php echo e($v->check_out); ?></td>
         <td><?php echo e($v->Booking_id); ?></td>
         <td><?php echo e($v->unique_id); ?></td>
         <td><?php echo e($v->referred_by_name); ?></td>
         <td><?php echo e($v->referred_by); ?></td>
         <td><?php echo e($v->mid); ?></td>
         <td><?php echo e($v->mobile); ?></td>
         <th><?php echo e($v->adult); ?></th>
         <th><?php echo e($title); ?></th>
         <th><?php echo e($v->per_room_price); ?></th>
         <th><?php echo e($v->duration_of_stay); ?></th>
         <th><?php 
          
          $total=DB::select(DB::raw("select sum(payment) as total from payment_history where payment!='' and reservations_id='$v->id' and payment_date between '$start' and '$end'"));
          $final=$total[0]->total;
          if($final >= 0 && $final <= 1000)
          {
              $cgst=0;
              $sgst=0;
          }else if($final >= 1001 && $final <= 7500)
          {
              $cgst=round($final*6/100);
              $sgst=round($final*6/100);
          }else if($final >= 7501)
          {
              $cgst=round($final*9/100);
              $sgst=round($final*9/100);
          }
             echo $cgst;
          ?>
           </th>
           <th><?php echo $sgst; ?></th>
           <th><?php echo $final; ?></th>
         <?php
          foreach($th as $v1)
          {
              $t=DB::select(DB::raw("select sum(payment) as total from payment_history where payment!='' and mode='$v1->id' and reservations_id='$v->id' and payment_date between '$start' and '$end'"));
              echo "<th>".$t[0]->total."</th>";
          }
         ?>
         <th><?php
           if(strpos($v->p_remark,'Early Check In'))
           {
               echo $t[0]->total.' '.$v->p_remark;
           }
         ?></th>
         <td><?php echo e($v->company_gst_num); ?></td>
     </tr> 
   
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
</table>

<table>
    <tr>
        <th><b>Total Payment</b></th>
        <th><b>Expenses</b></th>
        <th><b>Revenue</b></th>
        <th><b>Remark</b></th>
        <th><b>Title</b></th>
    </tr>
    
    <?php
        $extrarevenue= DB::select(DB::raw("select * from payment_history where extra_revenue ='er' and payment_date between '$start' and '$end'"));
        foreach($extrarevenue as $vw)
        {
            echo "<tr><td>".$vw->payment."</td>";
            //print_r($vw->payment);
            $exrevexp = DB::select(DB::raw("SELECT sum(payment) as extra_payment_expense FROM payment_history where reservations_id = '$vw->reservations_id' and extra_revenue = 'break' and payment_date between '$start' and '$end'"));
            echo "<td>".$exrevexp[0]->extra_payment_expense."</td>";
            $tot = $vw->payment - $exrevexp[0]->extra_payment_expense;
            echo "<td>".$tot."</td>";
            echo "<td>".$vw->remark."</td>";
            echo "<td>".$vw->title."</td></tr>";
        }
    ?>
</table><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/excel_view/excelReport.blade.php ENDPATH**/ ?>