<?php    
$upsell_pro_id_cart = $this->cart->contents(); 
$n=1;
  foreach ($upsell_pro_id_cart as $upsell_items) {
      if($n===1){
         $upsell_reference_pro_id=$upsell_items['id'];
      }
   $n++;
  }
   $selected_upsell_pro_id = $this->db->select('upsell_pro_id')->from('tbl_upsell_product')->where('reference_pro_id',$upsell_reference_pro_id)->get()->row();
$product_upsell_details=$this->HomeModel->get_upsell_product_by_id($selected_upsell_pro_id->upsell_pro_id);
   
?>
<style type="text/css">
    .special-price .price {
    font-size: 18px;
    color: #009698;
    font-weight: bold;

}
@media (min-width: 992px) {
  .modal-dialog {
    max-width: 25%;
  }
}
/*.flexslider .flex-direction-nav .flex-next {
    right: 5px; 
    opacity: .8; 
}

.flexslider .flex-direction-nav .flex-prev {
    left: 5px; 
    opacity: .8; 
}
.flex-direction-nav a.flex-next:before {
    content: '\f105';
    margin-left: 284px;
    color: black;
}
.flex-direction-nav a.flex-prev:before {
    content: '\f104';
    margin-top: 82px;
    color: black;
}*/
</style>
<div id="upsellModalPopup" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div class="small-image">
                  <a href="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $product_upsell_details->pro_image; ?>" class="cloud-zoom anchorzoomcolorclass" id="zoom1" >
                  <img  src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $product_upsell_details->pro_image; ?>" alt="products" class="first-img img-responsive rounded">
                  </a>
            </div>
            <div class="flexslider flexslider-thumb">
                  <ul class="previews-list slides">                     
                     <?php 
                        $featureImage = $this->db->select('image_name')->from('tbl_image')->where('img_rel_id',$product_upsell_details->pro_id)->where('img_rel_cat_id',2)->get()->result();
                        foreach ($featureImage as $featureImageValue) {
                     ?>
                     <li style="float: left;display: block;margin: 2px;">
                        <a href='<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $featureImageValue->image_name; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $featureImageValue->image_name; ?>' " onclick="getVideoFile(1);">
                        <img src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $featureImageValue->image_name; ?>" style="min-width: 100px;max-width:100px;min-height: 100px;max-height: 100px;" alt="Thumbnail 2" class="img-thumbnail"/>
                        </a>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
               <div class="item-info" style="text-align:center;">
                        <div class="info-inner">
                           <div class="item-title"> <h5><a title="<?php echo $product_upsell_details->pro_title; ?>" href="<?php echo base_url()?>product-details/<?php echo $product_upsell_details->pro_title_slug; ?>" style="font-size: initial;"><?php echo $product_upsell_details->pro_title; ?></a> </h5></div>
                           <form action="<?php echo base_url() ?>add-to-cart-details" method="post" class="formsubmitcheck">
                           <div class="item-content">
                                  <div class="item-price">
                              <?php
                              if (!empty($product_upsell_details->pro_offer_price)) {
                                $productSalePrice = round(($product_upsell_details->pro_offer_price), 2);
                                $productRegularPrice = round(($product_upsell_details->pro_price), 2);
                              ?>
                           <p class="special-price hideprice">
                              <span class="price-label">Special Price</span>
                              <span class="price"> <?php echo currencyConverterFunction($product_upsell_details->pro_offer_price) ?></span>
                           </p>
                           <p class="old-price hideprice">
                              <span class="price-label">Regular Price:</span>
                              <span class="price"> <?php echo currencyConverterFunction($product_upsell_details->pro_price) ?></span>
                           </p>
                           <?php } else { ?>
                           $productSalePrice = round(($product_upsell_details->pro_price),2);
                           $productRegularPrice = round(($product_upsell_details->pro_price),2);
                           <p class="special-price hideprice">
                              <span class="price-label">Special Price</span>
                              <span class="price"> <?php echo currencyConverterFunction($product_upsell_details->pro_price) ?></span>
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
                                 </div>
                                 <form action="<?php echo base_url() ?>add-to-cart-details" method="post" class="formsubmitcheck">
                                    <?php
                                    $color_list_details = $this->db->select('attr_color_relation_id,attr_color_relation_product_id,attr_color_reference_id,attr_relation_color_name,attr_relation_color_image,color')->from('tbl_attr_relation_color')->join('tbl_color', 'tbl_attr_relation_color.attr_relation_color_name = tbl_color.color_id')->where('attr_color_relation_product_id', $product_upsell_details->pro_id)->get()->result();
                                    if (!empty($color_list_details)) {
                                    ?>
                                    <select name="product_color" id="product_color" class="colorvaluedata">
                                       <option value="">Color</option>
                                        <?php
                                             foreach ($color_list_details as $color_list_details_value) {
                                             ?>
                                             <option value="<?php echo $color_list_details_value->attr_relation_color_name; ?>" data-value="<?php echo $color_list_details_value->attr_color_relation_id; ?>" data-product="<?php echo $color_list_details_value->attr_color_relation_product_id; ?>" data-color="<?php echo $color_list_details_value->attr_relation_color_name; ?>"><?php echo $color_list_details_value->color; ?></option>
                                              <?php
                                             }
                                             ?>
                                          </select>
                                 <?php
                                    }
                                    ?>
                              <?php
                                $size_list_details = $this->db->select('attr_size_relation_id,attr_size_relation_product_id,attr_size_reference_id,attr_relation_size_name,size_name')->from('tbl_attr_relation_size')->join('tbl_size', 'tbl_attr_relation_size.attr_relation_size_name = tbl_size.size_id')->where('attr_size_relation_product_id', $product_upsell_details->pro_id)->get()->result();
                                if (!empty($size_list_details)) {
                               ?>
                                <select name="product_size" id="product_size" class="sizevaluedata">
                                 <option value="">Size</option>
                                    <?php
                                     foreach ($size_list_details as $size_list_details_value) {
                                     ?>
                                     <option value="<?php echo $size_list_details_value->attr_relation_size_name; ?>" data-value="<?php echo $size_list_details_value->attr_size_relation_id; ?>"><?php echo $size_list_details_value->size_name; ?></option>
                                     <?php
                                     }
                                     ?>
                                  </select>
                                 <?php
                                    }
                                    ?>     
                              <input type="hidden" value="<?php echo $product_upsell_details->pro_id ?>" name="pro_id" />
                              <input type="hidden" value="1" name="shipping_method" />
                              <input type="hidden" value="<?php echo $productSalePrice; ?>" id="product_price_to_cart" name="product_price_to_cart">
                              <input type="hidden" class="qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                              <input type="hidden" id="regularnewcolorprice" class="regularnewcolorprice" value="0">
                              <input type="hidden" id="specialnewcolorprice" class="specialnewcolorprice" value="0">
                              <input type="hidden" id="regularnewsizeprice" class="regularnewsizeprice" value="0">
                              <input type="hidden" id="specialnewsizeprice" class="specialnewsizeprice" value="0">
                           </div>
                           <button type="submit" class="button" style="margin-top: 10px;">ADD TO CART</button>
                           </form>
                        </div>
                     </div>
         </div>
      </div>
   </div>
</div>
<script>
    $(document).ready(function(){
        $("#upsellModalPopup").modal('show');
    });
</script>
<script>
    function upsellCartAdd() {
      $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>add-to-cart-details",
         data: $('.formsubmitcheck').serialize(),
         dataType: "json",
         success: function (data) {

            if (data.success == "ok") {
               window.location.reload();
            }
         }
      });
   }

$(".formsubmitcheck").submit(function(event) {
   let ColorValCheckEmpty=$('#product_color').val();
   let SizeValCheckEmpty=$('#product_size').val();
   if (ColorValCheckEmpty=='') {
      swal("choose color", "", "error");
   }else if(SizeValCheckEmpty==''){
      swal("choose size", "", "error");
   }else{
      upsellCartAdd();
   }
     event.preventDefault();
   });


$('.small-image').click(function(){
   return false;
})
</script>
<script type="text/javascript">
   $(document).ready(function() {
      $('.specialpricecolorajax').hide();
      $('.regularpricecolorajax').hide();
      $(".colorvaluedata").on('change', function () {
       let thiscolorvalue = $(this).find('option:selected').data('value');
       let colorProductId = $(this).find('option:selected').data('product');
       let colorId = $(this).find('option:selected').data('color');
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
   
     $(".sizevaluedata").on('change', function () {
       let thissizevalue =$(this).find('option:selected').data('value');
       let regularnewcolorprice = $('#regularnewcolorprice').val();
       let specialnewcolorprice = $('#specialnewcolorprice').val();
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
