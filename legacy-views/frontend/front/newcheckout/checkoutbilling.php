<style type="text/css">
   .form-control{
   height: 50px;
   }
   .panel-heading.collapsed .fa-chevron-down,
   .panel-heading .fa-chevron-right {
   display: none;
   }
   .panel-heading.collapsed .fa-chevron-right,
   .panel-heading .fa-chevron-down {
   display: inline-block;
   }
   i.fa {
   cursor: pointer;
   margin-right: 5px;
   }
   .collapsed ~ .panel-body {
   padding: 0;
   }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/countrylist/css/intlTelInput.css">
<script src="<?php echo base_url(); ?>assets/front/countrylist/js/intlTelInput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/countrylist/js/utils.js"></script>
<style>
   .separate-dial-code{
   width:100%;
   }
   .iti{
    position: relative;
    display: block;
}
</style>
<!-- Main Container -->
<section class="main-container col2-right-layout">
   <div class="main container">
      <div class="hidden-lg">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title"
                  data-toggle="collapse" 
                  data-target="#collapseOne">
                  <i class="fa fa-fw fa-chevron-down"></i>
                  <span class="pull-left">Order Summary</span>
                  <span class="pull-right" id="finalPriceShowSummary"></span>             
               </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                  
               <div class="panel-body">
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
                  <span id="cartCouponDiscountErrorMobile" style="color:red;"></span>
                  <div>
                     <form action="<?php echo base_url().'cart-coupon-discount'; ?>" method="post" id="cartCouponDiscountMobile" style="display:inline-flex;">
                        <input type="text" name="cartcoupondiscount" class="form-control" placeholder="Coupon code" style="width:100%; margin: 2px;" value="<?php echo  ($this->session->userdata('couponname')!='') ? $this->session->userdata('couponname') : ''; ?>">
                        <button class="btn btn-primary" type="submit">Apply Coupon</button>
                     </form>
                  </div>
               </aside>
               <script>
               $('#finalPriceShowSummary').html('<?php echo $this->session->userdata('currency_symbol_session'); ?><?php echo $totalPriceInCart ?>');
               </script>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-main col-sm-6 col-xs-12">
            <div style="border: 1px solid #ccc;">
               <div class="row text-center">
                  <div class="d-inline-block col-sm-4">  
                     Email
                  </div>
                  <div class="d-inline-block col-sm-4"> 
                     <?php echo htmlspecialchars($this->session->userdata('cus_email')); ?>
                  </div>
                  <div class="d-inline-block col-sm-4">  
                     <a href="<?php echo base_url(); ?>checkout">Change</a>
                  </div>
               </div>
               <hr>
               <div class="row text-center">
                  <div class="d-inline-block col-sm-4">  
                     Ship to
                  </div>
                  <div class="d-inline-block col-sm-4">                   
                     <?php echo htmlspecialchars($this->session->userdata('shipping_address1')); ?>
                  </div>
                  <div class="d-inline-block col-sm-4">  
                     <a href="<?php echo base_url(); ?>checkout">Change</a>
                  </div>
               </div>
            </div>
            <h4>Billing address</h4>
            <p>Select the address that matches your card or payment method.</p>
            <form id="billingFormCheckout">
               <div style="border: 1px solid #ccc;">
                  <input type="radio" id="sameAsShipping" name="billing_type" checked value="1">
                  <input type="hidden" name="hidden_dublicacy" id="hidden_dublicacy" value="<?php echo time().mt_rand(1000,9999); ?>">
                  <label for="sameAsShipping">Same as shipping address</label>
                  <br>
                  <input type="radio" id="differentbilling" name="billing_type" <?php if ($this->session->userdata('billing_type')==2) {
                    echo "checked"; 
                  } ?> value="2">
                  <label for="differentbilling">Use a different billing address</label>
                  <div class="box-border" <?php if ($this->session->userdata('billing_type')==2) { echo "style='display:block;'"; } else { echo "style='display:none;'"; }?>>
                     <ul style="list-style:none;">
                        <li class="row">
                           <div class="col-sm-6">
                              <label for="billing_first_name"></label>
                              <input class="input form-control" type="text" name="billing_first_name" id="billing_first_name" placeholder="First Name" value="<?php echo htmlspecialchars($this->session->userdata('billing_first_name')); ?>">
                              <span class="text-danger" id="billing_first_name_error"></span>
                           </div>
                           <!--/ [col] -->
                           <div class="col-sm-6">
                              <label for="billing_last_name"></label>
                              <input class="input form-control" type="text" name="billing_last_name" id="billing_last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($this->session->userdata('billing_last_name')); ?>">
                              <span class="text-danger" id="billing_last_name_error"></span>
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->                        
                        <li class="row">
                           <div class="col-sm-12">
                              <label for="phone_for_exclusive_offer" class="required"></label>
                              <input type="tel" id="billingphone" class="form-control" value="<?php echo $this->session->userdata('billing_mobile_number'); ?>">
                              <input type="hidden" name="billing_mobile_number" id="billing_mobile_number">
                              <span id="billing_mobile_error" style="display:block;"></span>
                              <span id="billingvalidmsg" class="hide" style="display:block;">✓ Valid</span>
                              <span id="billingerrormsg" class="hide" style="color:red;display:block;"></span>
                              <span id="phone_for_exclusive_offer_error" style="display:block;"></span>                       
                           </div>
                        </li>
                        <li class="row">
                           <div class="col-sm-12">
                              <label for="billing_company_name"></label>
                              <input class="input form-control" type="text" name="billing_company_name" id="billing_company_name" value="<?php echo htmlspecialchars($this->session->userdata('billing_company_name')); ?>" placeholder="Company Name (optional)">
                           </div>
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-xs-12">
                              <label for="billing_address1" class="required"></label>
                              <input class="input form-control" type="text" name="billing_address1" id="billing_address1" placeholder="Address" value="<?php echo htmlspecialchars($this->session->userdata('billing_address1')); ?>">
                              <span class="text-danger" id="billing_address1_error"></span>
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->                     
                        <li class="row">
                           <div class="col-xs-12">
                              <label for="billing_address2" class="required"></label>
                              <input class="input form-control" type="text" name="billing_address2" id="billing_address2" value="<?php echo htmlspecialchars($this->session->userdata('billing_address2')); ?>" placeholder="Apartment, suite, etc. (optional)">
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-12">
                              <label for="billing_city" class="required"></label>
                              <input class="input form-control" type="text" name="billing_city" id="billing_city" value="<?php echo htmlspecialchars($this->session->userdata('billing_city')); ?>" placeholder="City">
                              <span class="text-danger" id="billing_city_error"></span>
                           </div>
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-4">
                              <label class="required" for="billing_country"></label>
                              <div class="custom_select">
                                 <select class="input form-control" name="billing_country" id="billing_country">
                                    <option value="">--Country--</option>
                                    <?php
                                       $country_data=$this->db->select('*')->from('country')->where_in('id',[14,254,43,113,253])->get()->result();
                                       $indiaAvailable = false;
                                       foreach ($country_data as $country_option) {
                                          if ((int) $country_option->id === 113) {
                                             $indiaAvailable = true;
                                          } ?>
                                    <option
                                       value="<?php echo $country_option->id; ?>"
                                       <?php if ($country_option->id==$this->session->userdata('billing_country')) {
                                          echo "selected";
                                          } ?>
                                       ><?php echo $country_option->country; ?></option>
                                    <?php }
                                       if (! $indiaAvailable) { ?>
                                    <option value="113" <?php if (113 == $this->session->userdata('billing_country')) { echo "selected"; } ?>>India</option>
                                    <?php } ?>
                                 </select>
                                 <span class="text-danger" id="billing_country_error"></span>
                              </div>
                           </div>
                           <script>
                              $('#billing_country').on('change', function() {
                                $countriesID=this.value;
                                $.ajax({
                                 type:'POST',
                                 url:'<?php echo base_url(); ?>Country_controller_state',
                                 data:{country_id:$countriesID},
                                    success:function(successResponse){
                                       $('#billing_state').html(successResponse);
                                    }
                                });
                              });
                           </script>
                           <!--/ [col] -->
                           <!--/ [col] -->
                           <div class="col-sm-4">
                              <label class="required" for="billing_state"></label>
                              <div class="custom_select">
                                 <select class="input form-control" name="billing_state" id="billing_state">
                                    <option value="">State</option>
                                      <?php 
                                       $selectedSID=$this->db->select('*')->from('region')->where('country_id',$this->session->userdata('billing_country'))->get()->result(); 
                                       foreach ($selectedSID as $selectedSIDValue) { ?>
                                         <option value="<?php echo $selectedSIDValue->id; ?>" <?php if ($selectedSIDValue->id==$this->session->userdata('billing_state')) {
                                           echo "selected";
                                         } ?>><?php echo $selectedSIDValue->region; ?></option>
                                      <?php 
                                       }
                                      ?>
                                 </select>
                                 <span class="text-danger" id="billing_state_error"></span>
                              </div>
                           </div>
                           <!--/ [col] -->
                           <div class="col-sm-4">
                              <label for="billing_postal_code" class="required"></label>
                              <input class="input form-control" type="text" name="billing_postal_code" id="billing_postal_code" value="<?php echo htmlspecialchars($this->session->userdata('billing_postal_code')); ?>" placeholder="Zip/Postal Code">
                              <span class="text-danger" id="billing_postal_code_error"></span>
                           </div>
                           <!--/ [col] -->
                           <br>
                           <div class="col-sm-12">
                              <input type="checkbox" name="save_info_for_next_time" name="save_info_for_next_time" id="save_info_for_next_time" value="1">
                              <span>Save this information for next time</span>
                            </div>
                        </li>
                        <!--/ .row -->
                     </ul>
                  </div>
               </div>
               <button class="button" type="submit" style="margin-bottom: 10px;margin-top: 10px;"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue to payment</span></button>
            </form>
         </div>
         <div class="col-main col-sm-6 col-xs-12 hidden-xs">            
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
         <span id="cartCouponDiscountError" style="color:red;"></span>
         <div>
            <form action="<?php echo base_url().'cart-coupon-discount'; ?>" method="post" id="cartCouponDiscount" style="display:inline-flex;">
               <input type="text" name="cartcoupondiscount" class="form-control" placeholder="Coupon code" style="width:100%; margin: 2px;" value="<?php echo  ($this->session->userdata('couponname')!='') ? $this->session->userdata('couponname') : ''; ?>">
               <button class="btn btn-primary" type="submit">Apply Coupon</button>
            </form>
         </div>
         </div>
      </div>
   </div>
