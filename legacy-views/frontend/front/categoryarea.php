<style>
   .jtv-category-area .jtv-product-content {
   float: right;
   width: 62%;
   height: 160px;
   }
</style>
<div class="jtv-category-area">
   <div class="container" id="categoryProId">
      <div class="row">
         <div class="col-md-4 col-sm-6">
            <div class="jtv-single-cat">
               <div style="display: flex;">
                  <h2 class="cat-title" style="color: #009698;">Top Rated</h2>
                  <a href="<?php echo base_url().'mens-clothing-accessories'; ?>"   style="font-weight: bold;font-size: medium;color:#555;text-decoration: underline;margin-left: 10px;">See all deals</a>
               </div>
               <?php $toprated = $this->ProductModel->get_all_top_rated_product();?>
               <?php foreach ($toprated as $topratedvalue) { ?>
               <?php if($topratedvalue->pro_status==1){ ?>
               <div class="jtv-product jtv-cat-margin">
                  <div class="product-img">
                     <a href="<?php echo base_url()?>product-details/<?php echo $topratedvalue->pro_title_slug; ?>">
                     <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$topratedvalue->pro_image?>" alt="<?php echo $topratedvalue->pro_title; ?>" class="img-responsive rounded">
                     <img class="secondary-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$topratedvalue->pro_image?>" alt="<?php echo $topratedvalue->pro_title; ?>">
                     </a>
                  </div>
                  <div class="jtv-product-content">
                     <h3>
                        <a href="<?php echo base_url()?>product-details/<?php echo $topratedvalue->pro_title_slug; ?>"><?php 
                           echo substr("$topratedvalue->pro_title",0,60);
                           ?>
                        </a>
                     </h3>
                     <?php if (!empty($topratedvalue->pro_offer_price)) { ?>
                     <div class="price-box">
                        <p class="special-price">
                           <span class="price-label">Special Price</span>
                           <span class="price"><?php echo currencyConverterFunction($topratedvalue->pro_offer_price); ?>
                           </span>
                        </p>
                        <p class="old-price">
                           <span class="price-label">Regular Price:</span>
                           <span class="price"><?php echo currencyConverterFunction($topratedvalue->pro_price); ?>
                           </span>
                        </p>
                     </div>
                     <?php } else { ?>
                     <div class="price-box">
                        <p class="special-price">
                           <span class="price-label">Special Price</span>
                           <span class="price"><?php echo currencyConverterFunction($topratedvalue->pro_price); ?>
                           </span>
                        </p>
                     </div>
                     <?php } ?>
                     <div class="jtv-product-action">
                        <div class="jtv-extra-link">
                           <div class="button-cart">
                           </div>
                           <a href="<?php echo base_url()?>product-quick/<?php echo $topratedvalue->pro_title_slug; ?>"><i class="fa fa-search"></i></a>
                           <a href="javascript:void()" class="wishlist_value_class" data-value="<?php echo $topratedvalue->pro_id;?>"><i class="fa fa-heart"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php } } ?>
            </div>
         </div>
         <div class="col-md-4 col-sm-6">
            <div class="jtv-single-cat">
               <div style="display: flex;">
                  <h2 class="cat-title" style="color: #009698;">TOP SELLER</h2>
                  <a href="<?php echo base_url().'product-type/'.urlencode(base64_encode('is_topseller')); ?>"   style="font-weight: bold;font-size: medium;color:#555;text-decoration: underline;margin-left: 10px;">See all deals</a>
               </div>
               <?php $all_product_topseller = $this->ProductModel->get_all_product_topseller(); ?>
               <?php foreach ($all_product_topseller as $product_topseller) { ?>
               <?php if($product_topseller->pro_status==1){ ?>
               <div class="jtv-product jtv-cat-margin">
                  <div class="product-img"> <a href="<?php echo base_url()?>product-details/<?php echo $product_topseller->pro_title_slug; ?>"> <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$product_topseller->pro_image?>" alt="<?php echo $product_topseller->pro_title; ?>" class="img-responsive rounded"> <img class="secondary-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$product_topseller->pro_image?>" alt="<?php echo $product_topseller->pro_title; ?>"> </a> </div>
                  <div class="jtv-product-content">
                     <h3><a href="<?php echo base_url()?>product-details/<?php echo $product_topseller->pro_title_slug; ?>"><?php echo substr("$product_topseller->pro_title",0,60); ?></a></h3>
                     <?php if (!empty($product_topseller->pro_offer_price)) { ?>
                     <div class="price-box">
                        <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_topseller->pro_offer_price); ?> </span> </p>
                        <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($product_topseller->pro_price); ?> </span> </p>
                     </div>
                     <?php } else { ?>
                     <div class="price-box">
                        <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_topseller->pro_price); ?> </span> </p>
                     </div>
                     <?php } ?>
                     <div class="jtv-product-action">
                        <div class="jtv-extra-link">
                           <div class="button-cart">
                           </div>
                           <a href="<?php echo base_url()?>product-quick/<?php echo $product_topseller->pro_title_slug; ?>"><i class="fa fa-search"></i></a>
                           <a href="javascript:void()" class="wishlist_value_class" data-value="<?php echo $product_topseller->pro_id;?>"><i class="fa fa-heart"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php } } ?>
            </div>
         </div>
         <div class="col-md-4 col-sm-6">
            <div class="jtv-single-cat">
               <div style="display: flex;">
                  <h2 class="cat-title" style="color: #009698;">Best Deals</h2>
                  <a href="<?php echo base_url().'womens-clothing-accessories'; ?>"   style="font-weight: bold;font-size: medium;color:#555;text-decoration: underline;margin-left: 10px;">See all deals</a>
               </div>
               <?php $allbestsell = $this->ProductModel->get_all_bestdeals_product(); ?>
               <?php foreach ($allbestsell as $allbestselldeals) {?>
               <?php if($allbestselldeals->pro_status==1){?>
               <div class="jtv-product jtv-cat-margin">
                  <div class="product-img"> <a href="<?php echo base_url()?>product-details/<?php echo $allbestselldeals->pro_title_slug; ?>"> <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$allbestselldeals->pro_image?>" alt="<?php echo $allbestselldeals->pro_title; ?>" class="img-responsive rounded"> <img class="secondary-img img-responsive rounded" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$allbestselldeals->pro_image?>" alt="<?php echo $allbestselldeals->pro_title; ?>"> </a> </div>
                  <div class="jtv-product-content">
                     <h3><a href="<?php echo base_url()?>product-details/<?php echo $allbestselldeals->pro_title_slug; ?>"><?php echo substr("$allbestselldeals->pro_title",0,60); ?></a></h3>
                     <?php if (!empty($allbestselldeals->pro_offer_price)) { ?>
                     <div class="price-box">
                        <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($allbestselldeals->pro_offer_price); ?> </span> </p>
                        <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($allbestselldeals->pro_price); ?> </span> </p>
                     </div>
                     <?php } else { ?>
                     <div class="price-box">
                        <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($allbestselldeals->pro_price); ?> </span> </p>
                     </div>
                     <?php } ?>
                     <div class="jtv-product-action">
                        <div class="jtv-extra-link">
                           <div class="button-cart">
                           </div>
                           <a href="<?php echo base_url()?>product-quick/<?php echo $allbestselldeals->pro_title_slug; ?>"><i class="fa fa-search"></i></a>
                           <a href="javascript:void()" class="wishlist_value_class" data-value="<?php echo $allbestselldeals->pro_id;?>"><i class="fa fa-heart"></i></a>
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