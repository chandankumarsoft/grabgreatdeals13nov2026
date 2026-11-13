<!--  page-wrapper -->
<div id="page-wrapper" style="background:#fff">
   <div class="row">
      <!-- Page Header -->
      <div class="col-lg-12">
         <h1 class="page-header">Order Details</h1>
      </div>
      <!--End Page Header -->
   </div>
   <div class="row">
      <div class="col-lg-6">
         <div class="panel panel-primary">
            <div class="panel-heading">
               Billing Address
            </div>
            <div class="panel-body">
               <form action="">
                  <div class="row">
                     <div class="col-lg-6"><strong>Name</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($bill_info->bill_name); ?>">
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Email</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($bill_info->bill_email); ?>">
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Mobile</strong></div>
                     <div class="col-lg-6"><?php echo esc($bill_info->bill_mobile); ?></div>
                     <br>
                     <div class="col-lg-6"><strong>Company Name</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($bill_info->bill_cus_company); ?>">                        
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Address</strong></div>
                     <div class="col-lg-6">
                        <textarea class="form-control" cols="10" rows="2"><?php echo esc($bill_info->bill_address); ?></textarea>
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Apartment,Suite,etc</strong></div>
                     <div class="col-lg-6">
                        <textarea class="form-control" cols="10" rows="2"><?php echo esc($bill_info->bill_address2); ?></textarea>                        
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>City</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($bill_info->bill_city); ?>">
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Country</strong></div>
                     <div class="col-lg-6">
                        <select name="" id="" class="form-control">
                           <option value=""><?php echo esc($bill_info->country_name); ?></option>
                        </select>                        
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>State</strong></div>
                     <div class="col-lg-6">
                        <select name="" id="" class="form-control">
                           <option><?php echo esc($bill_info->state_name); ?></option>
                        </select>                        
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Postal Code</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($bill_info->bill_zip); ?>">
                     </div>
                  </div>
                  <div class="col-lg-12">                     
                     <input type="submit" class="btn btn-primary" value="Update">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="panel panel-primary">
            <div class="panel-heading">
               Shipping Address
            </div>
            <div class="panel-body">
               <form action="">
                  <div class="row">
                     <div class="col-lg-6"><strong>Name</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($ship_info->ship_name); ?>">
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Email</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($ship_info->ship_email); ?>">
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Mobile</strong></div>
                     <div class="col-lg-6"><?php echo esc($ship_info->ship_mobile); ?></div>
                     <br>
                     <div class="col-lg-6"><strong>Company Name</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($ship_info->ship_company_name); ?>">
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Address</strong></div>
                     <div class="col-lg-6">
                        <textarea class="form-control" cols="10" rows="2"><?php echo esc($ship_info->ship_address); ?></textarea>
                        
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Apartment,Suite,etc</strong></div>
                     <div class="col-lg-6">
                        <textarea class="form-control" cols="10" rows="2"><?php echo esc($ship_info->ship_address2); ?></textarea>                     
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>City</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($ship_info->ship_city); ?>">
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Country</strong></div>
                     <div class="col-lg-6">
                        <select name="" id="" class="form-control">
                              <option><?php echo esc($ship_info->country_name); ?></option>
                        </select>                     
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>State</strong></div>
                     <div class="col-lg-6">
                        <select name="" id="" class="form-control">
                              <option><?php echo esc($ship_info->state_name); ?></option>
                        </select>                     
                     </div>
                     <br>
                     <div class="col-lg-6"><strong>Postal Code</strong></div>
                     <div class="col-lg-6">
                        <input type="text" class="form-control" value="<?php echo esc($ship_info->ship_zip); ?>">
                     </div>
                  </div>
                  <div class="col-lg-12">                     
                     <input type="submit" class="btn btn-primary" value="Update">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-heading">
            Invoice# <?php echo esc($order_info->invoice_no)?>
            </div>
            <h5>
               Invoice Date: <?php $date=  $order_info->createdon;
                  echo date('d-M-Y',strtotime($date));
                  ?>
            </h5>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <!-- Advanced Tables -->
         <div class="panel panel-primary">
            <div class="panel-heading">
               Order Details
            </div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                     <thead>
                        <tr>
                           <th>Product Name</th>
                           <th>Color</th>
                           <th>Size</th>
                           <th>Quantity</th>
                           <th>Unit Price</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $total=0;
                           $currencyCode = $order_info->curreny_code ?? '';
                           foreach ($order_details_info as $order) {?>
                        <tr class="odd gradeX">
                           <td><?php echo esc($order->product_name); ?></td>
                           <td><?php echo esc($order->color_name); ?></td>
                           <td><?php echo esc($order->size_name); ?></td>
                           <td><?php echo esc($order->sales_quantity); ?></td>
                           <td><?php echo esc($order->product_amount_withcurrency.' '.$order->amount_currency_code); ?></td>
                           <td class="center"><?php echo esc($order->sales_quantity * $order->product_amount_withcurrency.' '.$order->amount_currency_code);?></td>
                        </tr>
                        <?php 
                           $total = $total+$order->sales_quantity * $order->product_amount_withcurrency;
                           $currencyCode = $order->amount_currency_code;
                              
                            } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <!--End Advanced Tables -->   
      </div>
   </div>
   <div class="row">
      <div class="col-lg-4"></div>
      <div class="col-lg-4"></div>
      <div class="col-lg-4">
         <div class="panel panel-primary">
            <div class="panel-heading">
               Amount Calcutation
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-6"><strong>Total</strong></div>
                  <div class="col-lg-6"><?php echo esc($total.' '.$currencyCode); ?></div>
               </div>
            </div>
            <!-- <div class="panel-footer">
               Panel Footer
               </div> -->
         </div>
      </div>
   </div>
   <div class="row">
         <div class="panel panel-primary">
            <div class="panel-heading">
               Payment Details
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-6"><strong>Card Details</strong></div>
                  <div class="col-lg-6">N/A</div>
               </div>
            </div>
            <!-- <div class="panel-footer">
               Panel Footer
               </div> -->
         </div>
   </div>
</div>
<!-- end page-wrapper -->