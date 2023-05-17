@extends('layouts.master_backend')
@section('content')
@php 
      $flag=0;
      $heading=lang_trans('btn_add');
      if(isset($data_row) && !empty($data_row)){
          $flag=1;
          $heading=lang_trans('btn_update');
      }
  @endphp
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{$heading}} OTA </h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  @if($flag==1)
                      {{ Form::model($data_row,array('url'=>route('save-ota-withpaymentmode'),'id'=>"edit-ota-form", 'class'=>"form-horizontal form-label-left")) }}
                      {{Form::hidden('id',null)}}
                  @else
                      {{ Form::open(array('url'=>route('save-ota-withpaymentmode'),'id'=>"add-ota-form", 'class'=>"form-horizontal form-label-left")) }}
                  @endif
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_name')}} <span class="required">*</span></label>
                        {{Form::text('name',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"name", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_fullname')])}}
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_gst_num')}} <span class="required">*</span></label>
                        {{Form::number('gst_no',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"gst_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_gst_num')])}}
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_mobile_num')}} <span class="required">*</span></label>
                        {{Form::number('mobile_no',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"mobile_no", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_mobile_num')])}}
                      </div>           
        
                      <div class="col-md-4 col-sm-4 col-xs-12">
                          <label class="control-label">{{lang_trans('txt_concern_person')}} <span class="required">*</span></label>
                          {{Form::text('conc_person',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"concern_person", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_concern_person')])}}                            
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> {{lang_trans('txt_address')}} <span class="required">*</span></label>
                        {{Form::textarea('address',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"address", "placeholder"=>lang_trans('ph_enter').lang_trans('txt_address'),"rows"=>1])}}
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Reconciliation status <span class="required">*</span></label>
                        <select class="form-control col-md-6 col-xs-12 valid" id="referred_by_name" name="reconciliation" aria-invalid="false" required>
                          @if(isset($data_row->reconciliation))
                            <option value="" @if($data_row->reconciliation == "") selected  @endif > Select </option>
                            <option value="1"  @if($data_row->reconciliation == 1) selected  @endif> Active </option>
                            <option value="0"  @if($data_row->reconciliation == 2) selected  @endif> Inactive </option>
                          @else
                            <option value=""> Select </option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          @endif
                        </select>
                      </div>


                      <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                      <!--  <label class="control-label"> Revenue from Bills (ECI/LCO)</label>-->
                      <!--  <div class="row">-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <input class="form-control " id="LCO" @if(isset($data_row->LCO)) value="{{$data_row->LCO}}"  @else   placeholder="Revenue from Bills (ECI/LCO)" @endif name="LCO" type="number">-->
                      <!--    </div>-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <select class="form-control valid" id="LCO_type" name="LCO_type" aria-invalid="false">-->
                      <!--      @if(isset($data_row->LCO_type))-->
                      <!--        <option value="" @if($data_row->LCO_type == "") selected   @endif> Select </option>-->
                      <!--        <option value="precentage" @if($data_row->LCO_type == "precentage")  selected   @endif>In %</option>-->
                      <!--        <option value="Amount" @if($data_row->LCO_type == "Amount") selected   @endif>In Amount</option>-->
                      <!--      @else-->
                      <!--        <option value=""> Select </option>-->
                      <!--        <option value="precentage">In %</option>-->
                      <!--        <option value="Amount">In Amount</option>-->
                      <!--      @endif-->
                      <!--      </select>-->
                      <!--      </div>-->
                      <!--  </div>-->
                      <!--</div>-->



                      <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                      <!--  <label class="control-label"> Revenue from Meals <span class="required">*</span></label>-->
                      <!--  <div class="row">-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <input class="form-control " id="Meals" @if(isset($data_row->Meals)) value="{{$data_row->Meals}}"  @else   placeholder="Revenue from Meals" @endif  name="Meals" type="number">-->
                      <!--    </div>-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <select class="form-control valid" id="Meals_type" name="Meals_type" aria-invalid="false">-->
                      <!--      @if(isset($data_row->Meals_type))-->
                      <!--        <option value="" @if($data_row->Meals_type == "") selected   @endif> Select </option>-->
                      <!--        <option value="precentage" @if($data_row->Meals_type == "precentage") selected   @endif>In %</option>-->
                      <!--        <option value="Amount" @if($data_row->Meals_type == "Amount") selected   @endif>In Amount</option>-->
                      <!--      @else-->
                      <!--        <option value=""> Select </option>-->
                      <!--        <option value="precentage">In %</option>-->
                      <!--        <option value="Amount">In Amount</option>-->
                      <!--      @endif-->
                      <!--      </select>-->
                      <!--      </div>-->
                      <!--  </div>-->
                      <!--</div>-->



                      <div class="col-md-4 col-sm-4 col-xs-12">
                          <label class="control-label"> Net share <span class="required">*</span></label>
                          <div class="row">
                              <div class="col-md-6 col-xs-6">
                                  <input class="form-control " id="Net_share" @if(isset($data_row->Net_share)) value="{{$data_row->Net_share}}"  @else   placeholder="Net share" @endif name="Net_share" type="number">
                              </div>
                              <div class="col-md-6 col-xs-6">
                                  <select class="form-control valid" id="Net_share_type" name="Net_share_type" aria-invalid="false">
                                  @if(isset($data_row->Net_share_type))
                                    <option value="" @if($data_row->Net_share_type == "") selected   @endif> Select </option>
                                    <option value="precentage" @if($data_row->Net_share_type == "precentage") selected   @endif>In %</option>
                                    <option value="Amount" @if($data_row->Net_share_type == "Amount") selected   @endif>In Amount</option>
                                  @else
                                    <option value=""> Select </option>
                                    <option value="precentage">In %</option>
                                    <option value="Amount">In Amount</option>
                                  @endif
                                  </select>
                            </div>
                        </div>
                      </div>






                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Tax on  commissions  <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="Tax_commissions"   @if(isset($data_row->Tax_commissions)) value="{{$data_row->Tax_commissions}}"  @else  placeholder="Tax on commissions"  @endif name="Tax_commissions" type="number">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="Tax_commissions_type" name="Tax_commissions_type" aria-invalid="false">
                            @if(isset($data_row->Tax_commissions_type))
                              <option value="" @if($data_row->Tax_commissions_type == "") selected   @endif> Select </option>
                              <option value="precentage" @if($data_row->Tax_commissions_type == "precentage") selected   @endif>In %</option>
                              <option value="Amount" @if($data_row->Tax_commissions_type == "Amount") selected   @endif>In Amount</option>
                            @else
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            @endif
                            </select>
                            </div>
                        </div>
                      </div>




                      <!--<div class="col-md-4 col-sm-4 col-xs-12">-->
                      <!--  <label class="control-label"> Net Hotel share payable post tax  <span class="required">*</span></label>-->
                      <!--  <div class="row">-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <input class="form-control " id="post_tax"     @if(isset($data_row->post_tax)) value="{{$data_row->post_tax}}"  @else  placeholder="Net Hotel share payable post tax"  @endif    name="post_tax" type="number">-->
                      <!--    </div>-->
                      <!--    <div class="col-md-6 col-xs-6">-->
                      <!--      <select class="form-control valid" id="post_tax_type" name="post_tax_type" aria-invalid="false">-->
                      <!--      @if(isset($data_row->post_tax_type))-->
                      <!--        <option value="" @if($data_row->post_tax_type == "") selected   @endif> Select </option>-->
                      <!--        <option value="precentage" @if($data_row->post_tax_type == "precentage") selected   @endif>In %</option>-->
                      <!--        <option value="Amount" @if($data_row->post_tax_type == "Amount") selected   @endif>In Amount</option>-->
                      <!--      @else-->
                      <!--        <option value=""> Select </option>-->
                      <!--        <option value="precentage">In %</option>-->
                      <!--        <option value="Amount">In Amount</option>-->
                      <!--      @endif-->
                      <!--      </select>-->
                      <!--      </div>-->
                      <!--  </div>-->
                      <!--</div>-->






                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> TDS amount u/s 194-O  <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="TDS"   @if(isset($data_row->TDS)) value="{{$data_row->TDS}}"  @else  placeholder="TDS amount u/s 194-O" @endif     name="TDS" type="number">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="TDS_type" name="TDS_type" aria-invalid="false">
                            @if(isset($data_row->TDS_type))
                              <option value="" @if($data_row->TDS_type == "") selected   @endif> Select </option>
                              <option value="precentage" @if($data_row->TDS_type == "precentage") selected   @endif>In %</option>
                              <option value="Amount" @if($data_row->TDS_type == "Amount") selected   @endif>In Amount</option>
                            @else
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            @endif
                            </select>
                            </div>
                        </div>
                      </div>






                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> TDS Deducted on Buy-Sell Booking  <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="TDS_Deducted"  @if(isset($data_row->TDS_Deducted)) value="{{$data_row->TDS_Deducted}}"  @else  placeholder="TDS Deducted on Buy-Sell Booking"  @endif   name="TDS_Deducted" type="text">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="" name="TDS_Deducted_type" aria-invalid="false">
                            @if(isset($data_row->TDS_Deducted_type))
                              <option value="" @if($data_row->TDS_Deducted_type == "") selected   @endif> Select </option>
                              <option value="precentage" @if($data_row->TDS_Deducted_type == "precentage") selected   @endif>In %</option>
                              <option value="Amount" @if($data_row->TDS_Deducted_type == "Amount") selected   @endif>In Amount</option>
                            @else
                              <option value=""> Select </option>
                              <option value="precentage">In %</option>
                              <option value="Amount">In Amount</option>
                            @endif
                            </select>
                            </div>
                        </div>
                      </div>





                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> TCS (CGST + SGST) <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <input class="form-control " id="TCS"    @if(isset($data_row->TCS)) value="{{$data_row->TCS}}"  @else  placeholder=" TCS (CGST + SGST)"  @endif    name="TCS" type="text">
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <select class="form-control valid" id="TCS_type" name="TCS_type" aria-invalid="false">
                              @if(isset($data_row->TCS_type))
                                <option value="" @if($data_row->TCS_type == "") selected   @endif> Select </option>
                                <option value="precentage" @if($data_row->TCS_type == "precentage") selected   @endif>In %</option>
                                <option value="Amount" @if($data_row->TCS_type == "Amount") selected   @endif>In Amount</option>
                              @else
                                <option value=""> Select </option>
                                <option value="precentage">In %</option>
                                <option value="Amount">In Amount</option>
                              @endif
                            </select>
                            </div>
                        </div>
                      </div>
                      
                      <!--<input type="hidden" name="otawrelat" id="otawrelat" value="related">-->

                        
                  </div>
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
@endsection