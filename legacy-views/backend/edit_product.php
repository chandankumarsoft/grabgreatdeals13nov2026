<script type="text/javascript" src="<?php echo base_url();?>/assets/back/ckeditor/ckeditor.js"></script>
<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Product Edit</h1>
      </div>
      <!--end page header -->
   </div>
   <style>
      .dropdown-check-list {  
      display: inline-block;
      }
      .dropdown-check-list .anchor {
      position: relative;
      cursor: pointer;
      display: inline-block;
      padding: 5px 50px 5px 10px;
      border: 1px solid #ccc;
      }
      .dropdown-check-list .anchor:after {
      position: absolute;
      content: "";
      border-left: 2px solid black;
      border-top: 2px solid black;
      padding: 5px;
      right: 10px;
      top: 20%;
      -moz-transform: rotate(-135deg);
      -ms-transform: rotate(-135deg);
      -o-transform: rotate(-135deg);
      -webkit-transform: rotate(-135deg);
      transform: rotate(-135deg);
      }
      .dropdown-check-list .anchor:active:after {
      right: 8px;
      top: 21%;
      }
      .dropdown-check-list ul.items {
      padding: 2px;
      display: none;
      margin: 0;
      border: 1px solid #ccc;
      border-top: none;
      }
      .dropdown-check-list ul.items li {
      list-style: none;
      }
      .dropdown-check-list.visible .anchor {
      color: #0094ff;
      }
      .dropdown-check-list.visible .items {
      display: block;
      }
   </style>
   <div class="row">
      <div class="col-lg-12">
         <!-- Form Elements -->
         <div class="panel panel-default">
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <h4 class="error">
               <?php $msg = $this->session->userdata('error_image');
                  echo $msg;                  
                  $this->session->unset_userdata('error_image');                  
                  ?>
            </h4>
            <?php if (!empty($this->session->userdata('pro_image')) || !empty($this->session->userdata('product_image_feature1')) || !empty($this->session->userdata('product_image_feature2'))|| !empty($this->session->userdata('product_image_feature3'))|| !empty($this->session->userdata('product_image_feature4'))) {
               ?>
            <div class="alert alert-danger">
               <?php if (!empty($this->session->userdata('pro_image'))) {
                  echo $this->session->userdata('pro_image')."</br>";
                  $this->session->unset_userdata('pro_image');
                  } ?>
               <?php if (!empty($this->session->userdata('product_image_feature1'))) {
                  echo $this->session->userdata('product_image_feature1')."</br>";
                  $this->session->unset_userdata('product_image_feature1');
                  } ?>
               <?php if (!empty($this->session->userdata('product_image_feature2'))) {
                  echo $this->session->userdata('product_image_feature2')."</br>";
                  $this->session->unset_userdata('product_image_feature2');
                  } ?>
               <?php if (!empty($this->session->userdata('product_image_feature3'))) {
                  echo $this->session->userdata('product_image_feature3')."</br>";
                  $this->session->unset_userdata('product_image_feature3');
                  } ?>
               <?php if (!empty($this->session->userdata('product_image_feature4'))) {
                  echo $this->session->userdata('product_image_feature4')."</br>";
                  $this->session->unset_userdata('product_image_feature4');
                  } ?>

                  <?php if (!empty($this->session->userdata('product_image_feature5'))) {
                  echo $this->session->userdata('product_image_feature5')."</br>";
                  $this->session->unset_userdata('product_image_feature5');
                  } ?>

                  <?php if (!empty($this->session->userdata('product_image_feature6'))) {
                  echo $this->session->userdata('product_image_feature6')."</br>";
                  $this->session->unset_userdata('product_image_feature6');
                  } ?>
            </div>
            <?php
               } ?>
            <?php if ($this->session->flashdata('update_pro_msg')!='') { ?>
            <div class="panel-heading">
               <h4 class="success"> <?php echo $this->session->flashdata('update_pro_msg'); ?></h4>
            </div>
            <?php } ?>
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-12">
                     <h5 style='color:red'> <?php echo validation_errors();?></h5>
                     <?php echo form_open_multipart('admin/update-product',''); ?>
                     <div class="form-group">
                        <label>Product Name or Title(*)</label>
                        <input type="text" class="form-control" value="<?php echo $all_product->pro_title?>" name="pro_title" style="width: 75%" required minlength="5">
                        <input type="hidden" class="form-control" value="<?php echo $all_product->pro_id?>" name="pro_id">
                     </div>
                     <div class="field_wrapper">
                        <label>Product Short Description With Bullet Points(*)</label>
                        <?php
                           if(count($all_pro_short_description) == 0) { ?>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control" minlength="10" required style="width:75%;margin-top: 10px;" />
                        </div>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control" minlength="10" required style="width:75%;margin-top: 10px;" />
                        </div>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control" minlength="10" required style="width:75%;margin-top: 10px;" />
                        </div>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control" minlength="10" required style="width:75%;margin-top: 10px;" />
                           <a href="javascript:void(0);" class="add_button" title="Add field" style="margin-left: 76%;"><img src="<?php echo base_url(); ?>assets/back/img/add-icon.png"/></a>
                        </div>
                        <?php  }
                           $no=0;                           
                           foreach ($all_pro_short_description as $all_pro_short_description)                    
                           {                           
                           $no++;                           
                           if ($no<=3) {                           
                           ?>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="<?php echo $all_pro_short_description->pro_short_desc_content; ?>" class="form-control" style="width:75%;margin-top: 10px;"/>
                        </div>
                        <?php
                           } else if($no<=4){?>
                        <input type="text" name="featuredbullettext[]" value="<?php echo $all_pro_short_description->pro_short_desc_content; ?>" class="form-control" style="width:75%;margin-top: 10px;"/>                        
                        <?php
                           } else{ ?>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="<?php echo $all_pro_short_description->pro_short_desc_content; ?>" class="form-control" style="width:75%;margin-top: 10px;display: inline-block;"/>
                           <a href="javascript:void(0);" class="remove_button"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png"></a>
                        </div>
                        <?php
                           }                           
                           }                           
                           ?>
                     </div>
                     <a href="javascript:void(0);" class="add_button" title="Add field" style="margin-left: 75%;padding: 5px;"><img src="<?php echo base_url(); ?>assets/back/img/add-icon.png"/></a>
                     <br>
                     <label>Product Categories(*)</label>
                     <div class="form-group">
                        <div class="multiple_select_checkbox tbl_category_class_check">
                           <?php
                              $categoryData=$this->db->select('*')->from('tbl_category')->get()->result();        
                              foreach ($categoryData as $mainCategoryData) {                              
                              if ($mainCategoryData->parent_id==0) { ?>
                           <div style="margin-left: 10px;">
                              <input type="checkbox" name="category_multi_data[]" id="<?php echo $mainCategoryData->category_id; ?>"  class="categoryclass<?php echo $mainCategoryData->category_id; ?>" value="<?php echo $mainCategoryData->category_id; ?>"
                                 <?php
                                    foreach ($all_cat_of_product as $all_cat_of_product_value) {                  
                                    if ($mainCategoryData->category_id==$all_cat_of_product_value->product_cat_id) { ?>
                                 checked="checked"
                                 <?php } }?>  />
                              <label for="<?php echo $mainCategoryData->category_id; ?>"><?php echo $mainCategoryData->category_name; ?></label>
                              <?php
                                 foreach ($categoryData as $subCategoryData) {                                 
                                 if ($mainCategoryData->category_id==$subCategoryData->parent_id) {               
                                 ?>
                              <div style="margin-left: 5%">
                                 <input type="checkbox" name="category_multi_data[]" id="<?php echo $subCategoryData->category_id; ?>"  class="categoryclass<?php echo $mainCategoryData->category_id; ?>" value="<?php echo $subCategoryData->category_id; ?>"
                                    <?php
                                       foreach ($all_cat_of_product as $all_cat_of_product_value) {               
                                       if ($subCategoryData->category_id==$all_cat_of_product_value->product_cat_id) { ?>
                                    checked="checked"
                                    <?php } }?>
                                    />
                                 <label for="<?php echo $subCategoryData->category_id; ?>"><?php echo $subCategoryData->category_name; ?></label>
                                 <?php
                                    foreach ($categoryData as $subOfSubCategoryData) {                            
                                    if ($subCategoryData->category_id==$subOfSubCategoryData->parent_id) {        
                                    ?>
                                 <div style="margin-left: 5%">
                                    <input type="checkbox" name="category_multi_data[]" id="<?php echo $subOfSubCategoryData->category_id; ?>"  class="categoryclass<?php echo $mainCategoryData->category_id; ?>" value="<?php echo $subOfSubCategoryData->category_id; ?>"
                                       <?php
                                          foreach ($all_cat_of_product as $all_cat_of_product_value) {            
                                          if ($subOfSubCategoryData->category_id==$all_cat_of_product_value->product_cat_id) { ?>
                                       checked="checked"
                                       <?php } }?>
                                       />
                                    <label for="<?php echo $subOfSubCategoryData->category_id; ?>"><?php echo $subOfSubCategoryData->category_name; ?></label>
                                 </div>
                                 <?php
                                    }                                    
                                    }                                    
                                    ?>
                              </div>
                              <?php
                                 }                                 
                                 }                                 
                                 ?>
                           </div>
                           <?php  } } ?>
                        </div>
                     </div>
                     
                     <script>
