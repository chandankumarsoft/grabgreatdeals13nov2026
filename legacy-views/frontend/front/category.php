<?php
   $all_category = $this->CategoryModel->get_all_category_front();
?>
<nav>
   <div class="container">
      <div class="row">
         <div class="col-md-3 col-sm-4">
            <div class="mm-toggle-wrap">
               <div class="mm-toggle"> <i class="fa fa-align-justify"></i> </div>
               <span class="mm-label">Categories</span>
            </div>
            <div class="mega-container visible-lg visible-md visible-sm">
               <div class="navleft-container">
                  <div class="mega-menu-title">
                     <h3>Categories</h3>
                  </div>
                  <div class="mega-menu-category" style="display: none;">
                     <ul class="nav">
                        <?php $sl=0;
                           foreach ($all_category as  $maincat) {
                           if($maincat->parent_id == 0){
                           $check_Product_Availability=$this->CategoryModel->checkProductAvailabilityById($maincat->category_id);
                           if (!empty($check_Product_Availability)) {
                           $sl++;
                           ?>
                        <li <?php if($sl >= 10){ echo 'class="readless"';} ?>>
                           <a href="<?php echo base_url().$maincat->category_url_name; ?>"><?php echo ucwords(strtolower($maincat->category_name));?></a>
                           <div class="wrap-popup column1">
                              <div class="popup">
                                 <ul class="nav">
                                    <?php
                                       $sl_sub=0;
                                       foreach ($all_category as  $subcat) {?>
                                    <?php
                                       if($subcat->parent_id == $maincat->category_id){
                                       $check_Product_Availability=$this->CategoryModel->checkProductAvailabilityById($subcat->category_id);
                                       if (!empty($check_Product_Availability)) {
                                       $sl_sub++;
                                       ?>
                                    <li>
                                       <?php if ($sl_sub==1) {?>
                                       <?php } ?>                                          
                                       <a href="<?php echo base_url().$maincat->category_url_name.'/'.$subcat->category_url_name; ?>"><span><?php echo ucwords(strtolower($subcat->category_name));?></span><i class="fa fa-angle-right pull-right" aria-hidden="true"></i></a>
                                       <div class="wrap-popup column1">
                                          <div class="popup">
                                             <ul class="nav">
                                                <?php
                                                   $sl_sub_sub=0;
                                                   foreach ($all_category as  $subcat1) {
                                                   ?>
                                                <?php if($subcat1->parent_id == $subcat->category_id){
                                                   $check_Product_Availability=$this->CategoryModel->checkProductAvailabilityById($subcat1->category_id);
                                                   if (!empty($check_Product_Availability)) {
                                                   $sl_sub_sub++;
                                                   ?>
                                                <li>
                                                   <?php if($sl_sub_sub==1) { ?>
                                                   <?php } ?>
                                                   <a href="<?php echo base_url().$maincat->category_url_name.'/'.$subcat->category_url_name.'/'.$subcat1->category_url_name; ?>"><span><?php echo ucwords(strtolower($subcat1->category_name));?></span></a>
                                                </li>
                                                <?php } }?>
                                                <?php } ?>
                                             </ul>
                                          </div>
                                       </div>
                                    </li>
                                    <?php } }?>
                                    <?php } ?>
                                 </ul>
                              </div>
                           </div>
                        </li>
                        <?php } } } ?>
                        <button id="readmore" class="btn btn-danger" style="width:100%;background-color:#333;border-color:#333;">Read More</button>
                        <button id="lessmoreid" class="btn btn-danger" style="width:100%;background-color:#333;border-color:#333;">Less More</button>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="mtmegamenu">
               <ul>
                  <li class="mt-root demo_custom_link_cms">
                     <div class="mt-root-item">
                        <a href="<?php echo base_url(); ?>">
                           <div class="title title_font"><span class="title-text">Home</span></div>
                        </a>
                     </div>
                  </li>
                  <li class="mt-root">
                     <div class="mt-root-item">
                        <a href="<?php echo base_url(); ?>about-us">
                           <div class="title title_font"><span class="title-text">about us</span></div>
                        </a>
                     </div>
                  </li>
                  <li class="mt-root">
                     <div class="mt-root-item">
                        <a href="<?php echo base_url(); ?>contact-us">
                           <div class="title title_font"><span class="title-text">Contact Us</span> </div>
                        </a>
                     </div>
                  </li>
                  <li class="mt-root demo_custom_link_cms">
                   <div class="mt-root-item">
                     <a href="<?php echo base_url(); ?>blog">
                     <div class="title title_font">
                        <span class="title-text">Blog</span>
                     </div>
                     </a>
                  </div>
                   <ul class="menu-items col-md-3 col-sm-4 col-xs-12">
                  <?php
                     $all_category_data_of_blog=$this->BlogModel->allGategoryOfBlog();
                     foreach ($all_category_data_of_blog as $all_category_data_of_blog_value) { ?>
                  <li class="menu-item depth-1">
                       <div class="title"> <a href="<?php echo base_url().'blog/category/'.$all_category_data_of_blog_value->blog_cat_slug; ?>"> <?php echo $all_category_data_of_blog_value->blog_cat_name;  ?> </a></div>
                     </li>   
                  <?php }
                     ?>                                       
                   </ul>
                 </li>
                  <style>
                     .best-seller-hide::-moz-selection { color: #fed700;}
                     .best-seller-hide::selection { color: #fed700; }
                  </style>
                  <li class="mt-root">
                     <div class="mt-root-item">
                        <div class="title title_font"><span class="title-text best-seller-hide" style="color: #fed700;">Best Seller</span></div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</nav>