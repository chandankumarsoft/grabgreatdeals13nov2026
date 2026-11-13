<script type="text/javascript" src="<?php echo base_url();?>/assets/back/ckeditor/ckeditor.js"></script>
<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Add New Product Details</h1>
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
            <!-- <div class="panel-heading">
               Add new Product
            </div> -->
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-12">
                     <h5 style='color:red'> <?php echo validation_errors();?></h5>
                     <?php echo form_open_multipart('admin/save-product','');?>
                     <div class="form-group">
                        <p id="titleExist"></p>
                        <label>Product Name or Title(*)</label>
                        <input type="text" class="form-control" id="pro_title" value="<?php echo set_value('pro_title'); ?>" name="pro_title" style="width: 75%" required minlength="5">
                     </div>
                     <div class="field_wrapper">
                        <label>Product Short Description With Bullet Points(*)</label>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control" required minlength="10"  style="width:75%;margin-top: 10px;" />
                        </div>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control"  required minlength="10"  style="width:75%;margin-top: 10px;" />
                        </div>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control" required  minlength="10"  style="width:75%;margin-top: 10px;" />
                        </div>
                        <div>
                           <input type="text" name="featuredbullettext[]" value="" class="form-control"  required minlength="10"  style="width:75%;margin-top: 10px;" />
                           
                        </div>
                     </div>
                     <a href="javascript:void(0);" class="add_button" title="Add field" style="margin-left: 76%;"><img src="<?php echo base_url(); ?>assets/back/img/add-icon.png"/></a>
                     <br>
                     <style type="text/css">div.multiple_select_checkbox {
                        width: 75%;
                        height: 300px;
                        overflow-x: hidden;
                        overflow-y: auto;
                        border: 1px solid #CCCCCC;
                        }
                     </style>
                     <label>Product Categories(*)</label>
                     <div class="form-group">
                        <div class="multiple_select_checkbox">
                           <?php
                              $categoryData=$this->db->select('*')->from('tbl_category')->get()->result();
                              foreach ($categoryData as $mainCategoryData) {
                              if ($mainCategoryData->parent_id==0) { ?>
                           <div style="margin-left: 10px;">
                              <input type="checkbox" name="category_multi_data[]" id="<?php echo $mainCategoryData->category_id; ?>" class="categoryclass<?php echo $mainCategoryData->category_id; ?>" value="<?php echo $mainCategoryData->category_id; ?>" />
                              <label for="<?php echo $mainCategoryData->category_id; ?>"><?php echo $mainCategoryData->category_name; ?></label>
                              <?php
                                 foreach ($categoryData as $subCategoryData) {
                                 if ($mainCategoryData->category_id==$subCategoryData->parent_id) {
                                 ?>
                              <div style="margin-left: 5%">
                                 
                                 <input type="checkbox" name="category_multi_data[]" id="<?php echo $subCategoryData->category_id; ?>" class="categoryclass<?php echo $mainCategoryData->category_id; ?>" value="<?php echo $subCategoryData->category_id; ?>" />
                                 <label for="<?php echo $subCategoryData->category_id; ?>"><?php echo $subCategoryData->category_name; ?></label>
                                 <?php
                                    foreach ($categoryData as $subOfSubCategoryData) {
                                    if ($subCategoryData->category_id==$subOfSubCategoryData->parent_id) {
                                    ?>
                                 <div style="margin-left: 5%">
                                    <input type="checkbox" name="category_multi_data[]" id="<?php echo $subOfSubCategoryData->category_id; ?>" class="categoryclass<?php echo $mainCategoryData->category_id; ?>" value="<?php echo $subOfSubCategoryData->category_id; ?>" />
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
$(document).on("click",".multiple_select_checkbox input[type='checkbox']", function(){ 
   var ClassNameValueGet = $(this).attr('class');
   if($(this).prop("checked") == false){
      $(".multiple_select_checkbox input[type='checkbox']").prop("disabled", false);
      $(".multiple_select_checkbox input[type='checkbox']").not('.'+ClassNameValueGet).prop("checked", false);
   }else{
      $(".multiple_select_checkbox input[type='checkbox']").prop("disabled", true);
      $('.'+ClassNameValueGet).removeAttr("disabled");
      $(".multiple_select_checkbox input[type='checkbox']").not('.'+ClassNameValueGet).prop("checked", false);
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
                           <?php
                              $product_type_data=$this->db->select('*')->from('tbl_product_type')->get()->result();
                              foreach ($product_type_data as $product_type_data_value) {
                              ?>
                           <label for="<?php echo 'pro_type'.$product_type_data_value->product_type_id; ?>">
                           <input type="checkbox" id="<?php echo 'pro_type'.$product_type_data_value->product_type_id; ?>" name="<?php echo $product_type_data_value->pro_type_name; ?>" value="1" <?php if ("$product_type_data_value->pro_type_name"=="is_normal"){ echo "checked"; } ?> /><?php echo $product_type_data_value->product_type_name; ?></label>
                           <?php
                              }
                              ?>                           
                        </div>
                     </div>
                     <?php
                         $fetched_tags_data_all=$this->db->select("GROUP_CONCAT(DISTINCT(`product_tag_name`) SEPARATOR ',') as tagsname")->from('tbl_product_tags')->get()->result();
                         $fetched_tags_data_explode=explode(',',$fetched_tags_data_all[0]->tagsname);
                         $fetched_tags_data_implode=implode("','",$fetched_tags_data_explode);
                     ?>
                     <label>Product Tags (Visitors choose the topic at a glance and seo friendly)</label>
                     <div>
                        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/tags/fm.tagator.jquery.css">
                        <script src="<?php echo base_url(); ?>/assets/tags/fm.tagator.jquery.js"></script>
                        <input id="activate_tagator" type="text" class="tagator form-control" name="product_tags" value="" placeholder="select or enter tags name" data-tagator-show-all-options-on-focus="true" data-tagator-autocomplete="<?php echo esc(str_replace('"', "'", json_encode($fetched_tags_data_explode, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG))); ?>" style="width: 75%">
                     </div>
                     <?php                    
                         $fetched_search_keys_data_all=$this->db->select("GROUP_CONCAT(DISTINCT(`search_key_name`) SEPARATOR ',') as searchkeyname")->from('tbl_product_search_keyword')->get()->result();
                         $fetched_search_key_data_explode=explode(',',$fetched_search_keys_data_all[0]->searchkeyname);
                         $fetched_search_key_data_implode=implode("','",$fetched_search_key_data_explode);
                      ?>
                     <label>Product Search Keywords (helpful for search this product in our website)</label>
                     <div>
                        <input id="activate_tagator1" type="text" class="tagator form-control" name="product_search_keywords" value="" placeholder="select or enter search key name" data-tagator-show-all-options-on-focus="true" data-tagator-autocomplete="<?php echo esc(str_replace('"', "'", json_encode($fetched_search_key_data_explode, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG))); ?>"  style="width: 75%">
                     </div>
                     <div class="form-group">
                        <label>Product Regular Price</label>
                        <input type="text" class="form-control pro_regular_price" value="<?php echo set_value('pro_price'); ?>" name="pro_price" required style="width: 75%" >
                     </div>
                     <div class="form-group">
                        <label>Product Sale Price</label>
                        <input type="text" class="form-control pro_sale_price" value="<?php echo set_value('pro_offer_price'); ?>" name="pro_offer_price" style="width: 75%">
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
                           <option value="<?php echo $brand->brand_id;?>"><?php echo $brand->brand_name;?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="form-group" style="width: 75%">
                        <label>Product Shipping Charge</label>
                        <select class="form-control" name="shipping_charge">
                           <option value="1" <?php echo set_select('shipping_charge', '1'); ?>>Yes</option>
                           <option value="2" <?php echo set_select('shipping_charge', '2'); ?>>No</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Product Sku Name</label>
                        <input type="text" class="form-control" value="<?php echo set_value('product_sku_name'); ?>" name="product_sku_name" required placeholder="Product Sku Name" style="width: 75%">
                     </div>
                     <label>Product Dimensions</label>
                     <div style="display:flex; width:75%;">
                        <input type="text" name="product_weight" class="form-control" placeholder="Weight(kg)" style="width:100%;">
                        <input type="text" name="product_length" class="form-control" placeholder="Length(cm)" style="width:100%;">
                        <input type="text" name="product_width" class="form-control" placeholder="Width(cm)" style="width:100%;">
                        <input type="text" name="product_height" class="form-control" placeholder="Height(cm)">
                     </div>

                     <div class="field_wrapper_attr" style="width: 75%;">
                        <label>Product Size Details</label>
                        <div style="display:flex;">
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
                           <input type="text" name="product_attr_size_regular_price[]" class="form-control product_size_regular_price" placeholder="Regular price" style="width:100%;" onkeyup="checkRegSalePrice(this,1);">
                           <input type="text" name="product_attr_size_sale_price[]" class="form-control" placeholder="Sale price" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
                           <input type="number" name="product_attr_size_quantity[]" class="form-control" placeholder="quantity" style="width:100%;">
                        </div>
                     </div>
                           <a href="javascript:void(0);" class="add_button_attr" title="Add field" style="margin-left: 75%;padding: 6px;"><img src="<?php echo base_url(); ?>assets/back/img/add-icon.png"/></a>


                        <div class="field_wrapper_color_attr" style="width: 75%;">
                        <label>Product Color Details</label>
                        <div style="display:flex;">
                           <input type="text" name="product_color_name[]" class="form-control" placeholder="Color Name" style="width:100%;">
                           <input type="file" name="product_color_name_image[]" class="form-control" style="width:100%;">
                           <input type="text" name="product_color_regular_price[]" class="form-control" placeholder="Regular price" style="width:100%;" onkeyup="checkRegSalePrice(this,1);">
                           <input type="text" name="product_color_sale_price[]" class="form-control" placeholder=" Sale price" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
                           <input type="number" name="product_color_quantity[]" class="form-control" placeholder="quantity" style="width:100%;">
                        </div>
                     </div>
                     <a href="javascript:void(0);" class="add_button_color_attr" title="Add field" style="margin-left: 75%;padding: 6px;"><img src="<?php echo base_url(); ?>assets/back/img/add-icon.png"/></a>      
                     <div class="form-group" style="width: 75%">
                        <label>Product Status</label>
                        <select class="form-control" name="pro_status">
                           <option value="1" <?php echo set_select('pro_status', '1'); ?>>Enable</option>
                           <option value="2" <?php echo set_select('pro_status', '2'); ?>>Disable</option>
                        </select>
                     </div>
                     <div class="form-group" style="width: 75%">
                        <label>Product Availability</label>
                        <select class="form-control" name="pro_availability" id="pro_availability">
                           <option value="1" <?php echo set_select('pro_availability', '1'); ?>>In Stock</option>
                           <option value="2" <?php echo set_select('pro_availability', '2'); ?>>Out Of Stock</option>
                           <option value="3" <?php echo set_select('pro_availability', '3'); ?>>Up Comming</option>
                        </select>
                     </div>
                     <script>
                        $("#pro_availability").change(function(){
                              let ProAvailabilityValue = $(this).val();
                              if (ProAvailabilityValue==1) {
                                 $('#ProQuantity').show();
                              }else{
                                 $('#ProQuantity').hide();
                              }
                           });                                                
                     </script>
                     <div class="form-group" id="ProQuantity">
                        <label>Product Quantity</label>
                        <input type="number" class="form-control" value="<?php echo set_value('pro_quantity'); ?>" name="pro_quantity"  style="width: 75%">
                     </div>
                     <div class="form-group" style="width: 75%">
                        <label>Product Reference URL</label>
                        <input type="text" class="form-control" value="<?php echo set_value('pro_reference_url'); ?>" name="pro_reference_url" >
                     </div>
                     <div class="form-group" style="width: 75%">
                        <label>Product Manufacturer Country Name</label>
                        <input type="text" class="form-control" value="<?php echo set_value('pro_manufacturer_country_name'); ?>" name="pro_manufacturer_country_name" required>
                     </div>
                     <div class="form-group">
                        <label>Product Description</label>
                        <textarea  id="ck1" class="form-control" rows="3" name="pro_desc"><?php echo set_value('pro_desc'); ?></textarea>
                        <script>
                           CKEDITOR.replace( 'ck1', {
                            height: 300,
                            filebrowserUploadUrl: "upload.php"
                           });
                       </script>
                     </div>

                     <div><p style="color:red;">Images must be at least 1000 pixels on the longest side and at least 500 pixels on the shortest side to be zoom-able.</p></div>
                     <div class="form-group">
                        <label>Product Main Image</label>
                        <input type="file" name="pro_image" id="profile-img" required  class="imgDropBox">
                        <img src="" id="profile-img-tag" class="imgDropAfter" style="max-width: 25%;min-width: 25%;height: 200px; margin-top:10px;" />
                     </div>
                     <script>
                        $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img width="200" height="200" style="margin:5px;">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});
                     </script>
                     <div class="form-group">
                        <label>Product Feature Images</label>
                        <input type="file" name="pro_image_features[]" multiple="multiple" id="gallery-photo-add">
                        <div class="gallery"></div>
                     </div>                      
                     <input type="hidden" name="top_product" value="0">
                     <button type="submit" class="btn btn-primary" id="form_submit">Save</button>
                     <?php echo form_close();?>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Form Elements -->
      </div>
   </div>
</div>
<!-- <script>
   $(document).ready(function(){
   $('#pro_title').on("input",function() {
   var pro_title_duplication=$('#pro_title').val();
   // alert(pro_title_duplication);
   $.ajax({
   type:'POST',
   url:'<?php //echo base_url(); ?>title-duplication-ckeck',
   dataType: "json",
   data:{pro_title_duplication:pro_title_duplication},
   success:function(result){
   if(result.message.error){
   $('#titleExist').html('Title Already Exist');
   }
   }
   });
   });
   });
   </script>  -->
<!-- end page-wrapper -->
<script type="text/javascript">
   $(document).ready(function(){
   var maxField = 10; //Input fields increment limitation
   var addButton = $('.add_button'); //Add button selector
   var wrapper = $('.field_wrapper'); //Input field wrapper
   var fieldHTML = '<div><input type="text" name="featuredbullettext[]" value="" class="form-control" style="width:75%;margin-top: 10px;display: inline-block;"/><a href="javascript:void(0);" class="remove_button">   <img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png"/ style="padding: 9px;"></a></div>'; //New input field html
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
   <div style="display:flex;width: 103%;">      
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
      <input type="text" name="product_attr_size_regular_price[]" class="form-control" placeholder="Regular price" style="width:100%;" onkeyup="checkRegSalePrice(this,1);" required>
      <input type="text" name="product_attr_size_sale_price[]" class="form-control" placeholder="Sale price" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
      <input type="number" name="product_attr_size_quantity[]" class="form-control" placeholder="quantity" style="width:100%;"> 
      <br>
      <a href="javascript:void(0);" class="remove_button_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding-left:6px;"/></a>
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
   <div style="display:flex;width: 103%;">   
     <input type="text" name="product_color_name[]" class="form-control" placeholder="Color Name" style="width:100%;"> 
      <input type="file" name="product_color_name_image[]" class="form-control" style="width:100%;">   
      <input type="text" name="product_color_regular_price[]" class="form-control" placeholder="Regular price" style="width:100%;" onkeyup="checkRegSalePrice(this,1);" required>
      <input type="text" name="product_color_sale_price[]" class="form-control" placeholder="Sale price" style="width:100%;" onkeyup="checkRegSalePrice(this,2);">
      <input type="number" name="product_color_quantity[]" class="form-control" placeholder="quantity" style="width:100%;"> 
      <br>
      <a href="javascript:void(0);" class="remove_button_color_attr"><img src="<?php echo base_url(); ?>assets/back/img/remove-icon.png" style="padding-left:6px;"/></a>
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
<script type="text/javascript">
   // function readURL1(input) {
   // if (input.files && input.files[0]) {
   // var reader = new FileReader();
   // reader.onload = function (e) {
   // $('#profile-img-tag-1').attr('src', e.target.result);
   // }
   // reader.readAsDataURL(input.files[0]);
   // }
   // }
   // $("#profile-img-1").change(function(){
   // readURL1(this);
   // });
</script>
<script type="text/javascript">
   // function readURL2(input) {
   // if (input.files && input.files[0]) {
   // var reader = new FileReader();
   // reader.onload = function (e) {
   // $('#profile-img-tag-2').attr('src', e.target.result);
   // }
   // reader.readAsDataURL(input.files[0]);
   // }
   // }
   // $("#profile-img-2").change(function(){
   // readURL2(this);
   // });
</script>
<script type="text/javascript">
   // function readURL3(input) {
   // if (input.files && input.files[0]) {
   // var reader = new FileReader();
   // reader.onload = function (e) {
   // $('#profile-img-tag-3').attr('src', e.target.result);
   // }
   // reader.readAsDataURL(input.files[0]);
   // }
   // }
   // $("#profile-img-3").change(function(){
   // readURL3(this);
   // });
</script>
<script type="text/javascript">
   // function readURL4(input) {
   // if (input.files && input.files[0]) {
   // var reader = new FileReader();
   // reader.onload = function (e) {
   // $('#profile-img-tag-4').attr('src', e.target.result);
   // }
   // reader.readAsDataURL(input.files[0]);
   // }
   // }
   // $("#profile-img-4").change(function(){
   // readURL4(this);
   // });
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