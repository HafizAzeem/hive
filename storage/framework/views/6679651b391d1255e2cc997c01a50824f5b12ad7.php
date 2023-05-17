<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>-->
<!--<link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet"/>-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

<!--<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>-->

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Budget</div>
                <div class="card-body">
                    <br/>
                    <form method="post" action="<?php echo e(route('save-budget')); ?>">
                    <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" class="form-control" name="idall">
                                <label>Budget Amount</label>
                                <input type="number" class="form-control" name="estimation">
                            </div>
                            <div class="col-md-3">
                                <label>Date</label>
                                <input type="month" class="form-control" name="tilldate">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info" style="margin-top:9%;">Submit</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Tags</div>
                <div class="card-body">
                    <br/>
                    <form method="GET" action="<?php echo e(route('save-tags')); ?>">
                    <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-11">
                                <?php 
                                    $tg = $tags[0]->tags;
                                ?>
                                <input id="input" type="text" name="tagsnew" value="<?php echo e($tg); ?>" data-role="tagsinput" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-info" style="margin-top:1%;">Submit</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="qwe">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>List All Budgets</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <br/>
                  <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Title</th>
                      <th>Location</th>
                      <th>Revenue Target</th>
                      <th>Date</th>
                      <th>Update</th>
                    </tr>
                  </thead>
                 

                  <tbody>
                    <?php $__currentLoopData = $datalist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     
                      <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($val->title); ?></td>
                        <td><?php echo e($val->location); ?></td>
                        <td><?php echo e($val->budgetestimate); ?></td>
                        <td><?php echo e(date('M-Y', strtotime($val->tilldate))); ?></td>
                            
                        <td>
                            <a class="btn btn-sm btn-info" href="<?php echo e(route('edit-budget',[$val->id])); ?>"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete_btn" data-url="<?php echo e(route('delete-budget',[$val->id])); ?>" title="<?php echo e(lang_trans('btn_delete')); ?>"><i class="fa fa-trash"></i></button>
                            <!--<div class="col-md-1">-->
                                <!--<button type="button" onclick="plus()" class="btn btn-success add-new-advance"><i class="fa fa-plus"></i></button>-->
                            <!--</div>-->
                        </td>
                      </tr>
                      
                   
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                  </tbody>
                  
                  
                 
                </table>
                
              </div>
                                
          </div>
      </div>
  </div>
</div>     
            
<?php echo $__env->yieldContent('js'); ?>
<script>
    $(document).ready(function(){  
        var x = "<?php echo "$tg" ?>";
        //   $('#input').tagsinput('x');
        $('#input').tagsinput('add', x );
        $('#input').tagsinput({
          typeahead: {
            source: function(query) {
              return $.getJSON('x.json');
            }
          }
        });
    });
</script>                
<script>

    // let id=1;
    // function plus()
    // {
    //   $("#remove"+id).show();
    //   id++;
    //   console.log(id)
    // }

    // function remove_addon(id)
    // {
    //     $("#remove"+id).remove();
    // }
</script>                
                                
                                    


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/budget/budgetforecast_list.blade.php ENDPATH**/ ?>