 <!-- Main Container -->
 <script>
   $(document).ready(function () {
      $('#comment_form').on('submit', function (event) {
         event.preventDefault();
         $.ajax({
            url: "<?php echo base_url(); ?>commentOnBlog",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
               if (response.error) {

                  if (response.name_error != '') {

                     $('#name_error').html(response.name_error);

                  } else {

                     $('#name_error').html('');

                  }
                  if (response.email_error != '') {

                     $('#email_error').html(response.email_error);

                  } else {

                     $('#email_error').html('');

                  }
                  if (response.subject_error != '') {

                     $('#subject_error').html(response.subject_error);

                  } else {

                     $('#subject_error').html('');

                  }
                  if (response.message_error != '') {

                     $('#message_error').html(response.message_error);

                  } else {

                     $('#message_error').html('');

                  }
               } else {
                  $('#success').html(response.success);
                  $('#name_error').html('');
                  $('#email_error').html('');
                  $('#subject_error').html('');
                  $('#message_error').html('');
                  $('#comment_form')[0].reset();
                  setTimeout(function(){
                  $('#success').hide();
                  $('#success').html('');
                  $('#success').show();
                  $("#test").load(" #test");
}, 1000);
               }
            }

         });
      });
   }); 
</script>
 <script type="text/javascript">
    function like_Comment_Id(likecommentid,blogid,type_of_data){
      // alert(type_of_data);
      $.ajax({
            url: "<?php echo base_url(); ?>likeCommentedData",
            method: "POST",
            dataType:'json',
            data: {
               likecommentid:likecommentid,
               blogid:blogid,
               type_of_data:type_of_data
            },            
            success: function (responselike) {
            if (responselike.like) {
              $('#like'+likecommentid).css("color", "blue");

              setTimeout(function(){
               $("#test").load(" #test");
         }, 1000);
            } else {
               $('#dislike'+likecommentid).css("color", "red");
               setTimeout(function(){
                  $("#test").load(" #test");
}, 1000);
            }
    }
         });
    }
     function replyid(id){
      $('#exampleModal').modal('show');
      $('#comment_to_comment').on('click',function(){
         var replyblog_id = $('#replyblog_id').val();
         var replycommentblog_id = id;
         var replyname = $('#replyname').val();
         var replyemail = $('#replyemail').val();
         var replymessage = $('#replymessage').val();
         $.ajax({
            url: "<?php echo base_url(); ?>replyOnComment",
            method: "POST",
            dataType:'json',
            data: {
               replyblog_id:replyblog_id,
               replycommentblog_id:replycommentblog_id,
               replyname:replyname,
               replyemail:replyemail,
               replymessage:replymessage
            },
            dataType: "json",
            success: function (replycomment_response) {
               if (replycomment_response.error) {

                  if (replycomment_response.name_error != '') {

                     $('#replyname_error').html(replycomment_response.name_error);

                  } else {

                     $('#replyname_error').html('');

                  }
                  if (replycomment_response.email_error != '') {

                     $('#replyemail_error').html(replycomment_response.email_error);

                  } else {

                     $('#replyemail_error').html('');

                  }
                  // if (replycomment_response.subject_error != '') {

                  //    $('#replysubject_error').html(replycomment_response.subject_error);

                  // } else {

                  //    $('#replysubject_error').html('');

                  // }
                  if (replycomment_response.message_error != '') {

                     $('#replymessage_error').html(replycomment_response.message_error);

                  } else {

                     $('#replymessage_error').html('');

                  }
               } else {
                  $('#replysuccess').html(replycomment_response.replysuccess);
                  $('#replyname_error').html('');
                  $('#replyemail_error').html('');
                  $('#replymessage_error').html('');
                  $('#replycomment')[0].reset();
                  setTimeout(function(){
                  $('#exampleModal').modal('hide');
                  $('#replysuccess').hide();
                  $('#replysuccess').html('');
                  $('#replysuccess').show();
                  $("#test").load(" #test");
}, 1000);
               }
            }

         });
      })
   }
 </script>
 <script type="text/javascript">
      function like_blog(blogid,type_of_data) {
         $.ajax({
            url: "<?php echo base_url(); ?>likebloginsert",
            method: "POST",
            dataType:'json',
            data: {
               blogid:blogid,
               type_of_data:type_of_data
            },            
            success: function (responselike) {
               if (responselike.like) {

                  $('#bloglike'+blogid).css("color", "blue");

                     setTimeout(function(){
                     $("#bloglikerefresh").load(" #bloglikerefresh");
                     }, 1000);

               } else {

                  $('#blogdislike'+blogid).css("color", "red");

                  setTimeout(function(){
                  $("#bloglikerefresh").load(" #bloglikerefresh");
                  }, 1000);

               }
            }
         });
      
      }
 </script>
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
         <div class="col-xs-12 col-sm-9">
            <div class="entry-detail">
               <div class="page-title">
                  <h1><?php echo $slug_data->title; ?></h1>
               </div>
               <div class="entry-photo">
                  <figure><img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.$slug_data->image; ?>" alt="Blog"></figure>
               </div>
               <div class="entry-meta-data">
                  <span class="author"> <i class="fa fa-user"></i>&nbsp; by:
                  <a href="#">Admin</a></span>
                  <span class="cat"> <i class="fa fa-folder"></i>&nbsp;                  
                  </span>
                  <span class="comment-count">
                                 reading time
                                 <i class="fa fa-clock-o"></i>&nbsp; 
                                 <?php 
                                    $contenttt=$slug_data->content;
                                    echo estimate_reading_time($contenttt); ?>
                  </span>
                  <span class="comment-count"> <i class="fa fa-comment"></i>&nbsp; <?php echo $slug_data->countcommentid; ?> </span>
                  <span class="date"><i class="fa fa-calendar">&nbsp;</i>&nbsp; <?php echo $slug_data->created_at; ?></span>
                  <!-- <div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>&nbsp; <span>(5 votes)</span></div> -->
                     <div class="rating" style="display: flex;font-size: 15px;" id="bloglikerefresh">
                        <?php $likesdata=$this->BlogModel->AllLikevalue($blogid); ?>
                        <p class="m-0 mr-2" id="bloglike<?php echo $blogid ?>" onclick="like_blog(<?php echo $blogid.','."1" ?>)">
                           <span>
                              <i class="fa fa-thumbs-up mr-1" aria-hidden="true" title="like" style="cursor: pointer;">                                 
                              </i><?php echo $likesdata->like; ?>
                           </span>                           
                        </p>
                        <p class="m-0 mr-2"  style="margin-left:10px;" id="blogdislike<?php echo $blogid ?>" onclick="like_blog(<?php echo $blogid.','."2" ?>)">
                              <span>
                                 <i class="fa fa-thumbs-down mr-1" aria-hidden="true" title="dislike" style="cursor: pointer;">                                    
                                 </i><?php echo $likesdata->dislike; ?>
                              </span>                           
                        </p>                          
                     </div>
               </div>
               <div class="content-text clearfix">
                  <?php echo legacy_localize_content_urls($slug_data->content); ?>
               </div>
               <div class="entry-tags"> <span>Tags:</span> <?php
                     $blogid=$slug_data->blog_id;
                     $alltagsdata=$this->BlogModel->allTagsByBlog($blogid);
                     foreach ($alltagsdata as $alltagsdataObj) { ?>
                  <a href="<?php echo base_url().'tags/'.$alltagsdataObj->blog_tag_slug ?>"><?php echo $alltagsdataObj->blog_tag_name ?></a> |
                  <?php
                     }
                     ?> </div>
            </div>
            <!-- Related Posts -->
            <div class="single-box">
               <h2>Related Posts</h2>
               <div class="slider-items-products">
                  <div id="related-posts" class="product-flexslider hidden-buttons">
                     <div class="slider-items slider-width-col4 fadeInUp">
                        <?php $relatedblog=$this->BlogModel->relatedBlogData($slug_data->slug);
                        foreach ($relatedblog as $relatedblogvalue) {  ?>
                        <div class="product-item">
                           <article class="entry">
                              <div class="entry-thumb image-hover2"> <a href="<?php echo base_url(); ?>blog/<?php echo $relatedblogvalue->slug; ?>"> <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.$relatedblogvalue->image; ?>" alt="Blog"> </a> </div>
                              <div class="entry-info">
                                 <h3 class="entry-title"><a href="<?php echo base_url(); ?>blog/<?php echo $relatedblogvalue->slug; ?>"><?php echo $relatedblogvalue->title; ?></a></h3>
                                 <div class="entry-meta-data"> <!-- span class="comment-count"> <i class="fa fa-comment-o">&nbsp;</i> 1 </span> --> <span class="date"> <i class="fa fa-calendar">&nbsp;</i> <?php echo $relatedblogvalue->created_at; ?> </span> </div>
                                 <div class="entry-more"> <a href="<?php echo base_url(); ?>blog/<?php echo $relatedblogvalue->slug; ?>">Read more</a> </div>
                              </div>
                           </article>
                        </div>
                         <?php
                          }
                         ?>
                     </div>
                  </div>
               </div>
            </div>
            <!-- ./Related Posts -->
            <!-- Comment -->
            <div class="single-box" id="test">
               <!-- <h2 class="">Comments</h2> -->
               <div class="comment-list">
                  <ul>
                     <?php 
                     $commented_data=$this->BlogModel->AllCommentedData($blogid); 
                     foreach ($commented_data as $commented_datavalue) {                       
                        ?>
                     <li>
                        <!-- <div class="avartar"> <img src="<?php //echo base_url(); ?>assets/front/images/avatar.png" alt="Avatar"> </div> -->
                        <div class="comment-body">
                           <div class="comment-meta"> <span class="author">
                              <a href="#">
                              <?php echo esc($commented_datavalue->comment_name); ?></a></span> <span class="date"><?php echo esc($commented_datavalue->comment_date); ?></span> </div>
                           <div class="comment"><?php echo esc($commented_datavalue->comment_content); ?> 
                        </div>
                        <div style="display: flex;">
                         <p class="m-0 mr-2" id="like<?php echo $commented_datavalue->comment_id ?>" onclick="like_Comment_Id(<?php echo $commented_datavalue->comment_id.','.$blogid.','."1"; ?>)">
                           <span><i class="fa fa-thumbs-up mr-1" aria-hidden="true" title="like" style="cursor: pointer;"></i></span>
                           </i><?php
                           if(isset($commented_datavalue->comment_like))
                           {
                              echo $commented_datavalue->comment_like;
                           }
                            ?>
                           </p>
                           <p class="m-0 mr-2" id="dislike<?php echo $commented_datavalue->comment_id ?>" style="margin-left:10px;" onclick="like_Comment_Id(<?php echo $commented_datavalue->comment_id.','.$blogid.','."2"; ?>)">
                              <span><i class="fa fa-thumbs-down mr-1" aria-hidden="true" title="dislike" style="cursor: pointer;"></i></span>
                           </i><?php if(isset($commented_datavalue->comment_dislike)){echo $commented_datavalue->comment_dislike;} ?>
                           </p>
                           <p style="margin-left:10px;cursor: pointer; font-weight: bold;" onclick="replyid(<?php echo $commented_datavalue->comment_id; ?>);">reply</p>
                           </div>
                        </div>
                        <ul>
                           <?php 
                     $commented_data_reply=$this->BlogModel->AllCommentedDataReply($blogid,$commented_datavalue->comment_id); 
                     foreach ($commented_data_reply as $commented_reply_datavalue) {                       
                        ?>
                           <li>
                              <!-- <div class="avartar"> <img src="<?php //echo base_url(); ?>assets/front/images/avatar.png" alt="Avatar"> </div> -->
                              <div class="comment-body">
                                 <div class="comment-meta"> <span class="author"><a href="#"><?php echo esc($commented_reply_datavalue->comment_name); ?></a></span> <span class="date"><?php echo esc($commented_reply_datavalue->comment_date); ?></span> </div>
                                 <div class="comment"><?php echo esc($commented_reply_datavalue->comment_content); ?></div>
                              </div>
                           </li>
                        <?php } ?>
                        </ul>
                     </li>
                      <?php
                      }
                     ?>
                     
                  </ul>
               </div>
            </div>
            <div class="single-box comment-box">
               <h2>Leave a Comment</h2>
               <div class="coment-form">
                  <p>Make sure you enter the () required information where indicated. HTML code is not allowed.</p>
                  <div class="row">
                    <form method="post" id="comment_form">
                     <div id="success"></div>
                     <div class="col-sm-6">
            <input type="hidden" name="blog_id" value="<?php echo $blogid; ?>">
            <?php echo form_label('Name', 'name'); ?>
            <?php echo form_input(['type' => 'text','id'=>'name','name'=>'name','value'=>'','class'=>'form-control']); ?>
            <span id="name_error" style="color: red;"></span>
                     </div>
                     <div class="col-sm-6">
            <?php echo form_label('Email', 'email'); ?>
            <?php echo form_input(['type' => 'text','id'=>'email','name'=>'email','value'=>'','class'=>'form-control']); ?>
            <span id="email_error" style="color: red;"></span>
                     </div>
                    <!--  <div class="col-sm-12">
            <?php //echo form_label('Subject', 'subject'); ?>
            <?php// echo form_input(['type' => 'text','id'=>'subject','name'=>'subject','value'=>'','class'=>'form-control']); ?>
            <span id="subject_error" style="color: red;"></span>
                     </div> -->
            <div class="col-sm-12">
            <?php echo form_label('Message', 'message'); ?>
            <?php echo form_textarea(['type'=>'text','id'=>'message','name'=>'message','value'=>'','class'=>'form-control']); ?>   
            <span id="message_error" style="color: red;"></span>                    
            </div>
