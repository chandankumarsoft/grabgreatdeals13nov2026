<!-- Sitemap  -->
<?php $all_category = $this->CategoryModel->get_all_category_front(); ?>
<style type="text/css">
.textstyle a{
font-size: larger;
}
</style>
<section class="container textstyle">
   <div class="sitemap-page">
      <div class="page-title">
         <h2>Sitemap</h2>
      </div>
      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
         <ul class="simple-list arrow-list bold-list">
            <?php
            foreach ($all_category as  $maincat) {
            if($maincat->parent_id == 0){
               $check_Product_Availability=$this->CategoryModel->checkProductAvailabilityById($maincat->category_id);
            if (!empty($check_Product_Availability)) {
            ?>
            <li>
               <a href="<?php echo base_url().$maincat->category_url_name; ?>"><?php echo ucwords(strtolower($maincat->category_name));?></a>
               <ul>
                  <?php foreach ($all_category as  $subcat) {?>
                  <?php
                  $sl_sub=0;
                  if($subcat->parent_id == $maincat->category_id){
                      $check_Product_Availability=$this->CategoryModel->checkProductAvailabilityById($subcat->category_id);
                                       if (!empty($check_Product_Availability)) {
                  $sl_sub++;
                  ?>                  
                  
                  <li><a href="<?php echo base_url().$maincat->category_url_name.'/'.$subcat->category_url_name; ?>"><i class="fa fa-angle-double-right">&nbsp;</i><?php echo ucwords(strtolower($subcat->category_name));?></a></li>
                  
                  <?php
                  foreach ($all_category as  $subcat1) {
                  ?>
                  <?php if($subcat1->parent_id == $subcat->category_id){
                      $check_Product_Availability=$this->CategoryModel->checkProductAvailabilityById($subcat1->category_id);
                                                   if (!empty($check_Product_Availability)) {
                  ?>
                  <li><a href="<?php echo base_url().$maincat->category_url_name.'/'.$subcat->category_url_name.'/'.$subcat1->category_url_name; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i><?php echo ucwords(strtolower($subcat1->category_name));?> </a> </li>
                  <?php } } } ?>
                  <?php } } } ?>
               </ul>
            </li>
            <?php } } } ?>
         </ul>
      </div>
      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
         <ul class="simple-list arrow-list bold-list">
            <li><a href="<?php echo base_url(); ?>show-cart">Shopping Cart</a></li>
            <li>
               <a href="<?php echo base_url(); ?>register">My Account</a>
               <ul>
                  <li><a href="javascript:void(0)">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>My Account</a></li>
                  <li><a href="javascript:void(0)">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>Order history</a></li>
                  <li><a href="javascript:void(0)">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>Advanced search</a></li>
                  <li><a href="javascript:void(0)">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>Reviews</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0)">Information</a>
               <ul>
                  <li><a href="<?php echo base_url(); ?>about-us">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>About Us</a></li>
                  <li><a href="<?php echo base_url(); ?>contact-us">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>Contact Us</a></li>
                  <li><a href="<?php echo base_url(); ?>terms-of-use">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>Terms & Condition</a></li>
                  <li><a href="<?php echo base_url(); ?>faq">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>FAQs</a></li>
                  <li><a href="<?php echo base_url(); ?>privacy-policy">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>Privacy Policy</a></li>
                  <li><a href="<?php echo base_url(); ?>sitemap">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i>Sitemap</a></li>
               </ul>
            </li>
            <li>
               <a href="<?php echo base_url(); ?>news">News</a>
               <ul>
                  <?php
                  $no=0;
                  $allblog=$this->db->select('blog_id,title,slug')->from('tbl_blog')->get()->result();
                  foreach ($allblog as $allblogvalue) {
                  $no++;
                  ?>
                  <li><a href="<?php echo base_url().'news/'.$allblogvalue->slug; ?>" style="color: black;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $no; ?>&nbsp;<i class="fa fa-angle-double-right">&nbsp;</i><?php echo $allblogvalue->title; ?></a></li>
                  <?php } ?>
               </ul>
            </li>
         </ul>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <img class="img-responsive animate scale" src="https://www.seller.grabgreatdeals.com/assets/front/images/large-icon-sitemap.png" alt=""> </div>
   </div>
</section>
<!-- //end Sitemap  -->