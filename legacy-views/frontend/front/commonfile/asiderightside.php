<aside class="sidebar col-xs-12 col-sm-3">
   <div class="block blog-module">
      <div class="sidebar-bar-title">
         <h3>Blog Categories</h3>
      </div>
      <div class="block_content">
         <div class="layered layered-category">
            <div class="layered-content">
               <ul class="tree-menu">
                  <?php
                     $all_category_data_of_blog=$this->BlogModel->allGategoryOfBlog();
                     foreach ($all_category_data_of_blog as $all_category_data_of_blog_value) { ?>
                  <li>
                     <a href="<?php echo base_url().'blog/category/'.$all_category_data_of_blog_value->blog_cat_slug; ?>">
                     <i class="fa fa-angle-right"></i>&nbsp;<?php echo $all_category_data_of_blog_value->blog_cat_name;  ?>
                     </a>
                  </li>
                  <?php }
                     ?>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="block blog-module">
      <div class="sidebar-bar-title">
         <h3>Popular Posts</h3>
      </div>
      <div class="block_content">
         <div class="layered">
            <div class="layered-content">
               <ul class="blog-list-sidebar">
                  <?php
                     $popular_blog_data=$this->BlogModel->popularBlogPost();
                     foreach ($popular_blog_data as $popular_blog_value) { ?>
                  <li>
                     <div class="post-thumb"> <a href="<?php echo base_url().'blog/'.$popular_blog_value->slug;  ?>">
                        <img src="<?php echo "https://www.seller.grabgreatdeals.com/".$popular_blog_value->image;  ?>" alt="Blog"></a> 
                     </div>
                     <div class="post-info">
                        <h5 class="entry_title"><a href="<?php echo base_url().'blog/'.$popular_blog_value->slug;  ?>"><?php echo $popular_blog_value->title;  ?></a></h5>
                        <div class="post-meta">
                           <span class="date"><i class="fa fa-calendar"></i><?php echo $popular_blog_value->created_at;  ?></span>
                        </div>
                     </div>
                  </li>
                  <?php }
                     ?>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="block blog-module">
      <div class="sidebar-bar-title">
         <h3>Recent Post</h3>
      </div>
      <div class="block_content">
         <div class="layered">
            <div class="layered-content">
               <ul class="blog-list-sidebar">
                  <?php
                     $recent_blog_data=$this->BlogModel->recentBlogPost();
                     foreach ($recent_blog_data as $recent_blog_value) { ?>
                  <li>
                     <div class="post-thumb"> <a href="<?php echo base_url().'blog/'.$recent_blog_value->slug;  ?>">
                        <img src="<?php echo "https://www.seller.grabgreatdeals.com/".$recent_blog_value->image;  ?>" alt="Blog"></a> 
                     </div>
                     <div class="post-info">
                        <h5 class="entry_title"><a href="<?php echo base_url().'blog/'.$recent_blog_value->slug;  ?>"><?php echo $recent_blog_value->title;  ?></a></h5>
                        <div class="post-meta">
                           <span class="date"><i class="fa fa-calendar"></i><?php echo $recent_blog_value->created_at;  ?></span>
                        </div>
                     </div>
                  </li>
                  <?php }
                     ?>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="popular-tags-area block">
      <div class="sidebar-bar-title">
         <h3>Popular Tags</h3>
      </div>
      <div class="tag">
         <ul>
            <?php
               $all_tags_data_of_blog=$this->BlogModel->allTagsOfBlog();
               foreach ($all_tags_data_of_blog as $all_tags_data_of_blog_value) { ?>
            <li><a href="<?php echo base_url().'tags/'.$all_tags_data_of_blog_value->blog_tag_slug;  ?>"><?php echo $all_tags_data_of_blog_value->blog_tag_name;  ?></a></li>
            <?php }
               ?>
         </ul>
      </div>
   </div>
</aside>