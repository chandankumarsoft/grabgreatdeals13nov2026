<section class="blog_post">
   <div class="container">
      <div class="row">
         <?php
            function estimate_reading_time($contenttt) {
                $word_count = str_word_count(strip_tags($contenttt));
            
                $minutes = floor($word_count / 200);
                $seconds = floor($word_count % 200 / (200 / 60));
            
                $str_minutes = ($minutes == 1) ? "minute" : "minutes";
                $str_seconds = ($seconds == 1) ? "second" : "seconds";
            
                if ($minutes == 0) {
                    return "{$seconds} {$str_seconds}";
                }
                else {
                    return "{$minutes} {$str_minutes}, {$seconds} {$str_seconds}";
                }
            }
            ?>
         <div class="col-xs-12 col-sm-9" id="center_column">
            <div class="center_column">
               <div class="page-title">
                  <h2>Blog post</h2>
               </div>
               <ul class="blog-posts">
                  <?php
                     foreach ($allblogdata as $allblogdatavalue) {  ?>
                  <li class="post-item">
                     <article class="entry">
                        <div class="row">
                           <div class="col-sm-5">
                              <div class="entry-thumb image-hover2">
                                 <a href="<?php echo base_url(); ?>blog/<?php echo $allblogdatavalue->slug; ?>">
                                    <figure><img src="<?php echo "https://www.seller.grabgreatdeals.com/".$allblogdatavalue->image; ?>" alt="Blog"></figure>
                                 </a>
                              </div>
                           </div>
                           <div class="col-sm-7">
                              <h3 class="entry-title">
                                 <a href="<?php echo base_url(); ?>blog/<?php echo $allblogdatavalue->slug; ?>"><?php echo $allblogdatavalue->title; ?></a>
                              </h3>
                              <div class="entry-meta-data">
                                 <span class="author">
                                 <i class="fa fa-user"></i>&nbsp; by:
                                 <a href="#">Admin</a>
                                 </span>
                                 <span class="cat">
                                 <i class="fa fa-folder"></i>&nbsp;
                                 <?php
                                    $blogid=$allblogdatavalue->blog_id;
                                    $alltagsdata=$this->BlogModel->allTagsByBlog($blogid);
                                    foreach ($alltagsdata as $alltagsdataObj) { ?>
                                 <a href="<?php echo base_url().'tags/'.$alltagsdataObj->blog_tag_slug ?>"><?php echo $alltagsdataObj->blog_tag_name ?></a>
                                 <?php
                                    }
                                    ?>
                                 </span>
                                 <span class="comment-count"> <i class="fa fa-comment"></i>&nbsp; 
                                 <?php 
                                    $commentdata=$this->BlogModel->allCommentCount($allblogdatavalue->blog_id);
                                    echo $commentdata->countcommentid;
                                    ?> 
                                 </span>
                                 <span class="comment-count">
                                 reading time
                                 <i class="fa fa-clock-o"></i>&nbsp; 
                                 <?php 
                                    $contenttt=$allblogdatavalue->content;
                                    echo estimate_reading_time($contenttt); ?>
                                 </span> 
                                 <span class="date">
                                 <i class="fa fa-calendar"></i>&nbsp; <?php echo $allblogdatavalue->created_at; ?>
                                 </span>
                              </div>
                              <div class="entry-excerpt"><?php echo substr(legacy_localize_content_urls($allblogdatavalue->content),0,300); ?>
                              </div>
                              <a href="<?php echo base_url(); ?>blog/<?php echo $allblogdatavalue->slug; ?>" class="button read-more">Read more&nbsp;
                              <i class="fa fa-angle-double-right"></i>
                              </a>
                           </div>
                        </div>
                     </article>
                  </li>
                  <?php
                     }
                     ?>               
               </ul>
               <div class="sortPagiBar">
                  <?php echo $this->pagination->create_links();?>
               </div>
            </div>
         </div>
         <?php include('commonfile/asiderightside.php'); ?>
      </div>
   </div>
</section>