$(document).on("click",".tbl_category_class_check input[type='checkbox']", function(){ 
   var ClassNameValueGet = $(this).attr('class');
   if($(this).prop("checked") == false){
      $(".tbl_category_class_check input[type='checkbox']").prop("disabled", false);
      $(".tbl_category_class_check input[type='checkbox']").not('.'+ClassNameValueGet).prop("checked", false);
   }else{
      $(".tbl_category_class_check input[type='checkbox']").prop("disabled", true);
      $('.'+ClassNameValueGet).removeAttr("disabled");
      $(".tbl_category_class_check input[type='checkbox']").not('.'+ClassNameValueGet).prop("checked", false);
   }
});
                    </script>
                     <script type="text/javascript">
                        var expanded = false;                        
                        function showCheckboxes() {                        
                           var checkboxes = document.getElementById("checkboxes");                        
                           if (!expanded) {                        
                              checkboxes.style.display = "block";                        
                              expanded = true;                        
                           } else {                        
                              checkboxes.style.display = "none";                        
                              expanded = false;                        
                           }                        
                        }                        
                     </script>
                     <style type="text/css">
                        .multiselect {
                        width: 200px;
                        }
                        .selectBox {
                        position: relative;
                        }
                        .selectBox select {
                        width: 100%;
                        font-weight: bold;
                        }
                        .overSelect {
                        position: absolute;
                        left: 0;
                        right: 0;
                        top: 0;
                        bottom: 0;
                        }
                        #checkboxes {
                        display: none;
                        border: 1px #dadada solid;
                        }
                        #checkboxes label {
                        display: block;
                        }
                        #checkboxes label:hover {
                        background-color: #1e90ff;
                        }
                     </style>
                     <div class="multiselect" style="width: 75%">
                        <label>Product Type Like(HOT DEALS,SPECIAL)(*)</label>
                        <div class="selectBox" onclick="showCheckboxes()">
                           <select class="form-control">
                              <option>Select an option</option>
                           </select>
                           <div class="overSelect"></div>
                        </div>
                        <div id="checkboxes" style="padding: 5px;">
                           <label for="idis_normal">
                           <input type="checkbox" id="idis_normal" name="is_normal" value="1" <?php if ($all_product->is_normal==1) { echo "checked"; } ?> />Normal Product</label>
                           <label for="idis_topseller">
                           <input type="checkbox" id="idis_topseller" name="is_topseller" value="1" <?php if ($all_product->is_topseller==1) { echo "checked"; } ?> />Top Seller</label>
                           <label for="idis_special">
                           <input type="checkbox" id="idis_special" name="is_special" value="1" <?php if ($all_product->is_special==1) { echo "checked"; } ?> />Special</label>
                           <label for="idis_hot_sale">
                           <input type="checkbox" id="idis_hot_sale" name="is_hot_sale" value="1" <?php if ($all_product->is_hot_sale==1) { echo "checked"; } ?> />Hot Sale</label>
                           <label for="idis_recent">
                           <input type="checkbox" id="idis_recent" name="is_recent" value="1" <?php if ($all_product->is_recent==1) { echo "checked"; } ?> />Trending Offers</label>
                           <label for="idis_toprated">
                           <input type="checkbox" id="idis_toprated" name="is_toprated" value="1" <?php if ($all_product->is_toprated==1) { echo "checked"; } ?> />Top Rated</label>
                           <label for="idis_best_rate">
                           <input type="checkbox" id="idis_best_rate" name="is_best_rate" value="1" <?php if ($all_product->is_best_rate==1) { echo "checked"; } ?> />Best Rate</label>
                        </div>
                     </div>
                     <?php
                        $fetched_tags_data=$this->db->select("GROUP_CONCAT(`product_tag_name` SEPARATOR ',') as tagsname")->from('tbl_product_tags_relation')->where('product_id',$all_product->pro_id)->get()->result();                        
                        $fetched_tags_data_all=$this->db->select("GROUP_CONCAT(DISTINCT(`product_tag_name`) SEPARATOR ',') as tagsname")->from('tbl_product_tags')->get()->result();               
                        $fetched_tags_data_explode=explode(',',$fetched_tags_data_all[0]->tagsname);              
                        $fetched_tags_data_implode=implode("','",$fetched_tags_data_explode);                     
                        ?>
                     <label>Product Tags (Visitors choose the topic at a glance and seo friendly)</label>
                     <div>
                        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/tags/fm.tagator.jquery.css">
                        <!-- <script src="//code.jquery.com/jquery.min.js"></script> -->
                        <script src="<?php  echo base_url(); ?>/assets/tags/fm.tagator.jquery.js"></script>
                        <input id="activate_tagator2" type="text" class="tagator form-control" name="product_tags" value="<?php echo $fetched_tags_data[0]->tagsname ?>" data-tagator-show-all-options-on-focus="true" data-tagator-autocomplete="<?php echo esc(str_replace('"', "'", json_encode($fetched_tags_data_explode, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG))); ?>" style="width: 75%">
                     </div>
                     <?php
                        $fetched_search_key_data=$this->db->select("GROUP_CONCAT(`search_keyword_name` SEPARATOR ',') as search_key_name")->from('tbl_search_keyword_relation')->where('product_id',$all_product->pro_id)->get()->result();                        
                        $fetched_search_keys_data_all=$this->db->select("GROUP_CONCAT(DISTINCT(`search_key_name`) SEPARATOR ',') as searchkeyname")->from('tbl_product_search_keyword')->get()->result();
                        $fetched_search_key_data_explode=explode(',',$fetched_search_keys_data_all[0]->searchkeyname);                        
                        $fetched_search_key_data_implode=implode("','",$fetched_search_key_data_explode);        
                        ?>
                     <label>Product Search Keywords (helpful for search this product in our website)</label>
                     <div>
                        <input id="activate_tagator22" type="text" class="tagator form-control" name="product_search_keywords" value="<?php echo $fetched_search_key_data[0]->search_key_name ?>" data-tagator-show-all-options-on-focus="true" style="width: 75%">
                     </div>
                     <style type="text/css">div.multiple_select_checkbox {
                        width: 75%;
                        height: 300px;
                        overflow-x: hidden;
                        overflow-y: auto;
                        border: 1px solid #CCCCCC;
                        }
                     </style>
                     <div class="form-group">
                        <label>Product Regular Price</label>
                        <input type="text" class="form-control pro_regular_price" value="<?php echo $all_product->pro_price?>" name="pro_price"  required style="width: 75%">
                     </div>
                     <div class="form-group">
                        <label>Product Sale Price</label>
                        <input type="text" class="form-control pro_sale_price" value="<?php echo $all_product->pro_offer_price?>" name="pro_offer_price" style="width: 75%">
                     </div>
                     <script>
                        $(document).ready(function(){
                           $('.pro_regular_price,.pro_sale_price').keyup(function(){
                             let pro_regular_price = $('.pro_regular_price').val();
                             let pro_regular_price_new = (pro_regular_price=='') ? 0 : pro_regular_price;
                             let pro_sale_price = $('.pro_sale_price').val();
                             let pro_sale_price_new = (pro_sale_price=='') ? 0 : pro_sale_price;
                             if (parseFloat(pro_regular_price_new) >= parseFloat(pro_sale_price_new)) {
                             }else{
                              $( ".pro_sale_price" ).val('');
                              swal("Regular price must be greater than sale price","", "error");
                             }
                           });
                        });
                     </script>
                     <div class="form-group">
                        <label>Product Brand</label>
                        <select class="form-control" name="pro_brand" style="width: 75%">
                           <option value="">Select One</option>
                           <?php $all_brand = $this->ProductModel->get_all_brand()?>
                           <?php foreach ($all_brand as $brand) { ?>
                           <option
                              <?php if($all_product->pro_brand==$brand->brand_id){?>
                              selected="selected";
                              <?php }?>
                              value="<?php echo $brand->brand_id;?>"><?php echo $brand->brand_name;?>
                           </option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="form-group" style="width: 75%">
                        <label>Product Shipping Charge</label>
                        <select class="form-control" name="shipping_charge">
                           <option value="1" <?php echo set_select('shipping_charge', '1'); ?> <?php
                              echo ($all_product->pro_shipping_charge==1) ? 'selected' : ''; ?>>Yes</option>
                           <option value="0" <?php echo set_select('shipping_charge', '0'); ?><?php
                              echo ($all_product->pro_shipping_charge==0) ? 'selected' : ''; ?>>No</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Product Sku Name</label>
                        <input type="text" class="form-control" value="<?php echo $all_product->product_sku_name?>" name="product_sku_name"  style="width: 75%">                        
                     </div>
                     <br>
                     <label>Product Dimensions</label>
                     <div style="display:flex;width:75%;">
                        <input type="text" name="product_weight" class="form-control" value="<?php echo $all_product->pro_weight;  ?>" placeholder="Weight(kg)" style="width:100%;">
                        <input type="text" name="product_length" class="form-control" value="<?php echo $all_product->pro_length;  ?>" placeholder="Length(cm)" style="width:100%;">
                        <input type="text" name="product_width" class="form-control" value="<?php echo $all_product->pro_width;  ?>" placeholder="Width(cm)" style="width:100%;">
                        <input type="text" name="product_height" class="form-control" value="<?php echo $all_product->pro_height;  ?>" placeholder="Height(cm)" style="width:100%;">
                     </div>
                     <style>
                           .form-control {
                              height: auto;
                           }
                            .img-wrap {
                               position: relative;
                               display: inline-block;
                               font-size: 0;
                           }
                           .img-wrap .close {
                               position: absolute;
                               top: 2px;
                               right: 2px;
                               z-index: 100;
                               background-color: #FFF;
                               padding: 5px 2px 2px;
                               color: #000;
                               font-weight: bold;
                               cursor: pointer;
                               opacity: .2;
                               text-align: center;
                               font-size: 22px;
                               line-height: 10px;
                               border-radius: 50%;
                           }
                           .img-wrap:hover .close {
                               opacity: 1;
                           }
                     </style>
                     <div class="field_wrapper_attr" style="width: 75%;">
                        <label>Product Size Details</label>
                        <?php
                           $product_attr_all_fetched=$this->db->select('*')->from('tbl_attr_relation_size')->where('attr_size_relation_product_id',$all_product->pro_id)->get()->result();                   
                           if (count($product_attr_all_fetched)>0) {                          
                           $nocheck=0;                           
                           foreach ($product_attr_all_fetched as $product_attr_all_fetched_value) {              
                           $nocheck++;                           
                           ?>
                        <div style="display:flex;width: 104%;">                           
                           <select name="product_size_name[]" class="form-control" style="width:100%;">
                              <option value="">select size</option>
                              <?php
                                 $size_data=$this->db->select('*')->from('tbl_size')->get()->result();
                                 foreach ($size_data as $size_value) {
                                 ?>
                              <option value="<?php echo $size_value->size_id; ?>" <?php echo ($size_value->size_id==$product_attr_all_fetched_value->attr_relation_size_name)?"selected":""; ?>><?php echo $size_value->size_name; ?></option>
                              <?php
                                 }                                 
                                 ?>
                           </select>
                           <input type="text" name="product_attr_size_regular_price[]" class="form-control" placeholder="Regular price" value="<?php echo $product_attr_all_fetched_value->attr_relation_size_regular_price; ?>" style="width:100%;" onkeyup="checkRegSalePrice(this,1);">
                           <input type="text" name="product_attr_size_sale_price[]" class="form-control" placeholder="Sale price" value="<?php echo $product_attr_all_fetched_value->attr_relation_size_sale_price; ?>" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
                           <input type="number" name="product_attr_size_quantity[]" class="form-control" value="<?php echo $product_attr_all_fetched_value->attr_relation_size_quantity; ?>" placeholder="quantity" style="width:100%;">
                           <?php if($nocheck==1) : ?>
                          <a href="javascript:void(0);" class="remove_button_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding: 6px;"/></a>
                           <?php
                              else:                              
                              ?>
                           <a href="javascript:void(0);" class="remove_button_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding: 6px;"/></a>
                           <?php endif; ?>
                        </div>

                        <?php
                           }                           
                           }
                           else{                           
                           ?>

                        <div style="display:flex;width:100%;">
                           <select name="product_size_name[]" class="form-control" style="width:100%;">
                              <option value="">select size</option>
                              <?php
                                 $size_data=$this->db->select('*')->from('tbl_size')->get()->result();
                                 
                                 foreach ($size_data as $size_value) {
                                 
                                 ?>
                              <option value="<?php echo $size_value->size_id; ?>"><?php echo $size_value->size_name; ?></option>
                              <?php
                                 }                                 
                                 ?>
                           </select>
                           <input type="text" name="product_attr_size_regular_price[]" class="form-control" placeholder="Regular price" style="width:100%;" onkeyup="checkRegSalePrice(this,1);">
                           <input type="text" name="product_attr_size_sale_price[]" class="form-control" placeholder="Sale price" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
                           <input type="number" name="product_attr_size_quantity[]" class="form-control" placeholder="quantity" style="width:100%;">                           
                        </div>
                        <?php } ?>

                     </div>
                     <a href="javascript:void(0);" class="add_button_attr" style="margin-left: 75%;padding: 10px;" title="Add field">
                        <img src="<?php echo base_url(); ?>assets/back/img/add-icon.png"/></a>
            
                           <div class="field_wrapper_color_attr" style="width: 75%;">
   <label>Product Color Details</label>
   <?php
      $product_attr_color_all_fetched=$this->db->select('*')->from('tbl_attr_relation_color')->where('attr_color_relation_product_id',$all_product->pro_id)->get()->result();                   
      if (count($product_attr_color_all_fetched)>0) {                          
      $nocheck=0;                           
      foreach ($product_attr_color_all_fetched as $product_attr_color_all_fetched_value) {
      $nocheck++;            
      ?>
      <div style="display:flex;width: 104%;">                        
      <?php
      if ($product_attr_color_all_fetched_value->attr_relation_color_name!='') {
       $selected_color_val=$this->db->select('color')->from('tbl_color')->where('color_id',$product_attr_color_all_fetched_value->attr_relation_color_name)->get()->row();
       $selected_color = $selected_color_val->color;
      }else{
         $selected_color='';
      }
      ?>

      <input type="text" name="product_color_name[]" class="form-control" placeholder="Color Name" value="<?php echo $selected_color; ?>" style="width:100%;">

      <input type="file" name="product_color_name_image[]" class="form-control" style="width:100%;">
      <div class="img-wrap">
      <!-- <span class="close removeclassname<?php// echo $nocheck; ?>">&times;</span>                     -->
      <img src="<?php echo base_url().'uploads/'.$product_attr_color_all_fetched_value->attr_relation_color_image; ?>" alt="" style="height: 50px;width: 50px;">
      <input type="hidden" name="product_color_name_image_hidden[]" value="<?php echo $product_attr_color_all_fetched_value->attr_relation_color_image; ?>">
      </div>
      <input type="text" name="product_color_regular_price[]" class="form-control" placeholder="Regular price" value="<?php echo $product_attr_color_all_fetched_value->attr_relation_color_regular_price; ?>" style="width:100%;" onkeyup="checkRegSalePrice(this,1);">

      <input type="text" name="product_color_sale_price[]" class="form-control" placeholder="Sale price" value="<?php echo $product_attr_color_all_fetched_value->attr_relation_color_sale_price; ?>" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">


      <input type="number" name="product_color_quantity[]" class="form-control" value="<?php echo $product_attr_color_all_fetched_value->attr_relation_color_quantity; ?>" placeholder="quantity" style="width:100%;">

      <?php if($nocheck==1) : ?>
     <a href="javascript:void(0);" class="remove_button_color_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding: 6px;"/></a>
      <?php
         else:                              
         ?>
      <a href="javascript:void(0);" class="remove_button_color_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding: 6px;"/></a>
      <?php endif; ?>
   </div>


 <?php }
      }

      else{                           
      ?>

   <div style="display:flex;width:100%;">
      <input type="text" name="product_color_name[]" class="form-control" placeholder="Color Name" style="width:100%;">
      <input type="file" name="product_color_name_image[]" class="form-control" style="width:100%;">
      <img src="" alt="" style="height: 50px;width: 50px;">
      <input type="text" name="product_color_regular_price[]" class="form-control" placeholder="Regular price" style="width:100%;" onkeyup="checkRegSalePrice(this,1);">
      <input type="text" name="product_color_sale_price[]" class="form-control" placeholder="Sale price" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
      <input type="number" name="product_color_quantity[]" class="form-control" placeholder="quantity" style="width:100%;">                           
   </div>
   <?php } ?>

</div>
<a href="javascript:void(0);" class="add_button_color_attr" style="margin-left: 75%;padding: 10px;" title="Add field">
   <img src="<?php echo base_url(); ?>assets/back/img/add-icon.png"/></a>
                     <div class="form-group" style="width: 100%">
                     <script>
                     // $(document).on("click",".img-wrap span", function(){ 
                     //    var ClassNameValueGet = $(this).attr('class');
                     //    $(ClassNameValueGet).siblings('.bidbutton');
                     //    alert(ClassNameValueGet);

                     // });
                     </script>
                     <div class="form-group" style="width: 75%;">
                        <label>Product Status</label>
                        <select class="form-control" name="pro_status">
                           <?php if($all_product->pro_status==1){?>
                           <option selected="" value="1">Enable</option>
                           <option  value="2">Disable</option>
                           <?php }elseif($all_product->pro_status==2){ ?>
                           <option  value="1">Enable</option>
                           <option selected="" value="2">Disable</option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="form-group" style="width: 75%;">
                        <label>Product Availability</label>
                        <select class="form-control" name="pro_availability" id="pro_availability">
                           <?php if($all_product->pro_availability==1){?>
                           <option selected="" value="1">In Stock</option>
                           <option value="2">Out Of Stock</option>
                           <option value="3">Up Comming</option>
                           <?php }elseif($all_product->pro_availability==2){?>
                           <option value="1">In Stock</option>
                           <option selected="" value="2">Out Of Stock</option>
                           <option value="3">Up Comming</option>
                           <?php }elseif($all_product->pro_availability==3){?>
                           <option value="1">In Stock</option>
                           <option value="2">Out Of Stock</option>
                           <option selected="" value="3">Up Comming</option>
                           <?php }?>
                        </select>
                     </div>
                     <script>
                        $(document).ready(function(){
                        let ProAvailabilityValueForHidden = $('#pro_availability').val();
                        if (ProAvailabilityValueForHidden==1) {
                        $('#ProQuantity').show();
                        }else{
                        $('#ProQuantity').hide();
                        }
                        $("#pro_availability").change(function(){
                        let ProAvailabilityValue = $(this).val();
                        if (ProAvailabilityValue==1) {
                        $('#ProQuantity').show();
                        }else{
                        $('#ProQuantity').hide();
                        }
                        });
                        });
                     </script>
                     <div class="form-group" id="ProQuantity" style="width: 75%;">
                        <label>Product Quantity</label>
                        <input type="number" class="form-control" value="<?php echo $all_product->pro_quantity?>" name="pro_quantity">
                     </div>
                     <div class="form-group" style="width: 75%;">
                        <label>Product Reference URL</label>
                        <input type="text" class="form-control"  name="pro_reference_url" value="<?php echo $all_product->pro_reference_url?>">                        
                     </div>                     
                     <div class="form-group" style="width: 75%;">
                        <label>Product Manufacturer Country Name</label>
                        <input type="text" class="form-control"  name="pro_manufacturer_country_name" value="<?php echo $all_product->pro_manufacturer_country_name?>" required>                        
                     </div>
                     <div class="form-group">
                        <label>Add Product Description</label>
                        <textarea  id="ck1" class="form-control" rows="3" name="pro_desc">
                        <?php echo $all_product->pro_desc; ?>
                        </textarea>
                        <script>
                           CKEDITOR.replace( 'ck1', {
                            height: 300,
                            filebrowserUploadUrl: "upload.php"
                           });
                       </script>
                     </div>
                     <div>
                        <p style="color:red;">Images must be at least 1000 pixels on the longest side and at least 500 pixels on the shortest side to be zoom-able.</p>
                     </div>
                     <div class="form-group">
                        <label>Product Main Image</label>
                        <input type="file" name="pro_image" id="profile-img" style="color: transparent;padding:  10px;outline-color:#656f12;">
                        <input type="hidden" name="old_pro_image" value="<?php echo $all_product->pro_image; ?>">
                        <img src="<?php echo base_url().'uploads/'.$all_product->pro_image; ?>" id="profile-img-tag" style="max-width: 25%;min-width: 25%;height: 200px; margin-top:10px;"/>
                     </div>
                     <div class="form-group">
                        <label>Add More Image</label>
                        <input type="file" name="pro_image_features[]" multiple="multiple" id="gallery-photo-add">
                        <div class="gallery"></div>
                     </div>
                     </div>

                     </div>

<style>
.thumbnail {
    position: relative;
    width:100px;
    height:100px;
}

.thumbnail img {
    width:100%;
    height:100%;
}

#close {
    display: block;
    position: absolute;
    width:20px;
    height:20px;
    top: 2px;
    right: 2px;
    background: url(<?php echo base_url('assets/back/ckeditor/skins/moono-lisa/images/close.png'); ?>);
    background-size: 100% 100%;
    background-repeat: no-repeat;
    }
}
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                     <div class="row">

             <div class="col-12 col-md-12 col-lg-12 col-sm-12" style="display: flex;">
               <?php 
         $slsl=$this->db->select('id,image_name')->from('tbl_image')->where('img_rel_id',$this->input->get('pro_id'))->get()->result();
         foreach ($slsl as $value) {
      ?>
      <div class="thumbnail <?php echo "feature-img-hide".$value->id; ?>">

         <img class="img-thumbnail" width="100" height="100" src="<?php  echo base_url().'uploads/'.$value->image_name; ?>" alt="Nature">
         <a href="javascript:void(0)" data-value="<?php echo $value->id; ?>" onclick="featureImagegDel($(this).attr('data-value'))" id="close"></a>
      </div>
         

    
      <?php
         }
      ?>
             </div>