<?php echo form_button(['type'=>'submit','content'=>'<span>Post Comment</span>','class'=>'button', 'id'=>'comment']); ?>
                  <?php echo form_close( ); ?>
                  </div>
               </div>
            </div>
            <!-- ./Comment -->
         </div>
         <!-- right colunm -->
         <?php include('commonfile/asiderightside.php'); ?>
         <!-- ./right colunm -->
      </div>
   </div>
</section>
<!-- Main Container End -->


<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reply Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
         <div id="replysuccess"></div>
           <form  method="post" id="replycomment">
            <input type="hidden" name="replyblog_id" id="replyblog_id" value="<?php echo $blogid; ?>">
              <div class="col-sm-6">
               <label for="replyname">Name</label>
                 <input type="text" name="replyname" id="replyname" class="form-control">
                 <span id="replyname_error" style="color: red;"></span>
              </div>
              <div class="col-sm-6">
               <label for="replyemail">Email</label>
                 <input type="text" name="replyemail" id="replyemail" class="form-control">
                 <span id="replyemail_error" style="color: red;"></span>
              </div>
              <div class="col-sm-12">
               <label for="replymessage">Message</label>
                <textarea id="replymessage" name="replymessage" class="form-control"></textarea>
                <span id="replymessage_error" style="color: red;"></span>
              </div>
           </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="comment_to_comment" class="button">Post Comment</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>