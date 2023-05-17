<?php
$permissionsArr = getMenuPermission();
?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
      <?php if($permissionsArr['dashboard']==1): ?> <li><a href="<?php echo e(route('new-dashboard')); ?>"><i class="fa fa-home"></i> <?php echo e(lang_trans('sidemenu_dashboard')); ?> </a></li> <?php endif; ?>

      <?php if($permissionsArr['arrival']==1 && ($permissionsArr['add-arrival'] || $permissionsArr['list-arrival'] || $permissionsArr['list-check-outs']) ): ?>
        <li><a><i class="fa fa-money"></i><?php echo e(lang_trans('sidemenu_arrival')); ?> <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-arrival']==1): ?> <li><a href="<?php echo e(route('room-arrival-reservation')); ?>"><?php echo e(lang_trans('sidemenu_arrival_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-arrival']==1): ?> <li><a href="<?php echo e(route('list-arrival-reservation')); ?>"><?php echo e(lang_trans('sidemenu_arrival_all')); ?> </a></li> <?php endif; ?>
            <li><a href="<?php echo e(route('rooms-inventory')); ?>">Inventory</a></li>
          </ul>
        </li>
      <?php endif; ?>
      <?php if($permissionsArr['check-in']==1 && ($permissionsArr['add-check-in'] || $permissionsArr['single-check-in'] || $permissionsArr['multi-check-in'] || $permissionsArr['list-check-outs']) ): ?>
        <li><a><i class="fa fa-money"></i><?php echo e(lang_trans('sidemenu_checkin')); ?> <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-check-in']==1): ?> <li><a href="<?php echo e(route('room-reservation')); ?>"><?php echo e(lang_trans('sidemenu_checkin_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['single-check-in']==1): ?> <li><a href="<?php echo e(route('single-list-reservation')); ?>"><?php echo e(lang_trans('sidemenu_single_checkin')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['multi-check-in']==1): ?> <li><a href="<?php echo e(route('multi-list-reservation')); ?>"><?php echo e(lang_trans('sidemenu_multi_checkin')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-check-outs']==1): ?> <li><a href="<?php echo e(route('list-check-outs')); ?>"><?php echo e(lang_trans('sidemenu_checkout_all')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>


      <?php if($permissionsArr['users']==1 && ($permissionsArr['add-users'] || $permissionsArr['list-users']) ): ?>
        <li><a><i class="fa fa-user"></i><?php echo e(lang_trans('sidemenu_users')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <?php if($permissionsArr['add-users']==1): ?> <li><a href="<?php echo e(route('add-user')); ?>"><?php echo e(lang_trans('sidemenu_user_add')); ?> </a></li> <?php endif; ?>
             <?php if($permissionsArr['list-users']==1): ?> <li><a href="<?php echo e(route('list-user')); ?>"><?php echo e(lang_trans('sidemenu_user_all')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if($permissionsArr['housekeeping']==1): ?> <li><a href="<?php echo e(route('housekeeping')); ?>"><i class="fa fa-home"></i> <?php echo e(lang_trans('sidemenu_housekeeping')); ?> </a></li> <?php endif; ?>
      <?php if($permissionsArr['tas']==1): ?>
        <li><a><i class="fa fa-user"></i><?php echo e(lang_trans('sidemenu_corporate')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
          <?php if($permissionsArr['add-corporate']==1): ?> <li><a href="<?php echo e(route('add-corporate')); ?>"><?php echo e(lang_trans('sidemenu_corporate_add')); ?> </a></li> <?php endif; ?>
          <?php if($permissionsArr['list-corporate']==1): ?>    <li><a href="<?php echo e(route('list-corporate')); ?>"><?php echo e(lang_trans('sidemenu_corporate_all')); ?> </a></li> <?php endif; ?>
          <?php if($permissionsArr['add-ta']==1): ?>    <li><a href="<?php echo e(route('add-ta')); ?>"><?php echo e(lang_trans('sidemenu_ta_add')); ?> </a></li> <?php endif; ?>
          <?php if($permissionsArr['list-ta']==1): ?>   <li><a href="<?php echo e(route('list-ta')); ?>"><?php echo e(lang_trans('sidemenu_ta_all')); ?> </a></li> <?php endif; ?>
          <?php if($permissionsArr['add-ota']==1): ?>   <li><a href="<?php echo e(route('add-ota')); ?>"><?php echo e(lang_trans('sidemenu_ota_add')); ?> </a></li> <?php endif; ?>
          <?php if($permissionsArr['list-ota']==1): ?>   <li><a href="<?php echo e(route('list-ota')); ?>"><?php echo e(lang_trans('sidemenu_ota_all')); ?> </a></li>  <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>
          <?php if($permissionsArr['billing']==1): ?>
        <li><a><i class="fa fa-user"></i>Billing<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
         <li><a href="<?php echo e(route('billing',['type'=>'corporate'])); ?>">Corporate Billing </a></li>
         <li><a href="<?php echo e(route('billing',['type'=>'ota'])); ?>">OTA Billing </a></li>
           <li><a href="<?php echo e(route('billing',['type'=>'ta'])); ?>">TA Billing </a></li>
          </ul>
        </li>
      <?php endif; ?>
      <?php if($permissionsArr['customers']==1 && ($permissionsArr['add-customers'] || $permissionsArr['list-customers']) ): ?>
        <li><a><i class="fa fa-user"></i><?php echo e(lang_trans('sidemenu_customers')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <?php if($permissionsArr['add-customers']==1): ?> <li><a href="<?php echo e(route('add-customer')); ?>"><?php echo e(lang_trans('sidemenu_customer_add')); ?> </a></li> <?php endif; ?>
             <?php if($permissionsArr['list-customers']==1): ?> <li><a href="<?php echo e(route('list-customer')); ?>"><?php echo e(lang_trans('sidemenu_customer_all')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if($permissionsArr['email']==1): ?>
        <li><a><i class="fa fa-user"></i><?php echo e(lang_trans('Report')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
          <?php if($permissionsArr['reports']==1): ?> <li><a href="<?php echo e(route('report')); ?>">All Reports </a></li><?php endif; ?>
          <?php if($permissionsArr['reports']==1): ?> <li><a href="<?php echo e(route('reportExcel')); ?>">Reports </a></li><?php endif; ?>
           <?php if($permissionsArr['daily-report']==1): ?> <li><a href="<?php echo e(route('daily-report')); ?>">Daily Report </a></li><?php endif; ?>
          <?php if($permissionsArr['add-email']==1): ?> <li><a href="<?php echo e(route('add-email')); ?>">Add Email </a></li> <?php endif; ?>
          <?php if($permissionsArr['list-email']==1): ?>  <li><a href="<?php echo e(route('list-email')); ?>">Emails List </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>
      <!-- <?php if($permissionsArr['report']==1): ?>
      <li><i class="fa fa-file"></i> <?php echo e(lang_trans('Report')); ?><span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu">
            <li><a href="<?php echo e(route('report')); ?>"><?php echo e(lang_trans('Report')); ?></a></li>
          </ul>
          </li>
      <?php endif; ?> -->

      <?php if($permissionsArr['food-category']==1 || $permissionsArr['food-item']==1): ?>
        <li><a><i class="fa fa-cutlery"></i><?php echo e(lang_trans('sidemenu_fooditems')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-food-category']==1): ?> <li><a href="<?php echo e(route('add-food-category')); ?>"><?php echo e(lang_trans('sidemenu_foodcat_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-food-category']==1): ?> <li><a href="<?php echo e(route('list-food-category')); ?>"><?php echo e(lang_trans('sidemenu_foodcat_all')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['add-food-item']==1): ?> <li><a href="<?php echo e(route('add-food-item')); ?>"><?php echo e(lang_trans('sidemenu_fooditem_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-food-item']==1): ?> <li><a href="<?php echo e(route('list-food-item')); ?>"><?php echo e(lang_trans('sidemenu_fooditem_all')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if($permissionsArr['stocks']==1): ?>
        <li><a><i class="fa fa-cart-plus"></i><?php echo e(lang_trans('sidemenu_stocks')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-product']==1): ?> <li><a href="<?php echo e(route('add-product')); ?>"><?php echo e(lang_trans('sidemenu_product_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-product']==1): ?> <li><a href="<?php echo e(route('list-product')); ?>"><?php echo e(lang_trans('sidemenu_product_all')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['add-stock']==1): ?> <li><a href="<?php echo e(route('io-stock')); ?>"><?php echo e(lang_trans('sidemenu_stock_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['history-stock']==1): ?> <li><a href="<?php echo e(route('stock-history')); ?>"><?php echo e(lang_trans('sidemenu_stock_history')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if($permissionsArr['room-type']==1): ?>
        <li><a><i class="fa fa-home"></i><?php echo e(lang_trans('sidemenu_roomtypes')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-room-type']==1): ?> <li class="sub_menu"><a href="<?php echo e(route('add-room-types')); ?>"><?php echo e(lang_trans('sidemenu_roomtype_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-room-type']==1): ?> <li class="sub_menu"><a href="<?php echo e(route('list-room-types')); ?>"><?php echo e(lang_trans('sidemenu_roomtype_all')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-room-type']==1): ?> <li class="sub_menu"><a href="<?php echo e(route('list-date_price_range')); ?>"><?php echo e(lang_trans('sidemenu_datepricerange_all')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if($permissionsArr['rooms']==1): ?>
      <li><a><i class="fa fa-home"></i><?php echo e(lang_trans('sidemenu_rooms')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-room']==1): ?> <li class="sub_menu"><a href="<?php echo e(route('add-room')); ?>"><?php echo e(lang_trans('sidemenu_room_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-room']==1): ?> <li class="sub_menu"><a href="<?php echo e(route('list-room')); ?>"><?php echo e(lang_trans('sidemenu_room_all')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>
      <?php if($permissionsArr['activities']==1): ?>
      <li><a><i class="fa fa-tag"></i>User Activities<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
         <li class="sub_menu"><a href="<?php echo e(route('user-activity')); ?>">Activities </a></li>
          </ul>
        </li>
        <?php endif; ?>
      <?php if($permissionsArr['amenities']==1): ?>
        <li><a><i class="fa fa-tag"></i><?php echo e(lang_trans('sidemenu_amenities')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-amenities']==1): ?> <li class="sub_menu"><a href="<?php echo e(route('add-amenities')); ?>"><?php echo e(lang_trans('sidemenu_amenities_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-amenities']==1): ?> <li class="sub_menu"><a href="<?php echo e(route('list-amenities')); ?>"><?php echo e(lang_trans('sidemenu_amenities_all')); ?> </a></li> <?php endif; ?>
            <li class="sub_menu"><a href="<?php echo e(route('Add_hotal_amenities')); ?>">Add Hotal Amenities </a></li> 
             <li class="sub_menu"><a href="<?php echo e(route('list-hotal-amenities')); ?>">All Hotal Amenities </a></li> 
            <li class="sub_menu"><a href="<?php echo e(route('Add_availed_services')); ?>">Add Availed Services </a></li> 
            <li class="sub_menu"><a href="<?php echo e(route('list-availed-services')); ?>">All Availed Services </a></li> 
          </ul>
        </li>
      <?php endif; ?>

      <?php if($permissionsArr['expense-categories']==1 || $permissionsArr['expenses']==1): ?>
        <li><a><i class="fa fa-hourglass-start"></i><?php echo e(lang_trans('sidemenu_expense')); ?><span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['add-expense-category']==1): ?> <li><a href="<?php echo e(route('add-expense-category')); ?>"><?php echo e(lang_trans('sidemenu_expensecat_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-expense-category']==1): ?> <li><a href="<?php echo e(route('list-expense-category')); ?>"><?php echo e(lang_trans('sidemenu_expensecat_all')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['add-expenses']==1): ?> <li><a href="<?php echo e(route('add-expense')); ?>"><?php echo e(lang_trans('sidemenu_expense_add')); ?> </a></li> <?php endif; ?>
            <?php if($permissionsArr['list-expenses']==1): ?> <li><a href="<?php echo e(route('list-expense')); ?>"><?php echo e(lang_trans('sidemenu_expense_all')); ?> </a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if($permissionsArr['settings']==1): ?> <li><a href="<?php echo e(route('settings')); ?>"><i class="fa fa-cog"></i><?php echo e(lang_trans('sidemenu_settings')); ?> </a></li> <?php endif; ?>
      <?php if($permissionsArr['permissions']==1): ?> <li><a href="<?php echo e(route('permissions-list')); ?>"><i class="fa fa-universal-access"></i><?php echo e(lang_trans('sidemenu_permissions')); ?> </a></li> <?php endif; ?>

      <?php if($permissionsArr['package-master'] || $permissionsArr['add-package'] ): ?>
      <li><a><i class="fa fa-home"></i> Package Master<span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display : block;">
        <!-- <li><a href="<?php echo e(route('package-master')); ?>">Package List</a></li> -->
        <?php if($permissionsArr['package-master']==1): ?> <li><a href="<?php echo e(route('package-master')); ?>">Package List</a></li> <?php endif; ?>
        <?php if($permissionsArr['add-package']==1): ?> <li><a href="<?php echo e(route('add-package')); ?>">Add Package Plan</a></li> <?php endif; ?>
        <!-- <li><a href="<?php echo e(route('add-package')); ?>">Add Package Plan</a></li> -->
      </ul>
      </li>
      <?php endif; ?>

      <?php if($permissionsArr['meal-master'] || $permissionsArr['add-meal-plan'] ): ?>
        <li><a><i class="fa fa-home"></i>Meal Master <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php if($permissionsArr['meal-master']==1): ?> <li><a href="<?php echo e(route('meal-master')); ?>">Meal Plan List </a></li> <?php endif; ?>
            <?php if($permissionsArr['add-meal-plan']==1): ?> <li><a href="<?php echo e(route('add-meal-plan')); ?>">Add Meal Plan</a></li> <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>
    
        <li><a><i class="fa fa-credit-card" aria-hidden="true"></i>Payment Master <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
           <li><a href="<?php echo e(route('payment-master')); ?>">Payment Mode List </a></li>  <li><a href="<?php echo e(route('add-payment-mode')); ?>">Add Payment Mode</a></li> 
          </ul>
        </li>
    


    </ul>
  </div>
</div>
<?php /**PATH /home/passerine/public_html/58.dsrhotelgroup.com/58/resources/views/layouts/sidebar_backend.blade.php ENDPATH**/ ?>