</section>
<!-- Main Container End -->

<script>
  $("#billing_first_name").keyup(function () {
    billing_first_name_fun();
  });

function billing_first_name_fun() {
  var shipping_address_value = $("#billing_first_name").val();
  if (shipping_address_value.length == '') {
    $("#billing_first_name_error").show();
    $("#billing_first_name_error").html("Enter first name");
    $("#billing_first_name_error").focus();
    $("#billing_first_name_error").css("color", "red");
    $("#billing_first_name").css("background-color", "white");
    $("#billing_first_name").css("color", "black");
    $("#billing_first_name").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $('#billing_first_name_error').show();
    $("#billing_first_name_error").html("");
    $('#billing_first_name_error').focus();
    $("#billing_first_name_error").css("color", "green");
    $("#billing_first_name").css("border", "#04ed14 solid 1px");
    return true;
  }
}

$("#billing_last_name").keyup(function () {
  billing_last_name_fun();
});

function billing_last_name_fun() {
  var shipping_address_value = $("#billing_last_name").val();
  if (shipping_address_value.length == '') {
    $("#billing_last_name_error").show();
    $("#billing_last_name_error").html("Enter last name");
    $("#billing_last_name_error").focus();
    $("#billing_last_name_error").css("color", "red");
    $("#billing_last_name").css("background-color", "white");
    $("#billing_last_name").css("color", "black");
    $("#billing_last_name").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $('#billing_last_name_error').show();
    $("#billing_last_name_error").html("");
    $('#billing_last_name_error').focus();
    $("#billing_last_name_error").css("color", "green");
    $("#billing_last_name").css("border", "#04ed14 solid 1px");
    return true;
  }
}

