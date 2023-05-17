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
    
    .modal-header .close {
        margin-top: -30px;
        color: white;
        opacity: 1;
        background: red;
        padding: 5px;
    }
    .modal-dialog {
        width: 45%;
        /*margin: 30px auto;*/
    }
    .labelnew {
        font-size: 20px;
        color: black;
    }
    
    .meassagnewskip{
        color:red;
        font-size:16px;
    }
</style>

<script>
$(document).on('focus',".date", function(){ //bind to all instances of class "date".
    $(this).datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "-150:+0"
    });
});

$(document).on('focus',".date_adult", function(){ //bind to all instances of class "date".
    $(this).datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "-150:+0"
    });
});

$(function() {
    $(".datePickerDefault").datepicker({
        dateFormat: 'yy-mm-dd',
        format: 'L',
        minDate: 0

    });
    $(".datePickerDefault1").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "-150:+0"
    });
});
</script>

<?php 
  //$settings = getSettings();
  //$deluxroom = $settings['deluxroom'];
  //$premiumroom = $settings['premiumroom'];
  //$executiveroom = $settings['executiveroom'];
  //print_r($deluxroom);
    $verify = $data_row_personal->verifystatus ?? '0';
?>

<?php
$flag=0;
$heading=lang_trans('btn_add');
if(isset($data_row) && !empty($data_row)){
$flag=1;
$heading=lang_trans('btn_update');
}

$multi_room = '';//$data_row->room_num;
$multi_room_id = '';//$data_row->id;
$c=1;
$remark=DB::table('payment_remark')->get();

