<style>
   .special-price .price {
    font-size: 18px;
    color: #009698;
    font-weight: bold;
}
.old-price .price {
    font-size: 14px;
}
</style>
<div class="main-container col1-layout">
   <div class="container" id="productTypeProId">
      <div class="row">
         <div class="col-main col-sm-12 col-xs-12">
            <div class="shop-inner">
               <div class="page-title">
                  <?php $product_type_name_fetched=$this->db->select('product_type_name')->from('tbl_product_type')->where('pro_type_name',"$product_type_slug")->get()->row(); ?>
                  <h2><?php echo $product_type_name_fetched->product_type_name; ?></h2>
               </div>
               <div class="product-grid-area">
                  <ul class="products-grid">
                     <?php foreach ($product_type as $product_type_value) { ?>
                     <?php if($product_type_value->pro_status==1){ ?>
                     <li class="item col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                        <div class="product-item">
                           <div class="item-inner">
                              <div class="product-thumbnail">
                                 <!-- <div class="icon-sale-label sale-left">Sale</div>
                                 <div class="icon-new-label new-right">New</div> -->
                                 <div class="pr-img-area">
                                    <a title="<?php echo $product_type_value->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $product_type_value->pro_title_slug; ?>">
                                       <figure>
                                          <img class="first-img img-responsive rounded" src="<?php echo'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$product_type_value->pro_image?>" alt="<?php echo $product_type_value->pro_title; ?>" style="max-height:255px;">
                                          <img class="hover-img img-responsive rounded" src="<?php echo'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$product_type_value->pro_image?>" alt="<?php echo $product_type_value->pro_title; ?>" style="max-height:255px;">
                                       </figure>
                                    </a>
                                 </div>
                                 <div class="pr-info-area">
                                    <div class="pr-button">
                                       <div class="mt-button add_to_wishlist">
                                          <a href="javascript:void(0)" class="wishlist_value_class" data-value="<?php echo $product_type_value->pro_id;?>">
                                          <i class="fa fa-heart"></i>
                                          </a>
                                       </div>
                                       <div class="mt-button quick-view"> <a href="<?php echo base_url()?>product-quick/<?php echo $product_type_value->pro_title_slug; ?>"> <i class="fa fa-search"></i> </a> </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="item-info">
                                 <div class="info-inner">
                                    <div class="item-title"> <a title="<?php echo $product_type_value->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $product_type_value->pro_title_slug; ?>"><?php echo $product_type_value->pro_title; ?></a> </div>
                                    <div class="item-content">
                                       <div class="item-price">
                                          <?php if (!empty($product_type_value->pro_offer_price)) { ?>
                                          <div class="price-box">
                                             <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_type_value->pro_offer_price); ?> </span> </p>
                                             <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($product_type_value->pro_price); ?> </span> </p>
                                          </div>
                                          <?php } else { ?>
                                          <div class="price-box">
                                             <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($product_type_value->pro_price); ?> </span> </p>
                                          </div>
                                          <?php } ?>
                                          <span class="free-shipping">free shipping</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </li>
                     <?php } } ?>
                  </ul>
               </div>
               <div class="pagination-area ">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>