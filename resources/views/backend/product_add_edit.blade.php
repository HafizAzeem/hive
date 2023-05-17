@extends('layouts.master_backend')
@section('content')
@php 
      $flag=0;
      $heading=lang_trans('heading_add_product');
      if(isset($data_row) && !empty($data_row)){
          $flag=1;
          $heading=lang_trans('heading_update_product');
      }
  @endphp
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>{{$heading}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  @if($flag==1)
                      {{ Form::model($data_row,array('url'=>route('save-product'),'id'=>"update-product-form", 'class'=>"form-horizontal form-label-left")) }}
                      {{Form::hidden('id',null)}}
                  @else
                      {{ Form::open(array('url'=>route('save-product'),'id'=>"add-product-form", 'class'=>"form-horizontal form-label-left")) }}
                  @endif
                  
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name"> {{lang_trans('txt_product_name')}}<span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('name',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"product_name", "required"=>"required"])}}
                          </div>
                      </div>
                      @if($flag==0)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="prod_quantity"> {{lang_trans('txt_qty')}}<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="col-md-6 col-sm-6 col-xs-12 p-left-0 p-right-0">
                                {{Form::number('stock_qty',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"prod_quantity", "required"=>"required"])}}
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12 p-left-0 p-right-0">
                                {{ Form::select('measurement',getUnits(),null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')]) }}    
                              </div>
                            </div>
                        </div>
                      @else
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="prod_quantity"> {{lang_trans('txt_curr_stock')}}<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{Form::number('curr_stock',$data_row->stock_qty,['class'=>"form-control col-md-7 col-xs-12", "id"=>"prod_quantity", "readonly"=>"readonly"])}}
                            </div>
                          </div>
                      @endif
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">{{lang_trans('txt_status')}}</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              {{ Form::select('status',config('constants.LIST_STATUS'),1,['class'=>'form-control']) }}    
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
@endsection