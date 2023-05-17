
<?php $__env->startSection('content'); ?>

<div class="">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Search Customer</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="height:200px;">
                    <form method="post" action="<?php echo e(route('outlet_action')); ?>">
                    <div class="row">
                        <div class="col-md-3"></div>
                       <div class="col-md-6">
                           <select id="search-input" class="js-example-basic-single form-control" name="state">
                          <option value=""></option>
                           </select>
                       </div>
                    </div>
                    </form>
                    
                  
                
                 
</div>
</div>
</div>
</div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery'); ?>
    <script>
    
    $(document).ready(function(){
$(".js-example-basic-single").select2({
  escapeMarkup: function (markup) {
        return markup;
    },
  ajax: {
    url: "<?php echo e(url('https://dashboard.f9hotels.com/api/getCustomer')); ?>",
    type: "post",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term // search term
      };
    },
    processResults: function (data, params) {
      return {
        results: data.results,
      };
    },
    cache: true
  },
  language: {
    noResults: function (event) {
    	// console.log(event.target.value);
     //var s = $("#search-input").val();select2-search__field
      return '<button id="add-customer-on-nosearch" onclick="f()" class="btn btn-primary" style="width:100%;" type="button">New Customer</button>';      

    }

  },
  placeholder: '<i class="mdi mdi-magnify"></i> Mobile No.',
  minimumInputLength: 8,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection,
  width:'100%',
  height:50
});

})
        function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }


  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      "<div class='select2-result-repository__meta'>" +
        "<div class='row'><div class='col-md-6'><div class='select2-result-repository__title'></div>" +
        "<div class='select2-result-repository__description'></div></div>" +
      "<div class='col-md-6' style='text-align:right;'><div class='select2-result-repository__store'></div>" +
        "<div class='select2-result-repository__address'></div></div>" +
        "</div>" +
      "</div>" +
    "</div>"
  );

    
      $container.find(".select2-result-repository__title").text(repo.name);
      $container.find(".select2-result-repository__description").text(repo.address);
      $container.find(".select2-result-repository__store").text(repo.mobile);
      $container.find(".select2-result-repository__address").text(repo.email);
    
        


  return $container;
}


function formatRepoSelection (repo) {
  return repo.name || repo.text;
}

    

function f() {
	// alert(document.getElementsByClassName('select2-search__field')[0].value)
	const sv = document.getElementsByClassName('select2-search__field')[0].value;
	window.location.href = "<?php echo e(url('admin/newcheckin')); ?>/"+sv;
}
$("#search-input").on("select2:select", function (e) {
    window.location.href="<?php echo e(url('admin/newexistscheckin')); ?>/"+e.params.data.id;
});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/backend/search.blade.php ENDPATH**/ ?>