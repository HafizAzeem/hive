@extends('layouts.master_backend')
@section('content')
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{lang_trans('heading_manage_inventory')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  {{ Form::open(array('url'=>route('save-stock'),'id'=>"stock-form", 'class'=>"form-horizontal form-label-left")) }}
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_product')}} <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              {{ Form::select('product_id',$product_list,null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')]) }}    
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_stock')}} <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              {{ Form::select('stock_is',['add'=>'Add','subtract'=>'Subtract'],1,['class'=>'form-control','id'=>'stock_is','placeholder'=>lang_trans('ph_select')]) }}    
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty">{{lang_trans('txt_qty')}} <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::number('qty',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"qty", "required"=>"required"])}}
                          </div>
                      </div>
                      <div class="form-group hide_elem" id="price_section">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">{{lang_trans('txt_price')}}</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('price',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"price"])}}
                          </div>
                      </div>
                     
                      <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="reset">{{lang_trans('btn_reset')}}</button>
                              <button class="btn btn-success" type="submit">{{lang_trans('btn_submit')}}</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
<script type="text/javascript" src="{{URL::asset('public/js/page_js/page.js')}}"></script> 
@endsection