</div>
                     <?php if ($this->session->userrole!=5) { ?>
                     <button type="submit" class="btn btn-primary">Update</button>
                     <?php } ?>
                     <a href="<?php echo 'https://www.grabgreatdeals.com/product-details'.'/'.$all_product->pro_title_slug; ?>" class="btn btn-primary" target="_blank">Preview</a>
                     <?php echo form_close();?>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Form Elements -->
      </div>
   </div>
</div>
<!-- end page-wrapper -->
<script type="text/javascript">
   $(document).ready(function(){   
      var maxField = 10; //Input fields increment limitation   
      var addButton = $('.add_button'); //Add button selector   
      var wrapper = $('.field_wrapper'); //Input field wrapper   
      var fieldHTML = '<div><input type="text" name="featuredbullettext[]" value="" required class="form-control" style="width:75%;margin-top: 10px;display: inline-block;"/><a href="javascript:void(0);" class="remove_button"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding:6px; "/></a></div>'; //New input field html   
      var x = 1; //Initial field counter is 1   
      //Once add button is clicked   
      $(addButton).click(function(){   
         //Check maximum number of input fields   
         if(x < maxField){   
            x++; //Increment field counter   
            $(wrapper).append(fieldHTML); //Add field html   
         }   
      });   
      //Once remove button is clicked   
      $(wrapper).on('click', '.remove_button', function(e){   
         e.preventDefault();   
         $(this).parent('div').remove(); //Remove field html   
         x--; //Decrement field counter   
      });   
   });   
