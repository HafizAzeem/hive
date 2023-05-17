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
    <?php
    $flag=0;
    $heading=lang_trans('btn_add');
    if(isset($data_row) && !empty($data_row)){
    $flag=1;
    $heading=lang_trans('btn_update');
    }
    ?>
<div class="">
   <?php if($flag==1): ?>
   <?php echo e(Form::model($data_row,array('url'=>route('save-arrival'),'id'=>"update-arrival-form", 'class'=>"form-horizontal form-label-left",'files'=>true))); ?>

   <?php echo e(Form::hidden('id',null)); ?>

   <?php else: ?>
   <?php echo e(Form::open(array('url'=>route('save-arrival'),'class'=>"form-horizontal form-label-left",'files'=>true))); ?>

   <?php endif; ?>
   <?php echo e(Form::hidden('per_room_price',null,['id'=>'base_price'])); ?>

   <?php echo e(Form::hidden('room_qty',null,['id'=>'room_qty'])); ?>


   <div class="row hide_elem" id="existing_guest_section">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2><?php echo e(lang_trans('heading_existing_guest_list')); ?></h2>
               <div class="clearfix"></div>
            </div>

            <div class="x_content">
               <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"><?php echo e(lang_trans('txt_guest')); ?></label>
                     <?php echo e(Form::text('selected_customer_id',null,['class'=>'typeahead form-control','placeholder'=>lang_trans('ph_select')])); ?>

                     <!-- <input class="typeahead form-control" type="text"> -->
                  </div>
               </div>
            </div>
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
               <h2><?php echo e(lang_trans('heading_guest_info')); ?></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Booking ID <span ></span></label>
                        <?php echo e(Form::text('Booking_id',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"Booking_id", "placeholder"=>"Booking ID"])); ?>

                        <!--<input class="form-control col-md-6 col-xs-12" id="Booking_id" placeholder="Booking ID"  name="Booking_id" type="text" >-->
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> And Number </label>
                        <?php echo e(Form::text('and_number',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"and_number", "placeholder"=>"And Number"])); ?>

                        <!--<input class="form-control col-md-6 col-xs-12" id="and_number" placeholder="And Number"  name="and_number" type="text">-->
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_fullname')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname'), 'required'])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_email')); ?> </label>
                        <?php echo e(Form::email('email',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_mobile_num')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('mobile',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile","maxlength"=>"10", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num'), 'required'])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::select('gender',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), 'required'])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_age')); ?> </label>
                        <?php echo e(Form::text('age',null,['class'=>"form-control datePickerDefault1 col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off"])); ?>

                     <!-- <?php echo e(Form::number('age',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])); ?> -->
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
               <h2><?php echo e(lang_trans('heading_checkin_info')); ?></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_adults')); ?> <span class="required">*</span></label>
                     <?php echo e(Form::number('adult',1,['class'=>"form-control col-md-7 col-xs-12", "id"=>"adult", "required"=>"required","placeholder"=>lang_trans('ph_enter').lang_trans('txt_adults'),"min"=>1, 'required'])); ?>

                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_kids')); ?> </label>
                     <?php echo e(Form::number('kids',0,['class'=>"form-control col-md-7 col-xs-12", "id"=>"kids", "required"=>"required","placeholder"=>lang_trans('ph_enter').lang_trans('txt_kids'),"min"=>0])); ?>

                  </div>
                  
                  <div class="col-md-2 col-sm-2 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_kids')); ?> </label>
                     <?php echo e(Form::number('infant',0,['class'=>"form-control col-md-7 col-xs-12", "id"=>"infant", "required"=>"required","placeholder"=>"Enter infant(below 5)","min"=>0])); ?>

                  </div>
                  
                  <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                  <!--   <label class="control-label"> <?php echo e(lang_trans('txt_vehicle_number')); ?></label>-->
                  <!--   <?php echo e(Form::text('vehicle_number',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"vehicle_number", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_vehicle_number')])); ?>-->
                  <!--</div>-->
                  <!--<div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">-->
                  <!--   <label class="control-label"> <?php echo e(lang_trans('txt_reason_of_visit')); ?></label>-->
                  <!--   <?php echo e(Form::select('reason_visit_stay',config('constants.REASON'),null,['class'=>"form-control h34 col-md-6 col-xs-12", "id"=>"reason_visit_stay","rows"=>1])); ?>-->
                  <!--</div>-->
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_referred_by_name')); ?></label>
                     <?php echo e(Form::select('referred_by_name',config('constants.REFERRED_BY_NAME'),$data_row->referred_by_name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name"])); ?>

                  </div>
                  <div id="corporate"></div>
                  </div>
               </div>
               <div class="row ">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_checkin')); ?><span class="required">*</span></label>
                         <?php
                         $dtPart2 = date('Y-m-d');
                         ?>
                     <?php echo e(Form::text('check_in_date', $dtPart2,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_in_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required'])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12 ">
                     <label class="control-label"> <?php echo e(lang_trans('txt_checkout')); ?> <span class="required">*</span></label>
                     <?php echo e(Form::text('check_out_date', $dtPart2,['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_out_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required'])); ?>

                  </div>
               </div>
               <!-- <div class="row">

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_room_type')); ?><span class="required">*</span></label>
                     <?php echo e(Form::select('room_type_id',$roomtypes_list,null,['class'=>'form-control',"id"=>"room_type_id",'placeholder'=>lang_trans('ph_select')])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('No of Rooms')); ?> <span class="required">*</span></label>
                     <?php echo e(Form::number('no_of_rooms',1,['class'=>"form-control col-md-6 col-xs-12", "id"=>"no_of_rooms", "placeholder"=>lang_trans('No of Rooms'),"min"=>1])); ?>

                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_select_rooms')); ?><span class="required">*</span></label>
                     <table class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th><?php echo e(lang_trans('txt_sno')); ?></th>
                              <th><?php echo e(lang_trans('txt_select')); ?></th>
                              <th><?php echo e(lang_trans('txt_room_num')); ?></th>
                              <th><?php echo e(lang_trans('txt_status')); ?></th>
                           </tr>
                        </thead>
                        <tbody id="rooms_list">
                        </tbody>
                     </table>
                  </div>

               </div> -->
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">

            <div class="x_title">
               <h2>Room Selection</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_room_type')); ?> <span></span></label>
                     <?php echo e(Form::select('room_type_id',$roomtypes_list ?? '',null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('No of Rooms')); ?> <span>*</span></label>
                     <?php echo e(Form::number('no_of_rooms',1,['class'=>"form-control col-md-6 col-xs-12", "placeholder"=>lang_trans('No of Rooms'),"min"=>1])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> Package <span class=""></span></label>
                     <select class="form-control" name="package_id" id="package_id">
                        <option>--Select--</option>
                        <?php $__currentLoopData = $package_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo e($pack->id); ?>" data-price ="<?php echo e($pack->package_price); ?>" data-room-type="<?php echo e($pack->room_type_id); ?>"><?php echo e($pack->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12" id="package_price_div" style="display : none;">
                     <label class="control-label"> Package Price <span class=""></span></label>
                     <?php echo e(Form::text('package_price',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"package_price", "placeholder"=>"Enter package price"])); ?>

                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_select_rooms')); ?><span class="required">*</span></label>
                     <table class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th><?php echo e(lang_trans('txt_sno')); ?></th>
                              <th><?php echo e(lang_trans('txt_select')); ?></th>
                              <th><?php echo e(lang_trans('txt_room_num')); ?></th>
                              <th><?php echo e(lang_trans('txt_status')); ?></th>
                           </tr>
                        </thead>
                        <tbody id="rooms_list">
                        </tbody>
                     </table>
                  </div>

               </div>
            </div>



         <div>
      </div>
   </div>


   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">

            <div class="x_content">

               <div class="ln_solid"></div>
               
                <div class="col-md-6">
                   <label>GST</label>
                   <input type="text" class="form-control" name="gst_number" >
                   
               </div>
               
                <div class="col-md-6">
                   <label>Company Name</label>
                   <input type="text" class="form-control" name="gst_company" >
                   
               </div>
               
               <div class="col-md-6">
                   <label>Company Address</label>
                   <input type="number" class="form-control" name="gst_address" >
                   
               </div>
               
                <div class="col-md-6">
                   <label>Advance Payment</label>
                   <input type="number" class="form-control" name="advance">
                </div>
                <div class="col-md-6">
                   <label>Total Payment</label>
                   <input type="number" class="form-control" name="payment" required>
                </div>
               
               <div class="col-md-6">
                   <label>Payment Mode</label>
                  <select class="form-control" name="payment_mode">
                      <?php $__currentLoopData = $payment_mode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($mode->id); ?>"><?php echo e($mode->payment_mode); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <br>
                  <button class="btn btn-success" style="display:none" id="first" type="button" onclick="payment_link()"><?php echo e(lang_trans('Verify')); ?></button>
                  <button class="btn btn-success btn-submit-form2" type="submit"  id="arrivals_btn"><?php echo e(lang_trans('btn_submit')); ?></button>
                   
               </div>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" name="arrival_room_num" id="arrival_room_num">
   <?php echo e(Form::close()); ?>

</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document" style="max-width: 80%;">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Photos</h5>

         </div>

         <form action="<?php echo e(route('save-guest-card')); ?>" method="post" enctype="multipart/form-data" id="image-form">
            <?php echo csrf_field(); ?>
            <div class="row">

               <div class="col-md-4">
                  <a href="javascript:" id="snapguest" class="btn btn-success">Open WebCam</a>
                  <a href="javascript:" id="snapguestclose" class="btn btn-success">Close WebCam</a>
                  <div id="camera">
                  </div>
                  <input type=button value="Take Snapshot Front" onClick="take_snapshot_guest()">
                  <input type=button value="Take Snapshot Back" onClick="take_snapshot_guest_back()">

                  <input type="hidden" name="id_cardno[]" id="id_card_guest" class="id_card_front">
                  <input type="hidden" name="id_cardno[]" id="id_card_guest_back" class="id_card_back">

               </div>
               <div class="col-md-4">
                  <div class="results_front_guest">Your captured Front Side image will appear here...</div>
               </div>
               <div class="col-md-4">
                  <div class="results_back_guest">Your captured Back Side image will appear here...</div>
               </div>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" id="btnSaveImage">
                  Save Now
               </button>
               <button type="button" id="close" class="btn btn-secondary" data-mdb-dismiss="modal">
                  Close
               </button>
            </div>

         </form>
      </div>
   </div>
</div>
<div class="colne_persons_info_elem hide_elem">
   <div class="row persons_info_elem">
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_name')); ?> </label>
         <?php echo e(Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name')])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> </label>
         <?php echo e(Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_age')); ?> </label>
         <?php echo e(Form::number('persons_info[age][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])); ?>


      </div>
      <div class="col-md-2 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_document_upload')); ?> <span class="required">*</span></label>
         <?php echo e(Form::file('persons_info[document_upload][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12" id="new">
         <label class="control-label"><?php echo e(lang_trans('Picture by Webcam')); ?> </label>
         <button type="button" class="btn btn-primary photo_id" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
            Upload Photo WebCam
         </button>
         <input type="hidden" name="image_guest[]" class="image-tag">
         <div class="col-md-3">
         </div>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"><?php echo e(lang_trans('txt_type_id')); ?> </label>
         <?php echo e(Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"><?php echo e(lang_trans('txt_id_number')); ?> </label>
         <?php echo e(Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number')])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> &nbsp;</label><br />
         <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
      </div>
   </div>
</div>
<div class="colne_persons_info_kids hide_elem">
   <div class="row persons_info_elem">
      <div class="x_title">
         <h2><?php echo e(lang_trans('Kids Info')); ?></h2>
         <div class="clearfix"></div>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_name')); ?> </label>
         <?php echo e(Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name')])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> </label>
         <?php echo e(Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_age')); ?> </label>
         <?php echo e(Form::number('persons_info[age][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"max"=>10])); ?>

      </div>
      <div class="col-md-2 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_document_upload')); ?> <span class="required">*</span></label>
         <?php echo e(Form::file('persons_info[document_upload][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12" id="new">
         <label class="control-label"><?php echo e(lang_trans('Picture by Webcam')); ?> </label>
         <button type="button" class="btn btn-primary photo_id" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
            Upload Photo WebCam
         </button>
         <input type="hidden" name="image_guest[]" class="image-tag">
         <div class="col-md-3">
         </div>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"><?php echo e(lang_trans('txt_type_id')); ?> </label>
         <?php echo e(Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"><?php echo e(lang_trans('txt_id_number')); ?> </label>
         <?php echo e(Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number')])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> &nbsp;</label><br />
         <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
      </div>
   </div>
</div>

<script>

    $('#referred_by_name').change(function() {
                  var status = $(this).val();
                  if (status == 'Corporate') {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">Corporate</label>'+
                     `<select name="corporate" class="form-control col-md-6 col-xs-12">
                       <?php $__currentLoopData = $corporates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <option value="<?php echo e($corp); ?>"><?php echo e($corp); ?></option>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'TA')
                  {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">TA</label>'+
                     `<select name="ta" class="form-control col-md-6 col-xs-12">
                       <?php $__currentLoopData = $tas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <option value="<?php echo e($corp); ?>"><?php echo e($corp); ?></option>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else if(status == 'OTA')
                  {
                     var html = '';
                     html +=
                     ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                     '<label class="control-label">OTA</label>'+
                     `<select name="ota" class="form-control col-md-6 col-xs-12">
                       <?php $__currentLoopData = $ota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <option value="<?php echo e($corp); ?>"><?php echo e($corp); ?></option>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </select>`;
                     $('#corporate').html(html);
                  }
                  else {
                     $('#corporate').html('');
                  }
    });
   $(document).ready(function() {
     // $("#arrivals_btn").attr("disabled", true);
                // $("#check_in_date_my").datepicker({
                //   startDate: '-0d',
                // });
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

            function loadSelectedDeviceOptions(selectedOption) {
               console.log(selectedOption);
               if (selectedOption == 7) {
                  $("#first").show();
                  $("#first").attr("onclick", "payment_link()");
               } else if (selectedOption == 4) {
                  $("#first").show();
                  $("#first").attr("onclick", "paytm_Send_Link()");
               } else {
                  $("#first").hide();
               }

            }

            $("#adult").keyup(function() {
               console.log("adult");
               var value = $("#adult").val();
               var i = 1;
               $(".persons_info_parent").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_elem").html();
                  $(".persons_info_parent").append(html);
               }
            });
            $("#adult").change(function() {
               console.log("adult1");
               var value = $("#adult").val();
               var i = 1;
               $(".persons_info_parent").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_elem").html();
                  $(".persons_info_parent").append(html);
               }
            });
            $("#kids").keyup(function() {
               console.log("kids1");
               var value = $("#kids").val();
               var i = 0;
               $(".persons_info_kids").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_kids").html();
                  $(".persons_info_kids").append(html);
               }
            });
            $("#kids").change(function() {
               console.log("kids2");
               var value = $("#kids").val();
               var i = 0;
               $(".persons_info_kids").empty();
               for (i; i <= value - 1; i++) {
                  var html = $(".colne_persons_info_kids").html();
                  $(".persons_info_kids").append(html);
               }
            });

            globalVar.page = 'room_reservation_add';
</script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/js/page_js/page.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('public/js/custom.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


<script language="JavaScript">
   $(document).on('click', '.photo_id', function() {


      $("#exampleModal").modal('show');

   });

   $(document).on('click', '#close', function() {


      $("#exampleModal").modal('hide');

   });

   $(".remove-second-advance").click(function() {

$("#second_advance").hide()})
   $("#snap").click(function() {


      Webcam.set({
         width: 250,
         height: 250,
         image_format: 'jpeg',
         jpeg_quality: 90
      });

      Webcam.attach('#my_camera');
   });
   $("#second_advance").hide();

   $(".add-new-advance").click(function() {

      $("#second_advance").show();

   })

   $("#snapclose").click(function() {




      Webcam.reset('#my_camera');
   });
   $("#snapguest").click(function() {


      Webcam.set({
         width: 250,
         height: 250,
         image_format: 'jpeg',
         jpeg_quality: 90
      });

      Webcam.attach('#camera');
   });
   $("#snapcloseguest").click(function() {




      Webcam.reset('#camera');
   });

   $(document).on('click', '.snap_guest', function() {
      Webcam.set({
         width: 100,
         height: 100,
         image_format: 'jpeg',
         jpeg_quality: 90
      });

      Webcam.attach('.my_camera');



   });


   function take_snapshot() {
      Webcam.snap(function(data_uri) {
         $(".images").val(data_uri);
         $('#id_card').val(data_uri);
         var image = $('#id_card').val();

         document.getElementById('resultss').innerHTML = '<img src="' + data_uri + '"/>';
      });
   }


   function take_snapshot_back() {
      Webcam.snap(function(data_uri) {

         $(".id_cardno_back").val(data_uri);

         var image = $('#id_card_back').val();

         document.getElementById('results-back').innerHTML = '<img src="' + data_uri + '"/>';
      });
   }


   function take_snapshot_guest() {

      Webcam.snap(function(data_uri) {
         $(".id_card_front").val(data_uri);
         $('#id_card_guest').val(data_uri);
         var image = $('#id_card_guest').val()

         document.getElementsByClassName('results_front_guest')[0].innerHTML = '<img src="' + data_uri + '"/>';
      });
   }


   function take_snapshot_guest_back() {
      Webcam.snap(function(data_uri) {
         $(".id_card_back").val(data_uri);
         $('#id_card_guest_back').val(data_uri);
         var image = $('#id_card_guest_back').val()

         document.getElementsByClassName('results_back_guest')[0].innerHTML = '<img src="' + data_uri + '"/>';
      });
   }

   function payment_link() {
      var val = $('input[name="guest_type"]:checked').val();

      if (val == "existing") {
         var customer_id = $('input[name="selected_customer_id"]').val();
         var advanced_payment = $('#advance_payment').val();

         var booking_payment = $('#booking_payment').val();
         // var payable= booking_payment - advanced_payment ;
         // alert(payable);
         if (customer_id == "") {
            alert('please select a customer');
         } else {

            $.ajax({
               url: "<?php echo e(route('sendpaymentlink')); ?>?guest_type=existing&customer=" + customer_id + "&advanced_payment=" + advanced_payment + "&booking_payment=" + booking_payment,
               type: "get",
               dataType: 'json',
               success: function(response) {
                  console.log(response);
               }
            });

         }
      } else {
         var name = $('#name').val();
         var email = $('#email').val();
         var phone = $('#phone').val();
         var advanced_payment = $('#advance_payment').val();

         var booking_payment = $('#booking_payment').val();


         if (name != "" && email != "" && phone != "" && payment != "") {
            $.ajax({
               url: "<?php echo e(route('sendpaymentlink')); ?>?guest_type=new&name=" + name + "&email=" + email + "&phone=" + phone + "&advanced_payment=" + advanced_payment + "&booking_payment=" + booking_payment,
               type: "get",
               dataType: 'json',
               success: function(response) {
                  console.log(response);
                  alert('Payment Link Sent Sucessfully');
               }
            });

         } else {
            alert('Enter Customer Information');
         }




      }

   }


   function paytm_Send_Link() {
      var val = $('input[name="guest_type"]:checked').val();
      if (val == "existing") {
         var customer_id = $('input[name="selected_customer_id"]').val();
         if (customer_id == "") {
            alert('please select a customer');
         } else {

            $.ajax({
               url: "<?php echo e(route('paytmSendLink')); ?>?guest_type=existing&customer=" + customer_id,
               type: "get",
               dataType: 'json',
               success: function(response) {
                  console.log(response);
               }
            });

         }
      } else {
         var name = $('#name').val();
         var email = $('#email').val();
         var phone = $('#phone').val();
         var payment = $('#advance_payment').val();


         if (name != "" && email != "" && phone != "" && payment != "") {
            $.ajax({
               url: "<?php echo e(route('paytmSendLink')); ?>?guest_type=new&name=" + name + "&email=" + email + "&phone=" + phone + "&payment=" + payment,
               type: "get",
               dataType: 'json',
               success: function(response) {
                  console.log(response);
                  alert('Payment Link Sent Sucessfully');
               }
            });

         } else {
            alert('Enter Customer Information');
         }




      }
   }
</script>



<script type="text/javascript">
   $(function() {


      $('#btnSaveImage').click(function() {
         var url = $('#image-form').attr('action');
         var data = $('#image-form').serialize();



         $.ajax({
            type: 'POST',
            url: url,
            data: data,
            datatype: "JSON",
            success: function(responce) {

               $('#close').click();
               $('#image-form')[0].reset();

               var front = 'Your captured Front Side image will appear here..';
               var back = 'Your captured Back Side image will appear here...';

               $('.results_front_guest').html(front);
               $('.results_back_guest').html(back);

            },
            error: function() {
               alert('error');
            }
         });


      });
   });
</script>
<script>
   $(function() {


        $('#package_id').change(function() {
            var package_price = $(this).find(':selected').attr('data-price');
            var room_type = $(this).find(':selected').attr('data-room-type');
            if(package_price)
            {
               $("#package_price").val(package_price);
               $('#room_type_id > option ' ).each(function(index) {
                  if($(this).val() == room_type)
                  {
                     $('#room_type_id option').eq(index).prop('selected', true);
                  }
               });
               $("#package_price_div").show();
            }
            else{
               $("#package_price").val();
               $("#package_price_div").hide();
            }

         });

   });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/rooms/room_arrival_reservation_add_edit.blade.php ENDPATH**/ ?>