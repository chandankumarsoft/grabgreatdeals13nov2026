<script type="text/javascript" src="<?php echo base_url();?>/assets/back/ckeditor/ckeditor.js"></script>
<!--  page-wrapper -->
<div id="page-wrapper">
    <div class="row">
        <!-- page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Edit Slider</h1>
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
                    Edit slider
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 style='color:red'> <?php echo validation_errors();?></h5>
                            <?php echo form_open_multipart('admin/update-baner','');?> 
                            <input type="hidden" name="baner_id" value="<?php echo $baner_details->baner_id; ?>">                           
                            <div class="form-group">
                                <label>Edit slider Title</label>
                                <textarea  id="ck" class="form-control" rows="3" name="baner_text"><?php echo $baner_details->baner_text; ?></textarea>
                                <script>CKEDITOR.replace('ck')</script>
                            </div>
                            <div class="form-group">
                                <label>Edit slider Link Where Do you Redirect</label>
                                <input type="url" class="form-control" value="<?php echo $baner_details->baner_link; ?>" name="baner_link" required>
                            </div>
                             <div class="form-group">
                                <label>Upload slider Image</label>
                                <input type="file" name="baner_name">
                                <input type="hidden" name="old_baner_name" value="<?php echo $baner_details->baner_name; ?>">
                                <img src="<?php echo base_url().$baner_details->baner_name; ?>" width="100px">
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
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