</script>
<div class="addMoreOption" style="display:none;">
   <div style="display:flex;width: 104%;">
      <select name="product_size_name[]" class="form-control">
         <option value="">select size</option>
         <?php
            $size_data=$this->db->select('*')->from('tbl_size')->get()->result();            
            foreach ($size_data as $size_value) {            
            ?>
         <option value="<?php echo $size_value->size_id; ?>"><?php echo $size_value->size_name; ?></option>
         <?php
            }            
            ?>
      </select>
      <input type="text" name="product_attr_size_regular_price[]" class="form-control" placeholder="Regular price" onkeyup="checkRegSalePrice(this,1);" required>
      <input type="text" name="product_attr_size_sale_price[]" class="form-control" placeholder="Sale price" onkeyup="checkRegSalePrice(this,2);">
      <input type="number" name="product_attr_size_quantity[]" class="form-control" placeholder="quantity">
      <a href="javascript:void(0);" class="remove_button_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding:6px;"/></a>
   </div>
</div>
<!-- end page-wrapper -->
<script type="text/javascript">
   $(document).ready(function(){   
      var maxField = 10; //Input fields increment limitation   
      var addButton = $('.add_button_attr'); //Add button selector   
      var wrapper = $('.field_wrapper_attr'); //Input field wrapper   
      var fieldHTML = $('.addMoreOption').html(); //New input field html   
      // alert(fieldHTML);   
      var x = 1; //Initial field counter is 1   
      //Once add button is clicked   
      $(addButton).click(function(){   
         //Check maximum number of input fields   
         if(x < maxField){   
            x++; //Increment field counter   
            $(wrapper).append(fieldHTML); //Add field html   
         }   
      });   
      //Once remove button is clicked   
      $(wrapper).on('click', '.remove_button_attr', function(e){   
         e.preventDefault();   
         $(this).parent('div').remove(); //Remove field html   
         x--; //Decrement field counter   
      });   
   });   
