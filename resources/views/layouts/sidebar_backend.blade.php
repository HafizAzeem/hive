@php
$urlname = basename(request()->path());

$permissionsArr = getMenuPermission();
$permissionsArr['outlet']=1;
@endphp

<?php
if(Auth::user()->name == 'Investors'){ 
    $data = 'none';
?>

<script>
    $(document).click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    return false;
});

// // disable right click
// $(document).unbind('click');
// $(document).unbind('contextmenu');
$(document).bind('contextmenu', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    return false;
});

</script>
<style>
    .top_tiles {
        pointer-events: none;
    }
</style>
<?php
    //echo $data;
}else {
    $data = 'block';
    //echo $data;
}
?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="display:{{$data}}">
  <div class="menu_section">
    <ul class="nav side-menu">
      @if($permissionsArr['dashboard']==1) <li><a href="{{route('new-dashboard')}}"><i class="fa fa-home"></i> {{lang_trans('sidemenu_dashboard')}} </a></li> @endif

      @if($permissionsArr['arrival']==1 && ($permissionsArr['add-arrival'] || $permissionsArr['list-arrival'] || $permissionsArr['list-check-outs']) )
        <li><a><i class="fa fa-money"></i>{{lang_trans('sidemenu_arrival')}} <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-arrival']==1) <li><a href="{{route('room-arrival-reservation')}}">{{lang_trans('sidemenu_arrival_add')}} </a></li> @endif
            @if($permissionsArr['list-arrival']==1) <li><a href="{{route('list-arrival-reservation')}}">{{lang_trans('sidemenu_arrival_all')}} </a></li> @endif
            <li><a href="{{route('inventory')}}">Inventory</a></li>
            <!--<li><a href="{{--route('rooms-inventory')--}}">Inventory</a></li>-->
          </ul>
        </li>
      @endif
      @if($permissionsArr['check-in']==1 && ($permissionsArr['add-check-in'] || $permissionsArr['single-check-in'] || $permissionsArr['multi-check-in'] || $permissionsArr['list-check-outs']) )
        <li><a><i class="fa fa-money"></i>{{lang_trans('sidemenu_checkin')}} <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-check-in']==1) <li><a href="{{route('search')}}">{{lang_trans('sidemenu_checkin_add')}} </a></li> @endif
            @if($permissionsArr['single-check-in']==1) <li><a href="{{route('single-list-reservation')}}">Bookings </a></li> @endif
          </ul>
        </li>
      @endif
        @if($permissionsArr['revenue']==1 && ($permissionsArr['add-extra-revenue'] || $permissionsArr['list-extra-revenue']) )
            <li><a><i class="fa fa-money"></i>Revenue <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @if($permissionsArr['add-extra-revenue']==1) <li><a href="{{route('add-extrarevenue')}}">Add Extra Revenue </a></li> @endif
                    @if($permissionsArr['list-extra-revenue']==1) <li><a href="{{route('list-extrarevenue')}}">List Extra Revenue </a></li> @endif
                </ul>
            </li>
        @endif
        
        @if($permissionsArr['performa-invoice']==1)
        <li><a><i class="fa fa-money"></i>Performa Invoice<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if($permissionsArr['add-performa-invoice']==1) <li><a href="{{route('add-performa')}}">Add Performa </a></li> @endif
                @if($permissionsArr['list-performa-invoice']==1) <li><a href="{{route('list-performa')}}">List performa </a></li> @endif 
            </ul>
        </li>
        @endif
        
        @if($permissionsArr['budget-estimation']==1)
        <li><a><i class="fa fa-money"></i>Budget Estimation<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if($permissionsArr['budget-estimation-chart']==1) <li><a href="{{route('budget-chart')}}">Estimation Chart</a></li> @endif
                <!--<li><a href="{{--route('add-budget')--}}">Add Budget </a></li>-->
                @if($permissionsArr['add-edit-budget-estimation']==1) <li><a href="{{route('list-budget')}}">Add/Edit Budget </a></li> @endif
            </ul>
        </li>
        @endif

      @if($permissionsArr['users']==1 && ($permissionsArr['add-users'] || $permissionsArr['list-users']) )
        <li><a><i class="fa fa-user"></i>{{lang_trans('sidemenu_users')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             @if($permissionsArr['add-users']==1) <li><a href="{{route('add-user')}}">{{lang_trans('sidemenu_user_add')}} </a></li> @endif
             @if($permissionsArr['list-users']==1) <li><a href="{{route('list-user')}}">{{lang_trans('sidemenu_user_all')}} </a></li> @endif
          </ul>
        </li>
      @endif

      @if($permissionsArr['housekeeping']==1) <li><a href="{{route('housekeeping')}}"><i class="fa fa-home"></i> {{lang_trans('sidemenu_housekeeping')}} </a></li> @endif
       <li class="top_tiles"><a href="{{route('outlet')}}"><i class="fa fa-home"></i> Outlet</a></li>
       
       
       
      @if($permissionsArr['tas']==1)
        <li><a><i class="fa fa-user"></i>{{lang_trans('sidemenu_corporate')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
          @if($permissionsArr['add-corporate']==1) <li><a href="{{route('add-corporate')}}">{{lang_trans('sidemenu_corporate_add')}} </a></li> @endif
          @if($permissionsArr['list-corporate']==1)<li><a href="{{route('list-corporate')}}">{{lang_trans('sidemenu_corporate_all')}}</a></li> @endif
          @if($permissionsArr['add-ta']==1)  <li><a href="{{route('add-ta')}}">{{lang_trans('sidemenu_ta_add')}}   </a></li> @endif
          @if($permissionsArr['list-ta']==1) <li><a href="{{route('list-ta')}}">{{lang_trans('sidemenu_ta_all')}}  </a></li> @endif
          @if($permissionsArr['add-ota']==1) <li><a href="{{route('add-ota')}}">{{lang_trans('sidemenu_ota_add')}} </a></li> @endif
          @if($permissionsArr['list-ota']==1)<li><a href="{{route('list-ota')}}">{{lang_trans('sidemenu_ota_all')}}</a></li> @endif
          
          <!--<li><a href="{{--route('add-ota-with-payment-mode')--}}">Add OTA With Payment Mode</a></li> -->
          <!--<li><a href="{{--route('list-ota-with-paymentmode')--}}">List OTA with Payment Mode </a></li>  -->
          </ul>
        </li>
      @endif
          @if($permissionsArr['billing']==1)
        <li><a><i class="fa fa-user"></i>Billing<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
         <li><a href="{{route('billing',['type'=>'corporate'])}}">Corporate Billing </a></li>
         <li><a href="{{route('billing',['type'=>'ota'])}}">OTA Billing </a></li>
           <li><a href="{{route('billing',['type'=>'ta'])}}">TA Billing </a></li>
          </ul>
        </li>
      @endif
      @if($permissionsArr['customers']==1 && ($permissionsArr['add-customers'] || $permissionsArr['list-customers']) )
        <li><a><i class="fa fa-user"></i>{{lang_trans('sidemenu_customers')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             @if($permissionsArr['add-customers']==1) <li><a href="{{route('add-customer')}}">{{lang_trans('sidemenu_customer_add')}} </a></li> @endif
             @if($permissionsArr['list-customers']==1) <li><a href="{{route('list-customer')}}">{{lang_trans('sidemenu_customer_all')}} </a></li> @endif
          </ul>
        </li>
      @endif

      @if($permissionsArr['email']==1)
        <li><a><i class="fa fa-user"></i>{{lang_trans('Report')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
          @if($permissionsArr['reports']==1) <li><a href="{{route('report')}}">All Reports </a></li>@endif
          @if($permissionsArr['reports']==1) <li><a href="{{route('reportExcel')}}">Reports </a></li>@endif
           @if($permissionsArr['daily-report']==1) <li><a href="{{route('daily-report')}}">Daily Report </a></li>@endif
          @if($permissionsArr['add-email']==1) <li><a href="{{route('add-email')}}">Add Email </a></li> @endif
          @if($permissionsArr['list-email']==1)  <li><a href="{{route('list-email')}}">Emails List </a></li> @endif
          </ul>
        </li>
      @endif
      <!-- @if($permissionsArr['report']==1)
      <li><i class="fa fa-file"></i> {{lang_trans('Report')}}<span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu">
            <li><a href="{{route('report')}}">{{lang_trans('Report')}}</a></li>
          </ul>
          </li>
      @endif -->

      @if($permissionsArr['food-category']==1 || $permissionsArr['food-item']==1)
        <li><a><i class="fa fa-cutlery"></i>{{lang_trans('sidemenu_fooditems')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-food-category']==1) <li><a href="{{route('add-food-category')}}">{{lang_trans('sidemenu_foodcat_add')}} </a></li> @endif
            @if($permissionsArr['list-food-category']==1) <li><a href="{{route('list-food-category')}}">{{lang_trans('sidemenu_foodcat_all')}} </a></li> @endif
            @if($permissionsArr['add-food-item']==1) <li><a href="{{route('add-food-item')}}">{{lang_trans('sidemenu_fooditem_add')}} </a></li> @endif
            @if($permissionsArr['list-food-item']==1) <li><a href="{{route('list-food-item')}}">{{lang_trans('sidemenu_fooditem_all')}} </a></li> @endif
            <li><a href="{{route('food-sales-report')}}">Food Sales Report</a></li>
          </ul>
        </li>
      @endif

      @if($permissionsArr['stocks']==1)
        <li><a><i class="fa fa-cart-plus"></i>{{lang_trans('sidemenu_stocks')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-product']==1) <li><a href="{{route('add-product')}}">{{lang_trans('sidemenu_product_add')}} </a></li> @endif
            @if($permissionsArr['list-product']==1) <li><a href="{{route('list-product')}}">{{lang_trans('sidemenu_product_all')}} </a></li> @endif
            @if($permissionsArr['add-stock']==1) <li><a href="{{route('io-stock')}}">{{lang_trans('sidemenu_stock_add')}} </a></li> @endif
            @if($permissionsArr['history-stock']==1) <li><a href="{{route('stock-history')}}">{{lang_trans('sidemenu_stock_history')}} </a></li> @endif
          </ul>
        </li>
      @endif

      @if($permissionsArr['room-type']==1)
        <li><a><i class="fa fa-home"></i>{{lang_trans('sidemenu_roomtypes')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-room-type']==1) <li class="sub_menu"><a href="{{route('add-room-types')}}">{{lang_trans('sidemenu_roomtype_add')}} </a></li> @endif
            @if($permissionsArr['list-room-type']==1) <li class="sub_menu"><a href="{{route('list-room-types')}}">{{lang_trans('sidemenu_roomtype_all')}} </a></li> @endif
            @if($permissionsArr['list-room-type']==1) <li class="sub_menu"><a href="{{route('list-date_price_range')}}">{{lang_trans('sidemenu_datepricerange_all')}} </a></li> @endif
          </ul>
        </li>
      @endif

      @if($permissionsArr['rooms']==1)
      <li><a><i class="fa fa-home"></i>{{lang_trans('sidemenu_rooms')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-room']==1) <li class="sub_menu"><a href="{{route('add-room')}}">{{lang_trans('sidemenu_room_add')}} </a></li> @endif
            @if($permissionsArr['list-room']==1) <li class="sub_menu"><a href="{{route('list-room')}}">{{lang_trans('sidemenu_room_all')}} </a></li> @endif
             @if($permissionsArr['list-room']==1) <li class="sub_menu"><a href="{{route('roomlight')}}">Hotel Room Light </a></li> @endif
          </ul>
        </li>
      @endif
      @if($permissionsArr['activities']==1)
      <li><a><i class="fa fa-tag"></i>User Activities<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
         <li class="sub_menu"><a href="{{route('user-activity')}}">Activities </a></li>
          </ul>
        </li>
        @endif
      @if($permissionsArr['amenities']==1)
        <li><a><i class="fa fa-tag"></i>{{lang_trans('sidemenu_amenities')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-amenities']==1) <li class="sub_menu"><a href="{{route('add-amenities')}}">{{lang_trans('sidemenu_amenities_add')}} </a></li> @endif
            @if($permissionsArr['list-amenities']==1) <li class="sub_menu"><a href="{{route('list-amenities')}}">{{lang_trans('sidemenu_amenities_all')}} </a></li> @endif
            <li class="sub_menu"><a href="{{route('Add_hotal_amenities')}}">Add Hotal Amenities </a></li> 
             <li class="sub_menu"><a href="{{route('list-hotal-amenities')}}">All Hotal Amenities </a></li> 
            <li class="sub_menu"><a href="{{route('Add_availed_services')}}">Add Availed Services </a></li> 
            <li class="sub_menu"><a href="{{route('list-availed-services')}}">All Availed Services </a></li> 
          </ul>
        </li>
      @endif

      @if($permissionsArr['expense-categories']==1 || $permissionsArr['expenses']==1)
        <li><a><i class="fa fa-hourglass-start"></i>{{lang_trans('sidemenu_expense')}}<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['add-expense-category']==1) <li><a href="{{route('add-expense-category')}}">{{lang_trans('sidemenu_expensecat_add')}} </a></li> @endif
            @if($permissionsArr['list-expense-category']==1) <li><a href="{{route('list-expense-category')}}">{{lang_trans('sidemenu_expensecat_all')}} </a></li> @endif
            @if($permissionsArr['add-expenses']==1) <li><a href="{{route('add-expense')}}">{{lang_trans('sidemenu_expense_add')}} </a></li> @endif
            @if($permissionsArr['list-expenses']==1) <li><a href="{{route('list-expense')}}">{{lang_trans('sidemenu_expense_all')}} </a></li> @endif
          </ul>
        </li>
      @endif

    @if($permissionsArr['settings']==1) <li><a href="{{route('settings')}}"><i class="fa fa-cog"></i>{{lang_trans('sidemenu_settings')}} </a></li> @endif
    
    @if($permissionsArr['collection_report']==1) <li><a href="{{route('collection_report')}}"><i class="fa fa-cog"></i>Collaction Report</a></li> @endif
       
    @if($permissionsArr['ta_report']==1)<li><a href="{{route('ta_report')}}"><i class="fa fa-home"></i> TA Invoice</a></li>@endif
       
    @if($permissionsArr['permissions']==1) <li><a href="{{route('permissions-list')}}"><i class="fa fa-universal-access"></i>{{lang_trans('sidemenu_permissions')}} </a></li> @endif

      @if($permissionsArr['package-master'] || $permissionsArr['add-package'] )
      <li><a><i class="fa fa-home"></i> Package Master<span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display : block;">
        <!-- <li><a href="{{route('package-master')}}">Package List</a></li> -->
        @if($permissionsArr['package-master']==1) <li><a href="{{route('package-master')}}">Package List</a></li> @endif
        @if($permissionsArr['add-package']==1) <li><a href="{{route('add-package')}}">Add Package Plan</a></li> @endif
        <!-- <li><a href="{{route('add-package')}}">Add Package Plan</a></li> -->
      </ul>
      </li>
      @endif

      @if($permissionsArr['meal-master'] || $permissionsArr['add-meal-plan'] )
        <li><a><i class="fa fa-home"></i>Meal Master <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @if($permissionsArr['meal-master']==1) <li><a href="{{route('meal-master')}}">Meal Plan List </a></li> @endif
            @if($permissionsArr['add-meal-plan']==1) <li><a href="{{route('add-meal-plan')}}">Add Meal Plan</a></li> @endif
          </ul>
        </li>
      @endif
    
        <li class="top_tiles"><a><i class="fa fa-credit-card" aria-hidden="true"></i>Payment Master <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
           <li><a href="{{route('payment-master')}}">Payment Mode List </a></li>  <li><a href="{{route('add-payment-mode')}}">Add Payment Mode</a></li> 
          </ul>
        </li>
        
         
           
         
    


    </ul>
  </div>
</div>
<?php
                    $userid = Auth::user()->role_id;
                   
                    ?>
                    
<?php  if($userid!=5) { ?>
<input type="hidden" id="role"value="0">

<?php } else { ?>

<input type="hidden" id="role"value="5">
 <?php } ?>
<script>
    $(document).ready(function(){
        // alert('hello');die;
        var role4= $('#role').val();
        if(role4==5){
            // alert(role4);
            
            $('.top_tiles').hide();
        }
        });
</script>
