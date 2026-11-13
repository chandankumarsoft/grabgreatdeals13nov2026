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
         <div class="page-content checkout-page">
            <h4>Contact information</h4>
            <p>Already have an account?Log in</p>
            <form id="signUpFormCheckout">
               <div class="box-border">
                  <ul>
                     <li class="row">
                        <div class="col-xs-12">
                           <input type="text" class="input form-control" name="account_email" id="account_email" value="<?php echo htmlspecialchars($this->session->userdata('account_email')); ?>" placeholder="Email">
                           <span class="text-danger" id="account_email_error"></span>
                           <br>
                           <input type="checkbox" name="exclusive_offer" id="exclusive_offer" value="1">
                           <span>Sign up for exclusive offers and news via text messages & email.</span>
                        </div>
                        <!--/ [col] -->
                     </li>
                  </ul>
               </div>
               <h4>Shipping address</h4>
               <div class="box-border">
                  <ul>
                     <li class="row">
                        <div class="col-sm-6">
                           <label for="shipping_first_name"></label>
                           <input class="input form-control" type="text" name="shipping_first_name" id="shipping_first_name" value="<?php echo htmlspecialchars($this->session->userdata('shipping_first_name')); ?>" placeholder="First Name">
                           <span class="text-danger" id="shipping_first_name_error"></span>
                        </div>
                        <!--/ [col] -->
                        <div class="col-sm-6">
                           <label for="shipping_last_name"></label>
                           <input class="input form-control" type="text" name="shipping_last_name" id="shipping_last_name" value="<?php echo htmlspecialchars($this->session->userdata('shipping_last_name')); ?>" placeholder="Last Name">
                           <span class="text-danger" id="shipping_last_name_error"></span>
                        </div>
                        <!--/ [col] -->
                     </li>
                     <!--/ .row -->                     
                     <li class="row">
                        <div class="col-sm-12">
                           <label for="phone_for_exclusive_offer" class="required"></label>
                           <input type="tel" id="shippingphone" class="form-control" value="<?php echo $this->session->userdata('shipping_mobile_number'); ?>">
                           <input type="hidden" placeholder="Mobile" name="shipping_mobile_number" id="shipping_mobile_number" class="form-control">
                           <span id="shipping_mobile_error" style="display:block;"></span>
                           <span id="shippingvalidmsg" class="hide" style="display:block;">✓ Valid</span>
                           <span id="shippingerrormsg" class="hide" style="color:red;display:block;"></span>
                           <span id="phone_for_exclusive_offer_error" style="display:block;"></span>
                        </div>
                     </li>
                     <li class="row">
                        <div class="col-sm-12">
                           <label for="shipping_company_name"></label>
                           <input class="input form-control" type="text" name="shipping_company_name" id="shipping_company_name" value="<?php echo htmlspecialchars($this->session->userdata('shipping_company_name')); ?>" placeholder="Company Name (optional)">
                        </div>
                     </li>
                     <!--/ .row -->
                     <li class="row">
                        <div class="col-xs-12">
                           <label for="shipping_address1" class="required"></label>
                           <input class="input form-control" type="text" name="shipping_address1" id="shipping_address1" value="<?php echo htmlspecialchars($this->session->userdata('shipping_address1')); ?>" placeholder="Address">
                           <span class="text-danger" id="shipping_address1_error"></span>
                        </div>
                        <!--/ [col] -->
                     </li>
                     <!--/ .row -->
                     <li class="row">
                        <div class="col-xs-12">
                           <label for="shipping_address2" class="required"></label>
                           <input class="input form-control" type="text" value="<?php echo htmlspecialchars($this->session->userdata('shipping_address2')); ?>" name="shipping_address2" id="shipping_address2" placeholder="Apartment, suite, etc. (optional)">
                        </div>
                        <!--/ [col] -->
                     </li>
                     <!--/ .row -->
                     <li class="row">
                        <div class="col-sm-12">
                           <label for="shipping_city" class="required"></label>
                           <input class="input form-control" type="text" value="<?php echo htmlspecialchars($this->session->userdata('shipping_city')); ?>" name="shipping_city" id="shipping_city" placeholder="City">
                           <span class="text-danger" id="shipping_city_error"></span>
                        </div>
                     </li>
                     <!--/ .row -->
                     <li class="row">
                        <div class="col-sm-4">
                           <label class="required" for="shipping_country"></label>
                           <div class="custom_select">
                              <select class="input form-control" name="shipping_country" id="shipping_country">
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
                                    <?php if ($country_option->id==$this->session->userdata('shipping_country')) {
                                    echo "selected";
                                    } ?>
                                 ><?php echo $country_option->country; ?></option>
                                 <?php }
                                    if (! $indiaAvailable) { ?>
                                 <option value="113" <?php if (113 == $this->session->userdata('shipping_country')) { echo "selected"; } ?>>India</option>
                                 <?php } ?>
                              </select>
                              <span class="text-danger" id="shipping_country_error"></span>
                           </div>
                        </div>
                        <script>
                        $('#shipping_country').on('change', function() {
                        $countriesID=this.value;
                        $.ajax({
                        type:'POST',
                        url:'<?php echo base_url(); ?>Country_controller_state',
                        data:{country_id:$countriesID},
                        success:function(successResponse){
                        $('#shipping_state').html(successResponse);
                        }
                        });
                        });
                        </script>
                        <!--/ [col] -->
                        <!--/ [col] -->
                        <div class="col-sm-4">
                           <label class="required" for="shipping_state"></label>
                           <div class="custom_select">
                              <select class="input form-control" name="shipping_state" id="shipping_state">
                                 <option value="">State</option>
                                 <?php
                                 $selectedSID=$this->db->select('*')->from('region')->where('country_id',$this->session->userdata('shipping_country'))->get()->result();
                                 foreach ($selectedSID as $selectedSIDValue) { ?>
                                 <option value="<?php echo $selectedSIDValue->id; ?>" <?php if ($selectedSIDValue->id==$this->session->userdata('shipping_state')) {
                                    echo "selected";
                                 } ?>><?php echo $selectedSIDValue->region; ?></option>
                                 <?php
                                 }
                                 ?>
                              </select>
                              <span class="text-danger" id="shipping_state_error"></span>
                           </div>
                        </div>
                        <!--/ [col] -->
                        <div class="col-sm-4">
                           <label for="shipping_postal_code" class="required"></label>
                           <input class="input form-control" type="text" value="<?php echo htmlspecialchars($this->session->userdata('shipping_postal_code')); ?>" name="shipping_postal_code" id="shipping_postal_code" placeholder="Zip/Postal Code">
                           <span class="text-danger" id="shipping_postal_code_error"></span>
                        </div>
                        <!--/ [col] -->
                        <br>
                        <div class="col-sm-12">
                           <input type="checkbox" name="save_info_for_next_time" name="save_info_for_next_time" id="save_info_for_next_time" value="1">
                           <span>Save this information for next time</span>
                        </div>
                     </li>
                     <!--/ .row -->
                     <button class="button" type="submit"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue to billing</span></button>
                     <a href="<?php echo base_url(); ?>">
                        <button class="button" type="button"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue to shopping</span></button>
                     </a>
                  </ul>
               </div>
            </form>
         </div>
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
      </aside>
      <script>
      $('#finalPriceShowSummary').html('<?php echo $this->session->userdata('currency_symbol_session'); ?><?php echo $totalPriceInCart ?>');
      </script>
   </div>