</script>

<div class="addMoreOptioncolor" style="display:none;">
   <div style="display:flex;width: 104%;">
      <input type="text" name="product_color_name[]" class="form-control" placeholder="Color Name" style="width:100%;">
      <input type="file" name="product_color_name_image[]" class="form-control" placeholder="color image" style="width:100%;">
      <img src="" alt="" style="height: 50px;width: 50px;">
      <input type="text" name="product_color_regular_price[]" class="form-control" placeholder="Regular price" style="width:100%;" onkeyup="checkRegSalePrice(this,1);" required>
      <input type="text" name="product_color_sale_price[]" class="form-control" placeholder="Sale price" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
      <input type="number" name="product_color_quantity[]" class="form-control" placeholder="quantity" style="width:100%;">

      <a href="javascript:void(0);" class="remove_button_color_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding:6px;"/></a>
   </div>
</div>
<!-- end page-wrapper -->
<script type="text/javascript">
   $(document).ready(function(){   
      var maxField = 10; //Input fields increment limitation   
      var addButton = $('.add_button_color_attr'); //Add button selector   
      var wrapper = $('.field_wrapper_color_attr'); //Input field wrapper   
      var fieldHTML = $('.addMoreOptioncolor').html(); //New input field html   
      // alert(fieldHTML);   
      var x = 1; //Initial field counter is 1   
      //Once add button is clicked   
      $(addButton).click(function(){   
         //Check maximum number of input fields   
         if(x < maxField){   
            x++; //Increment field counter   
            $(wrapper).append(fieldHTML); //Add field html   
         }   
      });   
      //Once remove button is clicked   
      $(wrapper).on('click', '.remove_button_color_attr', function(e){   
         e.preventDefault();   
         $(this).parent('div').remove(); //Remove field html   
         x--; //Decrement field counter   
      });   
   });   
