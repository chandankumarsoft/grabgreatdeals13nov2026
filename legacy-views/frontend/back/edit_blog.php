<script type="text/javascript" src="<?php echo base_url();?>/assets/back/ckeditor/ckeditor.js"></script>
<!--  page-wrapper -->
<div id="page-wrapper">
    <div class="row">
        <!-- page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Edit Blog Details</h1>
        </div>
        <!--end page header -->
    </div>
    
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
                <div class="panel-heading">
                    Edit Blog
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 style='color:red'> <?php echo validation_errors();?></h5>

                            <?php 
                                $attributes = array('class' => 'tagsforajaxddd');
                                echo form_open_multipart('update-blog',$attributes);
                            ?>
                            <div class="form-group">
                                <label>Edit Feature Image</label>
                                <span id="errorfeaturesimage" style="color: red; margin-left: 15px;"></span>
                                <input type="file" class="form-control" name="blogfeatureimage">
                                <input type="hidden" name="blogfeatureimageold" value="<?php echo $blog_details->image; ?>">
                                <input type="hidden" name="blog_id" value="<?php echo $blog_details->blog_id; ?>">
                                <img src="<?php echo base_url().$blog_details->image; ?>" width="100px">
                            </div>
                            <div class="form-group">
                                <label>Edit Blog Title</label>
                                <span id="errorblogtitle" style="color: red; margin-left: 15px;"></span>
                                <input type="text" class="form-control" value="<?php echo $blog_details->title; ?>" name="blog_title" id="blogtitlevalue">
                            </div>
                            <div class="form-group tagsforajax">
                                <label>Edit Blog Tags</label><span id="errorforblogtags" style="color: red; margin-left: 15px;"></span><label><button type="button" class="btn-primary btn-sm" data-toggle="modal" data-target="#tagsmodal" style="margin-left: 50px;border: none;">Add New Tags If Not In DropDown</button></label>

                               <select name="blogtags[]" multiple="multiple" class="4col formcls" id="blogtagscheck">
                                   <?php 
                                   $data=$this->BlogModel->fetch_all_tags();
                                   $selected_blog_tags=$this->db->select('DISTINCT(blog_tag_id)')->from('tbl_blog_relation')->where('blog_id',$blog_details->blog_id)->get()->result();

                                   foreach ($data as $value) { ?>
                                     <option value="<?php echo $value->blog_tag_id; ?>" 
                                      <?php foreach ($selected_blog_tags as $selected_blog_tags_value) {
                                       if ($selected_blog_tags_value->blog_tag_id==$value->blog_tag_id) {
                                         echo "selected";
                                       }
                                     } ?>
                                     >
                                     <?php echo $value->blog_tag_name; ?></option>
                                 <?php   } ?>                            
                                    
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Edit Blog Categories</label><span id="errorforblogcategory" style="color:red; margin-left: 15px;"></span><label><button type="button" class="btn-primary btn-sm" data-toggle="modal" data-target="#categorymodal" style="margin-left: 50px;border: none;">Add New Blog Categories If Not In DropDown</button></label>
                                <select name="blogcategories[]" multiple="multiple" class="4col formcls data" id="blogcategorycheck">
                                   <?php 
                                   $fetchcategoryblogdata=$this->BlogModel->fetch_all_category();
                                   $selected_blog_category=$this->db->select('DISTINCT(blog_cat_id)')->from('tbl_blog_relation')->where('blog_id',$blog_details->blog_id)->get()->result();
                                   foreach ($fetchcategoryblogdata as $categoryvalue) { ?>
                                     <option value="<?php echo $categoryvalue->blog_cat_id; ?>"

                                    <?php foreach ($selected_blog_category as $selected_blog_category_value) {
                                       if ($selected_blog_category_value->blog_cat_id==$categoryvalue->blog_cat_id) {
                                         echo "selected";
                                       }
                                     } ?>
                                      ><?php echo $categoryvalue->blog_cat_name; ?></option>
                                 <?php   } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Edit Blog Description</label>
                                <textarea  id="ck" class="form-control" rows="3" name="blog_desc"><?php echo $blog_details->content;  ?></textarea>
                                <!-- <script>CKEDITOR.replace('ck')</script> -->
                                <script>
                                 CKEDITOR.replace( 'ck', {
                                  height: 300,
                                  filebrowserUploadUrl: "upload.php"
                                 });
                                </script>                                                            
                            </div>
                            <button type="submit" class="btn btn-primary" id="blogpostsubmit">Save</button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Form Elements -->
        </div>
    </div>
