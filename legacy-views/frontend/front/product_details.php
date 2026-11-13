<style type="text/css">
   .social .fbtn {
   width: 50px;
   display: inline-block;
   color: #fff;
   text-align: center;
   line-height: 18px;
   float: left;
   }
   .social .fa {
   padding: 10px 0px;
   }
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
   .share-button.sharer .social.networks-5 {}
   .share-button.sharer .social.top {
   margin-top: -80px;
   transform-origin: 0 0 0;
   margin-left: 1px;
   }
   .share-button.sharer .social {
   margin-left: -65px;
   opacity: 0;
   transition: all 0.4s ease 0s;
   visibility: hidden;
   }
   .selectedbroder {
   border: 2px solid red;
   }
   .product-view-area .product-details-area .price-box {
   display: block;
   margin: 0 0 10px;
   padding: 0 0 0px;
   border-bottom: 1px solid #e5e5e5;
   }
   @media (min-width:479px) {
   .secure-img-resp img {
   height: 85px;
   }
   .secure-a-margin {
   margin-top: 30px !important;
   }
   }
   @media (max-width:479px) {
   .secure-img-resp img {
   height: 50px;
   }
   .secure-a-margin {
   margin-top: 0px !important;
   }
   }
   .product-view-area .product-details-area .price {
    font-size: 28px;
    color: #009698;
    font-weight: bold;
}
</style>
<div class="main-container col1-layout">
<div class="container" style="-webkit-box-shadow: 0px 10px 13px -7px #ffffff, 10px 14px 25px 6px rgba(0,0,0,0.05); 
box-shadow: 0px 10px 13px -7px #ffffff, 10px 14px 25px 6px rgba(0,0,0,0.05);">
   <div class="row">
      <div class="col-main">
         <div class="product-view-area">
            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
               <div class="icon-sale-label sale-left" style="display: none;">Sale</div>
               <div class="large-image showimage showpopdetails">
                  <a href="<?php echo base_url('uploads/large/' . $product_info->pro_image); ?>" class="cloud-zoom anchorzoomcolorclass" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20">
                  <img class="zoom-img imgzoomcolorclass" src="<?php echo base_url('uploads/large/' . $product_info->pro_image); ?>" alt="products">
                  </a>
               </div>
               <?php if (!empty($product_info->product_video_name)) { ?>
               <div class="large-image1 showvideo showpopdetails" style="position: relative; display: none;">
                  <a href="javascript:void(0);" class="cloud-zoom anchorzoomcolorclass1" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20">
                     <video controls id="myVideo1" class="zoom-img imgzoomcolorclass1" width="456" height="456" src="<?php echo base_url('video/' . $product_info->product_video_name); ?>">
                  </a>
               </div>
               <?php } ?>
               <div class="flexslider flexslider-thumb">
                  <ul class="previews-list slides" id="sksks">
                     <li>
                        <a href='<?php echo base_url('uploads/large/' . $product_info->pro_image); ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url('uploads/large/' . $product_info->pro_image); ?>' " onclick="getVideoFile(1);">
                        <img src="<?php echo base_url('uploads/large/' . $product_info->pro_image); ?>" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;" alt="Thumbnail 2" />
                        </a>
                     </li>
                     <?php if (!empty($product_info->product_video_name)) { ?>
                     <li>
                        <a href='<?php echo base_url('assets/front/images/loading/playbutton.png'); ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url('assets/front/images/loading/playbutton.png'); ?>' " onclick="getVideoFile(2);">
                        <img src="<?php echo base_url('assets/front/images/loading/playbutton.png'); ?>" class="img-rounded" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;" alt="Thumbnail 2" />
                        </a>
                     </li>
                     <?php } ?>
                     <?php 
                        $featureImage = $this->db->select('image_name')->from('tbl_image')->where('img_rel_id',$product_info->pro_id)->where('img_rel_cat_id',2)->get()->result();
                        foreach ($featureImage as $featureImageValue) {
                     ?>
                     <li>
                        <a href='<?php echo base_url('uploads/large/' . $featureImageValue->image_name); ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url('uploads/large/' . $featureImageValue->image_name); ?>' " onclick="getVideoFile(1);">
                        <img src="<?php echo base_url('uploads/large/' . $featureImageValue->image_name); ?>" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;" alt="Thumbnail 2" />
                        </a>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area">
               <div class="product-name">
                  <h3><?php echo $product_info->pro_title ?></h3>
               </div>
               <div class="price-box">
                  <?php
                     if (!empty($product_info->pro_offer_price)) {
                       // $productSalePrice = round(($product_info->pro_offer_price * $this->session->userdata('currency_value_session')), 2);
                       // $productRegularPrice = round(($product_info->pro_price * $this->session->userdata('currency_value_session')), 2);
                       $productSalePrice = round(($product_info->pro_offer_price), 2);
                       $productRegularPrice = round(($product_info->pro_price), 2);
                     ?>
                  <p class="special-price hideprice">
                     <span class="price-label">Special Price</span>
                     <span class="price"> <?php echo currencyConverterFunction($product_info->pro_offer_price) ?></span>
                  </p>
                  <p class="old-price hideprice">
                     <span class="price-label">Regular Price:</span>
                     <span class="price"> <?php echo currencyConverterFunction($product_info->pro_price) ?></span>
                  </p>
                  <?php } else { ?>
                  //$productSalePrice = round(($product_info->pro_price*$this->session->userdata('currency_value_session')),2);
                  //$productRegularPrice = round(($product_info->pro_price*$this->session->userdata('currency_value_session')),2);
                  $productSalePrice = round(($product_info->pro_price),2);
                  $productRegularPrice = round(($product_info->pro_price),2);
                  <p class="special-price hideprice">
                     <span class="price-label">Special Price</span>
                     <span class="price"> <?php echo currencyConverterFunction($product_info->pro_price) ?></span>
                  </p>
                  <?php } ?>
                  <p class="special-price specialpricecolorajax">
                     <span class="price-label">Special Price</span>
                     <span class="price specialpricecolorvalue"></span>
                  </p>
                  <p class="old-price regularpricecolorajax">
                     <span class="price-label">Regular Price:</span>
                     <span class="price regularpricecolorvalue"></span>
                  </p>
                  <input type="hidden" id="regularnewcolorprice" class="regularnewcolorprice" value="0">
                  <input type="hidden" id="specialnewcolorprice" class="specialnewcolorprice" value="0">
                  <input type="hidden" id="regularnewsizeprice" class="regularnewsizeprice" value="0">
                  <input type="hidden" id="specialnewsizeprice" class="specialnewsizeprice" value="0">
                  <div class="ratings">
                     <div class="rating">
                        <?php
                           $selected_rating_data = $this->db->select('ROUND(AVG(review_value)) as rating')->from('tbl_product_review')->where('product_id', $product_info->pro_id)->where('show_frontend',1)->get()->row();
                           if ($selected_rating_data->rating > 0) {
                             for ($ratingi = 0; $ratingi < $selected_rating_data->rating; $ratingi++) {
                               echo "<i class='fa fa-star'></i>";
                             }
                             for ($ratingi = 0; $ratingi < (5 - $selected_rating_data->rating); $ratingi++) {
                               echo "<i class='fa fa-star-o'></i>";
                             }
                           } else {
                           ?>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <?php
                           }
                           ?>
                           <span>(<?php echo $this->db->where(['product_id'=>$product_info->pro_id,'show_frontend'=>1])->from("tbl_product_review")->count_all_results(); ?>)</span>
                     </div>
                     <!--<p class="availability in-stock pull-right">Availability: <span class="pro_quantity_color_value"> In Stock</span></p>-->
                  </div>
                  <div class="short-description" style="margin-left: 10px;text-align: left;">
                     <h2>KeyPoints:</h2>
                     <ul>
                        <?php
                           $pro_short_desc_details = explode("=", $product_info->pro_short_desc_details);
                           foreach ($pro_short_desc_details as $bulletvalue) {
                             if ($bulletvalue != '') {
                               echo "<li style='list-style: disc;font-size: 14px;color: #666;line-height: 20px;'>";
                               echo strip_tags($bulletvalue);
                               echo "</li>";
                             }
                           }
                           ?>
                     </ul>
                  </div>
                  <div class="product-color-size-area">
                     <?php
                        $color_list_details = $this->db->select('attr_color_relation_id,attr_color_relation_product_id,attr_color_reference_id,attr_relation_color_name,attr_relation_color_image,color')->from('tbl_attr_relation_color')->join('tbl_color', 'tbl_attr_relation_color.attr_relation_color_name = tbl_color.color_id')->where('attr_color_relation_product_id', $product_info->pro_id)->get()->result();
                        if (!empty($color_list_details)) {
                        ?>
                     <div class="size-area" style="width: 100%;">
                        <h2 class="saider-bar-title">Color <span id="colornameshow"></span></h2>
                        <div class="size">
                           <input type="hidden" id="checkcolorselection" value="0">
                           <ul>
                              <?php
                                 foreach ($color_list_details as $color_list_details_value) {
                                 ?>
                              <li>
                                 <a href="javascript:void(0);" class="colorvaluedata" data-value="<?php echo $color_list_details_value->attr_color_relation_id; ?>" data-product="<?php echo $color_list_details_value->attr_color_relation_product_id; ?>" data-color="<?php echo $color_list_details_value->attr_relation_color_name; ?>" onclick="getVideoFile(1);">
                                 <?php if (!empty($color_list_details_value->attr_relation_color_image)) { ?>
                                 <img src="<?php echo base_url('uploads/thumbnail/' . $color_list_details_value->attr_relation_color_image); ?>" alt="" style="height: 50px;width: 50px;">
                                 <?php } else { ?>
                                 <?php echo esc($color_list_details_value->color); ?>
                                 <?php } ?>
                                 </a>
                              </li>
                              <?php
                                 }
                                 ?>
                           </ul>
                        </div>
                     </div>
                     <?php
                        }
                        ?>
                     <?php
                        $size_list_details = $this->db->select('attr_size_relation_id,attr_size_relation_product_id,attr_size_reference_id,attr_relation_size_name,size_name')->from('tbl_attr_relation_size')->join('tbl_size', 'tbl_attr_relation_size.attr_relation_size_name = tbl_size.size_id')->where('attr_size_relation_product_id', $product_info->pro_id)->get()->result();
                        if (!empty($size_list_details)) {
                        ?>
                     <div class="size-area" style="width: 100%;">
                        <h2 class="saider-bar-title">Variants</h2>
                        <div class="size">
                           <input type="hidden" id="checksizeselection" value="0">
                           <ul>
                              <?php
                                 foreach ($size_list_details as $size_list_details_value) {
                                 ?>
                              <li><a href="javascript:void(0);" class="sizevaluedata" data-value="<?php echo $size_list_details_value->attr_size_relation_id; ?>"><?php echo $size_list_details_value->size_name; ?></a></li>
                              <?php
                                 }
                                 ?>
                           </ul>
                        </div>
                     </div>
                     <?php
                        }
                        ?>
                  </div>
                  <script type="text/javascript">
                     $(document).ready(function() {
                       $('.specialpricecolorajax').hide();
                       $('.regularpricecolorajax').hide();                       

                       $(".colorvaluedata").click(function() {
                         let thiscolorvalue = $(this).data("value");
                         let colorProductId = $(this).data("product");
                         let colorId = $(this).data("color");
                         let regularnewsizeprice = $('#regularnewsizeprice').val();
                         let specialnewsizeprice = $('#specialnewsizeprice').val();
                         $(".colorvaluedata").removeAttr("style");
                         $(this).css({
                           "border-color": "yellow",
                           "border-style": "solid"
                         });
                         $.ajax({
                           type: 'post',
                           dataType: 'json',
                           url: '<?php echo base_url(); ?>product-color-data-value-get',
                           data: {
                             thiscolorvalue: thiscolorvalue,
                             regularnewsizeprice: regularnewsizeprice,
                             specialnewsizeprice: specialnewsizeprice
                           },
                           success: function(response) {
                             if (response.attr_relation_color_regular_price) {
                               $(".anchorzoomcolorclass").attr("href", "<?php echo base_url('uploads/large/'); ?>" + response.attr_relation_color_image);
                               $(".imgzoomcolorclass").attr("src", "<?php echo base_url('uploads/large/'); ?>" + response.attr_relation_color_image);                               
                               $('.hideprice').hide();
                               $('.specialpricecolorajax').show();
                               $('.regularpricecolorajax').show();
                               $('#colornameshow').html("(" + response.attr_relation_color_name + ")");
                               $('.regularpricecolorvalue').html(response.final_regular_price_show);
                               $('.specialpricecolorvalue').html(response.final_sale_price_show);
                               $('.pro_quantity_color_value').html(response.attr_relation_color_quantity + " In Stock");
                               $('.regularnewcolorprice').val(response.attr_relation_color_regular_price);
                               $('.specialnewcolorprice').val(response.attr_relation_color_sale_price);
                               $('#product_price_to_cart').val(response.final_sale_price);
                               $('#product_color').val(response.attr_relation_color_code);
                             }
                           }
                         });
                       });

                       $(".colorvaluedata").on('mouseover',function() {
                         let thiscolorvalue = $(this).data("value");
                         let colorProductId = $(this).data("product");
                         let colorId = $(this).data("color");
                         let regularnewsizeprice = $('#regularnewsizeprice').val();
                         let specialnewsizeprice = $('#specialnewsizeprice').val();
                         
                         $.ajax({
                           type: 'post',
                           dataType: 'json',
                           url: '<?php echo base_url(); ?>product-color-data-value-get',
                           data: {
                             thiscolorvalue: thiscolorvalue,
                             regularnewsizeprice: regularnewsizeprice,
                             specialnewsizeprice: specialnewsizeprice
                           },
                           success: function(response) {
                             if (response.attr_relation_color_regular_price) {
                               $(".anchorzoomcolorclass").attr("href", "<?php echo base_url('uploads/large/'); ?>" + response.attr_relation_color_image);
                               $(".imgzoomcolorclass").attr("src", "<?php echo base_url('uploads/large/'); ?>" + response.attr_relation_color_image);
                               $('#colornameshow').html("(" + response.attr_relation_color_name + ")");                               
                             }
                           }
                         });
                       });
                     
                       $(".sizevaluedata").click(function() {
                         let thissizevalue = $(this).data("value");
                         let regularnewcolorprice = $('#regularnewcolorprice').val();
                         let specialnewcolorprice = $('#specialnewcolorprice').val();
                         $(".sizevaluedata").removeAttr("style");
                         $(this).css({
                           "border": "3px",
                           "border-color": "yellow",
                           "border-style": "solid"
                         });
                         $.ajax({
                           type: 'post',
                           dataType: 'json',
                           url: '<?php echo base_url(); ?>product-size-data-value-get',
                           data: {
                             thissizevalue: thissizevalue,
                             regularnewcolorprice: regularnewcolorprice,
                             specialnewcolorprice: specialnewcolorprice
                           },
                           success: function(responsesize) {
                             if (responsesize.attr_relation_size_regular_price) {
                               $('.hideprice').hide();
                               $('.specialpricecolorajax').show();
                               $('.regularpricecolorajax').show();
                               $('.regularpricecolorvalue').html(responsesize.final_regular_price_show);
                               $('.specialpricecolorvalue').html(responsesize.final_sale_price_show);
                               $('.pro_quantity_color_value').html(responsesize.attr_relation_size_quantity + " In Stock");
                               $('.regularnewsizeprice').val(responsesize.attr_relation_size_regular_price);
                               $('.specialnewsizeprice').val(responsesize.attr_relation_size_sale_price);
                               $('#product_price_to_cart').val(responsesize.final_sale_price);
                               $('#product_size').val(responsesize.attr_relation_size_code);
                             }
                           }
                         });
                       });
                     });
                  </script>
                  <!--<div class="short-description" style="text-align: left;">-->
                     <!--<div><strong>Manufacturer Country Name:</strong><span>&nbsp;-->
                     <?php //echo $product_info->pro_manufacturer_country_name; ?>
                     <!--</span></div>-->
                  <!--</div>-->
                  <div class="product-variation" style="border-top:none;">
                     <form action="<?php echo base_url() ?>add-to-cart-details" method="post" class="formsubmitcheck">
                        <strong>Shipping Charge:</strong>
                     <div class="short-description" style="text-align: left;">
                     <div style="display: inline-block;">
                        <?php
                          $shipping_method_select = $this->db->select('TSC.id,TSC.shipping_description,TSC.shipping_amount')->from('tbl_shipping_charge TSC')->join('tbl_shipping_charge_relation TSCR','TSC.id = TSCR.ship_charge_id','INNER')->join('tbl_product TP','TP.pro_id = TSCR.pro_id')->where('TP.pro_id',$product_info->pro_id)->get()->result();
                          $shipping_charge_no=0;
                          foreach ($shipping_method_select as $shipping_method_selectvalue) {
                           $shipping_charge_no++;
                        ?>
                     <li style="list-style: none;display: inline-flex;">
                        <input type="radio" name="shipping_method" id="<?php echo 'shipping_method'.$shipping_method_selectvalue->id; ?>" value="<?php echo $shipping_method_selectvalue->id; ?>" class="shipping_method" <?php if ($shipping_charge_no==1) {
                           echo "checked";
                        } ?>>
                        <label for="<?php echo 'shipping_method'.$shipping_method_selectvalue->id; ?>" style="margin-left: 5px;"><?php echo $shipping_method_selectvalue->shipping_description; ?><strong>
                              <?php echo currencyConverterFunction($shipping_method_selectvalue->shipping_amount); ?>
                           </strong></label>
                     </li>
                     <br>
                        <?php
                          }
                        ?>

                     </div>
                  </div>
                        <div class="cart-plus-minus">
                           <label for="qty">Quantity:</label>
                           <div class="numbers-row">
                              <div class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                              <input type="hidden" id="currencyvalue" value="<?php echo $this->session->userdata('currency_value_session'); ?>">
                              <input type="hidden" value="<?php echo $productSalePrice; ?>" id="product_price_to_cart" name="product_price_to_cart">
                              <input type="hidden" value="<?php echo $productRegularPrice; ?>" id="product_regular_price_to_cart" name="product_regular_price_to_cart">
                              <input type="text" class="qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                              <div class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                           </div>
                           <script>
                              $(document).on('click', '.inc', function() {
                                let incresultqty = $('#qty').val();
                                if (!isNaN(incresultqty)) {
                                  incresultqty++;
                                  $('#qty').val(incresultqty);
                                  $('.hideprice').hide();
                                  $('.specialpricecolorajax').show();
                                  $('.regularpricecolorajax').show();
                                  let currencyvalue = $('#currencyvalue').val();
                                  let product_price_to_cart_Price = $('#product_price_to_cart').val();
                                  let product_regular_price_to_cart_Price = $('#product_regular_price_to_cart').val();
                                  let incfinalprice = (incresultqty * product_price_to_cart_Price) * currencyvalue;
                                  let incfinalregularprice = (incresultqty * product_regular_price_to_cart_Price) * currencyvalue;
                                  let incfinalpricePrint = incfinalprice.toFixed(2);
                                  let incfinalregularpricePrint = incfinalregularprice.toFixed(2);
                                  $('.regularpricecolorvalue').html("<?php echo $this->session->userdata('currency_symbol_session'); ?>" + incfinalregularpricePrint);
                                  $('.specialpricecolorvalue').html("<?php echo $this->session->userdata('currency_symbol_session'); ?>" + incfinalpricePrint);
                                }
                              });
                              $(document).on('click', '.dec', function() {
                                let decresultqty = $('#qty').val();
                                if (!isNaN(decresultqty) && decresultqty > 1) {
                                  decresultqty--;
                                  $('#qty').val(decresultqty);
                                  $('.hideprice').hide();
                                  $('.specialpricecolorajax').show();
                                  $('.regularpricecolorajax').show();
                                  let currencyvalue = $('#currencyvalue').val();
                                  let product_price_to_cart_Price = $('#product_price_to_cart').val();
                                  let product_regular_price_to_cart_Price = $('#product_regular_price_to_cart').val();
                                  let decfinalprice = (decresultqty * product_price_to_cart_Price) * currencyvalue;
                                  let incfinalregularprice = (decresultqty * product_regular_price_to_cart_Price) * currencyvalue;
                                  let decfinalpricePrint = decfinalprice.toFixed(2);
                                  let decfinalregularpricePrint = incfinalregularprice.toFixed(2);
                                  $('.regularpricecolorvalue').html("<?php echo $this->session->userdata('currency_symbol_session'); ?>" + decfinalregularpricePrint);
                                  $('.specialpricecolorvalue').html("<?php echo $this->session->userdata('currency_symbol_session'); ?>" + decfinalpricePrint);
                                }
                              });
                           </script>
                        </div>
                        <input type="hidden" value="<?php echo $product_info->pro_id ?>" name="pro_id" />
                        <input type="hidden" value="" name="product_color" id="product_color" />
                        <input type="hidden" value="" name="product_size" id="product_size" />
                        <button type="submit" class="button pro-add-to-cart" title="Add to Cart" type="button">
                           <span>
                              <!-- <i class="fa fa-shopping-cart"> --></i>Add to Cart
                           </span>
                        </button>
                     </form>
                  </div>
                  <div class="product-cart-option">
                     <ul>
                        <li style="border-right: none;"><a href="javascript:void(0);" class="wishlist_value_class secure-a-margin" data-value="<?php echo $product_info->pro_id; ?>"><i class="fa fa-heart"></i><span>Add to Wishlist</span></a></li>
                        <!-- <li><a href="#"><i class="fa fa-retweet"></i><span>Add to Compare</span></a></li>
                           <li><a href="#"><i class="fa fa-envelope"></i><span>Email to a Friend</span></a></li> -->
                        <li class="secure-img-resp">
                           <img src="<?php echo base_url('assets/front/images/secureguranteeimg/free.png'); ?>" alt="">
                           <img src="<?php echo base_url('assets/front/images/secureguranteeimg/moneyback.png'); ?>" alt="">
                           <img src="<?php echo base_url('assets/front/images/secureguranteeimg/premium.png'); ?>" alt="">
                           <img src="<?php echo base_url('assets/front/images/secureguranteeimg/secure.png'); ?>" alt="">
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="pull-left" style="margin-bottom:45px;">
                  <div class="share-button sharer" style="display: block;">
                     <span>SHARE THIS:</span>
                     <button type="button" class="button cart-button share-btn"><i class="fa fa-share-alt" aria-hidden="true"></i></button>
                     <div class="social top center networks-5 ">
                        <!-- Facebook Share Button -->
                        <a class="fbtn share facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo  current_url() ?>&t=<?php echo $product_info->pro_title ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
                        <!-- Google Plus Share Button -->
                        <a class="fbtn share mailto" href="mailto:?subject=<?php echo $product_info->pro_title ?>&body=<?php echo  current_url() ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Mail"><i class="fa fa-envelope-square"></i></a>
                        <!-- Twitter Share Button -->
                        <a class="fbtn share whatsapp" href="https://api.whatsapp.com/send?text=<?php echo $product_info->pro_title ?><?php echo  current_url() ?>" data-action="share/whatsapp/share" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp"><i class="fa fa-whatsapp"></i></a>
                        <!-- Pinterest Share Button -->
                        <!-- LinkedIn Share Button -->
                        <a class="fbtn share linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo  current_url() ?>&t=<?php echo $product_info->pro_title ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Linkedin"><i class="fa fa-linkedin"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="product-overview-tab">
            <div class="container">
               <div class="row">
                  <div class="col-xs-12">
                     <div class="product-tab-inner">
                        <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                           <li class="active"> <a href="#description" data-toggle="tab">Description </a> </li>
                           <li> <a href="#reviews" data-toggle="tab">Reviews</a> </li>
                           <!-- <li> <a href="#custom_tabs" data-toggle="tab">Custom Tab</a> </li> -->
                        </ul>
                        <div id="productTabContent" class="tab-content">
                           <div class="tab-pane fade in active" id="description">
                              <div class="std">
                                 <?php echo legacy_localize_content_urls($product_info->pro_desc); ?>
                              </div>
                           </div>
                           <div id="reviews" class="tab-pane fade">
                              <div class="col-sm-5 col-lg-5 col-md-5">
                                 <div class="reviews-content-left" id="refreshdivafterajax">
                                    <h2>Customer Reviews</h2>
                                    <?php
                                       $fetched_review = $this->db->select('*')->from('tbl_product_review')->where('product_id', $product_info->pro_id)->where('show_frontend',1)->order_by('review_id', 'desc')->get()->result();
                                       foreach ($fetched_review as $fetched_value) {
                                       
                                       ?>
                                    <div class="review-ratting">
                                       <p class="author">
                                          <?php echo $fetched_value->reviewer_name; ?><small> (Posted on <?php echo $fetched_value->created_at; ?>)</small>
                                       </p>
                                       <table>
                                          <tbody>
                                             <tr>
                                                <th>avarage rating</th>
                                                <td>
                                                   <div class="rating">
                                                      <?php
                                                         if ($fetched_value->review_value > 0) {
                                                           for ($ratingi = 0; $ratingi < $fetched_value->review_value; $ratingi++) {
                                                             echo "<i class='fa fa-star'></i>";
                                                           }
                                                           for ($ratingi = 0; $ratingi < (5 - $fetched_value->review_value); $ratingi++) {
                                                             echo "<i class='fa fa-star-o'></i>";
                                                           }
                                                         }
                                                         ?>
                                                   </div>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                       <p>
                                          <bold>summary:</bold>
                                          <?php echo $fetched_value->review_title; ?>
                                       </p>
                                       <div>
                                          <bold>Review:</bold>
                                          <?php echo $fetched_value->review_description; ?>
                                       </div>
                                       <div>
                                          <img src="<?php echo base_url() . 'uploads/review/' .$fetched_value->review_image; ?>" alt="" class="img-responsive">
                                       </div>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                              <div class="col-sm-7 col-lg-7 col-md-7">
                                 <div class="reviews-content-right">
                                    <h2>Write Your Own Review</h2>
                                    <form action="<?php echo  base_url(); ?>add-reviews" method="post" onsubmit="return false" id="review_form">
                                       <h4>How do you rate this product?<em>*</em></h4>
                                       <div class="table-responsive reviews-table">
                                          <table>
                                             <tbody>
                                                <tr>
                                                   <th></th>
                                                   <th>1 star</th>
                                                   <th>2 stars</th>
                                                   <th>3 stars</th>
                                                   <th>4 stars</th>
                                                   <th>5 stars</th>
                                                </tr>
                                                <tr>
                                                   <td>Quality</td>
                                                   <td><input type="radio" class="rating_val" value="1"></td>
                                                   <td><input type="radio" class="rating_val" value="2"></td>
                                                   <td><input type="radio" class="rating_val" value="3"></td>
                                                   <td><input type="radio" class="rating_val" value="4"></td>
                                                   <td><input type="radio" class="rating_val" value="5"></td>
                                                </tr>
                                                <span id="rating_val_error" style="color:red;"></span>
                                                <span id="success_rating_add" style="color:green;"></span>
                                             </tbody>
                                          </table>
                                       </div>
                                       <div class="form-area">
                                          <div class="form-element">
                                             <span id="reviewer_name_error" style="color: red;"></span>
                                             <label>Name <em>*</em></label>
                                             <input type="text" name="reviewer_name" id="reviewer_name">
                                          </div>
                                          <div class="form-element">
                                             <span id="review_title_error" style="color: red;"></span>
                                             <label>Summary of Your Review <em>*</em></label>
                                             <input type="text" name="review_title" id="review_title">
                                          </div>
                                          <div class="form-element">
                                             <span id="review_description_error" style="color: red;"></span>
                                             <label>Review <em>*</em></label>
                                             <textarea name="review_description" id="review_description"></textarea>
                                          </div>
                                          <div class="form-element">
                                             <label>Image</label>
                                             <input type="file" name="review_image" id="review_image">
                                          </div>
                                          <div class="buttons-set">
                                             <button class="button submit" title="Submit Review" type="submit" id="reviewsubmit"><span><i class="fa fa-thumbs-up"></i> &nbsp;Review</span></button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <script type="text/javascript">
                              function get_filter(class_name) {
                                var filter = [];
                                $('.' + class_name + ':checked').each(function() {
                                  filter.push($(this).val());
                                });
                                return filter;
                              }
                              $(document).ready(function() {
                                $('.rating_val').click(function() {
                                  $('.rating_val').removeAttr('checked')
                                  var rating_val_class = $(this).attr("value");
                                  for (var i = 0; i < rating_val_class; i++) {
                                    $('.rating_val')[i].checked = "checked";
                                  }
                                });
                                $('#review_form').submit(function() {
                                  var product_id = <?php echo $product_info->pro_id; ?>;
                                  var rating_val_obj = get_filter('rating_val');
                                  var rating_val = Math.max.apply(null, rating_val_obj);
                                  var reviewer_name = $('#reviewer_name').val();
                                  var review_title = $('#review_title').val();
                                  var review_description = $('#review_description').val();
                                  rating_val_fun(rating_val);
                                  reviewer_name_fun(reviewer_name);
                                  review_title_fun(review_title);
                                  review_description_fun(review_description);
                                  var formData = new FormData($('#review_form')[0]);
                                  formData.append('product_id', product_id);
                                  formData.append('rating_val', rating_val);
                                  formData.append('reviewer_name', reviewer_name);
                                  formData.append('review_title', review_title);
                                  formData.append('review_description', review_description);
                                 //  formData.append("review_image", fileInputElement.files[0]);
                                 //  formData.append('review_image', myFileInput.files[0], 'chris.jpg');
                                  if (rating_val_fun(rating_val) && reviewer_name_fun(reviewer_name) && review_title_fun(review_title) && review_description_fun(review_description) == true) {
                                       $.ajax({
                                         type: "POST",
                                         enctype: 'multipart/form-data',
                                         url: "<?php echo base_url(); ?>add-reviews",
                                         data:formData,
                                         processData: false,
                                         contentType: false,
                                          success: function(data) {
                                               $('#review_form')[0].reset();
                                               $("#success_rating_add").text('review added successfully');
                                               setTimeout(function() {
                                                $('#success_rating_add').hide();
                                               }, 4000);
                                               $("#refreshdivafterajax").load(" #refreshdivafterajax");
                                          }
                                       });
                                    }
                                });
                              
                                function rating_val_fun(rating_val) {
                                  if (!$.isNumeric(rating_val)) {
                                    $('#rating_val_error').show();
                                    $('#rating_val_error').text("rating can't blank");
                                    return false;
                                  } else {
                                    $('#rating_val_error').hide();
                                    return true;
                                  }
                                }
                              
                                function reviewer_name_fun(reviewer_name) {
                                  if ($.trim(reviewer_name) == "") {
                                    $('#reviewer_name_error').show();
                                    $('#reviewer_name_error').text("name can't blank");
                                    return false;
                                  } else {
                                    $('#reviewer_name_error').hide();
                                    return true;
                                  }
                                }
                              
                                function review_title_fun(review_title) {
                                  if ($.trim(review_title) == "") {
                                    $('#review_title_error').show();
                                    $('#review_title_error').text("summary can't blank");
                                    return false;
                                  } else {
                                    $('#review_title_error').hide();
                                    return true;
                                  }
                                }
                              
                                function review_description_fun(review_description) {
                                  if ($.trim(review_description) == "") {
                                    $('#review_description_error').show();
                                    $('#review_description_error').text("review can't blank");
                                    return false;
                                  } else {
                                    $('#review_description_error').hide();
                                    return true;
                                  }
                                }
                              });
                           </script>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- upsell Product -->
<style>
   .special-price .price {
    font-size: 18px;
    color: #009698;
    font-weight: bold;
}
</style>
<div class="container" id="upsellProId" style="-webkit-box-shadow: 0px 10px 13px -7px #ffffff, 10px 14px 25px 6px rgba(0,0,0,0.05); 
box-shadow: 0px 10px 13px -7px #ffffff, 10px 14px 25px 6px rgba(0,0,0,0.05);">
   <div class="row">
      <div class="col-xs-12">
         <div class="related-product-area">
            <div class="page-header">
               <h2>PEOPLE ALSO BOUGHT</h2>
            </div>
            <div class="related-products-pro">
               <div class="slider-items-products">
                  <div id="related-product-slider" class="product-flexslider hidden-buttons">
                     <div class="slider-items slider-width-col4 fadeInUp">
                        <?php foreach ($gethotdealsfetchupsell as $gethotdeals) { ?>
                        <?php if($gethotdeals->pro_status==1){ ?>
                        <div class="product-item">
                           <div class="item-inner">
                              <div class="product-thumbnail">
                                 <!-- <div class="icon-sale-label sale-left">Sale</div>
                                 <div class="icon-new-label new-right">New</div> -->
                                 <div class="pr-img-area">
                                    <a title="<?php echo $gethotdeals->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $gethotdeals->pro_title_slug; ?>">
                                       <figure> 
                                          <img class="first-img img-responsive rounded" src="<?php echo base_url('uploads/large/' . $gethotdeals->pro_image); ?>" alt="html template"> 
                                          <img class="hover-img img-responsive rounded" src="<?php echo base_url('uploads/large/' . $gethotdeals->pro_image); ?>" alt="html template">
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
<?php $this->load->view('front/productdetails/productDetailsModal'); ?>
<!-- upsell Product End --> 
<script type="text/javascript">
   $(document).ready(function() {
     $(".share-btn").click(function(e) {
       $('.networks-5').not($(this).next(".networks-5")).each(function() {
         $(this).removeClass("active");
       });
       $(this).next(".networks-5").toggleClass("active");
     });
   });
</script>
<script type="text/javascript">
   function getVideoFile(fileType) {
     $(".showvideo").hide();
     if (fileType == 1) {
       $('#myVideo1').trigger('pause');
       $(".showvideo").hide();
       $(".showimage").show();
     } else {
       $(".showimage").hide();
       $(".showvideo").show();
   
     }
   }
</script>
<script>
   function test() {
      $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>add-to-cart-details",
         data: $('.formsubmitcheck').serialize(),
         dataType: "json",
         beforeSend: function () {
            swal({
               title: "Loading...",
               text: "Please wait",
               icon: "<?php echo base_url(); ?>assets/front/images/loading/loadingcart.gif",
               button: false,
               closeOnClickOutside: false,
               closeOnEsc: false
            });
         },
         success: function (data) {

            if (data.success == "ok") {
               window.location.href = "<?php echo base_url(); ?>checkout";
               // $("#topcartajaxdetails").load(" #topcartajaxdetails >*");
               // swal("Added Cart", "", "success");
               // setTimeout(function () {
               //    swal.close();
               // }, 2000);
            }
         }
      });
   }
   $('.colorvaluedata').click(function() {
     $('#checkcolorselection').val(1);
   });
   $('.sizevaluedata').click(function() {
     $('#checksizeselection').val(1);
   });
   $(".formsubmitcheck").submit(function(event) {
     let colorvaluedata = $('*').hasClass("colorvaluedata");
     let sizevaluedata = $('*').hasClass("sizevaluedata");
     if (colorvaluedata == true && sizevaluedata == false) {
       let checkcolorselection = $('#checkcolorselection').val();
       if (checkcolorselection == 1) {
         test();
       } else {
         swal("choose color", "", "error");
       }
     } else if (colorvaluedata == false && sizevaluedata == true) {
       let checksizeselection = $('#checksizeselection').val();
       if (checksizeselection == 1) {
         test();
       } else {
         swal("choose size", "", "error");
       }
     } else if (colorvaluedata == true && sizevaluedata == true) {
       let checkcolorselection = $('#checkcolorselection').val();
       let checksizeselection = $('#checksizeselection').val();
       if (checkcolorselection == 1 && checksizeselection == 0) {
         swal("choose size", "", "error");
       } else if (checkcolorselection == 0 && checksizeselection == 1) {
         swal("choose color", "", "error");
       } else if (checkcolorselection == 0 && checksizeselection == 0) {
         swal("choose color", "", "error");
       } else if (checkcolorselection == 1 && checksizeselection == 1) {
         test();
       }
   
     } else {
         test();
     }
     event.preventDefault();
   });
</script>