</script>
<script type="text/javascript">
   function readURL(input) {   
      if (input.files && input.files[0]) {   
         var reader = new FileReader();   
         reader.onload = function (e) {   
            $('#profile-img-tag').attr('src', e.target.result);   
         }   
         reader.readAsDataURL(input.files[0]);   
      }   
   }   
   $("#profile-img").change(function(){   
      readURL(this);   
   });   
</script>

<script>
   function checkRegSalePrice(thisvalue,keyvalue) {
      if (keyvalue==1) {
           let pro_regular_size_color_price = $(thisvalue).val();
           let pro_regular_size_color_price_new = (pro_regular_size_color_price=='') ? 0 : pro_regular_size_color_price;
           let pro_sale_size_color_price = $(thisvalue).next().val();
           let pro_sale_size_color_price_new = (pro_sale_size_color_price=='') ? 0 : pro_sale_size_color_price;
           if (parseFloat(pro_regular_size_color_price_new) >= parseFloat(pro_sale_size_color_price_new)) {

           }else{
               $(thisvalue).next().val('');
               swal("Regular price must be greater than sale price","", "error");
           }
      }else{
           let pro_sale_size_color_price = $(thisvalue).val();
           let pro_sale_size_color_price_new = (pro_sale_size_color_price=='') ? 0 : pro_sale_size_color_price;
           let pro_regular_size_color_price = $(thisvalue).prev().val();
           let pro_regular_size_color_price_new = (pro_regular_size_color_price=='') ? 0 : pro_regular_size_color_price;
           if (parseFloat(pro_regular_size_color_price_new) >= parseFloat(pro_sale_size_color_price_new)) {

           }else{
               $(thisvalue).val('');
               swal("Regular price must be greater than sale price","", "error");
           }
      }
   }
</script>
<script>
   function featureImagegDel(ImgId)
   {
                 $.ajax({
                    url:'<?php echo base_url(); ?>admin/product-feature-image-delete',
                    type:'POST',
                     dataType:'json',
                    data:{ImgId:ImgId},
                    success:function(result){
                     if (result.success==1) {
                        $('.feature-img-hide'+ImgId).hide();
                     }
                    }
                 });
   }
</script>