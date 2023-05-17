<?php $__env->startSection('content'); ?>
<?php 
      $flag=0;
      $heading=lang_trans('btn_add');
      if(isset($data_row) && !empty($data_row)){
          $flag=1;
          $heading=lang_trans('btn_update');
      }
  ?>
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e($heading); ?> <?php echo e(lang_trans('txt_room')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if($flag==1): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-room'),'id'=>"room-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-room'),'id'=>"room-form", 'class'=>"form-horizontal form-label-left"))); ?>

                  <?php endif; ?>
                  
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="room_no"> <?php echo e(lang_trans('txt_room_num')); ?><span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::number('room_no',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"room_no", "required"=>"required"])); ?>

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="room_floor"> <?php echo e(lang_trans('txt_floor')); ?><span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('floor',config('constants.ROOM_FLOOR'),null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>    
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="room_type_id"> <?php echo e(lang_trans('txt_room_type')); ?><span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('room_type_id',$roomtypes_list,null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>    
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_status')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('status',config('constants.LIST_STATUS'),1,['class'=>'form-control'])); ?>    
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Price</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo e(Form::number('price',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"room_Price", "required"=>"required"])); ?> 
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_maintinance')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('maintinance',config('constants.LIST_MAINTINANCE'),0,['class'=>'form-control',"id"=>"maintinance"])); ?>    
                          </div>
                      </div>

                      <p id="reason"></p>
                     
                      <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="reset"><?php echo e(lang_trans('btn_reset')); ?></button>
                              <button class="btn btn-success" type="submit"><?php echo e(lang_trans('btn_submit')); ?></button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
<script>
      $('#maintinance').change(function() {
                  var status = $(this).val();
                  if(status == 1)
                  {
                    var html = '';
                     html +=  '  <div class="form-group"> <label class="control-label col-md-3 col-sm-3 col-xs-12" for="room_no"> Describe Reason <span class="required">*</span></label>'+
                    '<div class="col-md-6 col-sm-6 col-xs-12">'+
                    `<?php echo e(Form::text('reason',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"reason", "required"=>"required"])); ?>`
                    '</div></div>';
                     $('#reason').html(html);
                  }
                  else{
                    $('#reason').html('');
                  }            
      });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/passerine/public_html/lajpatnagar.f9hotels.com/new/resources/views/backend/rooms/room_add_edit.blade.php ENDPATH**/ ?>