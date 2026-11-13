<!--  page-wrapper -->
<div id="page-wrapper">
    <div class="row">
        <!-- page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Add Product Attribute image</h1>
        </div>
        <!--end page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Elements -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Product Attribute image
                </div>
                <?php if(!empty($this->session->flashdata('flsh_msg'))){ ?>
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h4 class="success"><?php echo $this->session->flashdata('flsh_msg')?></h4>
                </div>
                
                <?php } ?>
                <?php if(!empty($this->session->flashdata('error'))){ ?>
                <div class="alert alert-danger">
                    <h4><?php echo esc((string) $this->session->flashdata('error')); ?></h4>
                </div>
                <?php } ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 style='color:red'> <?php echo validation_errors();?></h5>
                            <?php echo form_open_multipart('admin/product-attr-image-save','');?>
                            <div class="field_wrapper_color_attr" style="width: 75%;">
                                <label>Product Color Details</label>
                                <?php foreach ($selected_attr_image as $key => $selected_attr_image_value) { ?>
                                
                                <div style="display:flex;width:100%;">
                                    <input type="text" name="product_color_name[]" value="<?php echo $selected_attr_image_value->color; ?>" class="form-control" placeholder="Color Name" style="width:100%;">
                                    <input type="hidden" name="attr_color_relation_product_id<?php echo $key; ?>" value="<?php echo $selected_attr_image_value->attr_color_relation_product_id; ?>">
                                    <input type="hidden" name="attr_relation_color_name<?php echo $key; ?>" value="<?php echo $selected_attr_image_value->attr_relation_color_name; ?>">
                                    <img src="<?php echo base_url().'uploads/'.$selected_attr_image_value->attr_relation_color_image; ?>" alt="" style="height: 50px;width: 50px;">
                                    <input type="file" name="product_color_name_image<?php echo $key; ?>[]" multiple="" class="form-control" style="width:100%;">
                                </div>
                                <?php } ?>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Form Elements -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th width="20%" class="text-center">Product ID</th>
                                    <th width="20%" class="text-center">Attr Image</th>
                                    <th width="20%" class="text-center">Image</th>
                                    <th width="10%" class="text-center">Color ID</th>
                                    <th width="15%" class="text-center">Color Name</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($selected_attrimg as $selected_attrimg_value){
                                ?>
                                <tr class="gradeC text-center">
                                    <td><?php echo $selected_attrimg_value->product_id;?></td>
                                    <td><img src="<?php echo base_url().'uploads/'.$selected_attrimg_value->image;?>" class="img-rounded" width="120" height="120"/></td>
                                    <td><img src="<?php echo base_url().'uploads/'.$selected_attrimg_value->attr_relation_color_image;?>" class="img-rounded" width="120" height="120"/></td>
                                    <td><?php echo $selected_attrimg_value->attr_relation_color_name; ?></td>
                                    <td><?php echo $selected_attrimg_value->color; ?></td>
                                    <td class="align-middle">
                                         <form method="post" action="<?php echo base_url(); ?>admin/product-attr-image-delete?attrimg_id=<?php echo (int) $selected_attrimg_value->attrimg_id;?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this image?');"><button class="btn btn-danger" type="submit">Delete</button></form>
                                    </td>
                                    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end page-wrapper -->