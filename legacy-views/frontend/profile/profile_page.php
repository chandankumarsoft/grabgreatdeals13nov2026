<!-- Main Container -->
<div class="main-container col2-left-layout">
   <div class="container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
            <div class="shop-inner">
               <div class="page-title">
                  <h2>Game & Video</h2>
               </div>
               <div class="order-detail-content">
                  <div class="table-responsive">
                     <table class="table table-bordered cart_summary">
                        <tbody>
                           <tr>
                              <td colspan="3" rowspan="2" class="cart_product">
                                 <a href="#"><img src="<?php echo base_url(); ?>/assets/front/images/profile.png" alt="Product"></a>
                                 <p>profile Name
                                    <a href="#">Complete Profile</a>
                                 </p>
                              </td>
                              <td class="cart_description">
                                 <p class="product-name"><a href="#"><b>My Service</b></a></p>
                                 <a href="#">Service: Tony</a><br>
                                 <a href="#">WhatsApp: +91858895656</a><br>
                                 <a href="#">email :</a>
                              </td>
                              <td class="availability in-stock">
                                 <p class="product-name"><a href="#"><b>My Orders</b></a></p>
                                 <a href="#">Unpaid(0)</a><br>
                                 <a href="#">Paid(0)</a><br>
                                 <a href="#">Shipped(0)</a><br><a href="#">Complited(0)</a>
                              </td>
                              <td class="cart_description">
                                 <p class="product-name"><a href="#"><b>My Address</b></a></p>
                                 <a href="#">0 Address</a><br>
                                 <a href="#"><b>My Favorites</b></a><br>
                                 <a href="#">0 Item(s)</a>
                              </td>
                              <td class="cart_description">
                                 <p class="product-name"><a href="#"><b>Credit(0)</b></a></p>
                                 <a href="#"> = (US$ 0.00)</a><br>
                                 <a href="#"><b>Coupon (0)</b></a><br>
                                 <a href="#"><b>Growth (0)</b></a>
                              </td>
                           </tr>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="5"><b>You May Also Like<b></td>
                              <td colspan="2" rowspan="2"></td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</div>
<!-- Main Container End -->