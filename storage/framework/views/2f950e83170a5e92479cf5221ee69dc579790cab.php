
<?php $__env->startSection('content'); ?>

<div class="">
  <?php echo e(Form::open(array('url'=>route('save-settings'),'id'=>"update-setting-form", 'class'=>"form-horizontal form-label-left"))); ?>

  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_site_settings')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_site_page_title')); ?></label>
                      <?php echo e(Form::text('site_page_title',@$data_row['site_page_title'],['class'=>"form-control col-md-7 col-xs-12", "required"=>true])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_site_lang')); ?></label>
                      <?php echo e(Form::select('site_language',config('constants.LANG_LIST'),@$data_row['site_language'],['class'=>"form-control col-md-7 col-xs-12", "required"=>true])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_hotel_name')); ?></label>
                      <?php echo e(Form::text('hotel_name',@$data_row['hotel_name'],['class'=>"form-control col-md-7 col-xs-12", "required"=>true])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_hotel_tagline')); ?></label>
                      <?php echo e(Form::text('hotel_tagline',@$data_row['hotel_tagline'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>


                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_hotel_email')); ?></label>
                      <?php echo e(Form::email('hotel_email',@$data_row['hotel_email'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_hotel_phone')); ?></label>
                      <?php echo e(Form::text('hotel_phone',@$data_row['hotel_phone'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_hotel_mobile')); ?></label>
                      <?php echo e(Form::text('hotel_mobile',@$data_row['hotel_mobile'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_hotel_website')); ?></label>
                      <?php echo e(Form::text('hotel_website',@$data_row['hotel_website'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label"><?php echo e(lang_trans('txt_hotel_address')); ?></label>
                      <?php echo e(Form::textarea('hotel_address',@$data_row['hotel_address'],['class'=>"form-control col-md-7 col-xs-12",'rows'=>1])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label">Hotel Star Category</label>
                      <?php echo e(Form::text('Hotel_Star',@$data_row['Hotel_Star'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label">Hotel City</label>
                      <?php echo e(Form::text('Hotel_city',@$data_row['Hotel_city'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <label class="control-label">Car Parking Spaces (In sq-feet) </label>
                      <?php echo e(Form::text('car_parking_spaces',@$data_row['car_parking_spaces'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                    </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2><?php echo e(lang_trans('heading_gst_settings')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo e(lang_trans('txt_gstin')); ?></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo e(Form::text('gst_num',@$data_row['gst_num'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

                          </div>
                      </div>
                       <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_room_rent_gst')); ?> (%) on amount(0 to 1000)</label>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_sgst')); ?> (%)</label>
                            <?php echo e(Form::number('gst_0',@$data_row['gst_0'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                           <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_cgst')); ?> (%)</label>
                            <?php echo e(Form::number('cgst_0',@$data_row['cgst_0'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_room_rent_gst')); ?> (%) on amount(1001 to 7500)</label>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_sgst')); ?> (%)</label>
                            <?php echo e(Form::number('gst',@$data_row['gst'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                           <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_cgst')); ?> (%)</label>
                            <?php echo e(Form::number('cgst',@$data_row['cgst'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                      </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_room_rent_gst')); ?> (%) on amount(7501 to Above)</label>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_sgst')); ?> (%)</label>
                            <?php echo e(Form::number('gst_1',@$data_row['gst_1'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                           <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_cgst')); ?> (%)</label>
                            <?php echo e(Form::number('cgst_1',@$data_row['cgst_1'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                      </div>
                      <!-- <div class="form-group">-->
                      <!--    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_room_rent_gst')); ?> (%) on amount(above 7499)</label>-->
                      <!--    <div class="col-md-3 col-sm-3 col-xs-12">-->
                      <!--      <label class=""><?php echo e(lang_trans('txt_sgst')); ?> (%)</label>-->
                      <!--      <?php echo e(Form::number('gst_2',@$data_row['gst_2'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>-->
                      <!--    </div>-->
                      <!--     <div class="col-md-3 col-sm-3 col-xs-12">-->
                      <!--      <label class=""><?php echo e(lang_trans('txt_cgst')); ?> (%)</label>-->
                      <!--      <?php echo e(Form::number('cgst_2',@$data_row['cgst_2'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>-->
                      <!--    </div>-->
                      <!--</div>-->
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo e(lang_trans('txt_food_gst')); ?> (%)</label>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_sgst')); ?> (%)</label>
                            <?php echo e(Form::number('food_gst',@$data_row['food_gst'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class=""><?php echo e(lang_trans('txt_cgst')); ?> (%)</label>
                            <?php echo e(Form::number('food_cgst',@$data_row['food_cgst'],['class'=>"form-control col-md-7 col-xs-12", "required"=>"required","min"=>0, "step"=>"0.01"])); ?>

                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"> Service Charges</label>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class="">Service Charges(%)</label>
                            <?php echo e(Form::number('food_scharges',@$data_row['food_scharges'],['class'=>"form-control col-md-7 col-xs-12", "min"=>0, "step"=>"0.01"])); ?>

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
                  <h2><?php echo e(lang_trans('heading_currency_settings')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo e(lang_trans('txt_currency')); ?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo e(Form::select('currency',getCurrencyList(),@$data_row['currency'],['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_currency_symbol')); ?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo e(Form::text('currency_symbol',@$data_row['currency_symbol'],['class'=>"form-control col-md-7 col-xs-12"])); ?>

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
                  <h2><?php echo e(lang_trans('heading_default_settings')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo e(lang_trans('txt_nationality')); ?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo e(Form::select('default_nationality',config('constants.NATIONALITY_LIST'),@$data_row['default_nationality'],['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo e(lang_trans('txt_country')); ?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo e(Form::select('default_country',getCountryList(),@$data_row['default_country'],['class'=>'form-control','placeholder'=>lang_trans('ph_select')])); ?>

                      </div>
                  </div>
                  
                   <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">MID</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" class="form-control" name="mid" required value="<?php echo e(old('newmid',$data_row['newmid'] ?? '')); ?>">
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
                <h2><?php echo e(lang_trans('default_checkin_setting')); ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br/>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo e(lang_trans('sidemenu_checkin')); ?></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo e(Form::time('checkin_time',@$data_row['checkin_time'],['class'=>"form-control col-md-7 col-xs-12", "required"=>true])); ?>

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
                <h2>CheckOut Default Time</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Check Out</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" required="" name="checkout_time" type="time" value="<?php echo e($data_row['checkout_time']); ?>">
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
                  <h2><?php echo e(lang_trans('heading_term_and_conditions')); ?></h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                 <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label"><?php echo e(lang_trans('txt_invoice_tnc')); ?></label>
                    <?php echo e(Form::textarea('invoice_term_condition',@$data_row['invoice_term_condition'],['class'=>"form-control col-md-7 col-xs-12 summernote",'rows'=>10])); ?>

                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 text-right">
          <div class="x_panel">
              <div class="x_content">
                <br/>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                       <button class="btn btn-success" type="submit">
                            <?php echo e(lang_trans('btn_submit')); ?>

                        </button>
                    </div>
                </div>
              </div>
          </div>
      </div>
  </div>

  <?php echo e(Form::close()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp-7-4\htdocs\hive\resources\views/backend/settings.blade.php ENDPATH**/ ?>