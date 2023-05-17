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
                  <h2>{{$heading}} {{lang_trans('heading_expense')}}</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  @if($flag==1)
                      {{ Form::model($data_row,array('url'=>route('save-expense'),'id'=>"expense-form", 'class'=>"form-horizontal form-label-left", "files"=>true)) }}
                      {{Form::hidden('id',null)}}
                  @else
                      {{ Form::open(array('url'=>route('save-expense'),'id'=>"expense-form", 'class'=>"form-horizontal form-label-left", "files"=>true)) }}
                  @endif
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"> {{lang_trans('txt_category')}} <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              {{ Form::select('category_id',$category_list,null,['class'=>'form-control','placeholder'=>lang_trans('ph_select')]) }}    
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> {{lang_trans('txt_title')}} <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('title',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"title", "required"=>"required"])}}
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount"> {{lang_trans('txt_amount')}} <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('amount',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"amount", "required"=>"required"])}}
                          </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_date"> {{lang_trans('txt_date')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          {{Form::text('datetime',date('Y-m-d'),['class'=>"form-control col-md-6 col-xs-12 datePickerDefault1", "id"=>"expense_date", "placeholder"=>lang_trans('ph_date'), "autocomplete"=>"off"])}}
                        </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="remark"> {{lang_trans('txt_remark')}}</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::textarea('remark',null,['class'=>"form-control col-md-7 col-xs-12", "id"=>"remark", "rows"=>1])}}
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="attachments"> {{lang_trans('txt_attachment')}}</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            {{Form::file('attachments[]',['class'=>"form-control",'id'=>'attachments','multiple'=>true])}}
                          </div>
                      </div>
                      @if( $flag==1 && $data_row->attachments->count())
                    <div class="row">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="attachments"> {{lang_trans('txt_uploaded_files')}}</label>
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                              <tr>
                                <th>{{lang_trans('txt_sno')}}.</th>
                                <th>{{lang_trans('txt_name')}}.</th>
                                <th>{{lang_trans('txt_action')}}</th>
                              </tr>
                              @if($data_row->attachments)
                                @foreach($data_row->attachments as $k=>$val)
                                  @if($val->file!='')
                                    <tr>
                                      <td>{{$k+1}}</td>
                                      <td>{{$val->file}}</td>
                                      <td>
                                        <a href="{{checkFile($val->file,'uploads/expenses/','blank_id.jpg')}}" data-toggle="lightbox"  data-title="{{lang_trans('txt_attachment')}}" data-footer="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> </a>
                                        <a href="{{checkFile($val->file,'uploads/expenses/','blank_id.jpg')}}" class="btn btn-sm btn-success" download><i class="fa fa-download"></i> </a>
                                       <button type="button" class="btn btn-danger btn-sm delete_btn" data-url="{{route('delete-mediafile',[$val->id])}}" title="{{lang_trans('btn_delete')}}"><i class="fa fa-trash"></i></button>
                                      </td>
                                    </tr>
                                  @endif
                                @endforeach
                              @else
                                <tr>
                                    <td colspan="2">{{lang_trans('txt_no_file')}}</td>
                                </tr>
                              @endif
                            </table>
                        </div>
                        <div class="col-sm-3">&nbsp;</div>
                    </div>
                  @endif
                      <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="reset">
                                  {{lang_trans('btn_reset')}}
                              </button>
                              <button class="btn btn-success" type="submit">
                                  {{lang_trans('btn_submit')}}
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
@endsection
