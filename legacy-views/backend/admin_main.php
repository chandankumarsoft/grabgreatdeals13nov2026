<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- Page Header -->
      <div class="col-lg-12">
         <h1 class="page-header" style="border-bottom: 1px solid #c2b4b4;">Dashboard</h1>
      </div>
      <!--End Page Header -->
   </div>
   <?php if (($this->session->userrole == 1)) { ?>
      <div class="row">
         <!--quick info section -->
         <div class="col-lg-12">
            <div class="col-lg-4">
               <div class="card-for-dashboard text-center">
                  <a href="admin/customer-details">
                     <p>TOTAL CUSTOMERS</p>
                     <span><?php echo $total_customer; ?></span>
                  </a>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="card-for-dashboard text-center">
                  <a href="admin/manage-order">
                     <p>TOTAL ORDERS</p>
                     <span><?php echo $total_order; ?></span>
                  </a>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="card-for-dashboard text-center">
                  <a href="<?php base_url(); ?>admin/manage-order?view_status=0&payment_status=2&payment_type=&tracking_status=&currency=">
                     <p>NEW ORDERS</p>
                     <span><?php echo $new_order; ?></span>
                  </a>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="card-for-dashboard text-center">
                  <p class="text-center" style="font-weight:bold;">Total Completed Sales</p>
                  <table class="table">
                     <thead>
                        <tr>
                           <?php
                           foreach ($total_order_currecy as $total_order_currecy_value) {
                              echo "<th>$total_order_currecy_value->curreny_code</th>";
                           }
                           ?>
                        </tr>
                     </thead>
                     <tbody style="text-align:justify;">
                        <tr>
                           <?php
                           foreach ($total_order_currecy as $total_order_currecy_value) {
                              echo "<td><p>" . round($total_order_currecy_value->amount, 2) . "</p></td>";
                           }
                           ?>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <!--end quick info section -->
      </div>
   <?php } ?>
</div>
<!-- end page-wrapper -->