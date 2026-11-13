<!-- Main Container -->
<section class="main-container col2-left-layout" id="uiui">
   <div class="main container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
            <div class="my-account">
               <div class="page-title">
                  <h2>My Wishlist</h2>
               </div>
               <div class="wishlist-item table-responsive">
                  <table class="col-md-12">
                     <thead>
                        <tr>
                           <th class="th-delate">Remove</th>
                           <th class="th-product">Images</th>
                           <th class="th-details">Product Name</th>
                           <th class="th-price">Unit Price</th>
                           <th class="th-total th-add-to-cart">Add to Cart </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        if (!empty($wishlist)) {                        
                        foreach ($wishlist as $wishlist_value) {
                        ?>
                        <tr>
                           <td class="th-delate"><a href="javascript:void(0);" class="Wishlist_id_delete" data-value="<?php echo $wishlist_value->wishlist_pro_id; ?>">X</a></td>
                           <td class="th-product">
                              <a href="<?php echo base_url()?>product-details/<?php echo $wishlist_value->pro_title_slug; ?>">
                                <img src="<?php echo base_url().'uploads/'.$wishlist_value->pro_image?>" alt="cart">
                              </a>
                           </td>
                           <td class="th-details">
                              <h2>
                                 <a href="<?php echo base_url()?>product-details/<?php echo $wishlist_value->pro_title_slug; ?>"><?php echo $wishlist_value->pro_title; ?>
                                    
                                 </a>
                              </h2>
                           </td>
                           <td class="th-price">
                              <?php if (!empty($wishlist_value->pro_offer_price)) { ?>
                              <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $<?php echo $wishlist_value->pro_offer_price;?></span> </p>
                              <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $<?php echo $wishlist_value->pro_price; ?> </span> </p>
                              <?php } else { ?>
                              <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $<?php echo $wishlist_value->pro_price;?></span> </p>
                              <?php } ?>
                           </td>
                           <th class="td-add-to-cart">                              
                              <form action="<?php echo base_url()?>add-to-cart"  method="post">
                                 <input type="hidden" value="1" name="qty"/>
                                 <input type="hidden" value="<?php echo $wishlist_value->wishlist_pro_id; ?>" name="pro_id"/>
                                 <button type="submit" class="btn btn-default" 
                                 style="background: #fed700;
                                        color: #333e48;
                                        display: inline-block;
                                        font-weight: 700;
                                        padding: 8px 16px;
                                        text-transform: uppercase;
                                        border-radius: 50px;
                                 ">Add to Cart</button>
                              </form>
                           </th>
                        </tr>
                        <?php
                        }
                        }else{
                        ?>
                        <tr>
                           <td colspan="5">
                           <div>You are not added product in wishlist.</div>
                           </td>
                        </tr>
                        <?php
                        }
                        ?>
                     </tbody>
                  </table>
                  <?php if (!empty($wishlist)) { ?>
                  <!-- <a href="javascript:void(0);" class="all-cart">Add all to cart</a> -->
               <?php } ?>
               </div>
            </div>
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</section>