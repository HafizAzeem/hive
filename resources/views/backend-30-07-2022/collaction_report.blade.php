@extends('layouts.master_backend')
@section('content')
<div class="">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Collection Report</h2>
                    <div class="clearfix"></div>
                </div>
                   <div class="x_content">
                    <form method="post" action="{{route('collection_report_action')}}">
                         @csrf
                    <div class="row">
                        <div class="col-md-3">
                           
                           <label> Date</label>
                           <input type="date" class="form-control" required name="start">
                        </div>
                         <div class="col-md-3">
                           
                           <label>End Date</label>
                           <input type="date" class="form-control" required name="end">
                        </div>
                        <div class="col-md-3"><button class="btn btn-info"style="margin-top:25px;">Search</button></div>
                    </div>
                    </form>
                   </div> 
             <div class="row">
                <?php if(isset($start) && isset($end))
                {
             //  $revenue=DB::select(DB::raw("select sum(payment) as total from payment_history where payment!='' and payment_date='$start'"));
             $revenue=DB::select(DB::raw("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end'"))
               ?>
            <div class="col-md-3">
            <div class="x_panel">
                <div class="x_title" style="color:Green;font-weight:bolder;">Total Revenue &nbsp;
                <a href="{{url('admin/exportExcel/'.$start.'/'.$end)}}" style="color:black;">(Download)</a>
                </div>
                <div class="x_content" style="padding:20px;text-align:center">
                 Rs {{$revenue[0]->total ?? 0}}
                 
                  
                </div>
               
                </div>
            </div>
               <?php
                }
                
             ?>
             
              <?php if(isset($start))
                {
               $expenses=DB::select(DB::raw("select sum(amount) as total from expenses where  DATE(created_at) between '$start' and '$end'"));
               ?>
                <div class="col-md-3">
            <div class="x_panel">
                <div class="x_title" style="color:red;font-weight:bolder;">Total Expenses</div>
                <div class="x_content" style="padding:20px;text-align:center">
                 Rs {{$expenses[0]->total ?? 0}}
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
            
            $data=DB::select(DB::raw("SELECT sum(payment_history.payment) as total FROM reservations inner join payment_history on payment_history.reservations_id=reservations.id and payment_history.payment_date between '$start' and '$end' and payment_history.mode='$p->id'"))
              
                    ?>
        <div class="col-md-3">
            <div class="x_panel">
                <div class="x_title" style="color:blue;font-weight:bolder;"> {{ucfirst($p->payment_mode)}}</div>
                <div class="x_content" style="padding:20px;text-align:center">
                 Rs {{$data[0]->total ?? 0}}
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
                  {{$checkin[0]->total ?? 0}}
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
@endsection
@section('jquery')
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
@endsection