<style type="text/css">
   .form-style-2{
   max-width: 500px;
   padding: 20px 12px 10px 20px;
   font: 13px Arial, Helvetica, sans-serif;
   }
   .form-style-2-heading{
   font-weight: bold;
   font-style: italic;
   border-bottom: 2px solid #ddd;
   margin-bottom: 20px;
   font-size: 15px;
   padding-bottom: 3px;
   }
   .form-style-2 label{
   display: block;
   margin: 0px 0px 15px 0px;
   }
   .form-style-2 label > span{
   width: 100px;
   font-weight: bold;
   float: left;
   padding-top: 8px;
   padding-right: 5px;
   }
   .form-style-2 span.required{
   color:red;
   }
   .form-style-2 .tel-number-field{
   width: 40px;
   text-align: center;
   }
   .form-style-2 input.input-field, .form-style-2 .select-field{
   width: 48%;
   }
   .form-style-2 input.input-field,
   .form-style-2 .tel-number-field,
   .form-style-2 .textarea-field,
   .form-style-2 .select-field{
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
   border: 1px solid #C2C2C2;
   box-shadow: 1px 1px 4px #EBEBEB;
   -moz-box-shadow: 1px 1px 4px #EBEBEB;
   -webkit-box-shadow: 1px 1px 4px #EBEBEB;
   border-radius: 3px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   padding: 7px;
   outline: none;
   }
   .form-style-2 .input-field:focus,
   .form-style-2 .tel-number-field:focus,
   .form-style-2 .textarea-field:focus,
   .form-style-2 .select-field:focus{
   border: 1px solid #0C0;
   }
   .form-style-2 .textarea-field{
   height:100px;
   width: 55%;
   }
   .form-style-2 input[type=submit],
   .form-style-2 input[type=button]{
   border: none;
   padding: 8px 15px 8px 15px;
   background: #FF8500;
   color: #fff;
   box-shadow: 1px 1px 4px #DADADA;
   -moz-box-shadow: 1px 1px 4px #DADADA;
   -webkit-box-shadow: 1px 1px 4px #DADADA;
   border-radius: 3px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   }
   .form-style-2 input[type=submit]:hover,
   .form-style-2 input[type=button]:hover{
   background: #EA7B00;
   color: #fff;
   }
</style>
<div class="main-container col2-left-layout">
   <div class="container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
   <!-- div class="main container"> -->
     <!--  <div class="col-main"> -->
         <div class="cart">
            <div class="page-content page-order">
               <div class="page-title">
                  <h2>Shopping Cart</h2>
               </div>
               <div class="order-detail-content">
                  <div class="table-responsive">
                     <table class="table table-bordered cart_summary">
                        <thead>
                           <tr>
                              <th class="cart_product">Product</th>
                              <th>Description</th>
                              <th>Unit price</th>
                              <th>Qty</th>
                              <th>Total</th>
                              <th  class="action"><i class="fa fa-trash-o"></i></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $cart_content = $this->cart->contents(); ?>
                           <?php foreach ($cart_content as $items){ ?>
                           <tr>
                              <td class="cart_product"><a href="#"><img width="100" src="<?php echo $items['options']['pro_image']?>" alt="Product"></a></td>
                              <td class="cart_description">
                                 <p class="product-name"><a href="#"><?php echo $items['name']?></a></p>
                              </td>
                              <td class="price"><span>$<?php echo $items['price']?></span></td>
                              <td class="qty">
                                 <div class="cart_quantity_button">
                                    <form action="<?php echo base_url()?>update-cart-qty" method="post">
                                       <input class="cart_quantity_input" type="text" name="qty" value="<?php echo $items['qty']?>" autocomplete="off" size="2">
                                       <input  type="hidden" name="rowid" value="<?php echo $items['rowid']?>">
                                       <input  type="submit" style="margin-top: 5px;"  value="Update"/>
                                    </form>
                                       </div>
                                    </td>
                                    <td class="price"><span>$<?php echo $items['subtotal']?></span></td>
                                    <td class="action"><form method="post" action="<?php echo base_url()?>delete-to-cart/<?php echo esc((string) $items['rowid'], 'attr'); ?>" style="display:inline;"><button type="submit" style="border:0;background:transparent;padding:0;"><i class="icon-close"></i></button></form></td>
                                 </tr>
                                 <?php } ?>
                              </tbody>
                              <tfoot>
                              <?php $cart_total = $this->cart->total(); ?>
                              <tr>
                                 <td colspan="2" rowspan="3"></td>
                                 <td colspan="3">Total products</td>
                                 <td colspan="2">$<?php echo $cart_total;?> </td>
                              </tr>
                              <?php
                              $shiping = "0";
                              if($cart_total>0 && $cart_total<49){
                              $shiping = 0;
                              }elseif($cart_total>50 && $cart_total<98){
                              $shiping = 2;
                              }elseif($cart_total>99 && $cart_total<198){
                              $shiping = 5;
                              }elseif($cart_total>199){
                              $shiping = 10;
                              }elseif($cart_total<0){
                              $shiping = 0;
                              }
                              ?>
                              <tr>
                                 <td colspan="3">Shipping Cost Estimated Time : 14-21 Days</td>
                                 <td colspan="2"><strong>$<?php echo $shiping?> </strong></td>
                              </tr>
                              <tr>
                                 <?php $g_total = $cart_total+$shiping;?>
                                 <?php
                                 $gdata = array();
                                 $gdata['g_total'] = $g_total;
                                 $this->session->set_userdata($gdata);
                                 ?>
                                 <td colspan="3"><strong>Total</strong></td>
                                 <td colspan="2"><strong>$<?php echo "$g_total"; ?> </strong></td>
                              </tr>
                              </tfoot>
                           </table>
                        </div>
                        
                        <div class="cart_navigation">
                           <a class="continue-btn" href="<?php echo base_url(); ?>"><i class="fa fa-arrow-left"> </i>&nbsp; Continue shopping</a>
                           <form action="<?php echo base_url()?>update-cart-qty" method="post" >
                              <input type="submit" class="btn btn-default update"  value="Update"/>
                              <?php $customer_id = $this->session->userdata('cus_id'); ?>
                              <?php $shipping_id = $this->session->userdata('shipping_id'); ?>                              
                              <a class="checkout-btn" href="<?php echo base_url()?>checkout"><i class="fa fa-check"></i> Proceed to checkout</a>
                              
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
           <!--  </div> -->
   <!--       </div> -->
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</div>