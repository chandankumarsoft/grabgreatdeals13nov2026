<table border="0" cellpadding="0" cellspacing="0" width="100%">
   <tr>
      <td style="padding: 10px 0 30px 0;">
         <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
            <tr>
               <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                  <a href="https://www.grabgreatdeals.com.au/"><img src="https://www.grabgreatdeals.com.au/assets/front/images/logo/final-logo.png" alt="Creating Email Magic" width="300" height="62" style="display: block;" /></a>
               </td>
            </tr>
            <tr><td style="color:blue;font-family: Arial, sans-serif;font-size: 24px;text-align: center;">
               <a href="https://www.grabgreatdeals.com.au/" style="text-decoration:none;text-align:center;">grabgreatdeals.com.au</a>
            </td>
         </tr>
         <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
               <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                     <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                        <h3>Dear: <?php echo $cus_full_name;?></h3>
                        <h4><?php echo $to;?></h4>
                        <h5>Thank you for your recent purchase from our web site.</h5><hr/>
                     </td>
                  </tr>
                  <tr>
                     <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                        <table class="table table-condensed">
                           <thead>
                              <tr class="cart_menu">
                                 <td class="image">Item</td>
                                 <td class="description"></td>
                                 <td class="price">Price</td>
                                 <td class="quantity">Quantity</td>
                                 <td class="total">Total</td>
                                 <td></td>
                              </tr>
                           </thead>
                           <tbody>
                              
                              <?php $cart_content = $this->cart->contents();
                              
                              ?>
                              <?php foreach ($cart_content as $items){ ?>
                              <tr>
                                 <td class="cart_product">
                                    <a href=""><img  width="100" src="<?php echo $items['options']['pro_image']?>" alt=""></a>
                                 </td>
                                 <td class="cart_description">
                                    <h4><a href=""><?php echo $items['name']?></a></h4>
                                 </td>
                                 <td class="cart_price">
                                    <p>$<?php echo $items['price']?></p>
                                 </td>
                                 <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                       
                                       <input class="cart_quantity_input" type="text" name="quantity" value="<?php echo $items['qty']?>" autocomplete="off" size="2">
                                       
                                    </div>
                                 </td>
                                 <td class="cart_total">
                                    <p class="cart_total_price">$<?php echo $items['subtotal']?></p>
                                 </td>
                                 
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </table>
               <div class="container">
                  <h2 class="text-center">Here is your amount Details.....</h2>
                  <div class="row">
                     <div class="col-sm-6">
                        
                     </div>
                     <div class="col-sm-6">
                        <div class="total_area">
                           <ul>
                              <?php
                                 $cart_total = $this->cart->total();
                              ?>
                              <li>Cart Sub Total <span>$<?php echo $cart_total;?></span></li>
                              <?php
                                 //$tax = ($cart_total*2)/100;
                              ?>
                              <!-- <li>Eco Tax 2% <span>$<?php// echo $tax?></span></li> -->
                              <!-- Shipping Cost Dependend Quantity, price, buyer distance etc -->
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
                              <li>Shipping Cost <span>$(<?php echo $shiping?>) Estimated Time : 14-21 Days</span></li>
                              <?php //$g_total = $cart_total+$tax+$shiping;?>
                              <?php $g_total = $cart_total+$shiping;?>
                              <li>Total <span>
                                 <?php
                                    $gdata = array();
                                    $gdata['g_total'] = $g_total;
                                    $this->session->set_userdata($gdata);
                                    echo "$$g_total";
                                 ?>
                              </span></li>
                           </ul>
                           
                        </div>
                     </div>
                  </div>
               </div>
            </td>
         </tr>
         <tr>
            <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
               <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                     <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                        &reg; Someone, somewhere 2019<br/>
                        <a href="https://www.grabgreatdeals.com.au/" style="color: #ffffff;"><font color="#ffffff">Visit</font></a> to this newsletter instantly
                     </td>
                     <td align="right" width="25%">
                        <table border="0" cellpadding="0" cellspacing="0">
                           <tr>
                              <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                 <a href="https://twitter.com/GreatGrabDeals/" style="color: #ffffff;" target="_blank">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                 </a>
                              </td>
                              <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                              <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                 <a href="https://www.facebook.com/GrabGreatDeal/" target="_blank" style="color: #ffffff;">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                 </a>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </td>
</tr>
</table>