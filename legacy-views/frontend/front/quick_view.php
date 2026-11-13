<style>
.product-view-area .product-details-area .price {
    font-size: 28px;
    color: #009698;
    font-weight: bold;
}
</style>
<div style="display: block;" id="quick_view_popup-wrap">
   <div id="quick_view_popup-outer">
      <div id="quick_view_popup-content">
         <div style="width:auto;height:auto;overflow: auto;position:relative;">
            <div class="product-view-area">
               <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                  <!-- <div class="icon-sale-label sale-left">Sale</div> -->
                  <div class="large-image"> 
                     <a href="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->pro_image; ?>" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> 
                     <img class="zoom-img" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->pro_image; ?>" alt="products"> 
                     </a> 
                  </div>
                  <div class="flexslider flexslider-thumb">
                     <ul class="previews-list slides">
                        <li>
                           <a href='<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->pro_image; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->pro_image; ?>' ">
                           <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->pro_image; ?>" alt = "Thumbnail 2"/>
                           </a>
                        </li>
                        <?php if (!empty($product_info->product_image_feature1)) { ?>
                        <li>
                           <a href='<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature1; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature1; ?>' ">
                           <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature1; ?>" alt = "Thumbnail 2" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;"/>
                           </a>
                        </li>
                        <?php } ?>
                        <?php if (!empty($product_info->product_image_feature2)) { ?>
                        <li>
                           <a href='<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature2; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature2; ?>' ">
                           <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature2; ?>" alt = "Thumbnail 1" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;"/>
                           </a>
                        </li>
                        <?php } ?>
                        <?php if (!empty($product_info->product_image_feature3)) { ?>
                        <li>
                           <a href='<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature3; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature3; ?>' ">
                           <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature3; ?>" alt = "Thumbnail 1" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;"/>
                           </a>
                        </li>
                        <?php } ?>
                        <?php if (!empty($product_info->product_image_feature4)) { ?>
                        <li>
                           <a href='<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature4; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature4; ?>' ">
                           <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/'.$product_info->product_image_feature4; ?>" alt = "Thumbnail 2" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;"/>
                           </a>
                        </li>
                        <?php } ?>
                     </ul>
                  </div>
               </div>
               <script type="text/javascript">
                  $(document).click(function (e) {               
                  if ($(e.target).is('#quick_view_popup-wrap')) {
                   window.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
                  }
                  });
               </script>
               <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
                  <div class="product-details-area">
                     <div class="product-name">
                        <h1><a href="<?php echo base_url(); ?>product-details/<?php echo $product_info->pro_title_slug; ?>" title="<?php echo $product_info->pro_title; ?>"><?php echo $product_info->pro_title; ?></a></h1>
                     </div>
                     <div class="price-box">
                        <?php if (!empty($product_info->pro_offer_price)) { ?>
                        <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_info->pro_offer_price); ?></span> </p>
                        <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($product_info->pro_price); ?></span> </p>
                        <?php } else { ?>
                        <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_info->pro_price); ?></span> </p>
                        <?php } ?>
                     </div>
<!--                      <div class="ratings">
                        <p class="availability in-stock pull-right">Availability: <span>In Stock</span></p>
                     </div> -->
                     <div class="short-description">
                        <h2>Short Details</h2>
                        <ul>
                           <?php
                              $pro_short_desc_details=explode("=",$product_info->pro_short_desc_details);
                              foreach ($pro_short_desc_details as $bulletvalue) {
                              if ($bulletvalue!='') {
                              echo "<li style='list-style: disc;font-size: 14px;color: #666;line-height: 20px;'>";
                                 echo strip_tags($bulletvalue);
                              echo "</li>";
                              }
                              }
                              ?>
                              <button class="button" title="Continue">
                              <a class="link-learn" title="Continue" href="<?php echo base_url(); ?>product-details/<?php echo $product_info->pro_title_slug; ?>" style="color:#ffffff;">Continue</a>
                              </button>
                        </ul>
                     </div>
                     <div class="product-cart-option">
                        <ul>
                           <!--  <li><a href="#"><i class="fa fa-heart"></i><span>Add to Wishlist</span></a></li>
                              <li><a href="#"><i class="fa fa-retweet"></i><span>Add to Compare</span></a></li> -->
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <!--product-view-->
         </div>
      </div>
      <a style="display: inline;" id="quick_view_popup-close" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fa fa-times-circle"></i></a>
   </div>
</div>
<div id="quick_view_popup-overlay"></div>