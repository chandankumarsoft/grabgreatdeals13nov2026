<div class="breadcrumbs">
   <div class="container">
      <div class="row">
         <div class="col-xs-12">
            <ul>
               <div class="breadcrumb-container">
                  <div class="container">
                     <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>" title="Home Page"><span>Home</span></a></li>
                        <?php
                           $breadcrumb_pro_cat=$this->db->select('*')->from('tbl_category')->where('category_id',$product_info->pro_cat)->get()->row();
                           if ($breadcrumb_pro_cat->parent_id==0) {
                              $parent_id_data=$breadcrumb_pro_cat->category_id;
                           }else {
                               $breadcrumb_pro_sub_cat=$this->db->select('*')->from('tbl_category')->where('category_id',$product_info->pro_cat)->get()->row();
                           
                               $breadcrumb_pro_sub_cataa=$this->db->select('*')->from('tbl_category')->where('category_id',$breadcrumb_pro_sub_cat->parent_id)->get()->row();
                               if ($breadcrumb_pro_sub_cataa->parent_id==0) {
                                  $parent_id_data=$breadcrumb_pro_sub_cataa->category_id;
                               }else{
                                 $breadcrumb_pro_sub_sub_cat=$this->db->select('*')->from('tbl_category')->where('category_id',$product_info->pro_cat)->get()->row();
                           
                               $breadcrumb_pro_sub_cataaa=$this->db->select('*')->from('tbl_category')->where('category_id',$breadcrumb_pro_sub_sub_cat->parent_id)->get()->row();
                           
                                  $breadcrumb_pro_sub_cataaaa=$this->db->select('*')->from('tbl_category')->where('category_id',$breadcrumb_pro_sub_cataaa->parent_id)->get()->row();
                           
                               if ($breadcrumb_pro_sub_cataaaa->parent_id==0) {
                                  $parent_id_data=$breadcrumb_pro_sub_cataaaa->category_id;
                               }
                               }                  
                               
                           }
                           $breadcrumb_pro_cat=$this->db->select('*')->from('tbl_category')->where('category_id',$parent_id_data)->get()->row();
                           if ($breadcrumb_pro_cat!='') {
                           $breadcrumb_pro_cat_url=base_url().$breadcrumb_pro_cat->category_url_name;
                           echo "<li><a href=\"$breadcrumb_pro_cat_url\" ><span>$breadcrumb_pro_cat->category_name</span></a></li>";
                           }                
                           $base_url_site=base_url().'product-details'.'/'.$product_info->pro_title_slug;
                           echo "<li><a href=\"$base_url_site\" ><span>$product_info->pro_title</span></a></li>";
                           ?>
                     </ol>
                  </div>
               </div>
            </ul>
         </div>
      </div>
   </div>
</div>