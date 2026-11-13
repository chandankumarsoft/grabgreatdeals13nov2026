<?php
$stripePublishableKey = trim((string) env('stripe.publishableKey', ''));
$stripeSecretKey = trim((string) env('stripe.secretKey', ''));
$stripePaymentsEnabled = ENVIRONMENT === 'production'
    ? str_starts_with($stripePublishableKey, 'pk_live_')
        && str_starts_with($stripeSecretKey, 'sk_live_')
    : str_starts_with($stripePublishableKey, 'pk_')
        && str_starts_with($stripeSecretKey, 'sk_');
?>
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
    .stripebutton{
      width:100%;
      border-radius:28px;
      background-color:#2C2E2F;
      color:#ffffff;outline:none;
      line-height: 2;
      outline:none;
      font-weight: 600;
    }
    .stripebutton.focus{
      outline:none;
    }
    .stripebutton.hover{
      outline:none;
    }
   @media (max-width: 576px) {
      .stripebutton{
       width:100%;
       border-radius:28px;
       background-color:#2C2E2F;
       color:#ffffff;
       outline:none;
       line-height:22px;
       font-weight: 600;
      }
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
               <hr>
               <div class="row text-center">
                  <div class="d-inline-block col-sm-4">  
                     Bill to
                  </div>
                  <div class="d-inline-block col-sm-4">   
                   <?php if ($this->session->userdata('billing_type')==1) {
                          echo htmlspecialchars($this->session->userdata('shipping_address1')); 
                          }else{
                           echo htmlspecialchars($this->session->userdata('billing_address1'));
                          }
                   ?>                
                     
                  </div>
                  <div class="d-inline-block col-sm-4">  
                     <a href="<?php echo base_url(); ?>checkout-billing">Change</a>
                  </div>
               </div>
            </div>
            <h4>Payment</h4>
            <?php if ($stripePaymentsEnabled): ?>
            <p>All transactions are secure and encrypted.</p>
            <button class="stripebutton btn btn-lg" data-toggle="collapse" data-target="#demo" style="outline:none;color:#ffffff;">Pay Via Debit/Credit Card</button>
            <div id="demo" class="collapse">
            <script src="https://js.stripe.com/v3/"></script>
            <form id="payment-form">
               <div class="form-group">
               </div>
               <div class="form-group">
                  <label class="font-weight-bold">Full Name</label>
                  <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Full Name">
               </div>
               <div class="form-group">
                  <label class="font-weight-bold">Email For Receipt</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Email">
               </div>
               <div class="form-group">
                  <label class="font-weight-bold">Card Details</label>
                  <div id="card-element" style="background-color: white;border: #dddfe5 1px solid;padding: 10px;">
                  </div>
                  <div id="card-errors" role="alert" class="p-3 mb-2 text-white" style="background-color: #fb641b;
                     color: white;
                     text-align: center;
                     margin-top: 10px;
                     "></div>
               </div>
               <div class="form-group">
                  <button id="submit" class="btn btn-block btn-primary btn-lg" style="background-color:#333e48;border-color: #333e48;">Place Order</button>
               </div>
            </form>
            </div>
            <?php else: ?>
            <p>Card payments are currently unavailable. Please use Cash on Delivery.</p>
            <?php endif; ?>

            <div>
               <hr>
               <h4>Cash on Delivery</h4>
               <p>Pay in cash when your order is delivered.</p>
               <button type="button" id="place-cod-order" class="stripebutton btn btn-lg" style="outline:none;color:#ffffff;">Place Order - Cash on Delivery</button>
               <div id="cod-errors" role="alert" class="text-danger" aria-live="polite"></div>
               <?php if ($stripePaymentsEnabled): ?>
               <script>
                  $('#place-cod-order').on('click', function () {
                     var button = $(this);
                     button.prop('disabled', true);
                     $('#cod-errors').text('');

                     $.ajax({
                        url: '<?php echo base_url(); ?>order-place',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                           hidden_dublicacy: '<?php echo time().mt_rand(1000,9999); ?>',
                           payment_gateway_name: 'cod'
                        }
                     }).done(function (result) {
                        if (result.success !== 'ok') {
                           $('#cod-errors').text(result.error || 'Unable to place your order.');
                           button.prop('disabled', false);
                           return;
                        }

                        $.ajax({
                           url: '<?php echo base_url(); ?>order-completed-success',
                           type: 'POST',
                           dataType: 'json',
                           data: {payType: 'cod'}
                        }).done(function (confirmation) {
                           if (confirmation.status === true) {
                              window.location.href = '<?php echo base_url(); ?>order-success';
                              return;
                           }

                           $('#cod-errors').text(confirmation.error || 'Unable to confirm your order.');
                           button.prop('disabled', false);
                        }).fail(function (xhr) {
                           $('#cod-errors').text(xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Unable to confirm your order.');
                           button.prop('disabled', false);
                        });
                     }).fail(function (xhr) {
                        $('#cod-errors').text(xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Unable to place your order.');
                        button.prop('disabled', false);
                     });
                  });
               </script>
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
         </div>
         </div>
      </div>
   </div>
</section>
<!-- Main Container End -->

<script>
   var stripe = Stripe('<?php echo esc((string) env('stripe.publishableKey', '')); ?>');
   var elements = stripe.elements(); 
   var style = {
      base: {
         color: "#32325d",
      }
   };
   var card = elements.create("card", {
      style: style
   });
   card.mount("#card-element");
   card.addEventListener('change', ({
      error
   }) => {
      const displayError = document.getElementById('card-errors');
      if (error) {
         displayError.textContent = error.message;
      } else {
         displayError.textContent = '';
      }
   });

   var form = document.getElementById('payment-form');
   form.addEventListener('submit', function(ev) {
      ev.preventDefault();
      // let dataString = $("#billingFormCheckout").serialize();
      $.ajax({
         url: '<?php echo base_url(); ?>order-place',
         type: 'POST',
         dataType: 'json',
         data: {
                 hidden_dublicacy:'<?php echo time().mt_rand(1000,9999); ?>',
                 payment_gateway_name:'stripe_gateway'
               },
         success: function(result) {
            if (result.success == 'ok') {
               var response = fetch('<?php echo base_url(); ?>stripePost', {
                  method: 'POST',
                  headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
               }).then(function(response) {
                  return response.json();
               }).then(function(responseJson) {
                  var clientSecret = responseJson.client_secret;
                  stripe.confirmCardPayment(clientSecret, {
                     payment_method: {
                        card: card,
                        billing_details: {
                           name: "<?php echo htmlspecialchars($this->session->userdata('shipping_first_name')); ?>",
                           email: "<?php echo htmlspecialchars($this->session->userdata('account_email')); ?>",
                           address: {
                              city: "<?php echo htmlspecialchars($this->session->userdata('shipping_city')); ?>",
                              country: "<?php echo htmlspecialchars($this->session->userdata('currency_country_code')); ?>",
                              line1: "<?php echo htmlspecialchars($this->session->userdata('shipping_address1')); ?>",
                              line2: "<?php echo htmlspecialchars($this->session->userdata('shipping_address1')); ?>",
                              postal_code: "<?php echo htmlspecialchars($this->session->userdata('shipping_postal_code')); ?>",
                              state: "<?php echo htmlspecialchars($this->session->userdata('shipping_state')); ?>",
                           },
                        },
                     }
                  }).then(function(result) {
                     if (result.error) {
                        console.log(result.error.message);
                        $('#card-errors').text(result.error.message);
                     } else {
                        if (result.paymentIntent.status === 'succeeded') {
                           $.ajax({
                             url: "<?php echo base_url().'order-completed-success'; ?>",
                             type: 'POST',
                             data:{payType:'stripe_gateway', paymentIntentId:result.paymentIntent.id},
                             cache: false,
                             dataType: 'json',
                             success: function(html){
                              if (html.status==true) {                                 
                                 window.location.href = "<?php echo base_url(); ?>order-success";
                              }
                             }
                           });
                           $('#card-errors').text('Payment Completed');
                        }
                     }
                  });
               });
            }
         }
      });
   });
</script>
<?php endif; ?>
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