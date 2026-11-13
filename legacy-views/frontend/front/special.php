<div class="container" id="specialProId">
   <div class="special-products">
      <div class="page-header">
         <div style="display:flex;">
            <h2 style="color: #009698;">special products</h2>
            <a href="<?php echo base_url().'product-type/'.urlencode(base64_encode('is_special')); ?>"   style="font-weight: bold;font-size: medium;color:#555;text-decoration: underline;">See all deals</a>
         </div>
      </div>
      <div class="special-products-pro">
         <div class="slider-items-products">
            <div id="special-products-slider" class="product-flexslider hidden-buttons">
               <div class="slider-items slider-width-col4">
                  <?php
                     $all_product_special = $this->ProductModel->get_all_product_special(); ?>
                  <?php foreach ($all_product_special as $product_special) { ?>
                  <?php if($product_special->pro_status==1){ ?>
                  <div class="product-item">
                     <div class="item-inner">
                        <div class="product-thumbnail">
                           <!-- <div class="icon-sale-label sale-left">Sale</div>
                           <div class="icon-new-label new-right">New</div> -->
                           <div class="pr-img-area">
                              <a title="<?php echo $product_special->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $product_special->pro_title_slug; ?>">
                                 <figure> <img class="first-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$product_special->pro_image?>" alt="<?php echo $product_special->pro_title; ?>" style="max-height:255px;"> <img class="hover-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$product_special->pro_image?>" alt="<?php echo $product_special->pro_title; ?>" style="max-height:255px;"></figure>
                              </a>
                           </div>
                           <div class="pr-info-area">
                              <div class="pr-button">
                                 <div class="mt-button add_to_wishlist"> 
                                    <a href="javascript:void(0)" class="wishlist_value_class" data-value="<?php echo $product_special->pro_id;?>"> 
                                    <i class="fa fa-heart"></i> 
                                    </a> 
                                 </div>
                                 <div class="mt-button quick-view"> <a href="<?php echo base_url()?>product-quick/<?php echo $product_special->pro_title_slug; ?>"> <i class="fa fa-search"></i> </a> </div>
                              </div>
                           </div>
                        </div>
                        <div class="item-info">
                           <div class="info-inner">
                              <div class="item-title"> <a title="<?php echo $product_special->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $product_special->pro_title_slug; ?>"><?php echo $product_special->pro_title; ?></a> </div>
                              <div class="item-content">
                                 <div class="item-price">
                                    <?php if (!empty($product_special->pro_offer_price)) { ?>
                                    <div class="price-box">
                                       <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_special->pro_offer_price); ?> </span> </p>
                                       <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($product_special->pro_price); ?> </span> </p>
                                    </div>
                                    <?php } else { ?>
                                    <div class="price-box">
                                       <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_special->pro_price); ?> </span> </p>
                                    </div>
                                    <?php } ?>
                                    <span class="free-shipping">free shipping</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>