</div>
</div>
</section>
<!-- Main Container End -->
<script>
$("#shippingphone").keyup(function () {
shipping_mobile_fun();
});
function shipping_mobile_fun() {
var shipping_mobile_value = $.trim($("#shippingphone").val());
if (shipping_mobile_value.length == '') {
$("#shipping_mobile_error").show();
$("#shipping_mobile_error").html("Enter Mobile No");
$("#shipping_mobile_error").focus();
$("#shipping_mobile_error").css("color", "red");
$("#shippingphone").css("background-color", "white");
$("#shippingphone").css("color", "black");
$("#shippingphone").css("border", "#f71e0e solid 1px");
return false;
} else {
$("#shipping_mobile_error").hide();
$("#shippingphone").css("border", "");
return true;
}
}
$("#account_email").keyup(function () {
shipping_account_email_fun();
});
function shipping_account_email_fun() {
var shipping_account_email_value = $("#account_email").val();
var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if (shipping_account_email_value.length == '') {
$("#account_email_error").show();
$("#account_email_error").html("Enter Email Id");
$("#account_email_error").focus();
$("#account_email_error").css("color", "red");
$("#account_email").css("background-color", "white");
$("#account_email").css("color", "black");
$("#account_email").css("border", "#f71e0e solid 1px");
return false;
} else {}
if (!regex.test(shipping_account_email_value)) {
$("#account_email_error").show();
$("#account_email_error").html("Valid Email Address");
$("#account_email_error").focus();
$("#account_email_error").css("color", "red");
$("#account_email").css("background-color", "white");
$("#account_email").css("color", "black");
$("#account_email").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#account_email_error').show();
$("#account_email_error").html("");
$('#account_email_error').focus();
$("#account_email_error").css("color", "green");
$("#account_email").css("border", "#04ed14 solid 1px");
return true;
}
}
$("#shipping_first_name").keyup(function () {
shipping_first_name_fun();
});
function shipping_first_name_fun() {
var shipping_address_value = $("#shipping_first_name").val();
if (shipping_address_value.length == '') {
$("#shipping_first_name_error").show();
$("#shipping_first_name_error").html("Enter first name");
$("#shipping_first_name_error").focus();
$("#shipping_first_name_error").css("color", "red");
$("#shipping_first_name").css("background-color", "white");
$("#shipping_first_name").css("color", "black");
$("#shipping_first_name").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#shipping_first_name_error').show();
$("#shipping_first_name_error").html("");
$('#shipping_first_name_error').focus();
$("#shipping_first_name_error").css("color", "green");
$("#shipping_first_name").css("border", "#04ed14 solid 1px");
return true;
}
}
$("#shipping_last_name").keyup(function () {
shipping_last_name_fun();
});
function shipping_last_name_fun() {
var shipping_address_value = $("#shipping_last_name").val();
if (shipping_address_value.length == '') {
$("#shipping_last_name_error").show();
$("#shipping_last_name_error").html("Enter last name");
$("#shipping_last_name_error").focus();
$("#shipping_last_name_error").css("color", "red");
$("#shipping_last_name").css("background-color", "white");
$("#shipping_last_name").css("color", "black");
$("#shipping_last_name").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#shipping_last_name_error').show();
$("#shipping_last_name_error").html("");
$('#shipping_last_name_error').focus();
$("#shipping_last_name_error").css("color", "green");
$("#shipping_last_name").css("border", "#04ed14 solid 1px");
return true;
}
}
$("#shipping_address1").keyup(function () {
shipping_address1_fun();
});
function shipping_address1_fun() {
var shipping_address_value = $("#shipping_address1").val();
if (shipping_address_value.length == '') {
$("#shipping_address1_error").show();
$("#shipping_address1_error").html("Enter your Address");
$("#shipping_address1_error").focus();
$("#shipping_address1_error").css("color", "red");
$("#shipping_address1").css("background-color", "white");
$("#shipping_address1").css("color", "black");
$("#shipping_address1").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#shipping_address1_error').show();
$("#shipping_address1_error").html("");
$('#shipping_address1_error').focus();
$("#shipping_address1_error").css("color", "green");
$("#shipping_address1").css("border", "#04ed14 solid 1px");
return true;
}
}
$("#shipping_city").keyup(function () {
shipping_city_fun();
});
function shipping_city_fun() {
var shipping_city_value = $("#shipping_city").val();
if (shipping_city_value.length == '') {
$("#shipping_city_error").show();
$("#shipping_city_error").html("Enter your City Name");
$("#shipping_city_error").focus();
$("#shipping_city_error").css("color", "red");
$("#shipping_city").css("background-color", "white");
$("#shipping_city").css("color", "black");
$("#shipping_city").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#shipping_city_error').show();
$("#shipping_city_error").html("");
$('#shipping_city_error').focus();
$("#shipping_city_error").css("color", "green");
$("#shipping_city").css("border", "#04ed14 solid 1px");
return true;
}
}
$("#shipping_country").on('change', function () {
shipping_country_fun();
});
function shipping_country_fun() {
var shipping_country_value = $("#shipping_country").val();
if (shipping_country_value.length == '') {
$("#shipping_country_error").show();
$("#shipping_country_error").html("Select your Country Name");
$("#shipping_country_error").focus();
$("#shipping_country_error").css("color", "red");
$("#shipping_country").css("background-color", "white");
$("#shipping_country").css("color", "black");
$("#shipping_country").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#shipping_country_error').show();
$("#shipping_country_error").html("");
$('#shipping_country_error').focus();
$("#shipping_country_error").css("color", "green");
$("#shipping_country").css("border", "#04ed14 solid 1px");
return true;
}
}
$("#shipping_state").on('change', function () {
shipping_state_fun();
});
function shipping_state_fun() {
var shipping_state_value = $("#shipping_state").val();
if (shipping_state_value.length == '') {
$("#shipping_state_error").show();
$("#shipping_state_error").html("Select your state Name");
$("#shipping_state_error").focus();
$("#shipping_state_error").css("color", "red");
$("#shipping_state").css("background-color", "white");
$("#shipping_state").css("color", "black");
$("#shipping_state").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#shipping_state_error').show();
$("#shipping_state_error").html("");
$('#shipping_state_error').focus();
$("#shipping_state_error").css("color", "green");
$("#shipping_state").css("border", "#04ed14 solid 1px");
return true;
}
}
$("#shipping_postal_code").keyup(function () {
shipping_zip_fun();
});
function shipping_zip_fun() {
var shipping_postal_code_value = $("#shipping_postal_code").val();
if (shipping_postal_code_value.length == '') {
$("#shipping_postal_code_error").show();
$("#shipping_postal_code_error").html("Enter Postal Code");
$("#shipping_postal_code_error").focus();
$("#shipping_postal_code_error").css("color", "red");
$("#shipping_postal_code").css("background-color", "white");
$("#shipping_postal_code").css("color", "black");
$("#shipping_postal_code").css("border", "#f71e0e solid 1px");
return false;
} else {
$('#shipping_postal_code_error').show();
$("#shipping_postal_code_error").html("");
$('#shipping_postal_code_error').focus();
$("#shipping_postal_code_error").css("color", "green");
$("#shipping_postal_code").css("border", "#04ed14 solid 1px");
return true;
}
}
</script>
<script>
$("#signUpFormCheckout").submit(function (e) {
e.preventDefault(); // avoid to execute the actual submit of the form.
shipping_first_name_fun();
shipping_last_name_fun();
shipping_account_email_fun();
shipping_mobile_fun();
shipping_address1_fun();
shipping_city_fun();
shipping_country_fun();
shipping_state_fun();
shipping_zip_fun();
if (shipping_first_name_fun() && shipping_last_name_fun() && shipping_account_email_fun() && shipping_address1_fun() && shipping_city_fun() && shipping_country_fun() && shipping_state_fun() && shipping_zip_fun() && shippingintl.isValidNumber() == true) {
$("#shipping_mobile_number").val(shippingintl.getNumber());
$.ajax({
type: "POST",
dataType: "json",
url: '<?php echo base_url(); ?>checkout-shipping-save',
data: $(this).serialize(), // serializes the form's elements.
success: function (data) {
if (data.account_email_error) {
$('#account_email_error').html(data.account_email_error);
} else {
$('#account_email_error').html('');
}
if (data.shipping_first_name_error) {
$('#shipping_first_name_error').html(data.shipping_first_name_error);
} else {
$('#shipping_first_name_error').html('');
}
if (data.shipping_last_name_error) {
$('#shipping_last_name_error').html(data.shipping_last_name_error);
} else {
$('#shipping_last_name_error').html('');
}
if (data.shipping_address1_error) {
$('#shipping_address1_error').html(data.shipping_address1_error);
} else {
$('#shipping_address1_error').html('');
}
if (data.shipping_city_error) {
$('#shipping_city_error').html(data.shipping_city_error);
} else {
$('#shipping_city_error').html('');
}
if (data.shipping_country_error) {
$('#shipping_country_error').html(data.shipping_country_error);
} else {
$('#shipping_country_error').html('');
}
if (data.shipping_state_error) {
$('#shipping_state_error').html(data.shipping_state_error);
} else {
$('#shipping_state_error').html('');
}
if (data.shipping_postal_code_error) {
$('#shipping_postal_code_error').html(data.shipping_postal_code_error);
} else {
$('#shipping_postal_code_error').html('');
}
if (data.status == 'ok') {
window.location.href = "checkout-billing";
}
}
});
} else {
}
});
</script>
<script>
var shippingphoneinput = document.querySelector("#shippingphone"),
shippingerrorMsg = document.querySelector("#shippingerrormsg"),
shippingvalidMsg = document.querySelector("#shippingvalidmsg");
var shippingerrorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
var shippingintl = window.intlTelInput(shippingphoneinput, {
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
var shippingreset = function () {
shippingphoneinput.classList.remove("error");
shippingerrorMsg.innerHTML = "";
shippingerrorMsg.classList.add("hide");
shippingvalidMsg.classList.add("hide");
};
shippingphoneinput.addEventListener('blur', function () {
shippingreset();
if (shippingphoneinput.value.trim()) {
if (shippingintl.isValidNumber()) {
shippingvalidMsg.classList.remove("hide");
} else {
shippingphoneinput.classList.add("error");
var shippingerrorCode = shippingintl.getValidationError();
shippingerrorMsg.innerHTML = shippingerrorMap[shippingerrorCode];
shippingerrorMsg.classList.remove("hide");
}
}
});
shippingphoneinput.addEventListener('change', shippingreset);
shippingphoneinput.addEventListener('keyup', shippingreset);
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