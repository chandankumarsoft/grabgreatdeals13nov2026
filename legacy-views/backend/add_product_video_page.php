    <!--  page-wrapper -->
    <div id="page-wrapper">
        <div class="row">
           <!-- page header -->
           <div class="col-lg-12">
            <h1 class="page-header">Add new Video</h1>
        </div>
        <!--end page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Elements -->
            <div class="panel panel-default">
               
                <div class="panel-heading">
                    Add new Video
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php if (isset($form_data_error)) {
                                echo $form_data_error;
                            } ?>
                           <?php echo form_open_multipart('admin/save-product-video','');?>
                                <div class="form-group">
                                    <label>Product Sku Name</label>
                                    <input type="text" class="form-control" name="product_sku_name">
                                    <span style="color: red;"><?php echo form_error('product_sku_name'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label>Choose Product Video</label>
                                    <input type="file" class="form-control" name="video">
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
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


