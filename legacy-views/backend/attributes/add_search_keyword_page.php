<!--  page-wrapper -->
<div id="page-wrapper">
    <div class="row">
        <!-- page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Product Search Keywords</h1>
        </div>
        <!--end page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Elements -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Search Keywords Details
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                        </div>
                        <?php } else if($this->session->flashdata('error')){  ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                        </div>
                        <?php } else if($this->session->flashdata('warning')){  ?>
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                        </div>
                        <?php } else if($this->session->flashdata('info')){  ?>
                        <div class="alert alert-info">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
                        </div>
                        <?php } ?>
                        <div class="col-lg-6">
                            <h5 style='color:red'> <?php echo validation_errors();?></h5>
                            <?php echo form_open('admin/add-product-search_keywords','');?>
                            <div class="form-group">
                                <label>Search Key Name</label>
                                <input type="text" class="form-control" value="<?php echo set_value('product_search_key_name')?>" name="product_search_key_name">
                            </div>
                            <div class="form-group">
                                <label>search key Slug</label>
                                <input type="text" class="form-control" value="<?php echo set_value('product_search_key_slug')?>" name="product_search_key_slug">
                            </div>
                            <div class="form-group">
                                <label>search key Description</label>
                                <textarea class="form-control" name="product_search_key_description"><?php echo set_value('product_search_key_description')?></textarea>
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