</div>
<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="tagsmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Tags</h4>
      </div>
      <div class="modal-body">
        <form method="post" onsubmit="return false;">
            <div id="spantagserror">           
            </div>
            <div class="form-group">
            <label>Enter New Tags</label>
            <input type="text" name="addnewtags" id="addnewtags" class="form-control">
            </div>
            <button class="btn btn-primary" id="submitaddnewtags">Save</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#blogpostsubmit").click(function(){
     var blogfeatureimagevalue= $('#blogfeatureimagevalue').val();
     if (blogfeatureimagevalue=="") {
        $('#errorfeaturesimage').text("choose featured Image");
      setTimeout(function () {
        $('#errorfeaturesimage').hide();
        }, 5000);
      $('#errorfeaturesimage').show();
      return false;
     }
    });
    $("#blogpostsubmit").click(function(){
     var blogtitlevalue= $('#blogtitlevalue').val();
     if (blogtitlevalue=="") {
        $('#errorblogtitle').text("Enter Blog Title");
      setTimeout(function () {
        $('#errorblogtitle').hide();
        }, 5000);
      $('#errorblogtitle').show();
      return false;
     }
    });
    $("#blogpostsubmit").click(function(){
     var blogtagscheck= $('#blogtagscheck').val();
     if (blogtagscheck==null) {
        $('#errorforblogtags').text("Atleast One Tags Choose.");
      setTimeout(function () {
        $('#errorforblogtags').hide();
        }, 5000);
      $('#errorforblogtags').show();
      return false;
     }
    });
    $("#blogpostsubmit").click(function(){
     var blogcategorycheck= $('#blogcategorycheck').val();
     if (blogcategorycheck==null) {
        $('#errorforblogcategory').text("Atleast One Category Choose.");
      setTimeout(function () {
        $('#errorforblogcategory').hide();
        }, 5000);
      $('#errorforblogcategory').show();
      return false;
     }
    });
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#submitaddnewtags').click(function(){
            if($.trim($('#addnewtags').val()) == ''){
             $('#spantagserror').html("<span style='color: red;'>Tags Can't Be Blank</span>");
                       
        }else{     
                 var addnewtagsvalue=$('#addnewtags').val();
                 $.ajax({
                    url:'<?php echo base_url(); ?>add-tagsofblog',
                    type:'POST',
                     dataType:'json',
                    data:{addnewtagsvalue:addnewtagsvalue},
                    success:function(result){
                  if (result.exist) {
                     $('#spantagserror').html('<span style="color: red;">'+result.exist+'</span>');
                  }else{
                    $('#spantagserror').html('<span style="color: green;">'+result.datainserted+'</span>');
                    location.reload();
                  }
                    }
                 });
      }
            
        });

      
    });
</script>
<div id="categorymodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <form method="post" onsubmit="return false;">
            <div id="spancategoryerror">           
            </div>
            <div class="form-group">
            <label>Enter New Category Name</label>
            <input type="text" name="addnewcategory" id="addnewcategory" class="form-control">
            </div>
            <button class="btn btn-primary" id="submitaddnewcategory">Save</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('#submitaddnewcategory').click(function(){
            if($.trim($('#addnewcategory').val()) == ''){
             $('#spancategoryerror').html("<span style='color: red;'>category Can't Be Blank</span>");
                       
        }else{     
                 var addnewcategoryvalue=$('#addnewcategory').val();
                 $.ajax({
                    url:'<?php echo base_url(); ?>add-categoryofblog',
                    type:'POST',
                     dataType:'json',
                    data:{addnewcategoryvalue:addnewcategoryvalue},
                    success:function(result){
                      // alert(result);
                  if (result.exist) {
                     $('#spancategoryerror').html('<span style="color: red;">'+result.exist+'</span>');
                  }else{
                    $('#spancategoryerror').html('<span style="color: green;">'+result.datainserted+'</span>');
                    location.reload();
                  }
                    }
                 });
      }
            
        });

      
    });
</script>
<script src="<?php echo base_url(); ?>assets\back\multiselect\js\multiselect-checkbox\jquery.multiselect.js"></script>
<script>
$('select[multiple]').multiselect({
columns: 2,
placeholder: 'Select options',
selectAll : true
});
</script>
<!-- end page-wrapper -->