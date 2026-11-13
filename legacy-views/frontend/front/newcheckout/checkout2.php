<!-- Main Container -->
<section class="main-container col2-right-layout">
   <div class="main container">
      <div class="row">
         <div class="col-main col-sm-6 col-xs-12">
            <div style="border: 1px solid #ccc;">
            <div class="row text-center">
               <div class="d-inline-block col-sm-4">  
                  Contact
               </div>
               <div class="d-inline-block col-sm-4"> 
                  chandankumarsoft@gmail.com
               </div>
               <div class="d-inline-block col-sm-4">  
                  <a href="#">Change</a>
               </div>
            </div>
            <hr>
            <div class="row text-center">
               <div class="d-inline-block col-sm-4">  
                  Ship to
               </div>
               <div class="d-inline-block col-sm-4">                   
               fmt, kolkata, kolkata, 700002 kolkata WB, India
               </div>
               <div class="d-inline-block col-sm-4">  
                  <a href="#">Change</a>
               </div>
            </div>
            </div>

               <h4>Shipping method</h4>
            <div style="border: 1px solid #ccc;">
               <input type="radio">
               <span>Free Tracked Shipping</span>
               <strong class="pull-right">Free</strong>
            </div>
            <button class="button"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue to payment</span></button>
            <a href="#">Return to information</a>
         </div>

         <div class="col-main col-sm-6 col-xs-12">
            <aside class="right sidebar">
               <div class="cart-table cart-table--sm">
                  <table>
                     <thead>
                        <tr>
                           <th scope="col">ITEM</th>
                           <th scope="col">NAME</th>
                           <th scope="col">SHIPPING</th>
                           <th scope="col">QTY</th>
                           <th scope="col">PRICE</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $cart_content = $this->cart->contents();                       
                           ?>
                        <?php
                           $shipping_amount_value=0;                       
                           foreach ($cart_content as $items) { 
                            $shipping_amount_select=$this->db->select('shipping_amount')->from('tbl_shipping_charge')->where('id',$items['shipping_method'])->get()->row();
                            $shipping_amount_value+=$shipping_amount_select->shipping_amount;
                           ?>
                        <tr>
                           <td data-label="PRODUCT"><a href="javascript:void(0)"><img width="100" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'. $items['options']['pro_image']?>" alt="Product"></a></td>
                           <td data-label="ITEM">
                              <p class="product-name text-left"><?php echo $items['name'] ?></p>
                              <p class="text-left">
                                 <?php if ($items['options']['product_color']!='') { ?>                           
                                 Color:<strong>
                                 <?php $selected_color = $this->db->select('color')->from('tbl_color')->where('color_id',$items['options']['product_color'])->get()->row();
                                    echo $selected_color->color;
                                    ?>                                          
                                 </strong>
                                 <?php } ?>
                                 <?php if ($items['options']['product_size']!='') { ?>
                                 Size:<strong>
                                 <?php $selected_size = $this->db->select('size_name')->from('tbl_size')->where('size_id',$items['options']['product_size'])->get()->row();
                                    echo $selected_size->size_name;
                                    ?> 
                                 </strong>
                                 <?php } ?>
                              </p>
                           </td>
                           <td data-label="SHIPPING"><span><?php
                              $shippingchargeamountprint=$this->db->select('shipping_amount')->from('tbl_shipping_charge')->where('id',$items['shipping_method'])->get()->row(); 
                              echo currencyConverterFunction($shippingchargeamountprint->shipping_amount);
                              ?></span>
                           </td>
                           <td data-label="QTY"><span><?php echo $items['qty'] ?></span></td>
                           <td data-label="PRICE"><span><?php echo currencyConverterFunction($items['subtotal']); ?></span></td>
                        </tr>
                        <?php  } ?>
                     </tbody>
                  </table>
               </div>
               <hr>
               <div>
                  <form action="<?php echo base_url().'cart-coupon-discount'; ?>" method="post" id="cartCouponDiscount" style="display:flex;">
                     <input type="text" name="cartcoupondiscount" class="form-control" placeholder="Coupon code" style="width:100%;" value="<?php echo  ($this->session->userdata('couponname')!='') ? $this->session->userdata('couponname') : ''; ?>">
                     <button class="btn btn-primary" type="submit">Apply Coupon</button>
                  </form>
               </div>
               <hr>
               <div class="card-total-sm">
                  <style type="text/css">
                     .card-total-sm {
                     overflow: hidden;
                     background-color: #fbfbfb;
                     padding: 0px 0px 5px;
                     font-size: 14px;
                     font-weight: 600;
                     color: #000;
                     text-transform: uppercase;
                     }
                     caption,
                     th,
                     td {
                     vertical-align: top;
                     text-align: left;
                     font-weight: normal;
                     padding: 5px;
                     }
                  </style>
                  <table style="width: 100%">
                     <tfoot>
                        <?php $cart_total = $this->cart->total(); ?>
                        <tr>
                           <td colspan="2" rowspan="4"></td>
                           <td colspan="3" style="font-size:initial;font-weight:bold;">Total products:</td>
                           <td colspan="2"><?php echo currencyConverterFunction($cart_total); ?> </td>
                        </tr>
                        <?php $g_total = $cart_total;
                           $gdata = array();
                           $gdata['g_total'] = $g_total;
                           $this->session->set_userdata($gdata);
                           $g_total_cart_price = preg_replace( '/[^0-9.]/', '', currencyConverterFunction($g_total));
                           $couponDiscountTotalPrice = percentageCalculator($this->session->userdata('couponprice'),$g_total_cart_price);
                           ?>
                        <tr>
                           <td colspan="3">Total Shipping Charge:</td>
                           <td colspan="2"><strong>
                              <?php 
                                 echo currencyConverterFunction($shipping_amount_value);
                                 $shipping_amount_value=preg_replace( '/[^0-9.]/', '', currencyConverterFunction($shipping_amount_value)); 
                                 $g_total_cart_price+=$shipping_amount_value;
                                  ?>
                              </strong>
                           </td>
                        </tr>
                        <?php if ($this->session->userdata('couponprice')!='') { ?>
                        <tr>
                           <td colspan="3">Coupon Discount:<?php  echo $this->session->userdata('couponprice').'%'; ?></td>
                           <td colspan="2"><?php echo $this->session->userdata('currency_symbol_session'); ?><?php echo $couponDiscountTotalPrice; ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                           <td colspan="3" style="font-size: initial;font-weight: bold;"><strong>Total:</strong></td>
                           <td colspan="2"><strong><strong>
                              <?php echo $this->session->userdata('currency_symbol_session'); ?><?php  echo $g_total_cart_price - $couponDiscountTotalPrice;
                                 ?>
                              </strong> </strong>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </aside>
         </div>
      </div>
   </div>
</section>
<!-- Main Container End -->