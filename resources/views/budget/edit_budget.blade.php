@extends('layouts.master_backend')
@section('content')
<script>
    $(".datePickerDefault").datepicker({
        dateFormat: 'yy-mm-dd',
        format: 'L',
        minDate: 0
    });
</script>
  
<div class="">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Update Budget</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                      {{ Form::model($data_row[0],array('url'=>route('update-budget'),'id'=>"edit-budget-form", 'class'=>"form-horizontal form-label-left")) }}
                      {{Form::hidden('id',null,["id"=>"newid"])}}
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Budget Amount <span class="required">*</span></label>
                            {{Form::text('budgetestimate',null,['class'=>"form-control col-md-6 col-xs-12", "id"=>"budgetestimate"])}}
                        </div>
                        <?php $tilldate = date('Y-m', strtotime($data_row[0]->tilldate));  ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label"> Date </label>
                            {{Form::month('tilldate',$tilldate,['class'=>"form-control col-md-6 col-xs-12", "id"=>"budgetdate", "autocomplete"=>"off"])}}
                        </div>
                        
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-success" type="submit">{{lang_trans('btn_submit')}}</button>
                    </div>
                    
                    {{Form::close()}}
              </div>
          </div>
      </div>
  </div>
</div>
@endsection