$("#billing_address1").keyup(function () {
  billing_address1_fun();
});

function billing_address1_fun() {
  var shipping_address_value = $("#billing_address1").val();
  if (shipping_address_value.length == '') {
    $("#billing_address1_error").show();
    $("#billing_address1_error").html("Enter your Address");
    $("#billing_address1_error").focus();
    $("#billing_address1_error").css("color", "red");
    $("#billing_address1").css("background-color", "white");
    $("#billing_address1").css("color", "black");
    $("#billing_address1").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $('#billing_address1_error').show();
    $("#billing_address1_error").html("");
    $('#billing_address1_error').focus();
    $("#billing_address1_error").css("color", "green");
    $("#billing_address1").css("border", "#04ed14 solid 1px");
    return true;
  }
}

$("#billing_city").keyup(function () {
  billing_city_fun();
});

function billing_city_fun() {
  var billing_city_value = $("#billing_city").val();
  if (billing_city_value.length == '') {
    $("#billing_city_error").show();
    $("#billing_city_error").html("Enter your City Name");
    $("#billing_city_error").focus();
    $("#billing_city_error").css("color", "red");
    $("#billing_city").css("background-color", "white");
    $("#billing_city").css("color", "black");
    $("#billing_city").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $('#billing_city_error').show();
    $("#billing_city_error").html("");
    $('#billing_city_error').focus();
    $("#billing_city_error").css("color", "green");
    $("#billing_city").css("border", "#04ed14 solid 1px");
    return true;
  }
}