?>
<div class="">
  
   <?php echo e(Form::open(array('url'=>route('savecheckin'),'id'=>"add-reservation-form", 'class'=>"form-horizontal form-label-left",'files'=>true))); ?>

  
    <?php 
        $roomtypes = DB::table('room_types')->where('is_deleted', '0')->get();
        $deluxroom = $roomtypes[0]->base_price ?? '';
        $premiumroom = $roomtypes[1]->base_price ?? '';
        $executiveroom = $roomtypes[2]->base_price ?? '';
        // print_r($roomtypes[1]->base_price);
    ?>
    <input type="hidden" id="deluxroom" name="deluxroom" value="<?= $deluxroom; ?>">
    <input type="hidden" id="premiumroom" name="premiumroom" value="<?= $premiumroom; ?>">
    <input type="hidden" id="executiveroom" name="executiveroom" value="<?= $executiveroom; ?>">
   
   
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
                        <?php echo e(Form::text('Booking_id',$data_row->Booking_id ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"Booking_id", "placeholder"=>"Booking ID"])); ?>

                        <!--<input class="form-control col-md-6 col-xs-12" id="Booking_id" placeholder="Booking ID"  name="Booking_id" type="text" >-->
                    </div>
                    <?php $getmid = ($getmid->value + 1) ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> And Serial No. <span class="required">*</span></label>
                        <?php echo e(Form::text('and_number',$getmid ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"and_number", "placeholder"=>"And Number", 'required', 'disabled'])); ?>

                        <!--<input class="form-control col-md-6 col-xs-12" id="and_number" placeholder="And Number"  name="and_number" type="text" required>-->
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_fullname')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('name',$data_row->name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname'), 'required'])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_email')); ?> </label>
                        <?php echo e(Form::email('email',$data_row->email ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"email", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_email')])); ?>

                    </div>
                  
                  
                  <div class="col-md-4 col-sm-4 col-xs-12">
                        <div id="meassagnew" class="meassagnew text-danger"></div>
                        <label class="control-label"> Mobile No. <span class="required">*</span></label>
                        <input class="form-control col-md-6 col-xs-12" autocomplete="off" onkeyup="moblie(this.value)" length="10" id="mobile" placeholder="Enter Mobile No." required="" name="mobile" type="number" value="<?php echo e($data_row->mobile ?? $mobile); ?>">
                        <!--<select class="form-control col-md-6 col-xs-12" onkeyup="moblie(this.value)" length="10" id="mobile" placeholder="Enter Mobile No." required="" name="mobile">-->
                        <div id="find_numbuer">
                  
                  
                  
                        </div>
                        <?php 
                            //print_r($verify);
                            if($verify == 0) {
                        ?>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#arrivals_btn").prop('disabled', true);
                                    });
                                </script>
                                <div id="verifyfulldiv">
                                    <button class="btn btn-success sendotp" id="sendotp">SEND OTP</button>
                                    <a class="btn btn-success resendotp" id="resendotp" style="display:none;">RESEND OTP</a>
                                    <!--<a class="btn btn-success skipotp" id="skipotp" style="display:none;">Skip OTP</a>-->
                                    <!--<a class="btn btn-sm btn-danger btn-update-form" data-toggle="modal" data-target="#exampleModal689" value="689">Cancel</a>-->
                                    <button type="button" class="btn btn-primary skipotp" data-toggle="modal" data-target="#skipotp" style="display:none;">Skip OTP</button>
                                    <input type="number" name="enterotp" id="enterotp" class="form-control enterotp" placeholder="Enter Otp" disabled>
                                    <button class="btn btn-success verifyotp" id="verifyotp">VERIFY OTP</button>
                                </div>
                        <?php 
                            }
                        ?>
                        <!--<input type="number" class="form-control" id="verifyotp" placeholder="Enter Otp." required="" name="verifyotp">-->
                        <!--<a class="btn btn-primary btn-small" id="verifymobilebtn" style="margin-top: 5px;">Send Otp</a>-->
                        <!--<a class="btn btn-primary btn-small mt-2" id="verifyotpbtn" style="margin-top: 5px;">Verify Otp</a>-->
                        
                        <!--</select>-->
                  </div>
                

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> <span class="required">*</span></label>
                     <?php echo e(Form::select('gender',config('constants.GENDER'),$data_row->gender ?? '',['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), 'required'])); ?>

                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_age')); ?> </label>
                     <?php echo e(Form::text('age',$data_row->dob ?? '',['class'=>"form-control datePickerDefault1 col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off"])); ?>

                     <!-- <?php echo e(Form::number('age',$data_row->customer->age ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'),"min"=>10])); ?> -->
                  </div>

                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <label class="control-label"> Address </label>
                     <input class="form-control col-md-6 col-xs-12" id="Address" placeholder="Enter Address" autocomplete="off" name="Address" type="text" value="<?php echo e($data_row->address ?? ''); ?>">
                    
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
                  <div class="col-md-4 col-sm-2 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_adults')); ?> <span class="required">*</span></label>
                     <?php echo e(Form::number('adult',$data_row->adult ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"adult", "required"=>"required","placeholder"=>lang_trans('ph_enter').lang_trans('txt_adults'),"min"=>1, 'required'])); ?>

                  </div>
                  <div class="col-md-4 col-sm-2 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_kids')); ?> </label>
                     <?php echo e(Form::number('kids',$data_row->kids ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"kids","placeholder"=>lang_trans('ph_enter').lang_trans('txt_kids'),"min"=>0])); ?>

                  </div>
                  <div class="col-md-4 col-sm-2 col-xs-12">
                     <label class="control-label"> Infant (below 5) </label>
                     <?php echo e(Form::number('infant',$data_row->infant  ?? '',['class'=>"form-control col-md-7 col-xs-12", "id"=>"infant", "placeholder"=>" Infant (below 5) ","min"=>0])); ?>

                  </div>
               </div>
               <div class="row ">

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_meal_plan')); ?></label>
                     <?php echo e(Form::select('meal_plan',$mealplan_list ?? '',null,['class'=>'form-control',"id"=>"meal_plan",'placeholder'=>lang_trans('ph_select')])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_referred_by_name')); ?></label>
                     <?php echo e(Form::select('referred_by_name',config('constants.REFERRED_BY_NAME'),$data_row->referred_by_name ?? '',['class'=>"form-control col-md-6 col-xs-12", "id"=>"referred_by_name"])); ?>

                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> </label>
                    
                  </div>

                  <div id="corporate"></div>
               </div>
               <div class="row ">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_checkin')); ?><span class="required">*</span></label>
                        <?php
                        $d = new DateTime($data_row->check_in ?? '');
                         $dtPart = $d->format('Y-m-d');
                         $d2 = new DateTime($data_row->check_out ?? '');
                         $dtPart2 = $d2->format('Y-m-d');
                         ?>
                     <?php echo e(Form::text('check_in_date_my',$dtPart ?? '',['class'=>"form-control datePickerDefault col-md-6 col-xs-12", "id"=>"check_in_date_my", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off", 'required', 'disabled'])); ?>

                     <input type="hidden" name="check_in_date" value="<?= $dtPart; ?>">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label"> <?php echo e(lang_trans('txt_duration_of_stay')); ?> <span class="required">*</span></label>
                    <?php echo e(Form::number('duration_of_stay',1,['class'=>"form-control col-md-6 col-xs-12", "id"=>"duration_of_stay", "placeholder"=>lang_trans('txt_duration_of_stay'),"min"=>1, 'required'])); ?>

                 </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> Package</label>
                     <select class="form-control" name="package_id" id="package_id">
                        <option>--Select--</option>
                        <?php $__currentLoopData = $package_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo e($pack->id); ?>" data-price ="<?php echo e($pack->package_price); ?>" data-room-type="<?php echo e($pack->room_type_id); ?>"><?php echo e($pack->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
               </div>
               <div class="row">

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_room_type')); ?><span class="required">*</span></label>
                     <?php echo e(Form::select('room_type_id',$roomtypes_list ?? '',null,['class'=>'form-control',"id"=>"checkin_room_type_id",'placeholder'=>lang_trans('ph_select'), 'required'])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('No of Rooms')); ?> <span class="required">*</span></label>
                     <?php echo e(Form::number('no_of_rooms',1,['class'=>"form-control col-md-6 col-xs-12", "id"=>"no_of_rooms", "placeholder"=>lang_trans('No of Rooms'),"min"=>1, 'required'])); ?>

                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> Booking Reason <!-- <span class="required">*</span>--></label> 
                        <select class="form-control" name="Booking_Reason" id="package_id">
                           <option value=''>--Select--</option>
                           <option value='Personal'>Personal</option>
                           <option value='Business'>Business</option>
                           <option value='Leisure'>Leisure</option>
                        </select>
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
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2><?php echo e(lang_trans('heading_idcard_info')); ?></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content id_info">
               <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"><?php echo e(lang_trans('txt_type_id')); ?> </label>
                     <?php echo e(Form::select('idcard_type',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select')])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_id_number')); ?> </label>
                     <?php echo e(Form::text('idcard_no',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no","placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number')])); ?>

                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <label class="control-label"> <?php echo e(lang_trans('txt_document_upload')); ?> </label>
                     <?php echo e(Form::file('document_upload',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"document_upload","required"=>"required", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_document_upload')])); ?>

                  </div>
                  <sapn id="img"></sapn>
                  <sapn id="img1"></sapn>
               </div>


               <div class="row">
                  <h5>Capture Image:-</h5>
                  <div class="col-md-6">
                     <a href="javascript:" id="snap" class="btn btn-success">Open WebCam</a>
                     <a href="javascript:" id="snapclose" class="btn btn-success">Close WebCam</a>
                     <div id="my_camera">
                     </div>
                     <input type=button value="Take Snapshot Front" onClick="take_snapshot()">
                     <input type=button value="Take Snapshot Back" onClick="take_snapshot_back()">
                     <input type="hidden" name="id_cardno[]" id="id_card" class="id_cardno_front">
                     <input type="hidden" name="id_cardno[]" id="id_card_back" class="id_cardno_back">
                  </div>
                  <div class="col-md-3">
                     <div id="resultss">Your captured Front Side image will appear here...</div>
                  </div>
                  <div class="col-md-3">
                     <div id="results-back">Your captured Back Side image will appear here...</div>
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
               <h2><?php echo e(lang_trans('heading_person_info')); ?></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="persons_info_parent">


               </div>
               <div class="persons_info_kids">
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="colne_persons_info_elem hide_elem">
   <div class="row persons_info_elem">
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_name')); ?> </label>
         <?php echo e(Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> </label>
         <?php echo e(Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_age')); ?> </label>
         <?php echo e(Form::text('persons_info[age][]',null,['class'=>"form-control date_adult col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off", "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-2 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_document_upload')); ?> <span class="required">*</span></label>
         <input type="file" name="persons_info[document_upload1][]" id="form-file" class="persons_document_upload" form="add-reservation-form" />
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
         <?php echo e(Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"><?php echo e(lang_trans('txt_id_number')); ?> </label>
         <?php echo e(Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> &nbsp;</label><br />
         <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
      </div>
   </div>
</div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2><?php echo e(lang_trans('heading_payment_info')); ?></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-12" id="management">
                        <label>Total Price</label>
                        <input type="text" class="form-control" name="total_amount" required id="total_amount" placeholder="Total Price">
                        <input type="hidden" name="perroommainprice" id="perroommainprice">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('Price per Room')); ?> <span class="required" id="booking_payment_span">*</span></label>
                        <?php echo e(Form::text('booking_payment','',['class'=>"form-control col-md-7 col-xs-12 perroomprice", "id"=>"booking_payment", "placeholder"=>"Per Room Price","required", 'disabled'])); ?>

                    </div>
                    
                    <div class="col-md-3 col-sm-3 col-xs-12" id="management">
                        <label class="control-label"> <?php echo e(lang_trans('txt_advance_payment')); ?></label>
                        <?php echo e(Form::number('advance_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"advance_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_advance_payment'),"min"=>0])); ?>

                    </div>
                  
                  <!--<div class="col-md-3 col-sm-3 col-xs-12">-->
                  <!--   <label class="control-label"><span class="required">*</span> </label>-->
                  <!--   -->
                  <!--</div>-->
                  
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label"><span class="required">*</span> <?php echo e(lang_trans('txt_payment_mode')); ?></label>
                        <select name="payment_mode" class="form-control col-md-6 col-xs-12 select_id" id="payment" required>
                            
                        </select>
                    </div>
                  
                  <!--<label class="control-label"> &nbsp;lang_trans('ph_enter').lang_trans('Booking Payment')</label><br />-->
                    <div class="col-md-1">
                        <button type="button" onclick="plus()" style="margin-top:25px" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>
                    </div>
                  <!--<button type="button" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>-->
               </div>
               
               <!--Add Payment Jatin-->
               <?php 
                $a=1;
                for($p=0;$p<20;$p++)
                {
                     
                ?>
                <div class="row" id="remove<?= $a ;?>" style="display:none">  
                    <div class="col-md-4">                            
                        <label class="control-label">Payment</label>        
                        <input class="form-control col-md-4 col-xs-4" placeholder="Enter Advance Payment" name="payment[]" min="0" type="number">                        
                    </div>                         
                    <div class="col-md-3">                             
                        <label>Remark</label>                                
                        <select class="form-control" name="payment_remark[]">
                            <?php $__currentLoopData = $remark; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value='<?php echo e($r->title); ?>'><?php echo e($r->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </select>  
                    </div>                        
                    <div class="col-md-3">                            
                        <label class="control-label"> Payment Mode</label>                            
                         <?php echo e(Form::select('mode[]',$payment_mode_list,'',['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])); ?>

                        </select>                       
                    </div>
                    <div class="col-md-2"> 
                        <button type="button" onclick="remove_addon(<?= $a; ?>)" style="margin-top:25px" class="btn btn-danger add-new-advance"><i class="fa fa-minus"></i></button>     
                    </div>
                    
                </div>
                    
                <?php $a++; } ?>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <p style="font-size:18px;" id="pending_amount"></p>
                    </div>
                </div>
                
                
               <!--Add Payment Jatin End-->
               
               <!--<div class="row" id="second_advance">-->
               <!--   <div class="col-md-3 col-sm-3 col-xs-12">-->
               <!--      <label class="control-label"> <?php echo e(lang_trans('txt_booking_payment')); ?></label>-->
               <!--      <?php echo e(Form::text('sec_booking_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"sec_booking_payment", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_booking_payment'),"min"=>0, "disabled"])); ?>-->
               <!--   </div>-->
               <!--   <div class="col-md-3 col-sm-3 col-xs-12" id="sec_management">-->
               <!--      <label class="control-label"> <?php echo e(lang_trans('txt_advance_payment')); ?></label>-->
               <!--      <?php echo e(Form::number('sec_advance_payment',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"sec_advance_payment","placeholder"=>lang_trans('ph_enter').lang_trans('txt_advance_payment'),"min"=>0])); ?>-->
               <!--   </div>-->
               <!--   <div class="col-md-3 col-sm-3 col-xs-12">-->
               <!--      <label class="control-label"> <?php echo e(lang_trans('txt_payment_mode')); ?></label>-->
               <!--      <?php echo e(Form::select('sec_payment_mode',config('constants.PAYMENT_MODES'),null,['class'=>"form-control col-md-6 col-xs-12","id"=>"payment2", "placeholder"=>"--Select"])); ?>-->
               <!--   </div>-->
               <!--   &nbsp; <br />-->
               <!--   <button type="button" class="btn btn-danger remove-second-advance"><i class="fa fa-minus"></i></button>-->
               <!--   <button class="btn btn-success" style="display:none" id="first2" type="button" onclick="payment_link()"><?php echo e(lang_trans('Verify')); ?></button>-->
               <!--   <button class="btn btn-success" style="display:none" id="first4" type="button" onclick="paytm_Send_Link()"><?php echo e(lang_trans('Verify')); ?></button>-->

               <!--</div>-->
               <div class="ln_solid"></div>
               <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                  <button class="btn btn-success" style="display:none" id="first" type="button" onclick="payment_link()"><?php echo e(lang_trans('Verify')); ?></button>
                  <button class="btn btn-success btn-submit-form" type="button" id="arrivals_btn"><?php echo e(lang_trans('btn_submit')); ?></button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" id="arrivals_id" name="arrivals_id" value="<?= $arrivals_id; ?>">
   <?php echo e(Form::close()); ?>

   
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Previous Booking Detail</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="row">
                   
                   <table class="table">
                       <tr>
                           <th>Hotel Name</th>
                           <th>Mobile</th>
                           <th>Checkin</th>
                           <th>Checkout</th>
                           <th>Payment</th>
                       </tr>
                       <?php if(isset($booking)): ?>
                       <?php $__currentLoopData = $booking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <tr>
                           <td><?php echo e($v->hotel); ?></td>
                           <td><?php echo e($v->mobile); ?></td>
                           <td><?php echo e($v->checkin); ?></td>
                           <td><?php echo e($v->checkout); ?></td>
                           <td><?php echo e($v->payment); ?></td>
                       </tr>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       <?php endif; ?>
                       
                   </table>
                   
                   </div>
                   </div>
                   </div>
                     </div>
                       </div>
                   
   
   
   
</div>
<!-- Modal -->

<div class="modal fade skipotpmodel" id="skipotp" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">SKIP OTP REASON</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding:5%;">
                    <div class="meassagnewskip"> </div>
                    <label class="labelnew">Reason</label>
                    <input type="text" class="form-control" name="skipotpreason" id="skipotpreason" required>
                    <br>
                    <a type="button" class="btn btn-primary" id="skipreason">Submit Reason</a>
                </div>
            </div>
        </div>
    </div>
</div>
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

<div class="modal fade" id="requestmodel">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestmodelLabel">MAKE ADMIN REQUEST</h5>
            </div>
            <form action="#" method="get">
                <?php echo csrf_field(); ?>
                <div class="row">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="">
                    Send Request
                    </button>
                    <button type="button" id="close" class="btn btn-secondary" data-mdb-dismiss="modal">
                    Close
                    </button>
                </div>
            </form>
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
         <?php echo e(Form::text('persons_info[name][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"person_name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_name'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_gender')); ?> </label>
         <?php echo e(Form::select('persons_info[gender][]',config('constants.GENDER'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_age')); ?> </label>
         <?php echo e(Form::text('persons_info[age][]',null,['class'=>"form-control date col-md-6 col-xs-12", "id"=>"person_age", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_age'), "autocomplete"=>"off", "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-2 col-sm-1 col-xs-12">
         <label class="control-label"> <?php echo e(lang_trans('txt_document_upload')); ?> <span class="required">*</span></label>
         <input type="file" name="persons_info[document_upload1][]" id="form-file" class="persons_document_upload" form="add-reservation-form" />
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
         <?php echo e(Form::select('persons_info[idcard_type][]',config('constants.TYPES_OF_ID'),null,['class'=>'form-control col-md-6 col-xs-12','placeholder'=>lang_trans('ph_select'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
         <label class="control-label"><?php echo e(lang_trans('txt_id_number')); ?> </label>
         <?php echo e(Form::text('persons_info[idcard_no][]',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"idcard_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_id_number'), "form"=> "add-reservation-form"])); ?>

      </div>
      <div class="col-md-1 col-sm-1 col-xs-12">
         <label class="control-label"> &nbsp;</label><br />
         <button type="button" class="btn btn-danger delete-row"><i class="fa fa-minus"></i></button>
      </div>
   </div>
</div>

<script>

    $("#verifyotp").attr('disabled','disabled');
    $("#enterotp").attr('disabled','disabled');
    //$("#skipotp").attr('disabled','disabled');

    $("#sendotp").click(function (e) {
        e.preventDefault();
        var mobileno = $('#mobile').val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        var otp = Math.floor(1000 + Math.random() * 9000);
        if (filter.test(mobileno)) {
            if(mobileno.length!=10){
                $('.meassagnew').fadeIn('slow', function(){
                    $(".meassagnew").html("Please Enter Valid Mobile Number");
                    $('.meassagnew').delay(3000).fadeOut(); 
                });
                
            }else{
                $.ajax({
                    type:'POST',
                    url:"<?php echo e(route('mobotpchekin')); ?>",
                    data:{"_token": "<?php echo e(csrf_token()); ?>",mobile:mobileno,otp:otp},
                    success:function(data){
                        console.log(data);
                        if(data != 406){
                            
                            // $("#sendotp").attr('disabled','disabled');
                            $("#sendotp").prop('disabled', true);
                            
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Send Successfully");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                           
                            $("#enterotp").removeAttr('disabled');
                            $("#verifyotp").removeAttr('disabled');
                            $(".skipotp").show();
                            $( "#resendotp" ).show();
                            
                        }else{
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Not Send");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                        }
                        
                    }
                });
            }
        }
        else{
            $(".meassagnew").html("Server Error");
        }
        
    });
    
    $("#resendotp").click(function (e) {
        e.preventDefault();
        var mobileno = $('#mobile').val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        var otp = Math.floor(1000 + Math.random() * 9000);
        if (filter.test(mobileno)) {
            if(mobileno.length!=10){
                $('.meassagnew').fadeIn('slow', function(){
                    $(".meassagnew").html("Please Enter Valid Mobile Number");
                    $('.meassagnew').delay(3000).fadeOut(); 
                });
                
            }else{
                $.ajax({
                    type:'POST',
                    url:"<?php echo e(route('mobotpchekin')); ?>",
                    data:{"_token": "<?php echo e(csrf_token()); ?>",mobile:mobileno,otp:otp},
                    success:function(data){
                        console.log(data);
                        if(data != 406){
                            
                            // $("#sendotp").attr('disabled','disabled');
                            $("#sendotp").prop('disabled', true);
                            
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Send Successfully");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                           
                            $("#enterotp").removeAttr('disabled');
                            $("#verifyotp").removeAttr('disabled');
                            
                        }else{
                            $('.meassagnew').fadeIn('slow', function(){
                                $(".meassagnew").html("Otp Not Send");
                                $('.meassagnew').delay(3000).fadeOut(); 
                            });
                        }
                        
                    }
                });
            }
        }
        else{
            $(".meassagnew").html("Server Error");
        }
        
    });
    
    $("#verifyotp").click(function (e) {
        e.preventDefault();
        var mobileno = $('#mobile').val();
        var enterotp = $('#enterotp').val();
        if(enterotp == '') {
            $(".meassagnew").html("Please Enter Valid Otp");
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:"<?php echo e(route('verifyotpchekin')); ?>",
                // dataType: 'json',
                data:{"_token": "<?php echo e(csrf_token()); ?>",mobileno:mobileno,enterotp:enterotp},
                success:function(data){
                    console.log(data);
                    if(data == 1){
                        $('.meassagnew').fadeIn('slow', function(){
                            $(".meassagnew").html("Otp Verified");
                            $('.meassagnew').delay(3000).fadeOut(); 
                        });
                        $("#verifyotp").prop('disabled', true);
                        $(".btnhide").css("display", "block");
                        $("#arrivals_btn").removeAttr('disabled');
                        $("#verifyfulldiv").css("display", "none");
                        
                        //$("#arrivals_btn").prop('disabled', false);
                    }else{
                        $(".meassagnew").html("Otp Not Verified");
                    }
                }
            });
        }
        
    });
    
    $("#skipreason").click(function (e) {
        e.preventDefault();
        var mobileno = $('#mobile').val();
        var enterreason = $('#skipotpreason').val();
        if(enterreason == '') {
            $('.meassagnewskip').fadeIn('slow', function(){
                $(".meassagnewskip").html("Please Enter Valid Reason");
                $('.meassagnewskip').delay(3000).fadeOut(); 
            });
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:"<?php echo e(route('skipotp')); ?>",
                // dataType: 'json',
                data:{"_token": "<?php echo e(csrf_token()); ?>",mobileno:mobileno,enterreason:enterreason},
                success:function(data){
                    console.log(data);
                    if(data == 1){
                        $('.meassagnew').fadeIn('slow', function(){
                            $(".meassagnew").html("Reason Submited Successfully");
                            $('.meassagnew').delay(3000).fadeOut(); 
                        });
                        
                        $("#arrivals_btn").removeAttr('disabled');
                        $("#verifyfulldiv").css("display", "none");
                        $('#skipotp').modal('hide');
                        
                    }else{
                        $(".meassagnewskip").html("Reason Not Submited..");
                    }
                }
            });
        }
        
    });

    $("#checkin_room_type_id").click(function(){
        var roomtypeidnew = $("#checkin_room_type_id").val();
        if(roomtypeidnew == 1){
            var duration_of_stay = parseFloat($("#duration_of_stay").val());
            var no_of_rooms = parseFloat($("#no_of_rooms").val());
            var deluxroom = parseFloat($("#deluxroom").val());
            var prpnew = $(".perroomprice").val(deluxroom);
            var prpj = $("#perroommainprice").val(deluxroom);
            //
            var totalpricetab = duration_of_stay*no_of_rooms*deluxroom;
            alert(totalpricetab);
            var totalprice = (totalpricetab).toFixed(2);
            $("#total_amount").val(totalprice);
            //
        }
        if(roomtypeidnew == 2){
            var duration_of_stay = parseFloat($("#duration_of_stay").val());
            var no_of_rooms = parseFloat($("#no_of_rooms").val());
            var premiumroom = parseFloat($("#premiumroom").val());
            var prpnew = $(".perroomprice").val(premiumroom);
            var prpj = $("#perroommainprice").val(premiumroom);
            //
            var totalpricetab = duration_of_stay*no_of_rooms*premiumroom;
            alert(totalpricetab);
            var totalprice = (totalpricetab).toFixed(2);
            $("#total_amount").val(totalprice);
            //
        }
        if(roomtypeidnew == 3){
            var duration_of_stay = parseFloat($("#duration_of_stay").val());
            var no_of_rooms = parseFloat($("#no_of_rooms").val());
            var executiveroom = parseFloat($("#executiveroom").val());
            var prpnew = $(".perroomprice").val(executiveroom);
            var prpj = $("#perroommainprice").val(executiveroom);
            //
            var totalpricetab = duration_of_stay*no_of_rooms*executiveroom;
            alert(totalpricetab);
            var totalprice = (totalpricetab).toFixed(2);
            $("#total_amount").val(totalprice);
            //
        }
    });    

    $('#referred_by_name').ready(function() {
        var status = $('#referred_by_name').val();
        if (status == 'Corporate') {
            var html = '';
            html +=
                ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
                '<label class="control-label">Corporate</label>'+
                `<select name="corporate" class="form-control col-md-6 col-xs-12">
                <?php $__currentLoopData = $corporates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($corp); ?>" <?php if($data_row == $corp): ?>? selected <?php endif; ?>><?php echo e($corp); ?></option>
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
               <option value="<?php echo e($corp); ?>" selected><?php echo e($corp); ?></option>
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
             `<select name="ota" class="form-control col-md-6 col-xs-12 myotaall">
                <?php $__currentLoopData = $ota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo e($corp->name); ?>" data-ota="<?php echo e($corp->id); ?>"><?php echo e($corp->name); ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>`;
            $('#corporate').html(html);
        }
        else if(status == 'Management')
        {
            $('#management').hide();
            $('#sec_management').hide();
      }
        else {
            $('#corporate').html('');
        }
    });
    $('#referred_by_name').change(function() {
        var status = $(this).val();
        if (status == 'Corporate') {
         var html = '';
         html +=
         ' <div class="col-md-4 col-sm-4 col-xs-12" id="bookingid">'+
         '<label class="control-label">Corporate</label>'+
         `<select name="corporate" class="form-control col-md-6 col-xs-12">
           <?php $__currentLoopData = $corporates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <option value="<?php echo e($corp); ?>" selected><?php echo e($corp); ?></option>
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
           <option value="<?php echo e($corp); ?>" selected><?php echo e($corp); ?></option>
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
         `<select name="ota" class="form-control col-md-6 col-xs-12 myotaall valid" id="ota_new" aria-invalid="false">
         <option value="" data-ota="1">Select</option>
                           <option value="FAB" data-ota="1">FAB</option>
                              <option value="BOOKING" data-ota="2">BOOKING</option>
                              <option value="GOMMIT" data-ota="3">GOMMIT</option>
                              <option value="AGODA" data-ota="4">AGODA</option>
                              <option value="HAPPYEASYGO" data-ota="5">HAPPYEASYGO</option>
                              <option value="BREVISTAY" data-ota="6">BREVISTAY</option>
                              <option value="BAG2BAG" data-ota="7">BAG2BAG</option>
                              <option value="STAYUNCLE" data-ota="8">STAYUNCLE</option>
                              <option value="OTA" data-ota="9">OTA</option>
                              <option value="OYO" data-ota="10">OYO</option>
                              <option value="Cleartrip" data-ota="11">Cleartrip</option>
                              <option value="EasyMyTrip" data-ota="12">EasyMyTrip</option>
                              <option value="Airbnb" data-ota="13">Airbnb</option>
                              <option value="Expedia" data-ota="14">Expedia</option>
                              <option value="Hourlyrooms" data-ota="15">Hourlyrooms</option>
                              <option value="EGlobe" data-ota="16">EGlobe</option>
                              <option value="Cherish" data-ota="17">Cherish</option>
                              <option value="Qwiksta" data-ota="18">Qwiksta</option>
                              <option value="Jack" data-ota="27">Jack</option>
                      </select>`;
         $('#corporate').html(html);
      }
        else if(status == 'Management')
        {
         $('#management').hide();
         $('#sec_management').hide();
      }
        else {
         $('#corporate').html('');
      }
    });
    $(".myotaall").ready(function() {
        var id = 1;
        // alert(id);
        $.ajax({
            type:'POST',
            url:"<?php echo e(route('myotaalldata3')); ?>",
            data:{"_token": "<?php echo e(csrf_token()); ?>",id:id},
            success:function(data){
                var isDefault = id;
                //console.log(isDefault);
                var selectj = '';
                var defaultset = "";
                $.each(data,function(key, value){
                    
                    if (value.otarelation == isDefault)  {
                        console.log(value.otarelation);
                        defaultset =  'selected';
                        selectj += '<option value=' + value.id +' class="test" '+ defaultset +'>' + value.payment_mode + '</option>';
                    }else{
                        selectj += '<option value=' + value.id + '>' + value.payment_mode + '</option>';
                    }
                    
                });
                $(".select_id").html(selectj);
                
            }
        });
        
    });
        
    
        $(document).ready(function() {
           
            // $("#arrivals_btn").attr("disabled", true);
            $("#check_in_date_my").datepicker({
              startDate: '-0d',
            });
            $(document).on('click', '.btn-submit-form', function(e) {
                v = $(check_in_date_my).val();
                // v1 = $(check_out_date_my).val();
                var d1 = new Date(v);
                //  var d2 = new Date(v1);
                //                  if (d2 < d1) {
                //                     swal({
                //                        type: 'error',
                //                        title: 'Oops...',
                //                        text: 'Checkout should be greater than check in',
                //                     })
                //            e.preventDefault();
                // }
            });

            // $('#referred_by').change(function() {
            //    var status = $(this).val();
            //    if (status == 'ThirdParty') {
            //       var html = '';
            //       html +=
            //          '<label for="validationServerUsername">Booking ID</label>' +
            //          '<input type="text" class="form-control" name="booking_id" id="" >';
            //       $('#booking_id').html(html);
            //    } else {
            //       $('#booking_id').remove();
            //    }
            // });
            
            $(".myotaall").on('change', function() {
                var id = $(this).find(':selected').attr('data-ota');
                alert(id);
                
                $.ajax({
                    type:'POST',
                    url:"<?php echo e(route('myotaalldata')); ?>",
                    data:{"_token": "<?php echo e(csrf_token()); ?>",id:id},
                    success:function(data){
                        var isDefault = id;
                        //console.log(isDefault);
                        var selectj = '';
                        var defaultset = "";
                        $.each(data,function(key, value){
                            
                            if (value.otarelation == isDefault)  {
                                console.log(value.otarelation);
                                defaultset =  'selected';
                                selectj += '<option value=' + value.id +' class="test" '+ defaultset +'>' + value.payment_mode + '</option>';
                            }else{
                                selectj += '<option value=' + value.id + '>' + value.payment_mode + '</option>';
                            }
                            
                        });
                        $(".select_id").html(selectj);
                        
                    }
                });
                
            });
        
            $(document).on('change',"#ota_new", function() {
                
                var id = $(this).find(':selected').attr('data-ota');
                // alert(id);
                
                $.ajax({
                    type:'POST',
                    url:"<?php echo e(route('myotaalldata')); ?>",
                    data:{"_token": "<?php echo e(csrf_token()); ?>",id:id},
                    success:function(data){
                        var isDefault = id;
                        //console.log(isDefault);
                        var selectj = '';
                        var defaultset = "";
                        $.each(data,function(key, value){
                            
                            if (value.otarelation == isDefault)  {
                                console.log(value.otarelation);
                                defaultset =  '';
                                selectj +=  '<option value=' + value.id +' class="test" '+ defaultset +'>' + value.payment_mode + '</option>';
                            }else{
                                selectj += '<option value=' + value.id + '>' + value.payment_mode + '</option>';
                            }
                            
                        });
                        $(".select_id").html(selectj);
                        
                    }
                });
                
            });
        });

// function payment_mode(){
//     alert('hello');
//     $("#payment option[value='35']").attr("selected", "selected");
//     // $("#payment").parent().click();
//     // $("#payment").append("<option value='0'>Select</option>");
//     // $('#payment').prop(val==35).selected;
    
// }



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

        $("#advance_payment").keyup(function() {
            var advanced_payment = document.getElementById("advance_payment").value;
            var duration_of_stay = document.getElementById("duration_of_stay").value;
            var no_of_rooms = document.getElementById("no_of_rooms").value;
            var booking_payment = document.getElementById("booking_payment").value;
               
            var total_amount=document.getElementById("total_amount").value;
                
            var pending_amount=total_amount-advanced_payment;
                  
            $("#pending_amount").html("Pending Amount "+pending_amount);
               
            if((booking_payment * duration_of_stay * no_of_rooms)<advanced_payment)
            {
                $("#advance_payment").val('');
                $("#pending_amount").html("Pending Amount "+0);
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Invalid Amount',
                })
            }
        });
        
        // total price according to duration and room count 
        
        $("#duration_of_stay").keyup(function(){
            var duration_of_stay=$("#duration_of_stay").val();
            var no_of_rooms=$("#no_of_rooms").val();
            var prpnew = $(".perroomprice").val();
            var totalpricenew = duration_of_stay*no_of_rooms*prpnew;
            var totalpriced = (totalpricenew).toFixed(2);
            $("#total_amount").val(totalpriced);
        })
         
        $("#no_of_rooms").keyup(function(){
            var no_of_rooms=$("#no_of_rooms").val();
            var duration_of_stay=$("#duration_of_stay").val();
            var prpnew = $(".perroomprice").val();
            var totalpricenew = no_of_rooms*duration_of_stay*prpnew;
            var totalpricen = (totalpricenew).toFixed(2);
            $("#total_amount").val(totalpricen);
        })
        
        // total price according to duration and room count CODE END
        
        $("[name=total_amount]").keyup(function(){
             var total_amount=$(this).val();
             var duration_of_stay=$("#duration_of_stay").val();
             var no_of_rooms=$("#no_of_rooms").val();
             var duration_roooms = duration_of_stay*no_of_rooms;
             var price_per_room=total_amount/duration_roooms;
             var price_per_room = (price_per_room).toFixed(2);
             $("#booking_payment").val(price_per_room);
             $("#booking_payment_span").html(" ");
             // $("#booking_payment").prop('disabled',true);
         })
         
        // $("#duration_of_stay").keyup(function(){
        //      var total_amount=$("[name=total_amount]").val();
        //      var duration_of_stay=$("#duration_of_stay").val();
        //      var no_of_rooms=$("#no_of_rooms").val();
        //      var duration_roooms = duration_of_stay*no_of_rooms;
        //      var price_per_room=total_amount/duration_roooms;
        //      var price_per_room = (price_per_room).toFixed(2);
        //      $("#booking_payment").val(price_per_room);
        //     // $("#booking_payment").prop('disabled',true);
        //  })
         
        // $("#no_of_rooms").keyup(function(){
        //      var total_amount=$("[name=total_amount]").val();
        //      var no_of_rooms=$("#no_of_rooms").val();
        //      var duration_of_stay=$("#duration_of_stay").val();
        //      var duration_roooms = duration_of_stay*no_of_rooms;
        //      var price_per_room=total_amount/duration_roooms;
        //      var price_per_room = (price_per_room).toFixed(2);
        //      $("#booking_payment").val(price_per_room);
        //     // $("#booking_payment").prop('disabled',true);
        //  })

        $("#adult").keyup(function() {
           
           var value = $("#adult").val();
           var i = 1;
           $(".persons_info_parent").empty();
           for (i; i <= value - 1; i++) {
              var html = $(".colne_persons_info_elem").html();
              $(".persons_info_parent").append(html);
              $('.date_adult:last').attr('id', 'adult_'+i);
            //   .promise()
            //   .done(function() {
            //   $(".persons_info_parent").find(".datePickerDefault1").datepicker({
            //              changeMonth: true,
            //               changeYear: true,
            //               yearRange: "-50:+0"
            //           });
            //     });
           }
           
           var customer_id = $('input[name="selected_customer_id"]').val();
           $.ajax({
               url : '<?php echo e(route("getDocument")); ?>?customer_id='+customer_id,
               type : 'GET',
               dataType: 'json',
               success : function(res)
               {
                   
                  $("[name=idcard_type]").val(res.idcard_type);
                  $("[name=idcard_no]").val(res.idcard_no);
                  var img="<?php echo e(asset('storage/app')); ?>"+'/'+res.document;
                  $("#img").html("<img src='"+img+"' height='50' width='70'>")
                  $("#img1").html("<input type='hidden' name='document_id' value='"+res.document+"'>")
               }
           })
           
        });
        $("#adult").change(function() {
           
           var value = $("#adult").val();
           var i = 1;
           $(".persons_info_parent").empty();
           for (i; i <= value - 1; i++) {
              var html = $(".colne_persons_info_elem").html();
               $(".persons_info_parent").append(html);
                 $('.date_adult:last').attr('id', 'adult_'+i);
            //   .promise()
            //   .done(function() {
            //   $(".persons_info_parent").find(".datePickerDefault1").datepicker({
            //              changeMonth: true,
            //               changeYear: true,
            //               yearRange: "-50:+0"
            //           });
            //     });
           }
        });
        $("#kids").keyup(function() {
          
           var value = $("#kids").val();
           var i = 0;
           $(".persons_info_kids").empty();
           for (i; i <= value - 1; i++) {
              var html = $(".colne_persons_info_kids").html();
              $(".persons_info_kids").append(html);
              $('.date:last').attr('id', 'kids_'+i);
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
              $('.date:last').attr('id', 'kids_'+i);
           }
        });


        globalVar.page = 'room_reservation_add';
        </script>
<script type="text/javascript" src="<?php echo e(asset('public/js/page_js/page.js')); ?>"></script>
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
      var booking_amount = $("#booking_payment").val();
      $("#sec_booking_payment").val(booking_amount);

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
         var duration_of_stay = $('#duration_of_stay').val();
         var booking_payment = $('#booking_payment').val();
         // var payable= booking_payment - advanced_payment ;
         // alert(payable);
         if (customer_id == "") {
            alert('please select a customer');
         } 
         else {

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
    //   $(function() {
    //         $('#package_id').change(function() {
    //             var package_price = $(this).find(':selected').attr('data-price');
    //             var room_type = $(this).find(':selected').attr('data-room-type');
    //             if(package_price)
    //             {
    //               $("#booking_payment").val(package_price);
    //               $('#room_type_id > option ' ).each(function(index) {
    //                   if($(this).val() == room_type)
    //                   {
    //                      $('#room_type_id option').eq(index).prop('selected', true);
    //                   }
    //               });
    
    //             }
    //             else{
    //               $("#booking_payment").val();
    //             }
    
    //          });
    
    //   });

    $("#arrivals_btn").click(function(event){
        // alert('hello');return false;
          var payment_id= $('#payment').val();
            //  alert(payment_id);
             if(payment_id==0){
                alert('Please select payment mode'); 
                return false;
             }
       
         event.preventDefault();
        var flag_num = $("#flag_num").val();
        var booking_payment = parseFloat($("#booking_payment").val());
        var perroommainprice = parseFloat($("#perroommainprice").val());
        if(booking_payment < perroommainprice)
        {
            $("#booking_payment_span").html("* Per Room Price Should Be Greter Or Equal To " + perroommainprice);
            $("#requestmodel").modal('show');
        }
        else{
            if(flag_num == 1)
            {
                // $('#total_amount').removeAttr("disabled");
                $('#booking_payment').removeAttr("disabled");
                $("#update-reservation-form").submit();
            }
            else
            {
                // $('#total_amount').removeAttr("disabled");
                $('#booking_payment').removeAttr("disabled");
                $("#add-reservation-form").submit();
            }
        }
    });
   
    //   new final submit code 
        // $("#arrivals_btn").click(function(){
        //     var flag_num = $("#flag_num").val();
        //     var booking_payment = parseFloat($("#booking_payment").val());
            
        //     var roomtypeidnew = $("#checkin_room_type_id").val();
        //     // alert(roomtypeidnew);
           
        //     if(roomtypeidnew == 1){
        //         var deluxroom = parseFloat($("#deluxroom").val());
        //         // alert("true");
        //         if( booking_payment < deluxroom ){
        //             // alert(deluxroom);
        //             // alert(booking_payment);
        //             $("#booking_payment_span").html("* Booking amount should be Equal or greater than Delux Room Price ");
        //         }else{
        //             if(flag_num == 1)
        //             {
        //                 $('#booking_payment').removeAttr("disabled");
        //                 $("#update-reservation-form").submit();
        //             }
        //             else
        //             {
        //                 $('#booking_payment').removeAttr("disabled");
        //                 $("#add-reservation-form").submit();
        //             }
                  
        //         }
        //     } 
            
        //     if(roomtypeidnew == 2){
        //         var premiumroom = parseFloat($("#premiumroom").val());
        //         // alert(premiumroom);
        //         // alert(booking_payment);
        //         if(booking_payment < premiumroom ){
        //         //   alert("condition2");
        //           $("#booking_payment_span").html("* Booking amount should be Equal or greater than Premium Room Price ");
        //         }else{
        //             if(flag_num == 1)
        //             {
        //                 $('#booking_payment').removeAttr("disabled");
        //                 $("#update-reservation-form").submit();
        //             }
        //             else
        //             {
        //                 $('#booking_payment').removeAttr("disabled");
        //                 $("#add-reservation-form").submit();
        //             }
                  
        //         }
        //     }
            
        //     if(roomtypeidnew == 3){
        //         var executiveroom = parseFloat($("#executiveroom").val());
        //         // alert(booking_payment);
        //         // alert("true3");
        //         if(booking_payment < executiveroom ){
        //             // alert("condition3");
        //             $("#booking_payment_span").html("* Booking amount should be Equal or greater then Executive Room Price ");
        //         }else{
        //                 if(flag_num == 1)
        //                 {
        //                     $('#booking_payment').removeAttr("disabled");
        //                     $("#update-reservation-form").submit();
        //                 }
        //                 else
        //                 {
        //                     $('#booking_payment').removeAttr("disabled");
        //                     $("#add-reservation-form").submit();
        //                 }
                      
        //         }
        //     }
            
        //     $("#arrivals_btn").prop('disabled', true);
        //     enable();
        // });
    // final submit code end 

    function moblie(w)
    {
        console.log(w);
        $.get("<?php echo e(url('/mob')); ?>",
        {
            mob: w
        },
        function(data, status){
            document.getElementById("find_numbuer").innerHTML = data
            // alert("Data: " + data + "\nStatus: " + status);
        });
    }
    
    $('#arrivals_btn').on('click', function() {
        $("#arrivals_btn").prop('disabled', true);
        enable();
    });

    function enable()
    {
        setTimeout(function(){
            $("#arrivals_btn").prop('disabled', false);}
        ,5000);
    }
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
<script>

    $('#rooms_list').on('click', function() {
        // alert('hello');
        // $("#arrivals_btn").removeAttr('disabled');
    $("#arrivals_btn").attr('disabled', true);
    });
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/rooms/newcheckin.blade.php ENDPATH**/ ?>