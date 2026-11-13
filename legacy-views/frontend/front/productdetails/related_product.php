<!-- Related Product Slider -->
<div class="container" id="relatedProId">
   <div class="row">
      <div class="col-xs-12">
         <div class="related-product-area">
            <div class="page-header">
               <h2>Related Products</h2>
            </div>
            <div class="related-products-pro">
               <div class="slider-items-products">
                  <div id="related-product-slider" class="product-flexslider hidden-buttons">
                     <div class="slider-items slider-width-col4 fadeInUp">
                        <?php foreach ($gethotdealsfetch as $gethotdeals) { ?>
                        <?php if($gethotdeals->pro_status >=1){ ?>
                        <div class="product-item">
                           <div class="item-inner">
                              <div class="product-thumbnail">
                                 <div class="icon-sale-label sale-left">Sale</div>
                                 <div class="icon-new-label new-right">New</div>
                                 <div class="pr-img-area">
                                    <a title="<?php echo $gethotdeals->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $gethotdeals->pro_title_slug; ?>">
                                       <figure> 
                                          <img class="first-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$gethotdeals->pro_image?>" alt="html template"> 
                                          <img class="hover-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$gethotdeals->pro_image?>" alt="html template">
                                       </figure>
                                    </a>
                                 </div>
                                 <div class="pr-info-area">
                                    <div class="pr-button">
                                       <div class="mt-button add_to_wishlist"> 
                                          <a href="javascript:void(0)" class="wishlist_value_class" data-value="<?php echo $gethotdeals->pro_id;?>"> 
                                          <i class="fa fa-heart"></i>
                                          </a> 
                                       </div>
                                       <div class="mt-button quick-view"> <a href="<?php echo base_url()?>product-quick/<?php echo $gethotdeals->pro_title_slug; ?>"> <i class="fa fa-search"></i> </a> </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="item-info">
                                 <div class="info-inner">
                                    <div class="item-title"> <a title="<?php echo $gethotdeals->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $gethotdeals->pro_title_slug; ?>"><?php echo $gethotdeals->pro_title; ?></a> </div>
                                    <div class="item-content">
                                       <div class="item-price">
                                          <?php if (!empty($gethotdeals->pro_offer_price)) { ?>
                                          <div class="price-box">
                                             <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($gethotdeals->pro_offer_price); ?> </span> </p>
                                             <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($gethotdeals->pro_price); ?> </span> </p>
                                          </div>
                                          <?php } else { ?>
                                          <div class="price-box">
                                             <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($gethotdeals->pro_price); ?> </span> </p>
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
   </div>
</div>
<!-- Related Product Slider End --> 