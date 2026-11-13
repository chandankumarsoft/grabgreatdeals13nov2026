<!-- Main Container -->
<section class="main-container col2-left-layout" id="uiui">
   <div class="main container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
            <div class="my-account">
               <div class="page-title text-center">
                  <h2>Your Orders</h2>
               </div>
               <?php
               if (!empty($order_data_details)) {
               ?>
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="table-responsive">
                              <table class="table">
                                 <thead>
                                 <a href="<?php echo base_url().'my-order/'.$order_data_value->order_id; ?>">
                                    <tr>
                                       <th>ORDER DATE</th>
                                       <th>TOTAL</th>
                                       <th>SHIP TO</th>
                                       <th>ORDER No</th>
                                    </tr>
                                 </a>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td><?php echo $order_data_details->createdon; ?></td>
                                       <td><?php echo $order_data_details->order_amount_withcurrency.' '.$order_data_details->curreny_code; ?></td>
                                       <td><?php echo $order_data_details->ship_name; ?></td>
                                       <td><?php echo $order_data_details->invoice_no; ?><td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="panel">
                              <div class="panel">
                                 Billing Address
                              </div>
                              <div class="row">
                                 <div class="col-lg-6"><strong>Name</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->bill_name; ?></div>
                                 <div class="col-lg-6"><strong>Email</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->bill_email; ?></div>
                                 <div class="col-lg-6"><strong>Mobile</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->bill_mobile; ?></div>
                                 <div class="col-lg-6"><strong>Address</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->bill_address; ?></div>
                                 <div class="col-lg-6"><strong>City</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->bill_city; ?></div>
                                 <div class="col-lg-6"><strong>Country</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->country_name; ?></div>
                                 <div class="col-lg-6"><strong>State</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->state_name; ?></div>
                                 <div class="col-lg-6"><strong>Postal Code</strong></div>
                                 <div class="col-lg-6"><?php echo $bill_info->bill_zip; ?></div>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="panel">
                              <div class="panel">
                                 Shipping Address
                              </div>
                              <div class="row">
                                 <div class="col-lg-6"><strong>Name</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->ship_name; ?></div>
                                 <div class="col-lg-6"><strong>Email</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->ship_email; ?></div>
                                 <div class="col-lg-6"><strong>Mobile</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->ship_mobile; ?></div>
                                 <div class="col-lg-6"><strong>Address</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->ship_address; ?></div>
                                 <div class="col-lg-6"><strong>City</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->ship_city; ?></div>
                                 <div class="col-lg-6"><strong>Country</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->country_name; ?></div>
                                 <div class="col-lg-6"><strong>State</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->state_name; ?></div>
                                 <div class="col-lg-6"><strong>Postal Code</strong></div>
                                 <div class="col-lg-6"><?php echo $ship_info->ship_zip; ?></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">Image</th>
                              <th class="text-center">Product Name</th>
                              <th class="text-center">Color</th>
                              <th class="text-center">Size</th>
                              <th class="text-center">Quantity</th>
                              <th class="text-center">Unit Price</th>
                              <th class="text-center">Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              $order_details_info = $this->ProfileModel->get_order_details($order_data_details->order_id);
                              $total=0;
                              foreach ($order_details_info as $order) {?>
                           <tr class="odd gradeX">
                              <td class="text-center" style="width: 15%;height: 15%;"><img src="<?php echo 'https://www.seller.grabgreatdeals.com/uploads/'.$order->pro_image; ?>" alt="cart" class="img-responsive"></td>
                              <td class="text-center"><?php echo $order->product_name; ?></td>
                              <td class="text-center"><?php echo $order->product_color; ?></td>
                              <td class="text-center"><?php echo $order->product_size; ?></td>
                              <td class="text-center"><?php echo $order->sales_quantity; ?></td>
                              <td class="text-center"><?php echo $order->product_amount_withcurrency.' '.$order->amount_currency_code; ?></td>
                              <td class="text-center"><?php echo $order->sales_quantity * $order->product_amount_withcurrency.' '.$order->amount_currency_code;?></td>
                           </tr>
                           <?php 
                              $total = $total+$order->sales_quantity * $order->product_amount_withcurrency;
                                 
                               } ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="7" class="text-right">
                                 <h5>Total : <?php echo $total.' '.$order->amount_currency_code; ?> </h5>
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <?php
               }else{
               ?>
               <div class="panel panel-default">
                    <div class="panel-heading">Order Details</div>
                    <div class="panel-body">You have not placed any orders.</div>
               </div>              
               <?php   
               }
               ?>
            </div>
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</section>