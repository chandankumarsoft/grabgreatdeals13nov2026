<style>
  .modal-dialog {
  min-width: 80%;
  min-height: 50%;
}

.modal-content {
  min-height: 80%;
  min-width: 80%;
}
</style>
<!-- Modal -->
<div class="modal fade" id="productdetailsmodal" tabindex="-1" role="dialog" aria-labelledby="productdetailsmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div>
        <div class="col-main">
        <div class="product-view-area">
          <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
            <div class="icon-sale-label sale-left" style="display: none;">Sale</div>
            <div class="large-image showimage showpopdetails"> 
              <a href="<?php echo base_url().'uploads/'.$product_info->pro_image; ?>" class="cloud-zoom anchorzoomcolorclass" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> 
                <img class="zoom-img imgzoomcolorclass" src="<?php echo base_url().'uploads/'.$product_info->pro_image; ?>" alt="products"> 
              </a> 
            </div>

            <div class="large-image1 showvideo showpopdetails" style="position: relative; display: none;"> 
              <a href="javascript:void(0);" class="cloud-zoom anchorzoomcolorclass1" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> 
                <video controls id="myVideo111" class="zoom-img imgzoomcolorclass1"  width="456" height="456" src="<?php echo base_url().'video/'.$product_info->product_video_name;?>">
              </a> 
            </div>

            <div class="flexslider2 flexslider-thumb" style="display: none;">
              <ul class="previews-list slides">
                <li>
                  <a href='<?php echo base_url().'uploads/'.$product_info->pro_image; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url().'uploads/'.$product_info->pro_image; ?>' " onclick="getVideoFile(1);" >
                    <img src="<?php echo base_url().'uploads/'.$product_info->pro_image; ?>" class="img-responsive" style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" alt = "Thumbnail 2"/>
                  </a>
                </li>
                <?php if (!empty($product_info->product_video_name)) { ?>
                <li>
                  <a href='<?php echo base_url(); ?>assets/front/images/loading/playbutton.png' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url(); ?>assets/front/images/loading/playbutton.png' "  onclick="getVideoFile(2);" >
                    <img src="<?php echo base_url(); ?>assets/front/images/loading/playbutton.png" style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" class="img-responsive" alt = "Thumbnail 2"/>
                  </a>
                </li>
                <?php } ?>
                <?php if (!empty($product_info->product_image_feature1)) { ?>
                <li>
                  <a href='<?php echo base_url().'uploads/'.$product_info->product_image_feature1; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url().'uploads/'.$product_info->product_image_feature1; ?>' " onclick="getVideoFile(1);">
                    <img src="<?php echo base_url().'uploads/'.$product_info->product_image_feature1; ?>" style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" class="img-responsive" alt = "Thumbnail 2"/>
                  </a>
                </li>
                <?php } ?>

                <?php if (!empty($product_info->product_image_feature2)) { ?>
                <li>
                  <a href='<?php echo base_url().'uploads/'.$product_info->product_image_feature2; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url().'uploads/'.$product_info->product_image_feature2; ?>' " onclick="getVideoFile(1);">
                    <img src="<?php echo base_url().'uploads/'.$product_info->product_image_feature2; ?>"  style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" class="img-responsive" alt = "Thumbnail 1"/>
                  </a>
                </li>
                <?php } ?>
                <?php if (!empty($product_info->product_image_feature3)) { ?>
                <li>
                  <a href='<?php echo base_url().'uploads/'.$product_info->product_image_feature3; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url().'uploads/'.$product_info->product_image_feature3; ?>' " onclick="getVideoFile(1);">
                    <img src="<?php echo base_url().'uploads/'.$product_info->product_image_feature3; ?>"  style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" class="img-responsive" alt = "Thumbnail 1"/>
                  </a>
                </li>
                <?php } ?>
                <?php if (!empty($product_info->product_image_feature4)) { ?>
                <li>
                  <a href='<?php echo base_url().'uploads/'.$product_info->product_image_feature4; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url().'uploads/'.$product_info->product_image_feature4; ?>' " onclick="getVideoFile(1);">
                    <img src="<?php echo base_url().'uploads/'.$product_info->product_image_feature4; ?>"  style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" class="img-responsive" alt = "Thumbnail 2"/>
                  </a>
                </li>
                <?php } ?>
                <?php if (!empty($product_info->product_image_feature5)) { ?>
                <li>
                  <a href='<?php echo base_url().'uploads/'.$product_info->product_image_feature5; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url().'uploads/'.$product_info->product_image_feature5; ?>' " onclick="getVideoFile(1);">
                    <img src="<?php echo base_url().'uploads/'.$product_info->product_image_feature5; ?>"  style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" class="img-responsive" alt = "Thumbnail 2"/>
                  </a>
                </li>
                <?php } ?>
                <?php if (!empty($product_info->product_image_feature6)) { ?>
                <li>
                  <a href='<?php echo base_url().'uploads/'.$product_info->product_image_feature6; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo base_url().'uploads/'.$product_info->product_image_feature6; ?>' " onclick="getVideoFile(1);">
                    <img src="<?php echo base_url().'uploads/'.$product_info->product_image_feature6; ?>"  style="min-width: 80px;max-width:80px;min-height: 80px;max-height: 80px;" class="img-responsive" alt = "Thumbnail 2"/>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </div>
            <!-- end: more-images -->
          </div>
          <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area">
            <div class="product-name">
              <h1><?php echo $product_info->pro_title?></h1>
            </div>
            <div class="price-box">
              <?php if (!empty($product_info->pro_offer_price)) { ?>
              <p class="special-price hideprice"> <span class="price-label">Special Price</span> <span class="price"> $<?php echo $product_info->pro_offer_price;?></span> </p>
              <p class="old-price hideprice"> <span class="price-label">Regular Price:</span> <span class="price"> $<?php echo $product_info->pro_price; ?> </span> </p>
              <?php } else { ?>
              <p class="special-price hideprice"> <span class="price-label">Special Price</span> <span class="price"> $<?php echo $product_info->pro_price;?></span> </p>
              <?php } ?>
              <p class="special-price specialpricecolorajax">
                <span class="price-label">Special Price</span>
                <span class="price specialpricecolorvalue">
                  
                </span>
              </p>
              <p class="old-price regularpricecolorajax">
                <span class="price-label">Regular Price:</span>
                <span class="price regularpricecolorvalue"> 
                  
                </span>
                <input type="hidden" id="regularnewcolorprice" class="regularnewcolorprice" value="0">
                <input type="hidden" id="specialnewcolorprice" class="specialnewcolorprice" value="0">
                <input type="hidden" id="regularnewsizeprice" class="regularnewsizeprice" value="0">
                <input type="hidden" id="specialnewsizeprice" class="specialnewsizeprice" value="0">
              </p>
              <div class="ratings">
                <div class="rating">
                  <?php
                  $selected_rating_data=$this->db->select('ROUND(AVG(review_average)) as rating')->from('tbl_product_review')->where('product_id',$product_info->pro_id)->get()->row();
                  if ($selected_rating_data->rating>0) {
                  for ($ratingi=0; $ratingi <$selected_rating_data->rating; $ratingi++) {
                  echo "<i class='fa fa-star'></i>";
                  }
                  for ($ratingi=0; $ratingi <(5-$selected_rating_data->rating); $ratingi++) {
                  echo "<i class='fa fa-star-o'></i>";
                  }
                  }else{
                  ?>
                  <i class="fa fa-star-o"></i>
                  <i class="fa fa-star-o"></i>
                  <i class="fa fa-star-o"></i>
                  <i class="fa fa-star-o"></i>
                  <i class="fa fa-star-o"></i>
                  <?php
                  }
                  ?>
                </div>
                <!-- <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Your Review</a> </p> -->
                <p class="availability in-stock pull-right">Availability: <span class="pro_quantity_color_value"> <?php echo $product_info->pro_quantity;?> In Stock</span></p>
              </div>
              <div class="short-description" style="margin-left: 10px;text-align: left;">
                <h2>KeyPoints:</h2>
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
                </ul>
              </div>
              <!--  <div class="short-description">
                <h2>Quick Overview</h2>
                <?php //if (!empty($product_info->pro_short_desc)) {
                // echo $product_info->pro_short_desc;
                //} else {
                //echo strip_tags(substr($product_info->pro_desc, 0, 800));
                //}
                ?>
              </div> -->
              
              <div class="product-color-size-area">
                <?php
                  $color_list_details=$this->db->select('attr_color_relation_id,attr_color_reference_id,attr_relation_color_name,attr_relation_color_image')->from('tbl_attr_relation_color')->where('attr_color_relation_product_id',$product_info->pro_id)->get()->result();

                  if (!empty($color_list_details)) {
                  ?>
                  <div class="size-area" style="width: 100%;">
                  <h2 class="saider-bar-title">Color</h2>
                  <div class="size">
                    <ul>
                      <?php                      
                      foreach ($color_list_details as $color_list_details_value) {
                      ?>
                      <li>
                        <a href="javascript:void(0);" class="colorvaluedata"  data-value="<?php echo $color_list_details_value->attr_color_relation_id; ?>" onclick="getVideoFile(1);">
                        <img src="<?php echo base_url().'uploads/thumbnail/'.$color_list_details_value->attr_relation_color_image; ?>" alt="" style="height: 50px;width: 50px;">
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
                $size_list_details=$this->db->select('attr_size_relation_id,attr_size_relation_product_id,attr_size_reference_id,attr_relation_size_name,size_name')->from('tbl_attr_relation_size')->join('tbl_size', 'tbl_attr_relation_size.attr_relation_size_name = tbl_size.size_id')->where('attr_size_relation_product_id',$product_info->pro_id)->get()->result();
              if (!empty($size_list_details)) {
              ?>
                  <div class="size-area" style="width: 100%;">
                  <h2 class="saider-bar-title">Variations</h2>  
                  <div class="size">
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
                  $(document).ready(function(){
                    $('.specialpricecolorajax').hide();
                    $('.regularpricecolorajax').hide();

                    $(".colorvaluedata").click(function() {
                      let thiscolorvalue = $(this).data("value");                      
                      let regularnewsizeprice = $('#regularnewsizeprice').val();
                      let specialnewsizeprice = $('#specialnewsizeprice').val();
                      $(".colorvaluedata").removeAttr("style");
                      $(this).css({"border":"3px","border-color":"yellow","border-style":"solid"});
                      $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'<?php echo base_url(); ?>product-color-data-value-get',
                        data:{thiscolorvalue:thiscolorvalue},
                        success:function(response)
                        {
                          if (response.attr_relation_color_regular_price) {
                            $(".anchorzoomcolorclass").attr("href", "<?php echo base_url(); ?>uploads/large/"+response.attr_relation_color_image);
                            $(".imgzoomcolorclass").attr("src", "<?php echo base_url(); ?>uploads/large/"+response.attr_relation_color_image);
                            $('.hideprice').hide();                            
                            if (parseInt(response.attr_relation_color_sale_price) > parseInt(specialnewsizeprice)) {
                               $('.regularpricecolorvalue').html("$"+response.attr_relation_color_regular_price);
                               $('.specialpricecolorvalue').html("$"+response.attr_relation_color_sale_price);
                            }else{
                               $('.regularpricecolorvalue').html("$"+regularnewsizeprice);
                               $('.specialpricecolorvalue').html("$"+specialnewsizeprice);
                            }                          

                            $('.regularnewcolorprice').val(response.attr_relation_color_regular_price);
                            $('.specialnewcolorprice').val(response.attr_relation_color_sale_price);
                            $('.pro_quantity_color_value').html(response.attr_relation_color_quantity+" In Stock");          
                          }
                        }
                      });
                    });
                    
                    $(".sizevaluedata").click(function() {
                      let thissizevalue = $(this).data("value");
                      let regularnewcolorprice = $('#regularnewcolorprice').val();
                      let specialnewcolorprice = $('#specialnewcolorprice').val();
                      $(".sizevaluedata").removeAttr("style");
                      $(this).css({"border":"3px","border-color":"yellow","border-style":"solid"});
                      $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'<?php echo base_url(); ?>product-size-data-value-get',
                        data:{thissizevalue:thissizevalue},
                        success:function(responsesize)
                        {
                          if (responsesize.attr_relation_size_regular_price) {                            
                            $('.hideprice').hide();                            
                            $('.specialpricecolorajax').show();                            
                            $('.regularpricecolorajax').show();
                             if (parseInt(responsesize.attr_relation_size_sale_price) > parseInt(specialnewcolorprice)) {
                                $('.regularpricecolorvalue').html("$"+responsesize.attr_relation_size_regular_price);
                                $('.specialpricecolorvalue').html("$"+responsesize.attr_relation_size_sale_price);
                             }else{
                                $('.regularpricecolorvalue').html("$"+regularnewcolorprice);
                                $('.specialpricecolorvalue').html("$"+specialnewcolorprice);
                             }
                            

                            $('.regularnewsizeprice').val(responsesize.attr_relation_size_regular_price);
                            $('.specialnewsizeprice').val(responsesize.attr_relation_size_sale_price);
                            $('.pro_quantity_color_value').html(responsesize.attr_relation_size_quantity+" In Stock");          
                          }
                        }
                      });
                    });

                  });
                </script>
            </div>
          </div>
        </div>
      </div>
          </div>
          <div>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
