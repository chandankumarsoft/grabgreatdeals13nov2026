<!-- Main Container -->
<div class="main-container col2-left-layout">
   <div class="container body_content">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3" id="content">
            <?php
               if ($this->uri->segment(1)=='covid-19') { ?>
            <div class="category-description std">
               <div class="slider-items-products">
                  <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                     <div class="slider-items slider-width-col1 owl-carousel owl-theme">
                        <!-- Item -->
                        <div class="item">
                           <a href=""><img alt="" src="<?= base_url('uploads/masks-banner.webp'); ?>"></a>
                           <div class="inner-info">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
            <div class="shop-inner">
               <div class="page-title">
                  <h2>Product List </h2> 
                  <p id="all_counted_value_id"></p>                 
               </div>
               <div class="toolbar">
                  <div class="view-mode">
                  </div>
                  <div class="sorter">
                     <div class="short-by">
                        <label>Sort By:</label>
                        <select style="width: auto;" id="filter_sort_by">
                           <option value="pro_price_desc"  selected="selected">Default sorting</option>
                           <option value="pro_price_asc">Sort by Price: Low to High </option>
                           <option value="pro_price_desc">Sort by Price: High to Low</option>
                           <option value="pro_created_on_asc">Sort by Date: Old to New</option>
                           <option value="pro_created_on_desc">Sort by Date: New to Old</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div id="all-product-list">
                  <?php  $this->load->view('front/products_list'); ?>
               </div>
            </div>
         </div>
         <aside class="sidebar col-sm-3 col-xs-12 col-sm-pull-9" id="sidebar">
            <div class="sidebar-inner">
               <div class="block shop-by-side">
                  <div class="sidebar-bar-title">
                     <h3>Shop By</h3>
                  </div>
                  <div class="block-content">
                     <p class="block-subtitle">Shopping Options</p>
                     <div class="layered-Category">
                        <h2 class="saider-bar-title">Categories</h2>
                        <div class="layered-content">
                           <ul class="check-box-list">
                              <?php
                                 foreach ($category as $categoryObj) { ?>
                              <li>
                                 <input type="checkbox" class="commom_data_filter category_data" id="<?php echo $categoryObj['category_id']; ?>" value="<?php echo $categoryObj['category_id']; ?>">
                                 <label for="<?php echo $categoryObj['category_id']; ?>">
                                    <span class="button"></span>
                                    <?php echo $categoryObj['category_name']; ?>
                                    <span class="count">(<?php echo $categoryObj['totalProd']; ?>)</span> 
                                 </label>
                              </li>
                              <?php } ?>
                           </ul>
                        </div>
                     </div>
                     <div class="block product-price-range">
                        <div class="sidebar-bar-title">
                           <h3>Price</h3>
                        </div>
                        <div class="block-content">
                           <div class="slider-range">
                              <?php
                                 $selecred_max_price_value=$this->db->select('max(pro_price) as max_price')->from('tbl_product')->get()->row();
                              ?>
                              <div data-label-reasult="Range:" data-min="0" name="fhh" data-max="<?php echo $selecred_max_price_value->max_price;  ?>" data-unit="$" class="slider-range-price" data-value-min="0" data-value-max="<?php echo $selecred_max_price_value->max_price;  ?>">                                 
                              </div>
                              <div class="amount-range-price">Range: $0 - $<?php echo $selecred_max_price_value->max_price;  ?>                                 
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="manufacturer-area">
                        <h2 class="saider-bar-title">New Arrivals</h2>
                        <div class="saide-bar-menu">
                           <ul class="check-box-list">
                              <li>
                                 <input type="checkbox" class="commom_data_filter new_arrival_data" id="newarrival2" value="90">
                                 <label for="newarrival2">
                                    <span class="button"></span>Last 90 days
                                 </label>
                              </li>                              
                              <li>
                                 <input type="checkbox" class="commom_data_filter new_arrival_data" id="newarrival1" value="30">
                                 <label for="newarrival1">
                                    <span class="button"></span>Last 30 days
                                 </label>
                              </li> 
                           </ul>
                        </div>
                     </div>
                     <div class="manufacturer-area">
                        <h2 class="saider-bar-title">Popular Tags</h2>
                        <div class="saide-bar-menu">
                           <ul class="check-box-list" style="height:100px;overflow: auto;">
                              <?php 
                                $selected_popular_tag=$this->db->select('DISTINCT(product_tag_id),product_tag_name')->from('tbl_product_tags_relation')->get()->result(); 
                                foreach ($selected_popular_tag as $selected_popular_tag_value) {
                              ?>
                              <li>
                                  <input type="checkbox" class="commom_data_filter popular_tag_data" id="<?php echo 'popular_tag_data'.$selected_popular_tag_value->product_tag_id; ?>" value="<?php echo $selected_popular_tag_value->product_tag_id; ?>">
                                 <label for="<?php echo 'popular_tag_data'.$selected_popular_tag_value->product_tag_id; ?>"> 
                                    <span class="button"></span>
                                    <?php echo $selected_popular_tag_value->product_tag_name; ?>
                                 </label>
                              </li>
                              <?php
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </aside>
      </div>
   </div>
</div>
<!-- Main Container End -->
<script type="text/javascript">
   var mnval=0;
   var mxval=<?php echo $selecred_max_price_value->max_price;  ?>;
   $(document).ready(function(){
      function filter_data(minvalue,maxvalue,page_url) {
         var category_data         =get_filter('category_data');
         var colorDataValueByClass =get_filter('color_data');
         var sizeDataValueByClass  =get_filter('size_data');
         var brandDataValueByClass =get_filter('brand_data');
         var ratingDataValueByClass=get_filter('customer_rating_data');
         var newAarrivalDataValueByClass=get_filter('new_arrival_data');
         var tagDataValueByClass   =get_filter('popular_tag_data');
         var filter_sort_by_value  =sort_by_default_value();
         var base_url="<?php echo base_url(); ?>search_filter";
         if (page_url) {
             base_url=page_url;
         }
         $.ajax({
            url:base_url,
            method:'post',
            dataType:"html",
            data:{
               category_data        :category_data,
               minvalue             :mnval,
               maxvalue             :mxval,
               filter_sort_by_value :filter_sort_by_value,
               colorDataValueByClass:colorDataValueByClass,
               sizeDataValueByClass :sizeDataValueByClass,
               brandDataValueByClass:brandDataValueByClass,
               ratingDataValueByClass:ratingDataValueByClass,
               newAarrivalDataValueByClass:newAarrivalDataValueByClass,
               tagDataValueByClass  :tagDataValueByClass,
               call_by_ajax:1
            },
            cache: false,
            beforeSend: function() {
               $('#products-list').html("<div class='text-center'><img src='https://www.seller.grabgreatdeals.com/assets/front/images/loading/searchingproduct.gif'/></div>");
            },
            success:function(respond){
               $('html, body').animate({
                 scrollTop: ($('.breadcrumb').offset().top)
               },200);
               $("#all-product-list").html(respond);
            },
         });
      }

      function get_filter(class_name) {
         var filter=[];
         $('.'+class_name+':checked').each(function() {
            filter.push($(this).val());
         });
         return filter;
      }

      $('.commom_data_filter').click(function() {
         filter_data();
      });

      $("#filter_sort_by").change(function() {
         filter_data();
      });

      function sort_by_default_value(){
         let filter_sort_by_value = $('#filter_sort_by').val();
         return filter_sort_by_value;
      }
      
      jQuery('.slider-range-price').each(function() {
         var min       = jQuery(this).data('min');
         var max       = jQuery(this).data('max');
         var unit      = jQuery(this).data('unit');
         var value_min = jQuery(this).data('value-min');
         var value_max = jQuery(this).data('value-max');
         var label_reasult = jQuery(this).data('label-reasult');
         var t = jQuery(this);
         jQuery(this).slider({
            range : true,
            min   : min,
            max   : max,
            values: [value_min, value_max],
            stop: function(event, ui) {
               var result = label_reasult + " " + unit + ui.values[0] + ' - ' + unit + ui.values[1];
               // console.log(t);
               t.closest('.slider-range').find('.amount-range-price').html(result);
               var minvalue=ui.values[0];
               var maxvalue=ui.values[1];
               mxval = maxvalue;
               mnval = minvalue;
               filter_data(minvalue,maxvalue);
            }
         });
      });

      $(document).on("click", ".pagignation_ajax_call li a", function(event){
         event.preventDefault();
         var page_url= $(this).attr('href');
         if (page_url=='javascript:void(0);') {
           false;
         }else{            
         filter_data('','',page_url);
         }
      });
   });
</script>
