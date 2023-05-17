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
                  <h2><?php echo e($heading); ?> OTA </h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php if($flag==1): ?>
                      <?php echo e(Form::model($data_row,array('url'=>route('save-ota-withpaymentmode'),'id'=>"edit-ota-form", 'class'=>"form-horizontal form-label-left"))); ?>

                      <?php echo e(Form::hidden('id',null)); ?>

                  <?php else: ?>
                      <?php echo e(Form::open(array('url'=>route('save-ota-withpaymentmode'),'id'=>"add-ota-form", 'class'=>"form-horizontal form-label-left"))); ?>

                  <?php endif; ?>
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_name')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname')])); ?>

                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_gst_num')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::number('gst_no',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"gst_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_gst_num')])); ?>

                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_mobile_num')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::number('mobile_no',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num')])); ?>

                      </div>           
        
                      <div class="col-md-4 col-sm-4 col-xs-12">
                          <label class="control-label"><?php echo e(lang_trans('txt_concern_person')); ?> <span class="required">*</span></label>
                          <?php echo e(Form::text('conc_person',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"concern_person", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_concern_person')])); ?>                            
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> <?php echo e(lang_trans('txt_address')); ?> <span class="required">*</span></label>
                        <?php echo e(Form::textarea('address',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_address'),"rows"=>1])); ?>

                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Reconciliation status <span class="required">*</span></label>
                        <select class="form-control col-md-6 col-xs-12 valid" id="referred_by_name" name="reconciliation" aria-invalid="false" required>
                          <?php if(isset($data_row->reconciliation)): ?>
                            <option value="" <?php if($data_row->reconciliation == ""): ?> selected  <?php endif; ?> > Select </option>
                            <option value="1"  <?php if($data_row->reconciliation == 1): ?> selected  <?php endif; ?>> Active </option>
                            <option value="0"  <?php if($data_row->reconciliation == 2): ?> selected  <?php endif; ?>> Inactive </option>
                          <?php else: ?>
                            <option value=""> Select </option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          <?php endif; ?>
                        </select>
                      </div>


                      <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                      <!--  <label class="control-label"> Revenue from Bills (ECI/LCO)</label>-->
                      <!--  <div class="row">-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <input class="form-control " id="LCO" <?php if(isset($data_row->LCO)): ?> value="<?php echo e($data_row->LCO); ?>"  <?php else: ?>   placeholder="Revenue from Bills (ECI/LCO)" <?php endif; ?> name="LCO" type="number">-->
                      <!--    </div>-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <select class="form-control valid" id="LCO_type" name="LCO_type" aria-invalid="false">-->
                      <!--      <?php if(isset($data_row->LCO_type)): ?>-->
                      <!--        <option value="" <?php if($data_row->LCO_type == ""): ?> selected   <?php endif; ?>> Select </option>-->
                      <!--        <option value="precentage" <?php if($data_row->LCO_type == "precentage"): ?>  selected   <?php endif; ?>>In %</option>-->
                      <!--        <option value="Amount" <?php if($data_row->LCO_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>-->
                      <!--      <?php else: ?>-->
                      <!--        <option value=""> Select </option>-->
                      <!--        <option value="precentage">In %</option>-->
                      <!--        <option value="Amount">In Amount</option>-->
                      <!--      <?php endif; ?>-->
                      <!--      </select>-->
                      <!--      </div>-->
                      <!--  </div>-->
                      <!--</div>-->



                      <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                      <!--  <label class="control-label"> Revenue from Meals <span class="required">*</span></label>-->
                      <!--  <div class="row">-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <input class="form-control " id="Meals" <?php if(isset($data_row->Meals)): ?> value="<?php echo e($data_row->Meals); ?>"  <?php else: ?>   placeholder="Revenue from Meals" <?php endif; ?>  name="Meals" type="number">-->
                      <!--    </div>-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <select class="form-control valid" id="Meals_type" name="Meals_type" aria-invalid="false">-->
                      <!--      <?php if(isset($data_row->Meals_type)): ?>-->
                      <!--        <option value="" <?php if($data_row->Meals_type == ""): ?> selected   <?php endif; ?>> Select </option>-->
                      <!--        <option value="precentage" <?php if($data_row->Meals_type == "precentage"): ?> selected   <?php endif; ?>>In %</option>-->
                      <!--        <option value="Amount" <?php if($data_row->Meals_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>-->
                      <!--      <?php else: ?>-->
                      <!--        <option value=""> Select </option>-->
                      <!--        <option value="precentage">In %</option>-->
                      <!--        <option value="Amount">In Amount</option>-->
                      <!--      <?php endif; ?>-->
                      <!--      </select>-->
                      <!--      </div>-->
                      <!--  </div>-->
                      <!--</div>-->



                      <div class="col-md-4 col-sm-4 col-xs-12">
                          <label class="control-label"> Net share <span class="required">*</span></label>
                          <div class="row">
                              <div class="col-md-6 col-xs-6">
                                  <input class="form-control " id="Net_share" <?php if(isset($data_row->Net_share)): ?> value="<?php echo e($data_row->Net_share); ?>"  <?php else: ?>   placeholder="Net share" <?php endif; ?> name="Net_share" type="number">
                              </div>
                              <div class="col-md-6 col-xs-6">
                                  <select class="form-control valid" id="Net_share_type" name="Net_share_type" aria-invalid="false">
                                  <?php if(isset($data_row->Net_share_type)): ?>
                                    <option value="" <?php if($data_row->Net_share_type == ""): ?> selected   <?php endif; ?>> Select </option>
                                    <option value="precentage" <?php if($data_row->Net_share_type == "precentage"): ?> selected   <?php endif; ?>>In %</option>
                                    <option value="Amount" <?php if($data_row->Net_share_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>
                                  <?php else: ?>
                                    <option value=""> Select </option>
                                    <option value="precentage">In %</option>
                                    <option value="Amount">In Amount</option>
                                  <?php endif; ?>
                                  </select>
                            </div>
                        </div>
                      </div>






                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Tax on  commissions  <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="Tax_commissions"   <?php if(isset($data_row->Tax_commissions)): ?> value="<?php echo e($data_row->Tax_commissions); ?>"  <?php else: ?>  placeholder="Tax on commissions"  <?php endif; ?> name="Tax_commissions" type="number">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="Tax_commissions_type" name="Tax_commissions_type" aria-invalid="false">
                            <?php if(isset($data_row->Tax_commissions_type)): ?>
                              <option value="" <?php if($data_row->Tax_commissions_type == ""): ?> selected   <?php endif; ?>> Select </option>
                              <option value="precentage" <?php if($data_row->Tax_commissions_type == "precentage"): ?> selected   <?php endif; ?>>In %</option>
                              <option value="Amount" <?php if($data_row->Tax_commissions_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>
                            <?php else: ?>
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            <?php endif; ?>
                            </select>
                            </div>
                        </div>
                      </div>




                      <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                      <!--  <label class="control-label"> Net Hotel share payable post tax  <span class="required">*</span></label>-->
                      <!--  <div class="row">-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <input class="form-control " id="post_tax"     <?php if(isset($data_row->post_tax)): ?> value="<?php echo e($data_row->post_tax); ?>"  <?php else: ?>  placeholder="Net Hotel share payable post tax"  <?php endif; ?>    name="post_tax" type="number">-->
                      <!--    </div>-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <select class="form-control valid" id="post_tax_type" name="post_tax_type" aria-invalid="false">-->
                      <!--      <?php if(isset($data_row->post_tax_type)): ?>-->
                      <!--        <option value="" <?php if($data_row->post_tax_type == ""): ?> selected   <?php endif; ?>> Select </option>-->
                      <!--        <option value="precentage" <?php if($data_row->post_tax_type == "precentage"): ?> selected   <?php endif; ?>>In %</option>-->
                      <!--        <option value="Amount" <?php if($data_row->post_tax_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>-->
                      <!--      <?php else: ?>-->
                      <!--        <option value=""> Select </option>-->
                      <!--        <option value="precentage">In %</option>-->
                      <!--        <option value="Amount">In Amount</option>-->
                      <!--      <?php endif; ?>-->
                      <!--      </select>-->
                      <!--      </div>-->
                      <!--  </div>-->
                      <!--</div>-->






                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> TDS amount u/s 194-O  <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="TDS"   <?php if(isset($data_row->TDS)): ?> value="<?php echo e($data_row->TDS); ?>"  <?php else: ?>  placeholder="TDS amount u/s 194-O" <?php endif; ?>     name="TDS" type="number">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="TDS_type" name="TDS_type" aria-invalid="false">
                            <?php if(isset($data_row->TDS_type)): ?>
                              <option value="" <?php if($data_row->TDS_type == ""): ?> selected   <?php endif; ?>> Select </option>
                              <option value="precentage" <?php if($data_row->TDS_type == "precentage"): ?> selected   <?php endif; ?>>In %</option>
                              <option value="Amount" <?php if($data_row->TDS_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>
                            <?php else: ?>
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            <?php endif; ?>
                            </select>
                            </div>
                        </div>
                      </div>






                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> TDS Deducted on Buy-Sell Booking  <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="TDS_Deducted"  <?php if(isset($data_row->TDS_Deducted)): ?> value="<?php echo e($data_row->TDS_Deducted); ?>"  <?php else: ?>  placeholder="TDS Deducted on Buy-Sell Booking"  <?php endif; ?>   name="TDS_Deducted" type="text">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="" name="TDS_Deducted_type" aria-invalid="false">
                            <?php if(isset($data_row->TDS_Deducted_type)): ?>
                              <option value="" <?php if($data_row->TDS_Deducted_type == ""): ?> selected   <?php endif; ?>> Select </option>
                              <option value="precentage" <?php if($data_row->TDS_Deducted_type == "precentage"): ?> selected   <?php endif; ?>>In %</option>
                              <option value="Amount" <?php if($data_row->TDS_Deducted_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>
                            <?php else: ?>
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            <?php endif; ?>
                            </select>
                            </div>
                        </div>
                      </div>





                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> TCS (CGST + SGST) <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="TCS"    <?php if(isset($data_row->TCS)): ?> value="<?php echo e($data_row->TCS); ?>"  <?php else: ?>  placeholder=" TCS (CGST + SGST)"  <?php endif; ?>    name="TCS" type="text">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="TCS_type" name="TCS_type" aria-invalid="false">
                              <?php if(isset($data_row->TCS_type)): ?>
                                <option value="" <?php if($data_row->TCS_type == ""): ?> selected   <?php endif; ?>> Select </option>
                                <option value="precentage" <?php if($data_row->TCS_type == "precentage"): ?> selected   <?php endif; ?>>In %</option>
                                <option value="Amount" <?php if($data_row->TCS_type == "Amount"): ?> selected   <?php endif; ?>>In Amount</option>
                              <?php else: ?>
                                <option value=""> Select </option>
                                <option value="precentage">In %</option>
                                <option value="Amount">In Amount</option>
                              <?php endif; ?>
                            </select>
                            </div>
                        </div>
                      </div>












                        
                  </div>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/ota/otawithmode_add_edit.blade.php ENDPATH**/ ?>