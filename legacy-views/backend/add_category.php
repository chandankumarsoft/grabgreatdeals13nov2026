    <!--  page-wrapper -->
    <div id="page-wrapper">
        <div class="row">
           <!-- page header -->
           <div class="col-lg-12">
            <h1 class="page-header">Add Category</h1>
        </div>
        <!--end page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Elements -->
            <div class="panel panel-default">               
                <div class="panel-heading">
                    Add New Category
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                           <h5 style='color:red'> <?php echo validation_errors();?></h5>
                                <?php echo form_open('admin/save-category','');?>
                                <div class="form-group">
                                    <label>Enter First Level Category</label>
                                    <input type="text" class="form-control" value="<?php echo set_value('category_name')?>" name="category_name" required="">
                                </div>                                 
                                <button type="submit" class="btn btn-primary">Save</button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <h2>Add Second Level Category</h2>
                    <div class="row">
                        <div class="col-lg-6">
                           <h5 style='color:red'> <?php echo validation_errors();?></h5>
                                <?php echo form_open('admin/save-sub-category','');?>
                                <label>Choose First Level Category Name</label>
                                 <?php $cat = $this->CategoryModel->get_all_category();?>
                                 <select class="form-control" name="category_sub_id" required>
                                        <option value="">Select One</option>                                       
                                         <?php
                                         foreach ($cat as $category) {  ?>
                                        <option value="<?php echo $category->category_id;?>"><?php echo $category->category_name?></option>
                                        <?php } ?>
                                </select>
                                <div class="form-group">
                                    <label>Enter Second Level Category Name</label>
                                    <input type="text" class="form-control" value="" name="sub_category_name" required="">
                                </div>
                                 
                                <button type="submit" class="btn btn-primary">Save</button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <h2>Add Third Level Category</h2>
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 style='color:red'> <?php echo validation_errors();?></h5>
                            <?php echo form_open('admin/save-sub-sub-category','');?>
                            <label>Choose First Level Category Name</label>
                            <?php $cat = $this->CategoryModel->get_all_category();?>
                            <select class="form-control" name="sub_of_sub_category" id="category_sub_id" required>
                                <option value="">Select One</option>
                                <?php
                                foreach ($cat as $category) {  ?>
                                <option value="<?php echo $category->category_id;?>"><?php echo $category->category_name?></option>
                                <?php } ?>
                            </select>
                            <script>
                            $(document).ready(function() {
                            $('#category_sub_id').on('change', function() {
                            var category_sub_id = this.value;
                            $.ajax({
                            url: "<?php echo base_url(); ?>admin/sub-category-ajax",
                            type: "POST",
                            data:{category_sub_id: category_sub_id},
                            cache: false,
                            success: function(dataResult){
                            $("#pro_sub_cat").html(dataResult);
                            }
                            });
                            });
                            });
                            </script>
                            <div class="form-group">
                                <label>Choose Second Level Category Name</label>
                                <select class="form-control" name="sub_category_id" id="pro_sub_cat" required>
                                <option value="">Select One</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Enter Third level category</label>
                                <input type="text" class="form-control" value="" name="sub_sub_category_name" required>
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


