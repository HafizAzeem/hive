<?php $__env->startSection('content'); ?>
<script>
    $(".datePickerDefault").datepicker({
        dateFormat: 'yy-mm-dd',
        format: 'L',
        minDate: 0
    });
</script>
<?php 
      $flag=0;
      $heading=lang_trans('btn_add');
?>
  
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
                  <!--<?php if($flag==1): ?>-->
                      <!--<?php echo e(Form::model($data_row[0],array('url'=>route('save-extrarevenue'),'id'=>"edit-extrarevenue-form", 'class'=>"form-horizontal form-label-left"))); ?>-->
                      <!--<?php echo e(Form::hidden('id',null)); ?>-->
                  <!--<?php else: ?>-->
                      <?php echo e(Form::open(array('url'=>route('save-extrarevenue'),'id'=>"add-extrarevenue-form", 'class'=>"form-horizontal form-label-left"))); ?>

                  <!--<?php endif; ?>-->
                    <div class="row">
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <label class="control-label"> Title <span class="required">*</span></label>
                            <?php echo e(Form::text('title',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"title",'required'])); ?>

                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <label class="control-label"> Payment <span class="required">*</span></label>
                            <?php echo e(Form::text('payment',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"payment1",'required'])); ?>

                        </div>
                        <div class="col-md-6 col-sm-3 col-xs-12">
                            <label class="control-label"><span class="required">*</span> Payment Mode</label>
                            <?php echo e(Form::select('mode',$payment_mode_list ?? '',null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment", "placeholder"=>"--Select", 'required'])); ?>

                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <label class="control-label"> Remark <span class="required">*</span></label>
                            <?php echo e(Form::text('remark',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remark",'required'])); ?>

                        </div>
                        
                        <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                        <!--    <label class="control-label"> Date <span class="required">*</span></label>-->
                        <!--    <?php echo e(Form::date('payment_date', null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"payment_date", "autocomplete"=>"off",'required'])); ?>-->
                        <!--</div>-->
                        
                        <!--<input type="hidden" id="payment_date_new" value="<?php echo e(date('Y-m-d',strtotime($data_row[0]->payment_date?? ''))); ?>">-->
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Date <span class="required">*</span></label>
                            <?php
                                $d = new DateTime($data_row[0]->payment_date ?? '');
                                $dtPart = $d->format('Y-m-d');
                               // $d2 = new DateTime($data_row->check_out ?? '');
                                //$dtPart2 = $d2->format('Y-m-d');
                            ?>
                            <?php echo e(Form::date('payment_date_new',$dtPart ?? '',['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"payment_date_new", "autocomplete"=>"off", 'required', 'disabled'])); ?>

                            <input type="hidden" name="payment_date" value="<?= $dtPart; ?>">
                        </div>
                        
                    </div>
                    
                    <div class="row" style="margin-top: 2%;">
                      <div class="col-md-12">
                        <button type="button" onclick="plus()" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                    
                  
                    <?php 
                        $a=1;
                        for($p = 0; $p < 10; $p++)
                        {
                     
                    ?>
                    <div class="row" id="remove<?= $a;?>" style="display:none">  
                        <!--<td></td>-->
                        <!--<td></td>-->
                        <div class="col-md-3 col-sm-3 col-xs-12">                            
                            <label class="control-label">Payment</label>        
                            <input class="form-control" placeholder="Enter Payment" name="payment1[]" min="0" type="number">                        
                        </div>                         
                        <div class="col-md-3 col-sm-3 col-xs-12">                             
                            <label>Remark</label>                                
                            <input class="form-control" placeholder="Enter Remark" name="remark1[]" type="text">   
                        </div>                        
                        <div class="col-md-3 col-sm-3 col-xs-12">                            
                            <label class="control-label"> Payment Mode</label>
                            <?php echo e(Form::select('mode1[]',$payment_mode_list,'',['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])); ?>

                             
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12"> 
                            <button type="button" onclick="remove_addon(<?= $a; ?>)" style="margin-top:25px" class="btn btn-danger add-new-advance"><i class="fa fa-minus"></i></button>     
                        </div>
                    </div>
                    
                    <?php 
                        $a++; } 
                    ?>
                    <div class="ln_solid"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                        <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
                    </div>
                  <?php echo e(Form::close()); ?>

              </div>
          </div>
      </div>
  </div>
</div>
<script>
//   $(function() {

//       $(".datePickerDefault1").datepicker({
//         dateFormat: 'dd-mm-yy',
//          changeMonth: true,
//           changeYear: true,
//           yearRange: "-50:+0"
//       });
//   });
   
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
</script>   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/extrarevenue/add_edit_extrarevenue.blade.php ENDPATH**/ ?>