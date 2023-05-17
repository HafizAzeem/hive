<?php $__env->startSection('content'); ?>
<style type="text/css">
   #results {
      border: 1px solid;
      background: #ccc;
   }

   .results_guest {
      border: 1px solid;
      background: #ccc;
   }
</style>

<script>
$(document).on('focus',".date", function(){ //bind to all instances of class "date".
   $(this).datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:+0"
   });
});
   $(function() {
      $(".datePickerDefault").datepicker({
         dateFormat: 'yy-mm-dd',
         minDate: 0

      });
      $(".datePickerDefault1").datepicker({
         dateFormat: 'dd-mm-yy',
         changeMonth: true,
          changeYear: true,
          yearRange: "-90:+0"
      });
   });
</script>
<div class="">

   <?php echo e(Form::open(array('url'=>route('save-performa'),'class'=>"form-horizontal form-label-left",'files'=>true))); ?>


   <div class="row hide_elem" id="existing_guest_section">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <script type="text/javascript">
               var path = "<?php echo e(route('autocomplete')); ?>";
               $('input.typeahead').typeahead({
                  source: function(query, process) {
                     return $.get(path, {
                        query: query
                     }, function(data) {
                        console.log(data);
                        console.log(process.id);
                        console.log(data.name);
                        return process(data);
                     });
                  }
               });
            </script>
         </div>
      </div>
   </div>
   <div class="row" id="new_guest_section">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Performa Invoice</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> Booking ID <span ></span></label>-->
                    <!--    -->
                    <!--</div>-->
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> And Number </label>-->
                    <!--    -->
                    <!--</div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Customer Name <span class="required">*</span></label>
                        <?php echo e(Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname'), 'required'])); ?>

                    </div>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> <?php echo e(lang_trans('txt_email')); ?> </label>-->
                    <!--    -->
                    <!--</div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_mobile_num')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('mobile',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile","maxlength"=>"10", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num'), 'required'])); ?>

                    </div>

                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> <span class="required">*</span></label>-->
                    <!--    -->
                    <!--</div>-->
                    <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                    <!--    <label class="control-label"> <?php echo e(lang_trans('txt_age')); ?> </label>-->
                    <!--    -->
                    <!--</div>-->
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Particulars <span class="required">*</span></label>
                        <?php echo e(Form::text('title',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"title", "placeholder"=>"Title", 'required'])); ?>

                    </div>
                </div>
                
                <div class="row ">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_checkin')); ?><span class="required">*</span></label>
                        <?php
                                $dtPart2 = date('Y-m-d');
                                $dtPart3 = date('Y-m-d');
                                $dtPart4 = date('Y-m-d');
                           
                        ?>
                        <?php echo e(Form::text('check_in_date', $dtPart2,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_in_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required'])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_checkout')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('check_out_date', $dtPart3,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_out_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required'])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Payment Mode</label>
                        <select class="form-control" name="payment_mode">
                            <?php $__currentLoopData = $payment_mode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($mode->id); ?>"><?php echo e($mode->payment_mode); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_room_type')); ?> <span></span></label>
                        <?php echo e(Form::select('room_type_id',$roomtypes_list ?? '',null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('Room Qty')); ?> <span>*</span></label>
                        <?php echo e(Form::number('no_of_rooms',null,['class'=>"form-control col-md-6 col-xs-12", "placeholder"=>lang_trans('No of Rooms'),"min"=>1])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Room Rent <span>*</span></label>
                        <?php echo e(Form::number('payment',null,['class'=>"form-control col-md-6 col-xs-12", "placeholder"=>lang_trans('Per Room Rent'), 'required'])); ?>

                        <!--<input type="number" class="form-control" name="payment" placeholder="Per Room Rent" required>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Advance Payment </label>
                        <?php echo e(Form::number('advance',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"advance", "placeholder"=>"Advance Payment"])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Advance Payment Date </label>
                        <?php echo e(Form::date('advance_date',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"advance_date", "placeholder"=>"Advance Payment Date", "autocomplete"=>"off"])); ?>

                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                   <h2>Extra Charges</h2>
                   <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge One Title </label>
                            <?php echo e(Form::text('remarkone',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkone", "placeholder"=>"Charge One Title"])); ?>

                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge One Amount </label>
                            <?php echo e(Form::number('amountone',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountone", "placeholder"=>"Charge One Amount"])); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Two Title </label>
                            <?php echo e(Form::text('remarktwo',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarktwo", "placeholder"=>"Charge Two Title"])); ?>

                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Two Amount </label>
                            <?php echo e(Form::number('amounttwo',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amounttwo", "placeholder"=>"Charge Two Amount"])); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Three Title </label>
                            <?php echo e(Form::text('remarkthree',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkthree", "placeholder"=>"Charge Three Title"])); ?>

                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Three Amount </label>
                            <?php echo e(Form::number('amountthree',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountthree", "placeholder"=>"Charge Three Amount"])); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Four Title </label>
                            <?php echo e(Form::text('remarkfour',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkfour", "placeholder"=>"Charge Four Title"])); ?>

                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Four Amount </label>
                            <?php echo e(Form::number('amountfour',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountfour", "placeholder"=>"Charge Four Amount"])); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Five Title </label>
                            <?php echo e(Form::text('remarkfive',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"remarkfive", "placeholder"=>"Charge Five Title"])); ?>

                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Charge Five Amount </label>
                            <?php echo e(Form::number('amountfive',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"amountfive", "placeholder"=>"Charge Five Amount"])); ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12">
                    <button class="btn btn-success btn-submit-form2" type="submit"  id="arrivals_btn" style="float:right;"><?php echo e(lang_trans('btn_submit')); ?></button>
                </div>
            </div>
        </div>
        
    </div>
   </div>

    <?php echo e(Form::close()); ?>

</div>



<script>

   $(document).ready(function() {
        $(document).on('click', '.btn-submit-form2', function(e) {
        v = $(check_in_date_my).val();
        v1 = $(check_out_date_my).val();
        var d1 = new Date(v);
        var d2 = new Date(v1);
            if (d2 < d1) {
              swal({
                 type: 'error',
                 title: 'Oops...',
                 text: 'Checkout should be greater than check in',
              })
              e.preventDefault();
            }

        });
    });

    $(document).on('change', '#payment', function(event) {
       loadSelectedDeviceOptions($(this).val());
    });

    globalVar.page = 'room_reservation_add';
</script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/js/page_js/page.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/js/custom.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/performainvoice/add_edit_performainvoice.blade.php ENDPATH**/ ?>