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
               if (!empty($order_data)) {
               foreach ($order_data as $order_data_value) {
               ?>
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="row">
                       <a class="table-row" href="<?php echo base_url().'my-order/'.$order_data_value->order_id; ?>" title="Click More Details">
                        <div class="col-lg-12">
                           <div class="table-responsive">
                              <table class="table">
                                 <thead>
                                    <tr>
                                       <th>ORDER DATE</th>
                                       <th>TOTAL</th>
                                       <th>SHIP TO</th>
                                       <th>ORDER No</th>
                                    </tr>
                                 </thead>                                
                                 <tbody>
                                    <tr>
                                       <td><?php echo $order_data_value->createdon; ?></td>
                                       <td><?php echo $order_data_value->order_amount_withcurrency.' '.$order_data_value->curreny_code; ?></td>
                                       <td><?php echo $order_data_value->ship_name; ?></td>
                                       <td><?php echo $order_data_value->invoice_no; ?><td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                         </a>
                     </div>
                  </div>
                  <div class="panel-body">
                     <table class="col-md-12">
                        <tbody>
                           <?php
                           $products = $this->ProfileModel->get_order_details($order_data_value->order_id);
                           foreach ($products as $productsObj) {                              
                           ?>
                           <tr>
                              <td class="th-product" style="width: 100px;height: 100px;">
                                 <a href="<?php echo base_url()?>product-details/<?php echo $productsObj->pro_title_slug; ?>">
                                    <img src="<?php echo 'https://www.seller.grabgreatdeals.com/uploads/'.$productsObj->pro_image; ?>" alt="cart" class="img-responsive">
                                 </a>
                              </td>
                              <td class="th-details" style="vertical-align: middle;">
                                 <p style="margin-left: 10px;">
                                    <a href="<?php echo base_url()?>product-details/<?php echo $productsObj->pro_title_slug; ?>"><?php echo $productsObj->pro_title;?>                                  
                                    </a>
                                 </p>
                              </td>
                              <td class="th-price" style="display: grid;">
                                <!--  <button>button</button>
                                 <button>button</button>
                                 <button>button</button> -->
                              </td>
                           </tr>
                          <?php  }?>

                        </tbody>
                     </table>
                  </div>
               </div>
               <?php
               }
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