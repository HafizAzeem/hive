@extends('layouts.master_backend')
@section('content')
@php 
$i = $j = 0; 
$totalAmount = 0;
@endphp
<div class="">

  
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Room Inventory</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?php $dtPart2 = date('Y-m-d'); ?>
                    <!-- Sort By : <input type="text" name="sortDate" id="min" placeholder="Date"/> -->
                    <div class="col-md-3 col-xs-3">
                    <label class="control-label"> Sort Date<span class="required">*</span></label>
                     {{Form::date('min', $dtPart2,['class'=>"datePickerDefault ", "id"=>"min", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                    </div>
                    
                    <br/>
                    <br/>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{lang_trans('txt_sno')}}</th>
                        <th>Room Number</th>
                        <th>Status</th>
                        <th>Referred By</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $i=0;?>
                      @foreach($booked_rooms as $books)
                        <tr>
                          <td>{{++$i}}</td>
                          <td> {{$books["room_num"]}} </td>
                          @if($books["status"] == 'Booked')
                            <td><span class="btn btn-xs btn-cust">{{ $books["status"] }}</span></td>
                          @elseif($books["status"] == 'Available')
                            <td><span class="btn btn-xs btn-success">{{ $books["status"] }}</span></td>
                          @else
                          <td><span class="btn btn-xs btn-info">{{ $books["status"] }}</span></td>
                          @endif
                          <td>{{ $books["referred_by_name"] }}</td>
                          
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
   
</div>          
@endsection
@section('jquery')
<script>
$(document).ready(function() {
    
  // $('#min').datepicker({
  //   startDate: '-0d'
  // });
        
  $('#datatable').DataTable( {
      dom: 'Bfrtip',
      buttons: [
          'excel', 'pdf'
          
      ]
  } );

  $(document).on('change', '#min',  function (){
    var date = $("#min").val();
    $('#datatable').DataTable().destroy();
    $.ajax({
        url: "/get-filtered-room-data",
        type: "get",
        data : {"sortDate" : date},
        dataType: 'json',
        success: function(response) {
          $('#datatable').DataTable( {
            "draw": 1,
            "paging": true,
            "ordering" : true,
            buttons: [
                'excel', 'pdf'
                
            ],
            
            "data": response
            
          } );
        }
    });

    
    
  

    
    
 });
    
});

</script>
@endsection