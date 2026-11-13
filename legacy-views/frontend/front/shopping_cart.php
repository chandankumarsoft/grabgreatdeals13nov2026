<section class="main-container col1-layout">
   <div class="main container">
   <div class="col-main">
      <div class="cart">
         <div class="page-content page-order">
            <div class="page-title">
               <h2>Shopping Cart</h2>
            </div>
            <?php
               $cart_content = $this->cart->contents();
               if(empty($cart_content)){
               ?>
            <div>
               <p>Your cart is currently empty.</p>
            </div>
            <div>
               <a class="btn btn-default" href="<?php echo base_url(); ?>" style="color: aliceblue;background-color: #0083c1;"><i class="fa fa-arrow-left"> </i>&nbsp;Continue shopping
               </a>
            </div>
            <?php
               }else{
               
               ?>
            <style>
               table {
               border: 1px solid #ccc;
               border-collapse: collapse;
               margin: 0;
               padding: 0;
               width: 100%;
               table-layout: auto;
               }
               table caption {
               font-size: 1.5em;
               margin: .5em 0 .75em;
               }
               table tr {
               background-color: #ffffff;
               border: 1px solid #e5e5e5;
               padding: .35em;
               }
               table th,
               table td {
               padding: .625em;
               text-align: center;
               }
               table th {
               font-size: .85em;
               letter-spacing: .1em;
               text-transform: uppercase;
               }
               @media screen and (max-width: 600px) {
               table {
               border: 0;
               }
               table caption {
               font-size: 1.3em;
               }
               table thead {
               border: none;
               clip: rect(0 0 0 0);
               height: 1px;
               margin: -1px;
               overflow: hidden;
               padding: 0;
               position: absolute;
               width: 1px;
               }
               table tr {
               border-bottom: 3px solid #f5f5f5;
               display: block;
               margin-bottom: .625em;
               }
               table td {
               border-bottom: 1px solid #eaeaea;
               display: block;
               font-size: .8em;
               text-align: right;
               }
               table td::before {
               /*
               * aria-label has no advantage, it won't be read inside a table
               content: attr(aria-label);
               */
               content: attr(data-label);
               float: left;
               font-weight: bold;
               text-transform: uppercase;
               }
               table td:last-child {
               border-bottom: 0;
               }
               }
               @media screen and (max-width: 600px) {
               table td.shippingchargedesign::before {
               content: attr(data-label);
               float: none;
               font-weight: bold;
               text-transform: uppercase;
               }
               }
            </style>
            <table>
               <thead>
                  <tr>
                     <th scope="col">PRODUCT</th>
                     <th scope="col">DESCRIPTION</th>
                     <th scope="col">SHIPPING</th>
                     <th scope="col">UNIT PRICE</th>
                     <th scope="col">QTY</th>
                     <th scope="col">TOTAL</th>
                     <th scope="col"><i class="fa fa-trash-o"></i></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $cart_content = $this->cart->contents();                     
                  ?>
                  <?php 
                   $shipping_amount_value=0;
                    foreach ($cart_content as $items){
                    $shipping_amount_select=$this->db->select('shipping_amount')->from('tbl_shipping_charge')->where('id',$items['shipping_method'])->get()->row();
                    $shipping_amount_value+=$shipping_amount_select->shipping_amount;
                   ?>
                  <tr>
                     <td data-label="PRODUCT"><a href="javascript:void(0)"><img width="100" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'. $items['options']['pro_image']?>" alt="Product"></a></td>
                     <td data-label="DESCRIPTION" class="text-justify shippingchargedesign">
                        <p class="product-name"><a href="javascript:void(0)"><?php echo $items['name'];?></a></p>
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
                     <td data-label="SHIPPING" class="text-justify shippingchargedesign" style="display:grid;">
                        <?php
                          $shipping_method_select = $this->db->select('TSC.id,TSC.shipping_description,TSC.shipping_amount')->from('tbl_shipping_charge TSC')->join('tbl_shipping_charge_relation TSCR','TSC.id = TSCR.ship_charge_id','INNER')->join('tbl_product TP','TP.pro_id = TSCR.pro_id')->where('TP.pro_id', $items['id'])->get()->result();
                          $shipping_charge_no=0;
                          foreach ($shipping_method_select as $shipping_method_selectvalue) {
                           $shipping_charge_no++;
                        ?>
                        <li style="list-style: none;display: inline-flex;" class="text-left text-justifyt">
                           <input type="radio" name="<?php echo 'shipping_method'.$items['id']; ?>" id="<?php echo 'shipping_method'.$items['id'].$shipping_method_selectvalue->id; ?>" value="<?php echo $shipping_method_selectvalue->id; ?>" data-rowid="<?php echo $items['rowid']?>" class="shipping_method" <?php echo ($items['shipping_method']==$shipping_method_selectvalue->id) ? 'checked' : '' ?>>
                           <label for="<?php echo 'shipping_method'.$items['id'].$shipping_method_selectvalue->id; ?>" style="margin-left: 5px;font-weight: 500;">
                              <?php echo $shipping_method_selectvalue->shipping_description; ?>
                              <strong>
                              <?php echo currencyConverterFunction($shipping_method_selectvalue->shipping_amount); ?>
                           </strong>
                           </label>
                        </li>
                        <?php
                          }
                        ?>
                     </td>
                     <td data-label="UNIT PRICE"><span><?php echo currencyConverterFunction($items['price']); ?></span></td>
                     <td data-label="QTY">
                        <div class="cart_quantity_button">
                           <form action="<?php echo base_url()?>update-cart-qty" method="post">
                              <input class="cart_quantity_input" type="text" name="qty" value="<?php echo $items['qty']?>" autocomplete="off" size="2">
                              <input  type="hidden" name="rowid" value="<?php echo $items['rowid']?>">
                              <input  type="submit" style="margin-top: 5px;background-color: #337ab7;  color: #ffffff;padding: 2px;"  value="Update"/>
                           </form>
                        </div>
                     </td>
                     <td data-label="TOTAL"><span><?php echo currencyConverterFunction($items['subtotal']); ?></span></td>
                     <td data-label="REMOVE"><form method="post" action="<?php echo base_url()?>delete-to-cart/<?php echo esc((string) $items['rowid'], 'attr'); ?>" style="display:inline;"><button type="submit" style="border:0;background:transparent;padding:0;"><i class="icon-close"></i></button></form></td>
                  </tr>
                  <?php } ?>
               </tbody>
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
                            $this->session->set_userdata('total_shipping_charge_price',$shipping_amount_value);
                            echo currencyConverterFunction($shipping_amount_value);
                             $shipping_amount_value=preg_replace( '/[^0-9.]/', '', currencyConverterFunction($shipping_amount_value)); 
                             $g_total_cart_price+=$shipping_amount_value;
                        ?> </strong></td>
                  </tr>
                  <?php if ($this->session->userdata('couponprice')!='') { ?>
                  <tr>
                     <td colspan="3">Coupon Discount:<?php  echo $this->session->userdata('couponprice').'%'; ?></td>
                     <td colspan="2"><?php echo $this->session->userdata('currency_symbol_session'); ?><?php echo $couponDiscountTotalPrice; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                     <td colspan="3" style="font-size: initial;font-weight: bold;"><strong>Total:</strong></td>
                     <td colspan="2">
                        <strong>                        
                        <?php echo $this->session->userdata('currency_symbol_session'); ?><?php echo $g_total_cart_price - $couponDiscountTotalPrice; ?>
                        </strong>
                     </td>
                  </tr>
               </tfoot>
            </table>
            <div class="cart_navigation">
               <span id="cartCouponDiscountError" style="color:red;"></span>
               <div>
                  <form action="<?php echo base_url().'cart-coupon-discount'; ?>" method="post" id="cartCouponDiscount" style="display:inline-flex;">
                     <input type="text" name="cartcoupondiscount" class="form-control" placeholder="Coupon code" style="width:100%; margin: 2px;" value="<?php echo  ($this->session->userdata('couponname')!='') ? $this->session->userdata('couponname') : ''; ?>">
                     <button class="btn btn-primary" type="submit">Apply Coupon</button>
                  </form>
               </div>
               <div>
                  <?php $customer_id = $this->session->userdata('cus_id'); ?>
                  <?php $shipping_id = $this->session->userdata('shipping_id'); ?>
                  <a class="checkout-btn" href="<?php echo base_url()?>checkout"><i class="fa fa-check" style="background: #333e48;border: 2px solid #333e48;"></i> Proceed to checkout</a>
               </div>
            </div>
         </div>
         <?php
            }
            ?>
      </div>
   </div>
</section>
<script>
   $(document).ready(function () {
      $("#cartCouponDiscount").submit(function (e) {
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: "json",
            success: function (data) {
               if (data.error_msg == "success") {
                  window.location.href = "<?php echo base_url(); ?>show-cart";
               }
               if (data.error_msg_validation) {
                  $('#cartCouponDiscountError').html(data.error_msg_validation);
               }
            }
         });
      });
   });
</script>
<script>
$(document).ready(function () {
   $('.shipping_method').on('change', function () {
      $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>update-cart-qty-shipping",
         data: {
            rowid: $(this).attr('data-rowid'),
            shipping_method: $(this).val()
         },
         dataType: "json",
         beforeSend: function () {
            swal({
               title: "Loading...",
               text: "Please wait",
               icon: "<?php echo base_url(); ?>assets/front/images/loading/loadingcart.gif",
               button: false,
               closeOnClickOutside: false,
               closeOnEsc: false
            });
         },
         success: function (data) {
            if (data.error_msg == "success") {
               window.location.href = "<?php echo base_url(); ?>show-cart";
            }
         }
      });
   });
});
</script>