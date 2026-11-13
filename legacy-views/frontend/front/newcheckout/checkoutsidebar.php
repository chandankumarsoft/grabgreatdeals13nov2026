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
                  table tfoot {
                     border: 0;
                     text-align: right;
                  }

                  table tfoot caption {
                     font-size: 1.3em;
                  }

                  table tfoot thead {
                     border: none;
                     clip: rect(0 0 0 0);
                     height: 1px;
                     margin: -1px;
                     overflow: hidden;
                     padding: 0;
                     position: absolute;
                     width: 1px;
                  }

                  table tfoot tr {
                     border-bottom: 3px solid #ffffff;
                     display: table-row;
                     margin-bottom: .625em;
                  }

                  table tfoot td {
                     border-bottom: 1px solid #ffffff;
                     display: initial;
                     font-size: .8em;
                     text-align: right;
                  }

                  table tfoot td::before {
                     content: attr(data-label);
                     float: left;
                     font-weight: bold;
                     text-transform: uppercase;
                  }

                  table tfoot td:last-child {
                     border-bottom: 0;
                  }
               }
            </style>
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
                  $totalPriceInCart = $g_total_cart_price - $couponDiscountTotalPrice;
                     ?>
                  </strong> </strong>
               </td>
            </tr>
         </tfoot>
      </table>
   </div>
</aside>
<script>
   $('#finalPriceShowSummary').html('<?php echo $this->session->userdata('currency_symbol_session'); ?><?php echo $totalPriceInCart ?>');
</script>
