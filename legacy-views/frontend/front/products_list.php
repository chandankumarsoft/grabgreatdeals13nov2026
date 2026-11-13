<style type="text/css">
   .social .fbtn {
   width: 50px;
   display: inline-block;
   color: #fff;
   text-align: center;
   line-height:18px;
   float: left;
   }
   .social .fa{padding:15px 0px}
   .facebook {
   background-color: #3b5998;
   }
   .mailto {
   background-color: #eb3215;
   }
   .whatsapp {
   background-color: #078a2a;
   }
   .stumbleupon {
   background-color: #eb4924;
   }
   .commenting {
   background-color: #6307f8;
   }
   .linkedin {
   background-color: #0077b5;
   }
   .buffer {
   background-color: #323b43;
   }
   .share-button.sharer .social.active.top {
   transform: scale(1) translateY(-10px);
   }
   .share-button.sharer .social.active {
   opacity: 1;
   transition: all 0.4s ease 0s;
   visibility: visible;
   }
   .share-button.sharer .social.networks-5 {
   }
   .share-button.sharer .social.top {
   margin-top: -80px;
   transform-origin: 0 0 0;
   }
   .share-button.sharer .social {
   margin-left: -65px;
   opacity: 0;
   transition: all 0.4s ease 0s;
   visibility: hidden;
   }
   @media (max-width:480px) {
   .share-button.sharer {
   margin-top: -35px;
   }
   }
      .special-price .price {
    font-size: 18px;
    color: #009698;
    font-weight: bold;
}
.old-price .price {
    font-size: 14px;
}
</style>
<div class="product-list-area" id="productListProId">
   <?php
      if (!empty($counted_product_no)) {
      ?>
   <script>
      $('#all_counted_value_id').show();
      $('#all_counted_value_id').html('Showing <?php echo $page_number_breadcrumb+1; ?> – <?php echo $page_number_breadcrumb_last=(($page_number_breadcrumb+10)<$counted_product_no)? $page_number_breadcrumb+10: $counted_product_no; ?> of <?php echo $counted_product_no; ?> results');
   </script>
   <?php } else { ?>
   <script>
      $('#all_counted_value_id').hide();
   </script>
   <?php } ?>
   <ul class="products-list" id="products-list">
   <?php
      if (!empty($allproduct)) { ?>
   <?php foreach ($allproduct as $products) {  ?>
   <li class="item">
      <div class="product-img">
         <div class="icon-sale-label sale-left" style="display: none;">Sale</div>
         <a href="<?php echo base_url(); ?>product-details/<?php echo $products->pro_title_slug; ?>" title="<?php echo $products->pro_title; ?>">
            <figure> <img class="small-image" src="<?php echo 'https://www.seller.grabgreatdeals.com/'.'uploads/large/'.$products->pro_image; ?>" alt="<?php echo $products->pro_title; ?>"></figure>
         </a>
      </div>
      <div class="product-shop">
         <h2 class="product-name"><a href="<?php echo base_url(); ?>product-details/<?php echo $products->pro_title_slug; ?>" title="<?php echo $products->pro_title; ?>"><?php echo $products->pro_title; ?></a></h2>
         <div class="ratings">
            <div class="rating">
            </div>
         </div>
         <div class="item-price">
            <?php if (!empty($products->pro_offer_price)) { ?>
            <ul>
               <div class="pull-right">
                  <div class="share-button sharer" style="display: block; margin-top: 10px;">
                     SHARE THIS
                     <button type="button" class="button cart-button share-btn"><i class="fa fa-share-alt" aria-hidden="true"></i></button>
                     <div class="social top center networks-5">
                        <!-- Facebook Share Button -->
                        <a class="fbtn share facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo  base_url().'product-details/'.$products->pro_title_slug; ?>&amp;t=<?php echo $products->pro_title; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
                        <!-- Google Plus Share Button -->
                        <a class="fbtn share mailto" href="mailto:?subject=<?php echo $products->pro_title?>&body=<?php echo  base_url().'product-details/'.$products->pro_title_slug; ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Mail"><i class="fa fa-envelope-square"></i></a>
                        <!-- Twitter Share Button -->
                        <a class="fbtn share whatsapp" href="https://api.whatsapp.com/send?text=<?php echo $products->pro_title; ?><?php echo  base_url().'product-details/'.$products->pro_title_slug; ?>" data-action="share/whatsapp/share" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp"><i class="fa fa-whatsapp"></i></a>                
                        <!-- LinkedIn Share Button -->
                        <a class="fbtn share linkedin" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo  base_url().'product-details/'.$products->pro_title_slug; ?>&amp;t=<?php echo $products->pro_title; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Linkedin"><i class="fa fa-linkedin"></i></a>
                        </a>
                     </div>
                  </div>
               </div>
            </ul>
            <div class="price-box">
               <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($products->pro_offer_price); ?> </span> </p>
               <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($products->pro_price); ?> </span> </p>
            </div>
            <?php } else { ?>
            <div class="price-box">
               <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($products->pro_price); ?> </span> </p>
            </div>
            <?php } ?>
            <span class="free-shipping">free shipping</span>
         </div>
         <div class="desc std">
            <ul>
               <?php
                  if ($products->pro_short_desc_details!='') {
                  
                  $pro_short_desc_details=explode("=",$products->pro_short_desc_details);
                  foreach ($pro_short_desc_details as $bulletvalue) {
                  if ($bulletvalue!='') {
                  echo "<li>";
                    echo strip_tags($bulletvalue);
                  echo "</li>";
                  }
                  }
                  }
                  ?>
               <a class="link-learn" title="Learn More" href="<?php echo base_url(); ?>product-details/<?php echo $products->pro_title_slug; ?>">Learn More</a>
            </ul>
         </div>
         <div class="actions">
            <ul>
               <li> <a href="javascript:void(0);" class="wishlist_value_class" data-value="<?php echo $products->pro_id;?>"> <i class="fa fa-heart"></i><span> Add to Wishlist</span> </a> </li>
            </ul>
         </div>
      </div>
   </li>
   <?php } ?>
   <?php } else {?>
   <div class='text-center'><img src='https://www.seller.grabgreatdeals.com/assets/front/images/loading/productnotfound.png' /></div>
   <?php } ?>
</div>
<div style="text-align: center;">
   <?php echo $this->pagination->create_links();?>
</div>
<script type="text/javascript">
   $( document ).ready(function() {
   //custom button for homepage
   $( ".share-btn" ).click(function(e) {
   $('.networks-5').not($(this).next( ".networks-5" )).each(function(){
   $(this).removeClass("active");
   });
   
   $(this).next( ".networks-5" ).toggleClass( "active" );
   });
   });
</script>