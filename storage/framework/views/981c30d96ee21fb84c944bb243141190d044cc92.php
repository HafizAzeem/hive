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
                  <h2><?php echo e($heading); ?> <?php echo e(lang_trans('heading_expense')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if($flag==1): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-expense'),'id'=>"expense-form", 'class'=>"form-horizontal form-label-left", "files"=>true))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-expense'),'id'=>"expense-form", 'class'=>"form-horizontal form-label-left", "files"=>true))); ?>

                  <?php endif; ?>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo e(lang_trans('txt_category')); ?> <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php echo e(Form::select('category_id',$category_list,null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>    
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> <?php echo e(lang_trans('txt_title')); ?> <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('title',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"title", "required"=>"required"])); ?>

                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount"> <?php echo e(lang_trans('txt_amount')); ?> <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('amount',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"amount", "required"=>"required"])); ?>

                          </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_date"> <?php echo e(lang_trans('txt_date')); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo e(Form::text('datetime',date('Y-m-d'),['class'=>"form-control col-md-6 col-xs-12 datePickerDefault1", "id"=>"expense_date", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])); ?>

                        </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="remark"> <?php echo e(lang_trans('txt_remark')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::textarea('remark',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"remark", "rows"=>1])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="attachments"> <?php echo e(lang_trans('txt_attachment')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::file('attachments[]',['class'=>"form-control",'id'=>'attachments','multiple'=>true])); ?>

                          </div>
                      </div>
                      <?php if( $flag==1 && $data_row->attachments->count()): ?>
                    <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="attachments"> <?php echo e(lang_trans('txt_uploaded_files')); ?></label>
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                              <tr>
                                <th><?php echo e(lang_trans('txt_sno')); ?>.</th>
                                <th><?php echo e(lang_trans('txt_name')); ?>.</th>
                                <th><?php echo e(lang_trans('txt_action')); ?></th>
                              </tr>
                              <?php if($data_row->attachments): ?>
                                <?php $__currentLoopData = $data_row->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($val->file!=''): ?>
                                    <tr>
                                      <td><?php echo e($k+1); ?></td>
                                      <td><?php echo e($val->file); ?></td>
                                      <td>
                                        <a href="<?php echo e(checkFile($val->file,'uploads/expenses/','blank_id.jpg')); ?>" data-toggle="lightbox"  data-title="<?php echo e(lang_trans('txt_attachment')); ?>" data-footer="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> </a>
                                        <a href="<?php echo e(checkFile($val->file,'uploads/expenses/','blank_id.jpg')); ?>" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>
                                       <button type="button" class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-mediafile',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
                                      </td>
                                    </tr>
                                  <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php else: ?>
                                <tr>
                                    <td colspan="2"><?php echo e(lang_trans('txt_no_file')); ?></td>
                                </tr>
                              <?php endif; ?>
                            </table>
                        </div>
                        <div class="col-sm-3">&nbsp;</div>
                    </div>
                  <?php endif; ?>
                      <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="reset">
                                  <?php echo e(lang_trans('btn_reset')); ?>

                              </button>
                              <button class="btn btn-success" type="submit">
                                  <?php echo e(lang_trans('btn_submit')); ?>

                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
<script>
  $(document).on('focus',".date", function(){ //bind to all instances of class "date". 
   $(this).datepicker();
});
  $(function() {
      $(".datePickerDefault").datepicker({
         dateFormat: 'yy-mm-dd',
         minDate: 0

      });
      $(".datePickerDefault1").datepicker({
         dateFormat: 'yy-mm-dd',
         changeMonth: true,
          changeYear: true,
          yearRange: "-90:+0"
      });
   });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/expenses/add_edit.blade.php ENDPATH**/ ?>