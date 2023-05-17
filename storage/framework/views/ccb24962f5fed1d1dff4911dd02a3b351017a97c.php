<?php $__env->startSection('content'); ?>
<style>
    .colorstatus1{
        color:green;
        font-weight:500;
    }
    .colorstatus{
        color:blue;
        font-weight:500;
    }
</style>
<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Food Report Search</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo e(Form::model($search_data,array('url'=>route('search-foodreport'),'id'=>"search-expense", 'class'=>"form-horizontal form-label-left"))); ?>

              <div class="form-group col-sm-3">
                <label class="control-label"> <?php echo e(lang_trans('txt_category')); ?></label>
                <?php echo e(Form::select('category_id',$category_list,null,['class'=>"form-control",'placeholder'=>lang_trans('ph_select')])); ?>

              </div>
              <div class="form-group col-sm-2">
                <label class="control-label"> <?php echo e(lang_trans('txt_date_from')); ?></label>
                <?php echo e(Form::text('date_from',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_from')])); ?>

              </div>
              <div class="form-group col-sm-2">
                <label class="control-label"> <?php echo e(lang_trans('txt_date_to')); ?></label>
                <?php echo e(Form::text('date_to',null,['class'=>"form-control datepicker", 'placeholder'=>lang_trans('ph_date_to')])); ?>

              </div>
              <div class="form-group col-sm-3">
                <br/>
                 <button class="btn btn-success search-btn" name="submit_btn" value="search" type="submit"><?php echo e(lang_trans('btn_search')); ?></button>
                 <a class="btn btn-danger search-btn" href="<?php echo e(route('food-sales-report')); ?>" name="refresh" value="refresh">Refresh</a>
                 <!--<button class="btn btn-primary export-btn" name="submit_btn" value="export" type="submit"></button>-->
              </div>
            <?php echo e(Form::close()); ?>

          </div>
        </div>
      </div>
  </div>
  <div class="row">
      <div class="pt-3 pb-3" id="print_area">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Food Collection Report</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <?php
                    $totalAmount = 0;
                    $totalAmount1 = 0;
                    $totalAmountn = 0;
                    $i= 1;
                  ?>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo e(lang_trans('txt_sno')); ?></th>
                      <th>Food Name</th>
                      <!--<th></th>-->
                      <!--<th></th>-->
                      <th><?php echo e(lang_trans('txt_amount')); ?></th>
                      <th>Order Type</th>
                      <th>Payment Mode</th>
                      <th>Invoice</th>
                      <th><?php echo e(lang_trans('txt_date')); ?></th>
                      <!--<th></th>-->
                      <!--<th></th>-->
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                        $totalAmount = $totalAmount+$val->amount;
                      ?>
                      <tr>
                        <td><?php echo e($i); ?></td>
                        <td><?php echo e($val->name); ?></td>
                        <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->amount); ?></td>
                        <td class="colorstatus"><?php echo e($val->statusonoff); ?></td>
                        <td><?php echo e($val->payment_mode); ?></td>
                        <td>
                          <a class="btn btn-sm btn-info" href="<?php echo e(route('invoice',[$val->id])); ?>">Invoice</i></a>
                        </td>
                        <td><?php echo e(dateConvert($val->created_at,'d-m-Y')); ?></td>
                        <!--<td>-->
                        <!--  <a class="btn btn-sm btn-info" href=""><i class="fa fa-pencil"></i></a>-->
                        <!--  <button class="btn btn-danger btn-sm delete_btn" data-url="" title=""><i class="fa fa-trash"></i></button>-->
                        <!--</td>-->
                      </tr>
                      <?php $i++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php $__currentLoopData = $datalist2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $totalAmount1 = $totalAmount1 + $val->total_amount;
                        ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td>
                                <?php if($val->order_history): ?>
                                    <?php $__currentLoopData = $val->order_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OH=>$val_OH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php //print_r($val_OH->is_book); ?>
                                        <?php if($val_OH->orders_items): ?>
                                            <?php $__currentLoopData = $val_OH->orders_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_OI=>$val_OI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $price = $val_OI->item_price*$val_OI->item_qty;
                                                    $totalAmountn = $totalAmountn + $price;
                                                ?>
                                                <span> <?php echo e($val_OI->item_name); ?> (<?php echo e($val_OI->item_qty); ?>q) </span><br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(getCurrencySymbol()); ?> <?php echo e($val->total_amount); ?></td>
                            <td class="colorstatus1"><?php echo e($val->statusonoff); ?></td>
                            <td>
                                  <?php if($val->payment_mode==1): ?>
                             Cash
                            <?php elseif($val->payment_mode==4): ?>
                            Paytm
                             <?php elseif($val->payment_mode==5): ?>
                            Phone pe
                             <?php elseif($val->payment_mode==6): ?>
                            Complementary
                            
                            <?php endif; ?>
                            </td>
                            <td>
                          <a class="btn btn-sm btn-info" href="<?php echo e(route('invoice',[$val->id])); ?>">Invoice</i></a>
                        </td>
                            <td><?php echo e(dateConvert($val->created_at,'d-m-Y')); ?></td>
                        </tr>
                        
                        <?php $i++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
                <table class="table table-striped table-bordered">
                    <tr>
                      <th class="text-right" width="50%"><?php echo e(lang_trans('txt_grand_total')); ?></th>
                      <th width="50%"><b><?php echo e(getCurrencySymbol()); ?> <?php echo e(numberFormat($totalAmount) + numberFormat($totalAmount1)); ?></b></th>
                    </tr>
                </table>
              </div>
          </div>
      </div>
  </div>
  </div>
</div>  
 <div class="col-md-12 pt-3 pb-3 text-right">
                  <button onclick='downloadDiv();' class="btn btn-primary">Download PDF</button>
               
                   
                </div>
<?php $__env->stopSection(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js" ></script>
 <script>
  
  
  function downloadDiv(){
      const element = document.getElementById("print_area");
      html2pdf()
      .from(element)
      .save();
  };

</script>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/f9hotels/public_html/pms.nextpro71.com/new/pms/resources/views/backend/foodsalesreport.blade.php ENDPATH**/ ?>