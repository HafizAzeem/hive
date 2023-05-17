@extends('layouts.master_backend')

@section('content')
<div class="qwe">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Budget Forecast Chart</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Property</th>
                      <th>Revenue Target</th>
                      <th>Till-Date</th>
                      <th>Actual Revenue</th>
                      <th>Average</th>
                      <th>Days Month</th>
                      <th>Forecast Month</th>
                      <th>Zone</th>
                    </tr>
                  </thead>
                 

                  <!--<tbody>-->
                    {{--@foreach($datalist as $k=>$val)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$val->title}}</td>
                            <td>{{$val->budgetestimate}}</td>
                            <td>{{$today}}</td>
                            <td>{{$actualmr}}</td>
                            <td>{{$average}}</td>
                            <td>{{$DaysInCurrentMonth}}</td>
                            <td>{{$forecast}}</td>
                            
                            @if(round($forecast *100 / $val->budgetestimate) >= 100 )
                                <td style="background-color: green;color: white;">{{round($forecast *100 / $val->budgetestimate)}}%</td>
                            @elseif(round($forecast *100 / $val->budgetestimate) > 80 && round($forecast *100 / $val->budgetestimate) < 100 )
                                <td style="background-color: yellow;color: black;">{{round($forecast *100 / $val->budgetestimate)}}%</td>
                            @else
                                <td style="background-color: red;color: white;">{{round($forecast *100 / $val->budgetestimate)}}%</td>
                            @endif
                        </tr>
                    @endforeach --}}
                  <!--</tbody>-->
                  
    <tbody>
        @php  $k = 0;     @endphp
        @if(isset($arrReturn))
            @foreach($arrReturn as $vhf)
                @foreach($vhf['budget'] as $vh)
                    <?php 
                    if(!empty($vh->budgetestimate)){
                    ?>

                    @if(round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate) >= 100 )
                        <tr class="mygreen">
                            <td>{{$k+1}}</td>
                            <td>{{$vh->title}}</td>
                            <td>{{$vh->budgetestimate}}</td>
                            <td>{{$vhf['today']}}</td>
                            <td>{{$vhf['actualmr']}}</td>
                            <td>{{round($vhf['actualmr']/$vhf['today'])}}</td>
                            <td>{{$vhf['DaysInCurrentMonth']}}</td>
                            <td>{{round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']}}</td>
                            <td style="background-color: green;color: white;">{{round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate)}}%</td>
                        </tr>    
                    @elseif(round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate) > 80 && round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate) < 100 )
                        <tr class="myyellow">    
                            <td>{{$k+1}}</td>
                            <td>{{$vh->title}}</td>
                            <td>{{$vh->budgetestimate}}</td>
                            <td>{{$vhf['today']}}</td>
                            <td>{{$vhf['actualmr']}}</td>
                            <td>{{round($vhf['actualmr']/$vhf['today'])}}</td>
                            <td>{{$vhf['DaysInCurrentMonth']}}</td>
                            <td>{{round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']}}</td>
                            <td style="background-color: yellow;color: black;">{{round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate)}}%</td>
                        </tr>
                    @else
                        <tr class="myred">    
                            <td>{{$k+1}}</td>
                            <td>{{$vh->title}}</td>
                            <td>{{$vh->budgetestimate}}</td>
                            <td>{{$vhf['today']}}</td>
                            <td>{{$vhf['actualmr']}}</td>
                            <td>{{round($vhf['actualmr']/$vhf['today'])}}</td>
                            <td>{{$vhf['DaysInCurrentMonth']}}</td>
                            <td>{{round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']}}</td>
                            <td style="background-color: red;color: white;">{{round((round($vhf['actualmr']/$vhf['today'])*$vhf['DaysInCurrentMonth']) *100 / $vh->budgetestimate)}}%</td>
                        </tr>
                    @endif
                    <?php 
                    }
                    ?>
                        
                    @php  $k++; @endphp
                    
                @endforeach
            @endforeach
        @endif
    </tbody>
                  
                  
                 
                </table>
                
              </div>
                                
          </div>
      </div>
  </div>
</div>     
            
                        
<script>
    // let id=1;
    // function plus()
    // {
    //   $("#remove"+id).show();
    //   id++;
    //   console.log(id)
    // }

    // function remove_addon(id)
    // {
    //     $("#remove"+id).remove();
    // }
</script>                
                                
                                    


@endsection