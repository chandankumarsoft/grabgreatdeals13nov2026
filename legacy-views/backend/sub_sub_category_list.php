<div id="page-wrapper">
    <div class="row">
        <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Category Details</h1>
        </div>
        <!-- end  page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Category Second Level Details
                </div>
                <p class="text-success"> <?php if(isset($success_message)) {
                    echo $success_message;
                    } ?>
                </p>
                <?php
                   if (!empty($this->session->flashdata('flsh_msg'))) {
                    ?>
                       <div class="alert alert-success">
                     <?php echo $this->session->flashdata('flsh_msg'); ?>
                      </div>
                <?php
                   }
                 ?>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Category Name</th>
                                    <th>sub Category Name</th>
                                    <th>Sub of sub Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_sub_cats)){
                                foreach ($all_sub_cats as $value){
                                foreach ($all_sub_cats as $value1){
                                    if ($value1->parent_id==$value->category_id) {
                                   foreach ($all_sub_cats as $value2){
                                    if ($value2->parent_id==$value1->category_id) {
                                $i++;
                                ?>                                
                                <tr class="gradeC">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->category_name;?></td>
                                    <td><?php echo $value1->category_name;?></td>
                                    <td><?php echo $value2->category_name;?></td>
                                    <td>
                                        <a class="btn btn-info" href="<?php  echo base_url();?>admin/edit-sub-sub-category/<?php echo $value2->category_id;?>">Edit</a>
                                        <form method="post" action="<?php echo base_url();?>admin/delete-sub-sub-category/<?php echo (int) $value2->category_id;?>" style="display:inline;"><button class="btn btn-danger" type="submit">Delete</button></form>
                                    </td>                                    
                                </tr>
                                <?php }}}}}} ?>
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>assets/back/plugins/dataTables/jquery.dataTables.js"></script>
<script>
$(document).ready(function () {
$('#dataTables-example').dataTable();
});
</script>