$("#billing_country").on('change', function () {
  billing_country_fun();
});

function billing_country_fun() {
  var billing_country_value = $("#billing_country").val();
  if (billing_country_value.length == '') {
    $("#billing_country_error").show();
    $("#billing_country_error").html("Select your Country Name");
    $("#billing_country_error").focus();
    $("#billing_country_error").css("color", "red");
    $("#billing_country").css("background-color", "white");
    $("#billing_country").css("color", "black");
    $("#billing_country").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $('#billing_country_error').show();
    $("#billing_country_error").html("");
    $('#billing_country_error').focus();
    $("#billing_country_error").css("color", "green");
    $("#billing_country").css("border", "#04ed14 solid 1px");
    return true;
  }
}

$("#billing_state").on('change', function () {
  billing_state_fun();
});

function billing_state_fun() {
  var billing_state_value = $("#billing_state").val();
  if (billing_state_value.length == '') {
    $("#billing_state_error").show();
    $("#billing_state_error").html("Select your state Name");
    $("#billing_state_error").focus();
    $("#billing_state_error").css("color", "red");
    $("#billing_state").css("background-color", "white");
    $("#billing_state").css("color", "black");
    $("#billing_state").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $('#billing_state_error').show();
    $("#billing_state_error").html("");
    $('#billing_state_error').focus();
    $("#billing_state_error").css("color", "green");
    $("#billing_state").css("border", "#04ed14 solid 1px");
    return true;
  }
}

$("#billing_postal_code").keyup(function () {
  billing_zip_fun();
});

function billing_zip_fun() {
  var billing_postal_code_value = $("#billing_postal_code").val();
  if (billing_postal_code_value.length == '') {
    $("#billing_postal_code_error").show();
    $("#billing_postal_code_error").html("Enter Postal Code");
    $("#billing_postal_code_error").focus();
    $("#billing_postal_code_error").css("color", "red");
    $("#billing_postal_code").css("background-color", "white");
    $("#billing_postal_code").css("color", "black");
    $("#billing_postal_code").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $('#billing_postal_code_error').show();
    $("#billing_postal_code_error").html("");
    $('#billing_postal_code_error').focus();
    $("#billing_postal_code_error").css("color", "green");
    $("#billing_postal_code").css("border", "#04ed14 solid 1px");
    return true;
  }
}

$("#billingphone").keyup(function () {
  billing_mobile_fun();
});

function billing_mobile_fun() {
  var billing_mobile_value = $.trim($("#billingphone").val());
  if (billing_mobile_value.length == '') {
    $("#billing_mobile_error").show();
    $("#billing_mobile_error").html("Enter Mobile No");
    $("#billing_mobile_error").focus();
    $("#billing_mobile_error").css("color", "red");
    $("#billingphone").css("background-color", "white");
    $("#billingphone").css("color", "black");
    $("#billingphone").css("border", "#f71e0e solid 1px");
    return false;
  } else {
    $("#billing_mobile_error").hide();
    $("#billingphone").css("border", "");
    return true;
  }
} 
</script>

