@extends('layouts.master_backend')
@section('content')
<script>
    $(".datePickerDefault").datepicker({
        dateFormat: 'yy-mm-dd',
        format: 'L',
        minDate: 0
    });
</script>
@php 
      if(isset($data_row[0]) && !empty($data_row[0])){
          $flag=1;
          $heading=lang_trans('btn_update');
      }
  @endphp
  
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Extra Revenue</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  @if($flag==1)
                      {{ Form::model($data_row[0],array('url'=>route('update-extrarevenue'),'id'=>"edit-extrarevenue-form", 'class'=>"form-horizontal form-label-left")) }}
                      {{Form::hidden('id',null,["id"=>"newid"])}}
                  @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <label class="control-label"> Title <span class="required">*</span></label>
                            {{Form::text('title',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"title",'disabled'])}}
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <label class="control-label"> Payment <span class="required">*</span></label>
                            {{Form::text('payment',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"payment1",'disabled'])}}
                        </div>
                        <div class="col-md-6 col-sm-3 col-xs-12">
                            <label class="control-label"><span class="required">*</span> Payment Mode</label>
                            {{Form::select('mode',$payment_mode_list ?? '',null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select", 'disabled'])}}
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <label class="control-label"> Remark <span class="required">*</span></label>
                            {{Form::text('remark',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remark",'disabled'])}}
                        </div>
                        
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Date <span class="required">*</span></label>
                            {{Form::date('payment_date', null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"payment_date", "autocomplete"=>"off",'disabled'])}}
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" onclick="plus()" style="margin-top:2%;" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    
                    <?php 
                        $t_amount=0;
                        //$re=DB::table('reservations')->where('unique_id',$unique_id)->get();
                        $re = DB::table('payment_history')->where('id',$data_row[0]->id)->get();
                        
                        foreach($re as $r)
                        { 
                            // $id = $_GET['id'];
                            // print_r($id);die;
                            // print_r($r);
                            //print_r($r->reservations_id);die;
                            $pay=DB::table('payment_history')->where('reservations_id',$r->reservations_id)->get();
                            
                            foreach($pay as $pp)
                            {
                                //$t_amount += $pp->payment;
                                ?>
                                <div class="row"> 
                                    <div class="col-md-2">                            
                                        <label class="control-label">Payment</label>        
                                        <input class="form-control col-md-4 col-xs-4" placeholder="Enter Advance Payment" name="payment[]" value="{{numberFormat($pp->payment)}}" type="number">                        
                                    </div>    
                                    
                                    <div class="col-md-3">                             
                                        <label class="control-label" >Remark</label>
                                        <input class="form-control col-md-4 col-xs-4" placeholder="Enter Remark" name="remark_old[]" value="{{$pp->remark}}" type="text">  
                                       
                                    </div>                        
                                    <div class="col-md-3">                            
                                        <label class="control-label" > Payment Mode</label>                            
                                        {{Form::select('payment_mode[]',$payment_mode_list,$pp->mode,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])}}
                                        <input type="hidden" name="payment_history_ids[]" value="{{$pp->id}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Payment Date</label> 
                                        <input type="date" value="{{$pp->payment_date}}" name="payment_date[]" class="form-control">
                                    </div>
                                </div>
                                
                                <?php
                                
                            }
                            
                        }
                       
                       ?>
                
                
                
                    <?php 
                    $a=1;
                    for($p=0;$p<20;$p++)
                    {
                         
                    ?>
                        <div class="row" id="remove<?= $a ;?>" style="display:none">  
                            <div class="col-md-4">                            
                                <label class="control-label">Payment</label>        
                                <input class="form-control col-md-4 col-xs-4" placeholder="Enter Advance Payment" name="payment1[]" min="0" type="number">                        
                            </div>                         
                            <div class="col-md-3">                             
                                <label>Remark</label>                                
                                <input class="form-control" placeholder="Enter Remark" name="remark1[]" type="text"> 
                            </div>    
                            
                            <div class="col-md-3">                            
                                <label class="control-label"> Payment Mode</label>                            
                                {{Form::select('mode1[]',$payment_mode_list,'',['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2","placeholder"=>"--Select"])}}
                            </div>
                            <div class="col-md-2">                       
                                <button type="button" onclick="remove_addon(<?= $a; ?>)" style="margin-top:25px" class="btn btn-danger add-new-advance"><i class="fa fa-minus"></i></button>     
                            </div>
                        </div>
                        
                    <?php $a++; } ?>
                    
                    
                    
                    
                    <div class="ln_solid"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-success" type="submit">{{lang_trans('btn_submit')}}</button>
                    </div>
                    
                    
                    
                    
                    
                  {{Form::close()}}
              </div>
          </div>
      </div>
  </div>
</div>
<script>

    let id=1;
    function plus()
    {
       $("#remove"+id).show();
       id++;
       console.log(id)
    }

    function remove_addon(id)
    {
        $("#remove"+id).remove();
    }

//   $(function() {

//       $(".datePickerDefault1").datepicker({
//         dateFormat: 'dd-mm-yy',
//          changeMonth: true,
//           changeYear: true,
//           yearRange: "-50:+0"
//       });
//   });
   //id = $('#newid').val();
    // $(document).ready(function() {
    //     $("#check_in_date_my").datepicker({
    //       startDate: '-0d',
    //     });
    //     $(document).on('click', '.btn-submit-form', function(e) {
    //         v = $(check_in_date_my).val();
    //         // v1 = $(check_out_date_my).val();
    //         var d1 = new Date(v);
    //         //  var d2 = new Date(v1);
    //     });
    // });
</script>
@endsection