<!--  page-wrapper -->
<div id="page-wrapper">
    <div class="row">
        <!-- page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Forms Element</h1>
        </div>
        <!--end page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
        <div><?php echo $this->session->flashdata('flsh_msg'); ?></div>
            <!-- Form Elements -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add new Sub of sub Category
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 style='color:red'> <?php echo validation_errors();?></h5>
                            <?php echo form_open('save-sub-sub-category','');?>
                            <?php $cat = $this->CategoryModel->get_all_category();?>
                            <select class="form-control" name="category_id" id="category_sub_id">
                                <option>Select One</option>
                                <?php
                                foreach ($cat as $category) {  ?>
                                <option value="<?php echo $category->category_id;?>"><?php echo $category->category_name?></option>
                                <?php } ?>
                            </select>
                            <script>
                            $(document).ready(function() {
                            $('#category_sub_id').on('change', function() {
                            var category_id = this.value;
                            // alert(category_id);
                            $.ajax({
                            url: "Category/get_sub_subcat",
                            type: "POST",
                            data:{category_id: category_id},
                            cache: false,
                            success: function(dataResult){
                            // alert(dataResult);
                            $("#pro_sub_cat").html(dataResult);
                            }
                            });
                            });
                            });
                            </script>
                            <div class="form-group">
                                <label>Add Sub Category</label>
                                <select class="form-control" name="sub_category_id" id="pro_sub_cat">
                                <option>Select One</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Add Sub Of Sub Category</label>
                                <input type="text" class="form-control" value="" name="sub_sub_category_name" required="">
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