<script>
  $("#billingFormCheckout").submit(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form. 
    var radioValue = $("input[name='billing_type']:checked").val();
    if (radioValue == 2) {
      billing_first_name_fun();
      billing_last_name_fun();
      billing_mobile_fun();
      billing_address1_fun();
      billing_city_fun();
      billing_country_fun();
      billing_state_fun();
      billing_zip_fun();
      if (billing_first_name_fun() && billing_last_name_fun() && billing_address1_fun() && billing_city_fun() && billing_country_fun() && billing_state_fun() && billing_zip_fun() && billingintl.isValidNumber() == true) {
        $("#billing_mobile_number").val(billingintl.getNumber());
        $.ajax({
          type: "POST",
          dataType: "json",
          url: '<?php echo base_url(); ?>checkout-billing-save',
          data: $(this).serialize(), // serializes the form's elements.
          success: function (data) {

            if (data.status == 'ok') {
              window.location.href = "checkout-payment";
            }
          }
        });
      } else {}
    } else {
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '<?php echo base_url(); ?>checkout-billing-save',
        data: {
          billing_type: 1
        }, // serializes the form's elements.
        success: function (data) {

          if (data.status == 'ok') {
            window.location.href = "checkout-payment";
          }
        }
      });
    }
  }); 
</script>

<script>
    $(function() {
   $("input[name='billing_type']").click(function() {
     if ($("#differentbilling").is(":checked")) {
       $(".box-border").show();
     } else {
       $(".box-border").hide();
     }
   });
 });
</script>

<script>
  var billingphoneinput = document.querySelector("#billingphone"),
    billingerrorMsg = document.querySelector("#billingerrormsg"),
    billingvalidMsg = document.querySelector("#billingvalidmsg");

var billingerrorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

var billingintl = window.intlTelInput(billingphoneinput, {
  container: 'body',
  autoHideDialCode: true,
  autoPlaceholder: "ON",
  dropdownContainer: document.body,
  formatOnDisplay: true,
  nationalMode: true,
  placeholderNumberType: "MOBILE",
  preferredCountries: ['IN'],
  separateDialCode: true,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get('https://ipinfo.io/json?token=5cfcc113d1ef6a', function () {}, "jsonp").always(function (resp) {
      var countrynameaoutofetch = (resp && resp.country) ? resp.country : "us";
      callback(countrynameaoutofetch);
    });
  },
});
var billingreset = function () {
  billingphoneinput.classList.remove("error");
  billingerrorMsg.innerHTML = "";
  billingerrorMsg.classList.add("hide");
  billingvalidMsg.classList.add("hide");
};

billingphoneinput.addEventListener('blur', function () {
  billingreset();
  if (billingphoneinput.value.trim()) {
    if (billingintl.isValidNumber()) {
      billingvalidMsg.classList.remove("hide");
    } else {
      billingphoneinput.classList.add("error");
      var billingerrorCode = billingintl.getValidationError();
      billingerrorMsg.innerHTML = billingerrorMap[billingerrorCode];
      billingerrorMsg.classList.remove("hide");
    }
  }
});

billingphoneinput.addEventListener('change', billingreset);
billingphoneinput.addEventListener('keyup', billingreset); 
</script>
<script>
$(document).ready(function () {
$("#cartCouponDiscountMobile").submit(function (e) {
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
window.location.reload();
}
if (data.error_msg_validation) {
$('#cartCouponDiscountErrorMobile').html(data.error_msg_validation);
}
}
});
});
});
</script>
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
window.location.reload();
}
if (data.error_msg_validation) {
$('#cartCouponDiscountError').html(data.error_msg_validation);
}
}
});
});
});
</script>
<?php
$cart_id_arr = [];
$reference_pro_id = null;
foreach ($cart_content as $items) {
    $cart_id_arr[] = $items['id'];
    if ($reference_pro_id === null) {
        $reference_pro_id = $items['id'];
    }
}

if ($reference_pro_id !== null) {
    $selected_upsell_pro_id = $this->db->select('upsell_pro_id')
        ->from('tbl_upsell_product')
        ->where('reference_pro_id', $reference_pro_id)
        ->get()
        ->row();

    if (
        $selected_upsell_pro_id !== null
        && ! empty($selected_upsell_pro_id->upsell_pro_id)
        && ! in_array($selected_upsell_pro_id->upsell_pro_id, $cart_id_arr)
    ) {
        $this->load->view('front/newcheckout/checkoutupsell');
    }
}
?>